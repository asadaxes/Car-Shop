<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Models\Users;


class RegisteredUserController extends Controller
{
    public function registerView()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string',
            'email' => [
                'required',
                'email',
                Rule::unique('users')->where(function ($query) use ($request) {
                    return $query->where('email', $request->email);
                }),
            ],
            'password' => 'required|min:6|confirmed',
            'agreement' => 'required|accepted',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'full_name.required' => 'Full name is required',
            'email.required' => 'The email field is required.',
            'email.email' => 'The email must be a valid email address.',
            'email.unique' => 'The email has already been taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.confirmed' => 'The password confirmation does not match.',
            'agreement.required' => 'You must agree to our Terms of Conditions and Privacy Policy.',
            'agreement.accepted' => 'You must agree to our Terms of Conditions and Privacy Policy.',
            'g-recaptcha-response.required' => 'The captcha field is required.',
        ]);

        $user = Users::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->route('verification.notice');
    }
}