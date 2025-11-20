<x-app-layout>
    <div class="max-w-7xl mx-auto py-8 px-4">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-semibold">Admin • Payments</h1>
            <a href="{{ route('admin.payments.export', request()->only('status','method')) }}"
               class="px-4 py-2 rounded bg-ram-blue text-white hover:opacity-90">Export CSV</a>
        </div>

        @if(session('ok'))
            <div class="bg-green-50 text-green-700 p-3 rounded mb-4">{{ session('ok') }}</div>
        @endif

        <div class="grid sm:grid-cols-3 gap-4 mb-6">
            <div class="bg-white border rounded p-4">
                <div class="text-slate-500 text-sm">Completed (RWF)</div>
                <div class="text-xl font-semibold">{{ number_format($totals['completed'], 2) }}</div>
            </div>
            <div class="bg-white border rounded p-4">
                <div class="text-slate-500 text-sm">Pending (RWF)</div>
                <div class="text-xl font-semibold">{{ number_format($totals['pending'], 2) }}</div>
            </div>
            <div class="bg-white border rounded p-4">
                <div class="text-slate-500 text-sm">Failed (RWF)</div>
                <div class="text-xl font-semibold">{{ number_format($totals['failed'], 2) }}</div>
            </div>
        </div>

        <form method="GET" class="bg-white border rounded p-4 mb-6 grid md:grid-cols-4 gap-4">
            <div>
                <label class="block text-sm text-slate-600 mb-1">Status</label>
                <select name="status" class="w-full border rounded p-2">
                    <option value="">All</option>
                    @foreach(['pending','completed','failed','refunded'] as $s)
                        <option value="{{ $s }}" @selected($qStatus===$s)>{{ ucfirst($s) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm text-slate-600 mb-1">Method</label>
                <select name="method" class="w-full border rounded p-2">
                    <option value="">All</option>
                    @foreach($methods as $m)
                        <option value="{{ $m }}" @selected($qMethod===$m)>{{ $m }}</option>
                    @endforeach
                </select>
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm text-slate-600 mb-1">Search (name/email/txn)</label>
                <input type="text" name="q" value="{{ $qSearch }}" class="w-full border rounded p-2" placeholder="Search…">
            </div>
            <div class="md:col-span-4 flex gap-3">
                <button class="px-4 py-2 rounded bg-ram-blue text-white">Apply</button>
                <a href="{{ route('admin.payments.index') }}" class="px-4 py-2 rounded border">Reset</a>
            </div>
        </form>

        <div class="bg-white border rounded overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-ram-blue text-white">
                    <tr>
                        <th class="p-3">Date</th>
                        <th class="p-3">User</th>
                        <th class="p-3">Method</th>
                        <th class="p-3">Amount</th>
                        <th class="p-3">Status</th>
                        <th class="p-3"></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $p)
                        <tr class="border-b">
                            <td class="p-3">{{ optional($p->created_at)->format('d M Y H:i') }}</td>
                            <td class="p-3">
                                {{ $p->user?->name }}<br>
                                <span class="text-xs text-slate-500">{{ $p->user?->email }}</span>
                            </td>
                            <td class="p-3">
                                {{ $p->method ?? '—' }}<br>
                                <span class="text-xs text-slate-500">Txn: {{ $p->transaction_id ?? '—' }}</span>
                            </td>
                            <td class="p-3">{{ number_format($p->amount, 2) }} {{ $p->currency }}</td>
                            <td class="p-3">
                                <span class="px-2 py-1 rounded text-sm
                                    {{ $p->status === 'completed' ? 'bg-green-100 text-green-700' :
                                       ($p->status === 'failed' ? 'bg-red-100 text-red-700' :
                                       ($p->status === 'refunded' ? 'bg-purple-100 text-purple-700' : 'bg-yellow-100 text-yellow-700')) }}">
                                    {{ ucfirst($p->status) }}
                                </span>
                            </td>
                            <td class="p-3">
                                <a href="{{ route('admin.payments.show', $p) }}" class="text-ram-blue underline">Open</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="p-3 text-center text-slate-500">No payments found.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $payments->links() }}
        </div>
    </div>
</x-app-layout>
