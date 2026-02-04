<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login, arahkan ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Jika dia LOGIN tapi BUKAN Admin, jangan kasih error 403
        // Tapi arahkan ke rumahnya (Marketing Dashboard) agar tidak looping
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('marketing.dashboard');
        }

        return $next($request);
    }
}