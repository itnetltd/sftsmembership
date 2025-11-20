<x-guest-layout>
    {{-- Status (e.g., reset link sent) --}}
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="bg-white border border-slate-100 rounded-xl shadow-soft p-6">
        <div class="flex items-center gap-3 mb-4">
            <img src="{{ asset('brand/ram-logo.png') }}" alt="RAM" class="h-10 w-auto">
            <div>
                <div class="font-semibold">Welcome back</div>
                <div class="text-sm text-slate-600">Log in to your RAM account</div>
            </div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            {{-- Email --}}
            <div>
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    autocomplete="username"
                    class="block mt-1 w-full border-slate-300 focus:border-ram-blue focus:ring-ram-blue"
                />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div>
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="block mt-1 w-full border-slate-300 focus:border-ram-blue focus:ring-ram-blue"
                />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Remember + Forgot --}}
            <div class="flex items-center justify-between pt-1">
                <label for="remember_me" class="inline-flex items-center gap-2">
                    <input id="remember_me"
                           type="checkbox"
                           name="remember"
                           class="rounded border-slate-300 text-ram-blue focus:ring-ram-blue">
                    <span class="text-sm text-slate-700">{{ __('Remember me') }}</span>
                </label>

                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-ram-blue hover:underline">
                        {{ __('Forgot your password?') }}
                    </a>
                @endif
            </div>

            {{-- Submit --}}
            <div class="pt-2">
                <x-primary-button
                    class="ms-0 w-full justify-center bg-ram-blue hover:opacity-90 focus:ring-ram-blue">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </form>

        {{-- Divider + Register --}}
        <div class="mt-6 flex items-center gap-2 text-xs text-slate-400">
            <div class="flex-1 h-px bg-slate-200"></div>
            <span>or</span>
            <div class="flex-1 h-px bg-slate-200"></div>
        </div>
        <div class="mt-4 text-center text-sm">
            {{ __("Don’t have an account?") }}
            <a href="{{ route('register') }}" class="text-ram-blue hover:underline">Create one</a>
        </div>
    </div>
</x-guest-layout>
