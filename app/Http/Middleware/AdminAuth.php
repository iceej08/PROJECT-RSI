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
        // Jika BUKAN admin yang login...
        if (!Auth::guard('admin')->check()) {
            
            // --- INI PERBAIKANNYA ---
            // Arahkan ke rute 'admin.login', BUKAN 'login'
            return redirect()->route('admin.login') 
                ->with('error', 'Anda harus login sebagai admin untuk mengakses halaman ini');
        }

        // Jika user biasa mencoba mengakses...
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();

            // --- INI PERBAIKANNYA ---
            // Arahkan ke rute 'admin.login', BUKAN 'login'
            return redirect()->route('admin.login')
                ->with('error', 'Akses ditolak. Halaman ini hanya untuk admin.');
        }
        
        // Jika lolos, lanjutkan
        return $next($request);
    }
}