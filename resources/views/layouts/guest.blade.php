<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>SFTS Membership Portal</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Updated favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/sfts-logo.png') }}">
    <meta name="theme-color" content="#0f172a"> {{-- Deep navy --}}
</head>

<body class="font-sans antialiased bg-gray-50 text-gray-800 min-h-screen flex flex-col">

    {{-- Brand header --}}
    <header class="bg-indigo-900 text-white shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-3 flex items-center justify-between">

            {{-- Logo + Title --}}
            <a href="{{ url('/') }}" class="flex items-center gap-3">
                <img src="{{ asset('images/sfts-logo.png') }}" alt="SFTS" class="h-10 w-auto rounded-full bg-white/10 p-1">

                <div class="leading-tight hidden sm:block">
                    <div class="font-semibold tracking-wide">Shoot for the Stars</div>
                    <div class="text-xs text-indigo-200">Membership Portal</div>
                </div>
            </a>

            {{-- Nav links --}}
            <nav class="flex items-center gap-4 text-sm">
                <a href="{{ route('register') }}" class="hover:text-indigo-200 transition">Register</a>
                <a href="{{ route('login') }}" class="hover:text-indigo-200 transition">Log in</a>
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

            <span>© {{ date('Y') }} Shoot for the Stars Basketball Academy</span>

            <span class="flex items-center gap-2">
                <span class="h-2 w-2 rounded-full bg-indigo-600"></span>
                <span>Powered by SFTS Membership Portal · IT NET Ltd</span>
            </span>

        </div>
    </footer>

</body>
</html>
