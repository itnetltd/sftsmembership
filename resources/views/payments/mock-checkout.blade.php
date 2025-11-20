<x-app-layout>
    <div class="max-w-xl mx-auto p-6">
        <h1 class="text-xl font-semibold mb-4">Mock Checkout</h1>
        <p class="mb-3 text-slate-600">Reference: <span class="font-mono">{{ $payment->reference }}</span></p>
        <p class="mb-6">Amount: <strong>{{ number_format($payment->amount) }} RWF</strong></p>

        <a href="{{ route('payments.callback', ['tx_ref' => $payment->reference, 'status' => 'successful']) }}"
           class="inline-flex px-4 py-2 rounded bg-ram-blue text-white">
           Simulate Successful Payment
        </a>
    </div>
</x-app-layout>
