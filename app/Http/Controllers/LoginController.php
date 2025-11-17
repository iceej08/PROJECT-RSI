<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /**
     * Show the login form
     */
    public function showLoginForm()
    {
        return view('login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::guard('admin')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            
            $admin = Auth::guard('admin')->user();
            
            // Redirect to admin dashboard
            return redirect()->route('admin.dashboard')
                ->with('success', 'Selamat datang, ' . $admin->nama_lengkap . '!');
        }

        if (Auth::guard('web')->attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::guard('web')->user();

            // Check if user is Warga UB and not verified yet
            if ($user->kategori === true && $user->status_verifikasi === 'pending') {
                throw ValidationException::withMessages(['Akun Anda masih dalam proses verifikasi. Silakan tunggu hingga admin memverifikasi identitas Anda.']);
                Auth::guard('web')->logout();
                return redirect()->route('login');
            }

            return redirect()->route('welcome')
                ->with('success', 'Selamat datang, ' . $user->nama_lengkap . '!');
    }
        throw ValidationException::withMessages([
            'email' => ['Email atau password kamu salah.'],
        ]);
}

    /**
     * Handle logout
     */
    public function logout(Request $request)
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
