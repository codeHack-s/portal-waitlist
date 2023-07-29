<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_number' => ['nullable', 'numeric', 'digits:10', 'unique:'.User::class],
        ]);

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'balance' => 10,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'referred_by' => $request->referred_by ?? null,
            'referral_code' => $this->generateReferralCode($request->first_name),
            'last_login_at' => now(),
        ]);

        //get the user's refferer
        $referrer = User::where('referral_code', $request->referred_by)->first();
        //increment the referrer's balance by 5
        if($referrer) {
            $referrer->increment('balance', 5);
        }


        event(new Registered($user));

        Auth::login($user);

        // Send verification email
        if(!$user->hasVerifiedEmail()) {
            $user->sendEmailVerificationNotification();
        }

        return redirect()->route('verification.notice');
    }

    private function generateReferralCode($name): string
    {
        do {
            // generate a random string of 8 uppercase characters and digits starting with a DEV
            $referral_code = 'DEV' .$name. Str::upper(Str::random(3));
        } while (User::where('referral_code', $referral_code)->exists());

        return $referral_code;
    }
}
