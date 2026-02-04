<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsMarketing
{
    public function handle(Request $request, Closure $next): Response
    {
        // Jika belum login, arahkan ke login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Jika dia ADMIN, jangan biarkan dia masuk ke pintu Marketing,
        // Tapi langsung arahkan kembali ke Dashboard Admin
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return $next($request);
    }
}