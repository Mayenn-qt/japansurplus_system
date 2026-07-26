<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->isStaff() && Auth::user()->isActive()) {
            return $next($request);
        }

        Auth::logout();
        return redirect()->route('login')->withErrors(['email' => 'Unauthorized or inactive staff access.']);
    }
}
