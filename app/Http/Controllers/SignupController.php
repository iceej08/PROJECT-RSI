<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AkunUbsc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rules\Password;

class SignupController extends Controller
{
    public function showSignUpForm()
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

        // If user chooses "Warga UB", store data in session and redirect to upload page
        if ($validated['kategori'] === 'warga_ub') {
            // Store signup data in session temporarily
            Session::put('signup_data', [
                'nama_lengkap' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'password' => $validated['password'], // Will be hashed later
                'kategori' => true, // true = warga_ub
            ]);

            // Redirect to identity upload page
            return redirect()->route('signup.upload-identity')
                ->with('info', 'Silakan upload foto identitas Anda untuk verifikasi sebagai Warga UB.');
        }

        // warga umum
        $akun = AkunUbsc::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'kategori' => false, // false = umum
            'foto_identitas' => null, // No identity photo needed
            'status_verifikasi' => null, // No verification needed for Umum
            'tgl_daftar' => now()->toDateString(),
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat! Silakan login untuk melanjutkan.');
    }

    
}