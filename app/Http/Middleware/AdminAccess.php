<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->is_admin && $request->user()->is_active) {
            return $next($request);
        }
        return redirect()->route("dashboard");
    }
}