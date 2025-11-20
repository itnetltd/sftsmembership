<?php

namespace App\Http\Controllers\Webhook;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Payment;

class FlutterwaveWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Optional: verify signature
        $signature = $request->header('verif-hash');
        if (config('services.flutterwave.webhook_secret') && $signature !== config('services.flutterwave.webhook_secret')) {
            Log::warning('FLW webhook signature mismatch');
            return response()->json(['ok' => false], 401);
        }

        $payload = $request->all();
        Log::info('FLW webhook', $payload);

        // Update payment by tx_ref or transaction_id as you store it
        $txRef = data_get($payload, 'data.tx_ref');
        $status = data_get($payload, 'data.status'); // 'successful', 'failed', etc.
        $txnId  = data_get($payload, 'data.id');

        if ($txRef) {
            $p = Payment::where('reference', $txRef)->first();
            if ($p) {
                $p->transaction_id = $txnId;
                $p->status = $status === 'successful' ? 'completed' : ($status ?: 'pending');
                if ($p->status === 'completed' && !$p->paid_at) {
                    $p->paid_at = now();
                }
                $meta = (array) $p->meta;
                $meta['webhook'] = $payload;
                $p->meta = $meta;
                $p->save();
            }
        }

        return response()->json(['ok' => true]);
    }
}
