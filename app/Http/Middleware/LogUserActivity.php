<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserActivityLog;

class LogUserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Catat hanya jika user sudah login
        if (Auth::check()) {
            UserActivityLog::create([
                'user_id' => Auth::id(),
                'action' => $request->method() . ' ' . $request->path(),
                'model' => null, // Model dapat ditambahkan sesuai kebutuhan
                'model_id' => null, // Model ID jika diperlukan
                'details' => json_encode($request->all()), // Simpan detail request
                'ip_address' => $request->ip(),
            ]);
        }

        return $response;
    }
}
