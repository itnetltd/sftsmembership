<!DOCTYPE html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shoot For The Stars Membership Portal</title>

    {{-- Fonts & Assets --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Use SFTS logo as favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/sfts-logo.png') }}">
    <meta name="theme-color" content="#0F172A"> {{-- dark/navy --}}
</head>
<body class="bg-slate-50 text-slate-900 antialiased min-h-screen flex flex-col">

    {{-- Top brand bar --}}
    <header class="bg-slate-950 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/sfts-logo.png') }}" alt="Shoot For The Stars" class="h-10 w-auto rounded-full bg-slate-900">
                <div class="leading-tight hidden sm:block">
                    <div class="font-semibold tracking-wide uppercase text-xs text-sky-300">
                        Shoot For The Stars
                    </div>
                    <div class="text-sm opacity-95">
                        Youth Basketball Membership Portal
                    </div>
                </div>
            </a>

            <nav class="flex items-center gap-4 text-sm">
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-300 transition">Dashboard</a>
                    <a href="{{ route('application.create') }}" class="hover:text-yellow-300 transition">
                        My Player Profile
                    </a>
                    @if(auth()->user()->is_admin ?? false)
                        <a href="{{ route('admin.apps.index') }}" class="hover:text-yellow-300 transition">
                            Admin
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="hover:text-yellow-300 transition">Log in</a>
                    <a href="{{ route('register') }}" class="hover:text-yellow-300 transition">Register</a>
                @endauth
            </nav>
        </div>
    </header>

    <main class="flex-1">

        {{-- HERO --}}
        <section class="relative">
            <div class="absolute inset-0 -z-10 opacity-90"
                 style="background:
                    radial-gradient(1100px 380px at 60% -10%, rgba(250,204,21,0.18), transparent),
                    radial-gradient(900px 320px at 15% 0%, rgba(56,189,248,0.14), transparent);">
            </div>

            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
                <div class="grid lg:grid-cols-12 gap-10 items-center">
                    <div class="lg:col-span-7">
                        <h1 class="text-3xl sm:text-5xl font-semibold tracking-tight text-slate-900">
                            Manage Your Child’s
                            <span class="text-yellow-500">Basketball Membership</span>
                            in One Place.
                        </h1>
                        <p class="mt-5 text-slate-700 max-w-2xl">
                            Shoot For The Stars Membership Portal helps parents register players, follow payments,
                            choose age categories, and track their child’s progress in our youth basketball academy –
                            from U8 to U16.
                        </p>

                        {{-- Primary CTA --}}
                        <div class="mt-8">
                            <a href="{{ route('application.create') }}"
                               class="inline-flex items-center px-6 py-3 rounded-lg text-slate-950 bg-yellow-400 hover:bg-yellow-300 shadow-soft font-medium">
                                Register a Player
                            </a>
                        </div>

                        {{-- Light secondary links --}}
                        @guest
                            <div class="mt-4 flex flex-wrap items-center gap-4 text-sm text-slate-600">
                                <a href="{{ route('login') }}" class="underline hover:text-slate-900">Log in</a>
                                <span class="text-slate-400">•</span>
                                <a href="{{ route('register') }}" class="underline hover:text-slate-900">Create parent account</a>
                            </div>
                        @endguest
                    </div>

                    {{-- Compact card --}}
                    <div class="lg:col-span-5">
                        <div class="bg-white rounded-xl shadow-soft p-6 border border-slate-100">
                            <div class="flex items-center gap-3">
                                <img src="{{ asset('images/sfts-logo.png') }}" class="h-9 w-9 rounded-full bg-slate-900" alt="Shoot For The Stars">
                                <div class="font-medium">
                                    Shoot For The Stars Basketball Academy
                                    <div class="text-xs text-slate-500">Youth Membership Portal</div>
                                </div>
                            </div>
                            <ul class="mt-5 space-y-2 text-slate-700 text-sm">
                                <li class="flex items-center gap-2">
                                    <span class="h-2 w-2 bg-yellow-400 rounded-full"></span>
                                    Player categories: U8, U10, U12, U14, U16.
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="h-2 w-2 bg-sky-400 rounded-full"></span>
                                    Programs: Practice only, Full Program + Game Day, Shooting Clinics.
                                </li>
                                <li class="flex items-center gap-2">
                                    <span class="h-2 w-2 bg-emerald-400 rounded-full"></span>
                                    Track monthly payments, balances, and active memberships.
                                </li>
                            </ul>
                            <a href="{{ route('application.create') }}"
                               class="mt-6 w-full inline-flex justify-center px-4 py-2.5 rounded-lg bg-slate-900 text-white hover:bg-slate-800 text-sm font-medium">
                               Start Player Registration
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- FEATURES --}}
        <section class="py-12">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-soft">
                        <div class="flex items-center gap-2 text-slate-900 font-semibold">
                            <span class="h-2.5 w-2.5 rounded-full bg-yellow-400"></span>
                            Online Player Registration
                        </div>
                        <p class="mt-2 text-slate-600 text-sm">
                            Register new players for the academy, select age category and venue,
                            and keep all player details in one secure profile.
                        </p>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-soft">
                        <div class="flex items-center gap-2 text-slate-900 font-semibold">
                            <span class="h-2.5 w-2.5 rounded-full bg-sky-400"></span>
                            Membership Payments
                        </div>
                        <p class="mt-2 text-slate-600 text-sm">
                            Record monthly fees, see payment status, and monitor outstanding balances
                            for each player and program.
                        </p>
                    </div>
                    <div class="bg-white rounded-xl border border-slate-100 p-6 shadow-soft">
                        <div class="flex items-center gap-2 text-slate-900 font-semibold">
                            <span class="h-2.5 w-2.5 rounded-full bg-emerald-400"></span>
                            Teams & Categories
                        </div>
                        <p class="mt-2 text-slate-600 text-sm">
                            View which team and category each player belongs to, and keep track of
                            active programs like practices, games, and clinics.
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-sm text-slate-600 flex items-center justify-between">
            <span>© {{ date('Y') }} Shoot For The Stars Basketball Academy</span>
            <span class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-yellow-400"></span>
                <span>Youth basketball membership &amp; player management portal</span>
            </span>
        </div>
    </footer>
</body>
</html>
