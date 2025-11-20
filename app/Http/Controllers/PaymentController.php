<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Http\Client\ConnectionException;

class PaymentController extends Controller
{
    /* =========================
     |  Member Billing Pages
     |=========================*/

    // Billing history
    public function index()
    {
        $payments = Payment::where('user_id', auth()->id())->latest()->get();
        return view('payments.index', compact('payments'));
    }

    // Make a payment form
    public function create()
    {
        // prefill with user phone if you store it; fallback to blank
        $prefillMsisdn = auth()->user()->phone ?? '';
        return view('payments.create', ['prefillMsisdn' => $prefillMsisdn]);
    }

    /* =========================
     |  Create Payment (MTN MoMo)
     |=========================*/
    public function store(Request $request)
    {
        $validated = $request->validate([
            'amount' => 'required|integer|min:100',
            'method' => 'required|string|in:momo,card',
            // require MSISDN only for momo; we’ll normalize it below
            'msisdn' => 'required_if:method,momo|nullable|string|max:20',
        ]);

        $user   = $request->user();
        $amount = (int) $validated['amount'];

        if ($validated['method'] === 'momo') {
            // Normalize phone to 2507XXXXXXXX
            $payerMsisdn = $this->normalizeMsisdn((string) ($validated['msisdn'] ?? ''));
            if (!$payerMsisdn || !preg_match('/^2507\d{8}$/', $payerMsisdn)) {
                return back()->with('error', 'Enter a valid MTN number in the format 2507XXXXXXXX.')
                             ->withInput();
            }

            // 1) Create local pending payment
            $reference = Str::upper(Str::uuid()->toString());
            $payment = Payment::create([
                'user_id'   => $user->id,
                'amount'    => $amount,
                'currency'  => 'RWF',
                'method'    => 'MOMO',
                'status'    => 'pending',
                'reference' => $reference,   // used as MoMo X-Reference-Id + externalId
                'meta'      => null,
            ]);

            try {
                // 2) Access token
                $token = $this->momoAccessToken();

                // 3) Request-to-pay (will trigger SIM prompt)
                $ok = $this->momoRequestToPay(
                    token: $token,
                    amount: $amount,
                    currency: 'RWF',
                    externalId: $reference,
                    payerMsisdn: $payerMsisdn,
                    reference: $reference
                );

                if (!$ok) {
                    return back()->with('error', 'Could not create MoMo charge. Please try again.');
                }

                return redirect()
                    ->route('payments.index')
                    ->with('ok', 'MoMo prompt sent to your phone. Approve it to complete payment.');
            } catch (ConnectionException $e) {
                Log::error('MoMo connection error', ['msg' => $e->getMessage()]);
                return back()->with('error', 'Unable to reach MTN MoMo. Try again later.');
            } catch (\Throwable $e) {
                Log::error('MoMo error', ['ex' => $e]);
                return back()->with('error', 'Payment failed to initialize. Check logs.');
            }
        }

        // (Optional) keep/implement card branch later
        return back()->with('error', 'Unsupported payment method right now.');
    }

    /* =========================
     |  Manual Refresh Status
     |=========================*/
    public function refresh(Payment $payment)
    {
        // If you don’t have policies, ensure the user owns this payment:
        abort_unless($payment->user_id === auth()->id(), 403);

        if ($payment->method !== 'MOMO' || $payment->status !== 'pending') {
            return back();
        }

        try {
            $token = $this->momoAccessToken();
            $cfg   = config('services.mtn_momo');

            $res = Http::withHeaders([
                    'Authorization'             => 'Bearer ' . $token,
                    'Ocp-Apim-Subscription-Key' => $cfg['subscription_key'],
                    'X-Target-Environment'      => $cfg['target_environment'],
                ])
                ->timeout(20)
                ->retry(2, 300)
                ->get($cfg['base_url'] . '/collection/v1_0/requesttopay/' . $payment->reference);

            if ($res->successful()) {
                $status = data_get($res->json(), 'status'); // PENDING | SUCCESSFUL | FAILED
                if ($status === 'SUCCESSFUL') {
                    $payment->update(['status' => 'completed']);
                    return back()->with('ok', 'Payment completed!');
                } elseif ($status === 'FAILED') {
                    $payment->update(['status' => 'failed']);
                    return back()->with('error', 'Payment failed.');
                }
            } else {
                Log::warning('MoMo status poll failure', ['status' => $res->status(), 'body' => $res->body()]);
            }
        } catch (\Throwable $e) {
            Log::error('MoMo refresh error', ['ex' => $e]);
        }

        return back()->with('info', 'Still pending. If you didn’t receive a prompt, re-try payment.');
    }

    /* =========================
     |  MTN MoMo Helpers
     |=========================*/

    // Get access token for Collections
    private function momoAccessToken(): string
    {
        $cfg = config('services.mtn_momo');

        $res = Http::withHeaders([
                'Ocp-Apim-Subscription-Key' => $cfg['subscription_key'],
                'Authorization' => 'Basic ' . base64_encode($cfg['api_user'] . ':' . $cfg['api_key']),
            ])
            ->timeout(20)
            ->retry(2, 250)
            ->post($cfg['base_url'] . '/collection/token/');

        if (!$res->successful()) {
            Log::error('MoMo token failure', ['status' => $res->status(), 'body' => $res->body()]);
            throw new \RuntimeException('MoMo token request failed.');
        }

        return (string) data_get($res->json(), 'access_token');
    }

    // Create a request-to-pay
    private function momoRequestToPay(
        string $token,
        int $amount,
        string $currency,
        string $externalId,
        string $payerMsisdn,
        string $reference
    ): bool {
        $cfg = config('services.mtn_momo');

        $payload = [
            'amount'       => (string) $amount,
            'currency'     => $currency,
            'externalId'   => $externalId,
            'payer'        => [
                'partyIdType' => 'MSISDN',
                'partyId'     => $payerMsisdn,
            ],
            'payerMessage' => 'RAM Membership Payment',
            'payeeNote'    => 'RAM Fee',
        ];

        $res = Http::withHeaders([
                'Authorization'             => 'Bearer ' . $token,
                'Ocp-Apim-Subscription-Key' => $cfg['subscription_key'],
                'X-Reference-Id'            => $reference,                 // idempotency
                'X-Target-Environment'      => $cfg['target_environment'], // sandbox | production
                'Content-Type'              => 'application/json',
            ])
            ->timeout(25)
            ->retry(2, 300)
            ->post($cfg['base_url'] . '/collection/v1_0/requesttopay', $payload);

        if ($res->status() === 202) {
            return true;
        }

        Log::error('MoMo RTP failure', [
            'status' => $res->status(),
            'body'   => $res->body(),
            'hdrs'   => $res->headers(),
        ]);
        return false;
    }

    // Accepts 07XXXXXXXX, 7XXXXXXXX, +2507XXXXXXXX, or 2507XXXXXXXX → returns 2507XXXXXXXX
    private function normalizeMsisdn(string $raw): ?string
    {
        $s = preg_replace('/\s+/', '', $raw);

        if (preg_match('/^\+?2507\d{8}$/', $s)) {
            return ltrim($s, '+'); // +2507XXXXXXXX -> 2507XXXXXXXX
        }
        if (preg_match('/^07\d{8}$/', $s)) {
            return '250' . $s;     // 07XXXXXXXX -> 2507XXXXXXXX
        }
        if (preg_match('/^7\d{8}$/', $s)) {
            return '250' . $s;     // 7XXXXXXXXX  -> 2507XXXXXXXX
        }

        return null;
    }
}
