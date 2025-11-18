<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // Check if authenticated as admin
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('login')
                ->with('error', 'Anda harus login sebagai admin untuk mengakses halaman ini');
        }
        
        // Extra security: Make sure they're NOT logged in as regular user
        // This prevents users from accessing admin panel even if they guess the URL
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
            return redirect()->route('login')
                ->with('error', 'Akses ditolak. Halaman ini hanya untuk admin.');
        }
        
        return $next($request);
    }
}
