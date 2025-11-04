<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AkunUbsc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class SignupController extends Controller
{
    /**
     * Show the signup form
     */
    public function showSignupForm()
    {
        return view('signup');
    }

    /**
     * Handle signup request
     */
    public function signUp(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => ['required', 'string', 'max:100'],
            'email' => ['required', 'string', 'email', 'max:100', 'unique:akun_ubsc,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'kategori' => ['required', 'in:umum,warga_ub'],
            'terms' => ['accepted'],
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak cocok',
            'kategori.required' => 'Pilih kategori pendaftaran',
            'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        ]);

        // Create new user account
        $akun = AkunUbsc::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_hp' => $validated['no_hp'] ?? null,
            'kategori' => $validated['kategori'] === 'warga_ub' ? true : false,
            'status_verifikasi' => 'pending',
            'tgl_daftar' => now()->toDateString(),
        ]);

        // Auto login after registration
        Auth::guard('web')->login($akun);

        return redirect()->route('welcome')->with('success', 'Akun berhasil dibuat! Selamat datang di UB Sport Center.');
    }
}