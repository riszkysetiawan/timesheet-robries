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
            // Access the role name via the relationship
            $userRole = Auth::user()->role->nama; // Assuming 'nama' is the role name

            // Compare the role
            if ($userRole === $role) {
                return $next($request);
            }
        }

        return redirect('/');
    }
}
