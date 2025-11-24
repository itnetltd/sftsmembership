<x-app-layout> 
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-semibold mb-6">Apply for Shoot For The Stars Membership</h1>

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

                {{-- Player basic info --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Player Full Name *
                    </label>
                    <input
                        type="text"
                        name="company_name"
                        value="{{ old('company_name') }}"
                        class="w-full rounded-md border-slate-300 focus:border-indigo-600 focus:ring-indigo-600"
                        placeholder="e.g. Malvin Mugunga"
                        required
                    >
                    @error('company_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Age Category (U8, U10, U12, U14, U16)
                        </label>
                        <input
                            type="text"
                            name="sector"
                            value="{{ old('sector') }}"
                            class="w-full rounded-md border-slate-300 focus:border-indigo-600 focus:ring-indigo-600"
                            placeholder="e.g. U12"
                        >
                        @error('sector')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Preferred Training Venue
                        </label>
                        <input
                            type="text"
                            name="location"
                            value="{{ old('location') }}"
                            class="w-full rounded-md border-slate-300 focus:border-indigo-600 focus:ring-indigo-600"
                            placeholder="e.g. Green Hills, ISK, Rebero"
                        >
                        @error('location')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Parent / Guardian Email
                        </label>
                        <input
                            type="email"
                            name="company_website"
                            value="{{ old('company_website') }}"
                            class="w-full rounded-md border-slate-300 focus:border-indigo-600 focus:ring-indigo-600"
                            placeholder="parent@example.com"
                        >
                        @error('company_website')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Parent / Guardian Phone
                        </label>
                        <input
                            type="text"
                            name="phone"
                            value="{{ old('phone') }}"
                            class="w-full rounded-md border-slate-300 focus:border-indigo-600 focus:ring-indigo-600"
                            placeholder="+250 7xx xxx xxx"
                        >
                        @error('phone')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Program details --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Program Type
                        </label>
                        <select
                            name="membership_type"
                            class="mt-1 block w-full border-gray-300 rounded focus:border-indigo-600 focus:ring-indigo-600 text-sm"
                        >
                            <option value="">— Select —</option>
                            @foreach (['Practice Only', 'Full Program + Game Day', 'Shooting Clinics'] as $opt)
                                <option value="{{ $opt }}" @selected(old('membership_type') === $opt)>{{ $opt }}</option>
                            @endforeach
                        </select>
                        @error('membership_type')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Team / Division (optional)
                        </label>
                        <input
                            type="text"
                            name="chamber"
                            value="{{ old('chamber') }}"
                            class="mt-1 block w-full border-gray-300 rounded focus:border-indigo-600 focus:ring-indigo-600 text-sm"
                            placeholder="e.g. U12 Advanced"
                        >
                        @error('chamber')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            School
                        </label>
                        <input
                            type="text"
                            name="association"
                            value="{{ old('association') }}"
                            class="mt-1 block w-full border-gray-300 rounded focus:border-indigo-600 focus:ring-indigo-600 text-sm"
                            placeholder="e.g. Green Hills Academy"
                        >
                        @error('association')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">
                            Jersey Name / Number (optional)
                        </label>
                        <input
                            type="text"
                            name="cluster_name"
                            value="{{ old('cluster_name') }}"
                            class="mt-1 block w-full border-gray-300 rounded focus:border-indigo-600 focus:ring-indigo-600 text-sm"
                            placeholder="e.g. MALVIN • #7"
                        >
                        @error('cluster_name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">
                        Player Notes (position, experience, health info)
                    </label>
                    <textarea
                        name="products_services"
                        rows="3"
                        class="w-full rounded-md border-slate-300 focus:border-indigo-600 focus:ring-indigo-600 text-sm"
                        placeholder="e.g. Guard, 2 years playing, no health issues…"
                    >{{ old('products_services') }}</textarea>
                    @error('products_services')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button
                        type="submit"
                        class="inline-flex items-center px-5 py-2.5 rounded-lg bg-slate-900 text-white hover:bg-slate-800"
                    >
                        Submit Application
                    </button>
                    <a href="{{ route('dashboard') }}" class="ml-3 text-slate-600 underline">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
