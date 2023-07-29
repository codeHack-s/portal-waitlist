<x-guest-layout>

    <!-- Referred By Message -->
    @if(request('ref'))
        @php
            $referrer = App\Models\User::where('referral_code', request('ref'))->first();
        @endphp
        @if($referrer)
            <div class="mb-4 text-center text-sm text-green-600">
                You've been referred by {{ $referrer->first_name }}
            </div>
        @else
            <div class="mb-4 text-center text-sm text-red-600">
                The referral code provided is not valid.
            </div>
        @endif
    @endif


    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Welcome -->
        <div class="flex items-center flex-col my-4 sm:my-6 md:my-8 justify-center">
            <h1 class="sm:text-3xl text-2xl font-bold text-gray-900">Welcome to {{ config('app.name', 'Laravel') }}</h1>
            <p class="text-gray-400 italic text-xs">Join the waitlist to be notified when we launch.</p>
        </div>

        <section class="names flex w-full gap-2 items-center justify-between">
            <!-- First Name -->
            <div>
                <x-input-label for="first_name" :value="__('First Name')" />
                <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" :value="old('first_name')" required autofocus autocomplete="First name" />
                <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
            </div>

            <!-- Last Name -->
            <div>
                <x-input-label for="last_name" :value="__('Last Name')" />
                <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" :value="old('last_name')" required autocomplete="Last Name" />
                <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
            </div>

        </section>
        <!-- Username -->
        <div class="mt-4">
            <x-input-label for="username" :value="__('Username')" />
            <x-text-input id="username" class="block mt-1 w-full" type="text" name="username" :value="old('username')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('username')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Phone Number -->
        <div class="mt-4">
            <x-input-label for="phone_number" :value="__('Phone Number')" />
            <x-number-input id="phone_number" class="block mt-1 w-full" type="tel" name="phone_number" :value="old('phone_number')" autocomplete="tel" />
            <x-input-error :messages="$errors->get('phone_number')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Referred By -->
        @if(isset($referrer))
            <div class="mt-4">
                @php
                    $referralCode = $referrer->first_name . '\'s Referral Code';
                @endphp

                <x-input-label for="referred_by" :value="$referralCode" />
                <x-text-input id="referred_by" class="block mt-1 w-full" type="text" name="referred_by" :value="$referrer->referral_code" readonly />
                <x-input-error :messages="$errors->get('referred_by')" class="mt-2" />
            </div>

        @else
            <div class="mt-4">
                <x-input-label for="referred_by" :value="__('Enter Referral Code')" />
                <x-text-input id="referred_by" class="block mt-1 w-full" type="text" name="referred_by" :value="old('referred_by')" />
                <x-input-error :messages="$errors->get('referred_by')" class="mt-2" />
            </div>
        @endif

        <!-- Terms of Service -->
        <div class="mt-4 flex gap-2">
            <p class="text-xs italic text-gray-400" for="terms_of_service">Accept Terms of Service and cookie policy</p>
            <input type="checkbox" id="terms_of_service" class="block mx-2" name="terms_of_service" required />
        </div>

        <div class="flex items-center justify-end mt-4">

            <a class="underline text-sm text-gray-600 hover:text-blue-500" href="{{ route('login') }}">
                {{ __('Already joined?') }}
            </a>

            <div class="tooltip tooltip-left" data-tip="By clicking Register, you agree to our Terms, Data Policy and Cookies Policy.">
                <x-primary-button class="ml-4">
                    {{ __('Join the waitlist') }}
                </x-primary-button>
            </div>

        </div>
    </form>
</x-guest-layout>
