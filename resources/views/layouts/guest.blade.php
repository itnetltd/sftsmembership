<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'RAM Membership Portal') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link rel="icon" type="image/png" href="{{ asset('brand/ram-logo.png') }}">
    <meta name="theme-color" content="#0096D6">
</head>
<body class="font-sans antialiased bg-gray-50 text-ram-dark min-h-screen flex flex-col">

    {{-- Brand header --}}
    <header class="bg-ram-blue text-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('brand/ram-logo.png') }}" alt="RAM" class="h-10 w-auto">
                <div class="leading-tight hidden sm:block">
                    <div class="font-semibold tracking-wide">Rwanda Association of Manufacturers</div>
                    <div class="text-xs opacity-90">Membership Portal</div>
                </div>
            </a>

            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ route('register') }}" class="hover:text-ram-yellow transition">Register</a>
                <a href="{{ route('login') }}" class="hover:text-ram-yellow transition">Log in</a>
            </nav>
        </div>
    </header>

    {{-- Page content --}}
    <main class="flex-1">
        <div class="max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-10">
            {{ $slot }}
        </div>
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 text-sm text-slate-600 flex items-center justify-between">
            <span>© {{ date('Y') }} Rwanda Association of Manufacturers</span>
            <span class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-ram-yellow"></span>
                <span>Powered by RAM Membership Portal</span>
            </span>
        </div>
    </footer>
</body>
</html>
