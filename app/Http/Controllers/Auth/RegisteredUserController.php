<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'phone' => ['required', 'string', 'regex:/^(\+20|0)?1[0125][0-9]{8}$|^(\+966|0)?5[0-9]{8}$/'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'referral_code' => ['nullable', 'string', 'exists:users,referral_code'],
        ], [
            'phone.regex' => __('Please enter a valid Egyptian or Saudi phone number.'),
            'referral_code.exists' => __('The provided referral code is invalid.')
        ]);

        $referredByUser = null;
        if ($request->referral_code) {
            $referredByUser = User::where('referral_code', $request->referral_code)->first();
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'referred_by' => $referredByUser ? $referredByUser->id : null,
        ]);

        // Award points to the inviter
        if ($referredByUser) {
            $referralPoints = (int) \App\Models\PointSetting::getValue('referral_points', 50);
            if ($referralPoints > 0) {
                $referredByUser->addPoints(
                    $referralPoints, 
                    'referral', 
                    __('Reward for inviting :name', ['name' => $user->name]),
                    $user
                );
                
                // Notify the inviter
                $referredByUser->notify(new \App\Notifications\ReferralRewardNotification($user, $referralPoints));
            }
        }

        event(new Registered($user));

        Auth::login($user);
        
        $user->notify(new \App\Notifications\WelcomeNotification($user));

        $params = [];
        if ($request->filled('vendor_id')) {
            $params['vendor_id'] = $request->vendor_id;
        }

        return redirect(route('home', $params));
    }
}
