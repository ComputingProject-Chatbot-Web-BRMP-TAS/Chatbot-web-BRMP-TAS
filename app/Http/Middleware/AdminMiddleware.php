<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        // Jika belum login
        if (!Auth::check()) {
            return redirect('/ADMIN-BRMP-TAS/login')->withErrors(['email' => 'Silakan login terlebih dahulu.']);
        }

        // Jika login tapi bukan admin
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin.');
        }

        return $next($request);
    }
}
