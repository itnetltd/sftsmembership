<x-app-layout>
    <div class="max-w-4xl mx-auto py-6">
        <a href="{{ route('admin.apps.index') }}" class="text-blue-600 underline">&larr; Back</a>

        <h1 class="text-2xl font-semibold mt-3 mb-4">Application #{{ $app->id }}</h1>

        @if(session('ok'))
            <div class="bg-green-50 text-green-700 p-3 rounded mb-4">{{ session('ok') }}</div>
        @endif

        @php
            $badge = match($app->status){
                'approved' => 'bg-green-600',
                'rejected' => 'bg-red-600',
                default => 'bg-yellow-600'
            };
        @endphp

        <div class="border rounded p-4 mb-6 bg-white shadow">
            <div class="flex items-center justify-between">
                <p>
                    <strong>Status:</strong>
                    <span class="inline-block text-white text-xs px-2 py-1 rounded {{ $badge }}">
                        {{ ucfirst($app->status) }}
                    </span>
                </p>

                <div class="space-x-2">
                    {{-- Approve / Reject (disabled if not pending) --}}
                    <form action="{{ route('admin.apps.approve', $app) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-3 py-1 rounded text-white bg-green-600 disabled:opacity-50"
                                @disabled($app->status !== 'pending')>
                            Approve
                        </button>
                    </form>

                    <form action="{{ route('admin.apps.reject', $app) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="px-3 py-1 rounded text-white bg-red-600 disabled:opacity-50"
                                @disabled($app->status !== 'pending')>
                            Reject
                        </button>
                    </form>
                </div>
            </div>

            <div class="mt-4 grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <p><strong>Company:</strong> {{ $app->company_name }}</p>
                <p><strong>Applicant:</strong> {{ optional($app->user)->name ?? '—' }} ({{ optional($app->user)->email }})</p>
                <p><strong>Sector:</strong> {{ $app->sector ?? '—' }}</p>
                <p><strong>Location:</strong> {{ $app->location ?? '—' }}</p>
                <p class="sm:col-span-2">
                    <strong>Website:</strong>
                    @if($app->company_website)
                        <a href="{{ $app->company_website }}" target="_blank" rel="noopener" class="text-blue-600 underline">
                            {{ $app->company_website }}
                        </a>
                    @else
                        —
                    @endif
                </p>
                <p class="sm:col-span-2"><strong>Products/Services:</strong> {{ $app->products_services ?? '—' }}</p>
                <p class="sm:col-span-2"><strong>Submitted:</strong> {{ optional($app->submitted_at)->format('d M Y H:i') }}</p>
            </div>
        </div>

        <h2 class="text-lg font-semibold mb-2">Documents</h2>
        @if($app->documents->isEmpty())
            <p>No documents uploaded.</p>
        @else
            <ul class="list-disc ml-6 space-y-1">
                @foreach($app->documents as $doc)
                    @php
                        $disk = 'public';
                        $exists = \Illuminate\Support\Facades\Storage::disk($disk)->exists($doc->path);
                        $url = $exists ? \Illuminate\Support\Facades\Storage::disk($disk)->url($doc->path) : null;
                    @endphp
                    <li>
                        <span class="font-medium">{{ $doc->type }}</span> — {{ $doc->original_name }}
                        @if($doc->size)
                            <span class="text-gray-500 text-xs">({{ number_format($doc->size / 1024, 0) }} KB)</span>
                        @endif
                        @if($url)
                            <span class="ml-2">
                                <a href="{{ $url }}" target="_blank" class="text-blue-600 underline">View</a>
                                <span class="text-gray-400">|</span>
                                <a href="{{ $url }}" download class="text-blue-600 underline">Download</a>
                            </span>
                        @else
                            <span class="text-xs text-red-600 ml-2">File missing</span>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</x-app-layout>
