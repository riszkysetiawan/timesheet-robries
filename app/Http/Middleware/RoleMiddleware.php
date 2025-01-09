<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app/Http/Middleware/RoleMiddleware.php
    public function handle($request, Closure $next, ...$roles)
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role->nama; // Ambil role pengguna yang sedang login

            // Debugging
            \Log::info('User Role: ' . $userRole);
            \Log::info('Required Roles: ' . implode(', ', $roles));

            // Periksa apakah role pengguna ada di dalam daftar role yang diizinkan
            if (in_array($userRole, $roles)) {
                return $next($request); // Jika cocok, lanjutkan
            }
        }

        // Redirect jika role tidak cocok
        return redirect('/')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
