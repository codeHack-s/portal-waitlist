<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Welcome -->
        <div class="flex items-center flex-col my-4 sm:my-6 md:my-8 justify-center">
            <h1 class="sm:text-3xl text-2xl font-bold text-gray-700">Welcome Back</h1>
            <p class="text-gray-400 italic text-xs">Codehacks™️ Waitlist V 0.0.1</p>
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex justify-between items-center">
            <div class="mt-4 text-gray-400 italic text-xs">
                <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500">New Here?</a>
            </div>
            <div class="flex items-center justify-end mt-4">
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        {{ __('Reset password?') }}
                    </a>
                @endif

                <x-primary-button class="ml-3">
                    {{ __('Log in') }}
                </x-primary-button>
            </div>
        </div>

        <!--waitlist info-->
        <div class="flex items-center flex-col my-4 sm:my-6 md:my-8 justify-center">
            <p class="text-gray-400 italic text-xs">
                <span class="text-indigo-600 hover:text-indigo-500">Codehacks™️</span> is a community of [young] developers, designers, and entrepreneurs. We are building a platform to help you learn, connect, and grow.
            </p>
        </div>
    </form>
</x-guest-layout>
