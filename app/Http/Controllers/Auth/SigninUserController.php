<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Users;


class SigninUserController extends Controller
{
    public function signinView()
    {
        return view('auth.signin');
    }

    public function signin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ], [
            'email.required' => 'The email field is required.',
            'password.required' => 'The password field is required.',
            'g-recaptcha-response.required' => 'The captcha field is required.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember_me');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();
            if ($user->is_active) {
                return redirect()->route('home');
            } else {
                Auth::logout();
                return redirect()->back()->withErrors(['message' => 'Your account is inactive. Please contact the administrator.']);
            }
            return redirect()->route('home');
        }

        return redirect()->back()->withErrors(['message' => 'Invalid email or password!']);
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = Users::where('email', $googleUser->email)->first();

        if ($user) {
            Auth::login($user, true);
            return redirect()->route('home');
        } else {
            return redirect()->route('signin')->withErrors(['message' => 'No user found for this Google account! Please create an account to continue.']);
        }
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home')->with('info', 'You have logged out!');
    }
}