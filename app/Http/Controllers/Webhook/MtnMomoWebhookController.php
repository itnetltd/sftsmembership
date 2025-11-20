<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;

class MtnMomoWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Optional shared secret check
        $secret = config('services.mtnmomo.callback_secret');
        if ($secret && $request->header('X-Mtnmomo-Signature') !== $secret) {
            return response()->json(['ok' => false], 401);
        }

        // MTN payloads vary; adapt as per Rwanda callback
        $reference = $request->get('reference') ?? $request->get('X-Reference-Id');
        if (!$reference) return response()->json(['ok' => true]);

        $payment = Payment::where('reference', $reference)->first();
        if (!$payment) return response()->json(['ok' => true]);

        $status = strtoupper($request->get('status', ''));
        if ($status === 'SUCCESSFUL') {
            $payment->update([
                'status'         => 'completed',
                'transaction_id' => $request->get('financialTransactionId'),
                'meta'           => array_merge($payment->meta ?? [], ['webhook' => $request->all()]),
            ]);
        } elseif ($status === 'FAILED') {
            $payment->update([
                'status' => 'failed',
                'meta'   => array_merge($payment->meta ?? [], ['webhook' => $request->all()]),
            ]);
        }

        return response()->json(['ok' => true]);
    }
}
