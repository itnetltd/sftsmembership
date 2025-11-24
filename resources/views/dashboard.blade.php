{{-- resources/views/dashboard.blade.php --}}
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            Dashboard
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Welcome + main CTA --}}
            <div class="bg-white overflow-hidden shadow-sm rounded-2xl border border-slate-100">
                <div class="px-6 py-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                    <div>
                        <div class="text-sm font-semibold text-slate-500 uppercase tracking-[0.18em]">
                            Shoot For The Stars · Membership
                        </div>
                        <h3 class="mt-1 text-xl font-semibold text-slate-900">
                            Welcome, {{ Str::headline(auth()->user()->name ?? 'Coach/Parent') }}.
                        </h3>
                        <p class="mt-2 text-sm text-slate-600 max-w-xl">
                            Manage your child’s basketball membership, player profile, payments and documents
                            for the Shoot For The Stars youth academy.
                        </p>
                    </div>

                    <div class="flex items-center gap-3">
                        <a
                            href="{{ route('application.create') }}"
                            class="inline-flex items-center px-5 py-2.5 rounded-lg bg-slate-900 text-white text-sm font-medium shadow-sm hover:bg-slate-800 transition"
                        >
                            Start / Continue Player Registration
                        </a>
                    </div>
                </div>
            </div>

            {{-- 4 key cards row --}}
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-4">

                {{-- Player Application --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <div class="font-semibold text-slate-900 text-sm">
                            Player Registration
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-slate-100 text-slate-600">
                            {{-- Replace with real status later --}}
                            Not started
                        </span>
                    </div>
                    <p class="text-sm text-slate-600">
                        Create or update your player’s profile with age category, venue, jersey number and contact details.
                    </p>
                    <div class="mt-4">
                        <a href="{{ route('application.create') }}" class="text-xs font-medium text-slate-900 hover:underline">
                            Manage player profile
                        </a>
                    </div>
                </div>

                {{-- Documents --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <div class="font-semibold text-slate-900 text-sm">
                            Player Documents
                        </div>
                        <div class="text-xs text-slate-500">
                            Uploaded: 0
                        </div>
                    </div>
                    <ul class="text-sm text-slate-600 space-y-1.5">
                        <li class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
                            Birth certificate
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-sky-400"></span>
                            Player photo (passport style)
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-400"></span>
                            Medical / insurance document
                        </li>
                    </ul>
                    <div class="mt-4">
                        <a href="#"
                           class="text-xs font-medium text-slate-900 hover:underline">
                            Upload / view documents
                        </a>
                    </div>
                </div>

                {{-- Payments --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <div class="font-semibold text-slate-900 text-sm">
                            Payments
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium bg-yellow-50 text-yellow-700 border border-yellow-100">
                            Coming soon
                        </span>
                    </div>
                    <p class="text-sm text-slate-600">
                        Track monthly membership fees, see balances, and view payment history for each player and program.
                    </p>
                    <div class="mt-4 text-xs text-slate-500 flex items-center gap-2">
                        <span class="h-1.5 w-1.5 rounded-full bg-yellow-400"></span>
                        <span>Mobile Money & card payment integration planned.</span>
                    </div>
                </div>

                {{-- Teams & Programs --}}
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-5 flex flex-col justify-between">
                    <div class="flex items-center justify-between mb-3">
                        <div class="font-semibold text-slate-900 text-sm">
                            Teams & Programs
                        </div>
                        <div class="text-xs text-slate-500">
                            SFTS Academy
                        </div>
                    </div>
                    <p class="text-sm text-slate-600">
                        See which team and age category your player belongs to, and which programs they’re enrolled in:
                        Practice Only, Full Program + Game Day, or Shooting Clinics.
                    </p>
                    <div class="mt-4">
                        <a href="#"
                           class="text-xs font-medium text-slate-900 hover:underline">
                            View teams & categories
                        </a>
                    </div>
                </div>
            </div>

            {{-- Recent section --}}
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100">
                <div class="px-6 py-4 border-b border-slate-100 flex items-center justify-between">
                    <h3 class="font-semibold text-sm text-slate-900">
                        Recent Activity
                    </h3>
                    <span class="text-xs text-slate-500">
                        Last 30 days
                    </span>
                </div>
                <div class="px-6 py-6 text-sm text-slate-500">
                    No recent updates yet. Once you start registration, upload documents, or record payments,
                    they will appear here.
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
