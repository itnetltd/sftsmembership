<x-app-layout>
    {{-- Keep your existing Breeze header slot --}}
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    @php
        // Current user's application (if any)
        $app = \App\Models\MembershipApplication::with('documents')
            ->where('user_id', auth()->id())
            ->latest()
            ->first();

        $docCount = $app?->documents->count() ?? 0;

        // Required doc types (adjust anytime)
        $requiredTypes = ['RDB_certificate', 'TIN', 'ID_copy'];
        $haveTypes = $app ? $app->documents->pluck('type')->values()->all() : [];

        // Status badge color
        $statusClass = match($app?->status) {
            'approved' => 'bg-green-600',
            'rejected' => 'bg-red-600',
            'pending'  => 'bg-yellow-600',
            default    => 'bg-slate-400'
        };

        // CTA
        if (!$app) {
            $ctaLabel = 'Start Application';
            $ctaUrl   = route('application.create');
        } else {
            $ctaLabel = 'Open My Application';
            $ctaUrl   = route('application.show', $app);
        }

        // Simple admin flag (expects users.is_admin boolean)
        $isAdmin = (bool) (auth()->user()->is_admin ?? false);

        // Lightweight admin metrics
        $pendingCount  = $isAdmin ? \App\Models\MembershipApplication::where('status','pending')->count() : 0;
        $totalApps     = $isAdmin ? \App\Models\MembershipApplication::count() : 0;
        $approvedCount = $isAdmin ? \App\Models\MembershipApplication::where('status','approved')->count() : 0;
    @endphp

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Welcome + CTA --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-slate-200">
                <div class="p-6 flex items-center justify-between flex-wrap gap-4">
                    <div>
                        <div class="text-gray-900 font-semibold">Welcome, {{ auth()->user()->name }}.</div>
                        <div class="text-slate-600 text-sm">Manage your RAM membership application and documents.</div>
                    </div>
                    <a href="{{ $ctaUrl }}"
                       class="inline-flex items-center gap-2 rounded-lg px-4 py-2.5 bg-ram-blue text-white hover:opacity-90 shadow-soft">
                        {{ $ctaLabel }}
                    </a>
                </div>
            </div>

            {{-- Summary Cards --}}
            <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6">
                {{-- Application --}}
                <div class="bg-white border border-slate-200 rounded-xl shadow-soft p-5">
                    <div class="flex items-center justify-between mb-3">
                        <div class="font-medium">Application</div>
                        <span class="text-xs text-white px-2 py-1 rounded {{ $statusClass }}">
                            {{ $app?->status ? ucfirst($app->status) : 'Not started' }}
                        </span>
                    </div>
                    <div class="text-sm text-slate-600">
                        @if(!$app)
                            You haven’t started the membership application yet.
                        @else
                            <div><span class="text-slate-500">Company:</span> <span class="font-medium">{{ $app->company_name }}</span></div>
                            <div class="mt-1"><span class="text-slate-500">Submitted:</span> {{ optional($app->submitted_at)->format('d M Y H:i') ?? '—' }}</div>
                        @endif
                    </div>
                    <div class="mt-4">
                        <a href="{{ $ctaUrl }}" class="text-ram-blue underline text-sm">Manage</a>
                    </div>
                </div>

                {{-- Documents --}}
                <div class="bg-white border border-slate-200 rounded-xl shadow-soft p-5">
                    <div class="font-medium mb-3">Documents</div>
                    <div class="text-sm text-slate-600">
                        Uploaded: <span class="font-semibold">{{ $docCount }}</span>
                    </div>
                    <ul class="mt-3 space-y-2 text-sm">
                        @foreach($requiredTypes as $type)
                            @php $ok = in_array($type, $haveTypes, true); @endphp
                            <li class="flex items-center gap-2">
                                <span class="h-2.5 w-2.5 rounded-full {{ $ok ? 'bg-green-500' : 'bg-slate-300' }}"></span>
                                <span class="{{ $ok ? 'text-slate-800' : 'text-slate-500' }}">
                                    {{ $type === 'RDB_certificate' ? 'RDB Certificate' : ($type === 'TIN' ? 'TIN' : 'ID Copy') }}
                                </span>
                            </li>
                        @endforeach
                    </ul>
                    @if($app)
                        <div class="mt-4">
                            <a href="{{ route('application.show', $app) }}" class="text-ram-blue underline text-sm">View / Upload</a>
                        </div>
                    @endif
                </div>

                {{-- Payments placeholder --}}
                <div class="bg-white border border-slate-200 rounded-xl shadow-soft p-5">
                    <div class="font-medium mb-3">Payments</div>
                    <div class="text-sm text-slate-600">
                        <div>Status: <span class="font-medium">Coming soon</span></div>
                        <div class="mt-1 text-slate-500">Mobile Money, Cards, PayPal with auto-receipts.</div>
                    </div>
                    <div class="mt-4">
                        <span class="inline-flex items-center gap-2 text-xs text-slate-500">
                            <span class="h-2 w-2 rounded-full bg-ram-yellow"></span> Integration pending
                        </span>
                    </div>
                </div>

                {{-- Directory --}}
                <div class="bg-white border border-slate-200 rounded-xl shadow-soft p-5">
                    <div class="font-medium mb-3">Public Directory</div>
                    <div class="text-sm text-slate-600">
                        Your company will appear in the RAM public directory after approval.
                    </div>
                    @if($app && $app->status === 'approved')
                        <div class="mt-4">
                            <a href="#" class="text-ram-blue underline text-sm">Preview profile</a>
                        </div>
                    @endif
                </div>
            </div>

            {{-- Recent Documents --}}
            <div class="bg-white border border-slate-200 rounded-xl shadow-soft">
                <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                    <div class="font-medium">Recent Documents</div>
                    @if($app)
                        <a href="{{ route('application.show', $app) }}" class="text-ram-blue underline text-sm">Manage all</a>
                    @endif
                </div>
                <div class="px-5 py-5">
                    @if(!$app || $app->documents->isEmpty())
                        <p class="text-sm text-slate-600">No documents uploaded yet.</p>
                    @else
                        <ul class="divide-y divide-slate-100">
                            @foreach($app->documents->take(5) as $doc)
                                @php
                                    $exists = \Illuminate\Support\Facades\Storage::disk('public')->exists($doc->path);
                                    $url    = $exists ? \Illuminate\Support\Facades\Storage::disk('public')->url($doc->path) : null;
                                @endphp
                                <li class="py-2.5 flex items-center justify-between">
                                    <div class="min-w-0">
                                        <div class="font-medium truncate">{{ $doc->original_name }}</div>
                                        <div class="text-xs text-slate-500">
                                            {{ $doc->type }} @if($doc->size) • {{ number_format($doc->size/1024,0) }} KB @endif
                                        </div>
                                    </div>
                                    <div class="shrink-0 flex items-center gap-3 text-sm">
                                        @if($url)
                                            <a href="{{ $url }}" target="_blank" class="text-ram-blue underline">View</a>
                                            <a href="{{ $url }}" download class="text-ram-blue underline">Download</a>
                                        @else
                                            <span class="text-xs text-red-600">Missing</span>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>

            {{-- Admin Panel --}}
            @if($isAdmin)
                <div class="bg-white border border-slate-200 rounded-xl shadow-soft p-5">
                    <div class="flex items-center justify-between">
                        <div class="font-medium">Admin Panel</div>
                        <a href="{{ route('admin.apps.index') }}" class="text-ram-blue underline text-sm">Open Admin Dashboard</a>
                    </div>
                    <div class="grid sm:grid-cols-3 gap-4 mt-4 text-sm">
                        <div class="border border-slate-100 rounded-lg p-4">
                            <div class="text-slate-500">Total Applications</div>
                            <div class="text-xl font-semibold">{{ $totalApps }}</div>
                        </div>
                        <div class="border border-slate-100 rounded-lg p-4">
                            <div class="text-slate-500">Pending Review</div>
                            <div class="text-xl font-semibold">{{ $pendingCount }}</div>
                        </div>
                        <div class="border border-slate-100 rounded-lg p-4">
                            <div class="text-slate-500">Approved</div>
                            <div class="text-xl font-semibold">{{ $approvedCount }}</div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
