<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckActive
{
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if ($user && !$user->is_active) {
            Auth::logout();
            return redirect()->route('signin')->with('error', 'Your account has been suspended. Please contact our support team for more information.');
        }

        return $next($request);
    }
}