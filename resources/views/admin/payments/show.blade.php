<x-app-layout>
    <div class="max-w-3xl mx-auto py-8 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Payment #{{ $payment->id }}</h1>
            <a href="{{ route('admin.payments.index') }}" class="text-ram-blue underline">Back to list</a>
        </div>

        @if(session('ok'))
            <div class="bg-green-50 text-green-700 p-3 rounded mb-4">{{ session('ok') }}</div>
        @endif

        <div class="bg-white border rounded p-5 space-y-3">
            <div><span class="text-slate-500">Date: </span>{{ optional($payment->created_at)->format('d M Y H:i') }}</div>
            <div><span class="text-slate-500">User: </span>{{ $payment->user?->name }} ({{ $payment->user?->email }})</div>
            <div><span class="text-slate-500">Method: </span>{{ $payment->method ?? '—' }}</div>
            <div><span class="text-slate-500">Transaction ID: </span>{{ $payment->transaction_id ?? '—' }}</div>
            <div><span class="text-slate-500">Amount: </span>{{ number_format($payment->amount,2) }} {{ $payment->currency }}</div>
            <div><span class="text-slate-500">Status: </span>{{ ucfirst($payment->status) }}</div>
            <div><span class="text-slate-500">Paid At: </span>{{ optional($payment->paid_at)->format('d M Y H:i') ?? '—' }}</div>
            @if($payment->application)
                <div><span class="text-slate-500">Application: </span>
                    <a class="text-ram-blue underline" href="{{ route('admin.apps.show', $payment->application) }}">
                        #{{ $payment->application->id }} — {{ $payment->application->company_name }}
                    </a>
                </div>
            @endif
        </div>

        <div class="bg-white border rounded p-5 mt-6">
            <form method="POST" action="{{ route('admin.payments.updateStatus', $payment) }}" class="flex items-end gap-3">
                @csrf
                <div>
                    <label class="block text-sm text-slate-600 mb-1">Change Status</label>
                    <select name="status" class="border rounded p-2">
                        @foreach(['pending','completed','failed','refunded'] as $s)
                            <option value="{{ $s }}" @selected($payment->status === $s)>{{ ucfirst($s) }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="px-4 py-2 rounded bg-ram-blue text-white">Save</button>
            </form>
        </div>
    </div>
</x-app-layout>
