<x-app-layout>
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        @if(session('ok'))
            <div class="mb-6 rounded-lg bg-green-50 text-green-700 px-4 py-3">{{ session('ok') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-6 rounded-lg bg-red-50 text-red-700 px-4 py-3">{{ session('error') }}</div>
        @endif

        <div class="mb-5 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-semibold">Billing</h1>
                <p class="text-slate-600 text-sm">View your payments and make new ones.</p>
            </div>
            <a href="{{ route('payments.create') }}"
               class="inline-flex items-center px-4 py-2.5 rounded-lg bg-ram-blue text-white hover:opacity-90">
                Make a Payment
            </a>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 shadow-soft overflow-hidden">
            <table class="min-w-full text-sm">
                <thead class="bg-slate-50 text-slate-600">
                    <tr>
                        <th class="text-left px-4 py-3">Date</th>
                        <th class="text-left px-4 py-3">Amount</th>
                        <th class="text-left px-4 py-3">Method</th>
                        <th class="text-left px-4 py-3">Status</th>
                        <th class="text-left px-4 py-3">Reference</th>
                        <th class="text-left px-4 py-3">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                @forelse($payments as $p)
                    <tr>
                        <td class="px-4 py-3">{{ optional($p->created_at)->format('d M Y H:i') }}</td>
                        <td class="px-4 py-3">{{ number_format($p->amount, 0) }} RWF</td>
                        <td class="px-4 py-3">{{ strtoupper($p->method) }}</td>
                        <td class="px-4 py-3">
                            @php
                                $badge = [
                                    'completed' => 'bg-green-600',
                                    'pending'   => 'bg-yellow-600',
                                    'failed'    => 'bg-red-600',
                                    'refunded'  => 'bg-slate-600',
                                ][$p->status] ?? 'bg-slate-500';
                            @endphp
                            <span class="text-xs text-white px-2 py-1 rounded {{ $badge }}">{{ ucfirst($p->status) }}</span>
                        </td>
                        <td class="px-4 py-3">{{ $p->reference ?: '—' }}</td>
                        <td class="px-4 py-3">
                            @if($p->status === 'pending')
                                <form method="POST" action="{{ route('payments.refresh', $p) }}">
                                    @csrf
                                    <button class="text-ram-blue underline">Refresh status</button>
                                </form>
                            @else
                                <span class="text-slate-400">—</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-slate-500">No payments yet.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>

    </div>
</x-app-layout>
