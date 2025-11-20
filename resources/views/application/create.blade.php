<x-app-layout>
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-semibold mb-6">Apply for RAM Membership</h1>

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

        <div class="bg-white rounded-xl border border-slate-200 shadow-soft p-6">
            <form action="{{ route('application.store') }}" method="POST" class="grid gap-4">
                @csrf

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Company Name *</label>
                    <input type="text" name="company_name" value="{{ old('company_name') }}"
                           class="w-full rounded-md border-slate-300 focus:border-ram-blue focus:ring-ram-blue" required>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Sector</label>
                        <input type="text" name="sector" value="{{ old('sector') }}"
                               class="w-full rounded-md border-slate-300 focus:border-ram-blue focus:ring-ram-blue">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Location</label>
                        <input type="text" name="location" value="{{ old('location') }}"
                               class="w-full rounded-md border-slate-300 focus:border-ram-blue focus:ring-ram-blue">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Company Website</label>
                    <input type="url" name="company_website" placeholder="https://example.com" value="{{ old('company_website') }}"
                           class="w-full rounded-md border-slate-300 focus:border-ram-blue focus:ring-ram-blue">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Products / Services</label>
                    <textarea name="products_services" rows="4"
                              class="w-full rounded-md border-slate-300 focus:border-ram-blue focus:ring-ram-blue"
                              placeholder="Briefly describe what you manufacture or provide">{{ old('products_services') }}</textarea>
                </div>

                
                {{-- PSF: Membership --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium">Membership Type</label>
        <select name="membership_type" class="mt-1 block w-full border-gray-300 rounded">
            <option value="">— Select —</option>
            @foreach (['Champions','Ordinary','Golden Circle'] as $opt)
                <option value="{{ $opt }}" @selected(old('membership_type')===$opt)>{{ $opt }}</option>
            @endforeach
        </select>
        @error('membership_type') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Chamber</label>
        <input type="text" name="chamber" value="{{ old('chamber') }}" class="mt-1 block w-full border-gray-300 rounded">
        @error('chamber') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Association</label>
        <input type="text" name="association" value="{{ old('association') }}" class="mt-1 block w-full border-gray-300 rounded">
        @error('association') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Cluster Name</label>
        <input type="text" name="cluster_name" value="{{ old('cluster_name') }}" class="mt-1 block w-full border-gray-300 rounded">
        @error('cluster_name') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    
</div>
{{-- PSF: Registration --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-6">
    <div>
        <label class="block text-sm font-medium">Registration Type</label>
        <select name="registration_type" class="mt-1 block w-full border-gray-300 rounded">
            <option value="">— Select —</option>
            @foreach (['TIN','Company code','Patent','RCA Number'] as $opt)
                <option value="{{ $opt }}" @selected(old('registration_type')===$opt)>{{ $opt }}</option>
            @endforeach
        </select>
        @error('registration_type') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Registration Number</label>
        <input type="text" name="registration_number" value="{{ old('registration_number') }}" class="mt-1 block w-full border-gray-300 rounded">
        @error('registration_number') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
</div>
{{-- PSF: Address & Contact --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    <div>
        <label class="block text-sm font-medium">Phone</label>
        <input type="text" name="phone" value="{{ old('phone') }}" class="mt-1 block w-full border-gray-300 rounded">
        @error('phone') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">Fax</label>
        <input type="text" name="fax" value="{{ old('fax') }}" class="mt-1 block w-full border-gray-300 rounded">
        @error('fax') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>
    <div>
        <label class="block text-sm font-medium">P.O. Box</label>
        <input type="text" name="po_box" value="{{ old('po_box') }}" class="mt-1 block w-full border-gray-300 rounded">
        @error('po_box') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-sm font-medium">Street</label>
        <input type="text" name="street" value="{{ old('street') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>
    <div>
        <label class="block text-sm font-medium">Building</label>
        <input type="text" name="building" value="{{ old('building') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>
    <div>
        <label class="block text-sm font-medium">Quartier</label>
        <input type="text" name="quartier" value="{{ old('quartier') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>

    <div>
        <label class="block text-sm font-medium">Province</label>
        <input type="text" name="province" value="{{ old('province') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>
    <div>
        <label class="block text-sm font-medium">District</label>
        <input type="text" name="district" value="{{ old('district') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>
    <div>
        <label class="block text-sm font-medium">Sector</label>
        <input type="text" name="sector_admin" value="{{ old('sector_admin') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>

    <div>
        <label class="block text-sm font-medium">Cell</label>
        <input type="text" name="cell" value="{{ old('cell') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>
</div>
{{-- PSF: Company Profile --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mt-6">
    <div>
        <label class="block text-sm font-medium">Company Type</label>
        <input type="text" name="company_type" value="{{ old('company_type') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>
    <div>
        <label class="block text-sm font-medium">Ownership</label>
        <input type="text" name="ownership" value="{{ old('ownership') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>
    <div>
        <label class="block text-sm font-medium">Business Activity</label>
        <input type="text" name="business_activity" value="{{ old('business_activity') }}" class="mt-1 block w-full border-gray-300 rounded">
    </div>

    <div class="md:col-span-3">
        <label class="block text-sm font-medium">Activity Detail</label>
        <textarea name="business_activity_detail" rows="3" class="mt-1 block w-full border-gray-300 rounded">{{ old('business_activity_detail') }}</textarea>
    </div>

    <div class="md:col-span-3">
        <label class="block text-sm font-medium">Export/Import (goods/services)</label>
        <textarea name="export_import" rows="2" class="mt-1 block w-full border-gray-300 rounded">{{ old('export_import') }}</textarea>
    </div>

    <div class="md:col-span-3">
        <label class="block text-sm font-medium">Export/Import Countries</label>
        <textarea name="export_import_countries" rows="2" class="mt-1 block w-full border-gray-300 rounded">{{ old('export_import_countries') }}</textarea>
    </div>

    <div>
        <label class="block text-sm font-medium">Permanent Employees (range)</label>
        <input type="text" name="employees_perm" value="{{ old('employees_perm') }}" class="mt-1 block w-full border-gray-300 rounded" placeholder="e.g., 1–5">
    </div>
    <div>
        <label class="block text-sm font-medium">Part-time Employees (range)</label>
        <input type="text" name="employees_part" value="{{ old('employees_part') }}" class="mt-1 block w-full border-gray-300 rounded" placeholder="e.g., 1–5">
    </div>
</div>
{{-- PSF: Contacts (optional) --}}
<div class="mt-8">
    <h3 class="text-lg font-semibold mb-2">Key Contacts</h3>

    @for ($i = 0; $i < 2; $i++)
        <div class="border rounded p-4 mb-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium">Role</label>
                    <input type="text" name="contacts[{{ $i }}][role]" value="{{ old("contacts.$i.role") }}" class="mt-1 block w-full border-gray-300 rounded" placeholder="Owner / MD / Finance / Legal">
                </div>
                <div>
                    <label class="block text-sm font-medium">First Name</label>
                    <input type="text" name="contacts[{{ $i }}][first_name]" value="{{ old("contacts.$i.first_name") }}" class="mt-1 block w-full border-gray-300 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Last Name</label>
                    <input type="text" name="contacts[{{ $i }}][last_name]" value="{{ old("contacts.$i.last_name") }}" class="mt-1 block w-full border-gray-300 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Gender</label>
                    <select name="contacts[{{ $i }}][gender]" class="mt-1 block w-full border-gray-300 rounded">
                        <option value="">—</option>
                        <option value="Male" @selected(old("contacts.$i.gender")==='Male')>Male</option>
                        <option value="Female" @selected(old("contacts.$i.gender")==='Female')>Female</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium">Phone</label>
                    <input type="text" name="contacts[{{ $i }}][phone]" value="{{ old("contacts.$i.phone") }}" class="mt-1 block w-full border-gray-300 rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Email</label>
                    <input type="email" name="contacts[{{ $i }}][email]" value="{{ old("contacts.$i.email") }}" class="mt-1 block w-full border-gray-300 rounded">
                </div>
            </div>
        </div>
    @endfor
</div>
<div class="pt-2">
                    <button type="submit"
                            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-ram-blue text-white hover:opacity-90">
                        Submit Application
                    </button>
                    <a href="{{ route('dashboard') }}" class="ml-3 text-slate-600 underline">Cancel</a>
                </div>

            </form>
        </div>
    </div>
</x-app-layout>
