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
    public function handle($request, Closure $next, $role)
    {
        if (Auth::check()) {
            $userRole = Auth::user()->role->nama;
            \Log::info('User Role: ' . $userRole);
            \Log::info('Required Role: ' . $role);

            if ($userRole === $role) {
                return $next($request);
            }
        }

        return redirect('/');
    }
}
