<!DOCTYPE html> 
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Shoot For The Stars Membership Portal</title>

    {{-- Fonts & Assets --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Use SFTS logo as favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('brand/sfts-logo.png') }}">
    <meta name="theme-color" content="#0F172A"> {{-- dark/navy --}}
</head>
<body class="bg-gradient-to-br from-slate-50 via-white to-slate-50 text-slate-900 antialiased">

    {{-- Top brand bar --}}
    <header class="bg-slate-950 text-white shadow-lg sticky top-0 z-50 backdrop-blur-sm bg-opacity-95">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <img src="{{ asset('brand/sfts-logo.png') }}" alt="Shoot For The Stars" class="h-12 w-12 rounded-full bg-slate-900 p-1 transition-transform group-hover:scale-105">
                <div class="leading-tight hidden sm:block">
                    <div class="font-bold tracking-wide uppercase text-xs text-yellow-400">
                        Shoot For The Stars
                    </div>
                    <div class="text-sm opacity-90 font-medium">
                        Youth Basketball Membership Portal
                    </div>
                </div>
            </a>

            <nav class="flex items-center gap-5 text-sm font-medium">
                @auth
                    <a href="{{ route('dashboard') }}" class="hover:text-yellow-400 transition-colors duration-200">Dashboard</a>
                    <a href="{{ route('application.create') }}" class="hover:text-yellow-400 transition-colors duration-200">
                        My Player Profile
                    </a>
                    @if(auth()->user()->is_admin ?? false)
                        <a href="{{ route('admin.apps.index') }}" class="hover:text-yellow-400 transition-colors duration-200">
                            Admin
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="hover:text-yellow-400 transition-colors duration-200">Log in</a>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-yellow-400 text-slate-950 rounded-lg font-semibold hover:bg-yellow-300 transition-all duration-200 shadow-md hover:shadow-lg">
                        Register
                    </a>
                @endauth
            </nav>
        </div>
    </header>

    {{-- HERO --}}
    <section class="relative overflow-hidden">
        {{-- Enhanced gradient background --}}
        <div class="absolute inset-0 -z-10"
             style="background:
                radial-gradient(1200px 450px at 65% -5%, rgba(250,204,21,0.12), transparent),
                radial-gradient(1000px 380px at 20% 5%, rgba(56,189,248,0.1), transparent),
                radial-gradient(800px 300px at 80% 40%, rgba(16,185,129,0.08), transparent);">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 lg:py-28">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
                <div class="lg:col-span-7 space-y-6">
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold tracking-tight text-slate-900 leading-tight">
                        Manage Your Child's
                        <span class="text-yellow-500 bg-gradient-to-r from-yellow-400 to-yellow-500 bg-clip-text text-transparent">Basketball Membership</span>
                        in One Place.
                    </h1>
                    <p class="text-lg sm:text-xl text-slate-600 max-w-2xl leading-relaxed">
                        Shoot For The Stars Membership Portal helps parents register players, follow payments,
                        choose age categories, and track their child's progress in our youth basketball academy –
                        from U8 to U16.
                    </p>

                    {{-- Primary CTA --}}
                    <div class="flex flex-col sm:flex-row gap-4 pt-2">
                        <a href="{{ route('application.create') }}"
                           class="inline-flex items-center justify-center px-8 py-4 rounded-xl text-slate-950 bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-300 hover:to-yellow-400 shadow-lg hover:shadow-xl font-semibold text-base transition-all duration-300 transform hover:-translate-y-0.5">
                            Register a Player
                            <svg class="ml-2 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                            </svg>
                        </a>
                    </div>

                    {{-- Light secondary links --}}
                    @guest
                        <div class="flex flex-wrap items-center gap-3 text-sm text-slate-600 pt-2">
                            <a href="{{ route('login') }}" class="font-medium underline decoration-2 underline-offset-4 hover:text-slate-900 transition-colors">Log in</a>
                            <span class="text-slate-400">•</span>
                            <a href="{{ route('register') }}" class="font-medium underline decoration-2 underline-offset-4 hover:text-slate-900 transition-colors">Create parent account</a>
                        </div>
                    @endguest
                </div>

                {{-- Enhanced info card --}}
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-slate-200/60 backdrop-blur-sm hover:shadow-2xl transition-all duration-300">
                        <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                            <img src="{{ asset('brand/sfts-logo.png') }}" class="h-12 w-12 rounded-full bg-slate-900 p-1.5" alt="Shoot For The Stars">
                            <div>
                                <div class="font-bold text-slate-900 text-base">
                                    Shoot For The Stars Basketball Academy
                                </div>
                                <div class="text-xs text-slate-500 font-medium mt-0.5">Youth Membership Portal</div>
                            </div>
                        </div>
                        <ul class="space-y-4 text-slate-700 mb-6">
                            <li class="flex items-start gap-3">
                                <span class="h-2.5 w-2.5 rounded-full bg-yellow-400 mt-2 flex-shrink-0 shadow-sm"></span>
                                <span class="text-sm leading-relaxed"><strong class="text-slate-900">Player categories:</strong> U8, U10, U12, U14, U16.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="h-2.5 w-2.5 rounded-full bg-sky-400 mt-2 flex-shrink-0 shadow-sm"></span>
                                <span class="text-sm leading-relaxed"><strong class="text-slate-900">Programs:</strong> Practice only, Full Program + Game Day, Shooting Clinics.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <span class="h-2.5 w-2.5 rounded-full bg-emerald-400 mt-2 flex-shrink-0 shadow-sm"></span>
                                <span class="text-sm leading-relaxed"><strong class="text-slate-900">Track</strong> monthly payments, balances, and active memberships.</span>
                            </li>
                        </ul>
                        <a href="{{ route('application.create') }}"
                           class="w-full inline-flex justify-center items-center px-5 py-3.5 rounded-xl bg-slate-900 text-white hover:bg-slate-800 text-sm font-semibold transition-all duration-200 shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                           Start Player Registration
                           <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                               <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                           </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- FEATURES --}}
    <section class="py-16 lg:py-24 bg-white/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8">
                <div class="bg-white rounded-2xl border border-slate-200/60 p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="h-3 w-3 rounded-full bg-yellow-400 shadow-sm group-hover:scale-110 transition-transform"></span>
                        <h3 class="text-slate-900 font-bold text-lg">Online Player Registration</h3>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Register new players for the academy, select age category and venue,
                        and keep all player details in one secure profile.
                    </p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200/60 p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="h-3 w-3 rounded-full bg-sky-400 shadow-sm group-hover:scale-110 transition-transform"></span>
                        <h3 class="text-slate-900 font-bold text-lg">Membership Payments</h3>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        Record monthly fees, see payment status, and monitor outstanding balances
                        for each player and program.
                    </p>
                </div>
                <div class="bg-white rounded-2xl border border-slate-200/60 p-8 shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1 group sm:col-span-2 lg:col-span-1">
                    <div class="flex items-center gap-3 mb-4">
                        <span class="h-3 w-3 rounded-full bg-emerald-400 shadow-sm group-hover:scale-110 transition-transform"></span>
                        <h3 class="text-slate-900 font-bold text-lg">Teams & Categories</h3>
                    </div>
                    <p class="text-slate-600 text-sm leading-relaxed">
                        View which team and category each player belongs to, and keep track of
                        active programs like practices, games, and clinics.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- Footer --}}
    <footer class="bg-slate-950 text-slate-300 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 text-sm flex flex-col sm:flex-row items-center justify-between gap-4">
            <span class="text-slate-400">© {{ date('Y') }} Shoot For The Stars Basketball Academy</span>
            <span class="flex items-center gap-2 text-slate-400">
                <span class="h-2 w-2 rounded-full bg-yellow-400 shadow-sm"></span>
                <span>Youth basketball membership &amp; player management portal</span>
            </span>
        </div>
    </footer>
</body>
</html>
