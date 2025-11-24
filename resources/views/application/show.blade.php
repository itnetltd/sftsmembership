<x-app-layout> 
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- flash + errors --}}
        @if(session('ok'))
            <div class="mb-4 rounded-lg bg-green-50 text-green-700 px-4 py-3">{{ session('ok') }}</div>
        @endif
        @if(session('info'))
            <div class="mb-4 rounded-lg bg-blue-50 text-blue-700 px-4 py-3">{{ session('info') }}</div>
        @endif
        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-50 text-red-700 px-4 py-3">
                <div class="font-semibold">Please fix the following:</div>
                <ul class="list-disc ml-6 mt-2">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- page title --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold">My Player Application</h1>
            <p class="text-slate-600 text-sm">Track application status and manage your player details & documents.</p>
        </div>

        <div class="grid lg:grid-cols-12 gap-6">
            {{-- SUMMARY --}}
            <section class="lg:col-span-7 space-y-4">
                <div class="bg-white rounded-xl border border-slate-200 shadow-soft">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <img src="{{ asset('images/sfts-logo.png') }}" class="h-8 w-8 rounded-full bg-slate-900 p-0.5" alt="Shoot For The Stars">
                            <div class="font-medium">Application Summary</div>
                        </div>
                        @php
                            $badge = match($app->status) {
                                'approved' => 'bg-green-600',
                                'rejected' => 'bg-red-600',
                                default => 'bg-yellow-600'
                            };
                        @endphp
                        <span class="text-xs text-white px-2 py-1 rounded {{ $badge }}">
                            {{ ucfirst($app->status) }}
                        </span>
                    </div>

                    <div class="px-5 py-5 grid sm:grid-cols-2 gap-4 text-sm">
                        <div>
                            <div class="text-slate-500">Player Name</div>
                            <div class="font-medium">{{ $app->company_name }}</div>
                        </div>
                        <div>
                            <div class="text-slate-500">Age Category</div>
                            <div class="font-medium">{{ $app->sector ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="text-slate-500">Training Venue</div>
                            <div class="font-medium">{{ $app->location ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="text-slate-500">Parent / Guardian Email</div>
                            <div class="font-medium">
                                @if($app->company_website)
                                    <a href="mailto:{{ $app->company_website }}" class="text-indigo-600 underline break-all">
                                        {{ $app->company_website }}
                                    </a>
                                @else
                                    —
                                @endif
                            </div>
                        </div>
                        <div class="sm:col-span-2">
                            <div class="text-slate-500">Player Summary</div>
                            <div class="font-medium whitespace-pre-line">{{ $app->products_services ?? '—' }}</div>
                        </div>
                        <div>
                            <div class="text-slate-500">Submitted</div>
                            <div class="font-medium">{{ optional($app->submitted_at)->format('d M Y H:i') }}</div>
                        </div>
                    </div>
                </div>

                {{-- MEMBERSHIP / PROGRAM DETAILS --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-soft">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div class="font-medium">Membership & Program Details</div>
                    </div>

                    <div class="px-5 py-5 text-sm">
                        <dl class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <dt class="text-slate-500">Program Type</dt>
                                <dd class="font-medium">{{ $app->membership_type ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500">Team / Division</dt>
                                <dd class="font-medium">{{ $app->chamber ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500">School</dt>
                                <dd class="font-medium">{{ $app->association ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500">Jersey Name / Number</dt>
                                <dd class="font-medium">{{ $app->cluster_name ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500">Player Document Type</dt>
                                <dd class="font-medium">{{ $app->registration_type ?? '—' }}</dd>
                            </div>
                            <div>
                                <dt class="text-slate-500">Document Number</dt>
                                <dd class="font-medium">{{ $app->registration_number ?? '—' }}</dd>
                            </div>
                        </dl>

                        <h4 class="font-semibold mt-6 mb-2">Address & Contacts</h4>
                        <dl class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div><dt class="text-slate-500">Parent Phone</dt><dd class="font-medium">{{ $app->phone ?? '—' }}</dd></div>
                            <div><dt class="text-slate-500">Emergency Phone</dt><dd class="font-medium">{{ $app->fax ?? '—' }}</dd></div>
                            <div><dt class="text-slate-500">P.O. Box / Address</dt><dd class="font-medium">{{ $app->po_box ?? '—' }}</dd></div>
                            <div><dt class="text-slate-500">Street</dt><dd class="font-medium">{{ $app->street ?? '—' }}</dd></div>
                            <div><dt class="text-slate-500">Building</dt><dd class="font-medium">{{ $app->building ?? '—' }}</dd></div>
                            <div><dt class="text-slate-500">Neighbourhood</dt><dd class="font-medium">{{ $app->quartier ?? '—' }}</dd></div>
                            <div><dt class="text-slate-500">Province</dt><dd class="font-medium">{{ $app->province ?? '—' }}</dd></div>
                            <div><dt class="text-slate-500">District</dt><dd class="font-medium">{{ $app->district ?? '—' }}</dd></div>
                            <div><dt class="text-slate-500">Sector</dt><dd class="font-medium">{{ $app->sector_admin ?? '—' }}</dd></div>
                            <div><dt class="text-slate-500">Cell</dt><dd class="font-medium">{{ $app->cell ?? '—' }}</dd></div>
                        </dl>

                        @if($app->relationLoaded('contacts') ? $app->contacts->isNotEmpty() : $app->contacts()->exists())
                            <h4 class="font-semibold mt-6 mb-2">Parent / Emergency Contacts</h4>
                            <ul class="list-disc ml-6 space-y-1">
                                @foreach($app->contacts as $c)
                                    <li>
                                        <span class="font-medium">{{ $c->role ?? 'Contact' }}</span> —
                                        {{ trim(($c->first_name ?? '') . ' ' . ($c->last_name ?? '')) }}
                                        @if($c->gender) ({{ $c->gender }}) @endif
                                        @if($c->phone) · {{ $c->phone }} @endif
                                        @if($c->email) · {{ $c->email }} @endif
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>

                {{-- DOCUMENTS LIST --}}
                <div class="bg-white rounded-xl border border-slate-200 shadow-soft">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <div class="font-medium">Player Documents</div>
                        @if($app->status !== 'pending')
                            <span class="text-xs text-slate-500">Uploads locked ({{ $app->status }})</span>
                        @endif
                    </div>

                    <div class="px-5 py-5">
                        @if($app->documents->isEmpty())
                            <p class="text-slate-600 text-sm">No documents uploaded yet.</p>
                        @else
                            <ul class="space-y-3">
                                @foreach($app->documents as $doc)
                                    @php
                                        $disk = 'public';
                                        $exists = \Illuminate\Support\Facades\Storage::disk($disk)->exists($doc->path);
                                        $url = $exists ? \Illuminate\Support\Facades\Storage::disk($disk)->url($doc->path) : null;
                                    @endphp
                                    <li class="flex items-center justify-between gap-4 border border-slate-100 rounded-lg px-3 py-2">
                                        <div class="min-w-0">
                                            <div class="font-medium truncate">
                                                {{ $doc->type }} — {{ $doc->original_name }}
                                            </div>
                                            <div class="text-xs text-slate-500">
                                                @if($doc->size) {{ number_format($doc->size/1024,0) }} KB • @endif
                                                {{ $doc->mime ?? 'file' }}
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-3 shrink-0">
                                            @if($url)
                                                <a href="{{ $url }}" target="_blank" class="text-indigo-600 underline text-sm">View</a>
                                                <a href="{{ $url }}" download class="text-indigo-600 underline text-sm">Download</a>
                                            @else
                                                <span class="text-xs text-red-600">Missing file</span>
                                            @endif

                                            {{-- Delete only while pending --}}
                                            @if($app->status === 'pending')
                                                <form action="{{ route('documents.destroy', $doc) }}" method="POST"
                                                      onsubmit="return confirm('Remove this document?')" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="text-red-600 underline text-sm">Delete</button>
                                                </form>
                                            @endif
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                </div>
            </section>

            {{-- UPLOAD (pending only) --}}
            <aside class="lg:col-span-5">
                @if($app->status === 'pending')
                    <div class="bg-white rounded-xl border border-slate-200 shadow-soft sticky top-6">
                        <div class="px-5 py-4 border-b border-slate-100">
                            <div class="font-medium">Upload Required Documents</div>
                            <p class="text-xs text-slate-500 mt-1">Allowed: PDF/JPG/PNG • Max 5MB</p>
                        </div>

                        <form method="post" action="{{ route('documents.store', $app) }}" enctype="multipart/form-data" class="px-5 py-5 space-y-4">
                            @csrf
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Document Type</label>
                                <select name="type" required
                                        class="border-slate-300 rounded-md w-full focus:border-indigo-600 focus:ring-indigo-600 text-sm">
                                    <option value="Birth Certificate">Birth Certificate</option>
                                    <option value="Player ID / Passport">Player ID / Passport</option>
                                    <option value="Insurance / Medical">Insurance / Medical</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">File</label>
                                <input type="file" name="file" required
                                       class="block w-full text-sm border-slate-300 rounded-md focus:border-indigo-600 focus:ring-indigo-600">
                            </div>
                            <button type="submit"
                                    class="w-full inline-flex justify-center px-4 py-2.5 rounded-lg bg-slate-900 text-white hover:bg-slate-800">
                                Upload
                            </button>
                        </form>
                    </div>
                @else
                    <div class="bg-white rounded-xl border border-slate-200 shadow-soft p-5">
                        <div class="font-medium">Uploads Locked</div>
                        <p class="text-sm text-slate-600 mt-1">
                            This application is <span class="font-medium">{{ $app->status }}</span>. Document uploads and deletions are disabled.
                        </p>
                    </div>
                @endif
            </aside>
        </div>
    </div>
</x-app-layout>
