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
                'no_hp' => $validated['no_hp'] ?? null,
                'kategori' => true, // true = warga_ub
            ]);

            // Redirect to identity upload page
            return redirect()->route('signup.upload-identitas')
                ->with('info', 'Silakan upload foto identitas Anda untuk verifikasi sebagai Warga UB.');
        }

        // warga umum
        $akun = AkunUbsc::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'no_hp' => $validated['no_hp'] ?? null,
            'kategori' => false, // false = umum
            'foto_identitas' => null, // No identity photo needed
            'status_verifikasi' => null, // No verification needed for Umum
            'tgl_daftar' => now()->toDateString(),
        ]);

        return redirect()->route('login')
            ->with('success', 'Akun berhasil dibuat! Silakan login untuk melanjutkan.');
    }

    // upload page
    public function showUploadIdentitas()
    {
        // Check if signup data exists in session
        if (!Session::has('signup_data')) {
            return redirect()->route('signup')->with('error', 'Silakan isi form pendaftaran terlebih dahulu.');
        }

        return view('upload-identitas');
    }

    /**
     * Handle identity upload and complete registration
     */
    public function uploadIdentitas(Request $request)
    {
        // Validate session data exists
        if (!Session::has('signup_data')) {
            return redirect()->route('signup')->with('error', 'Silakan isi form pendaftaran terlebih dahulu.');
        }

        // Validate file upload
        $request->validate([
            'foto_identitas' => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:2048'], // Max 2MB
        ], [
            'foto_identitas.required' => 'Foto identitas wajib diupload',
            'foto_identitas.image' => 'File harus berupa gambar',
            'foto_identitas.mimes' => 'Format file harus jpeg, png, atau jpg',
            'foto_identitas.max' => 'Ukuran file maksimal 2MB',
        ]);

        // Get signup data from session
        $signupData = Session::get('signup_data');

        // Handle file upload
        $fotoIdentitasPath = null;
        if ($request->hasFile('foto_identitas')) {
            $file = $request->file('foto_identitas');
            $filename = time() . '_' . $file->getClientOriginalName();
            $fotoIdentitasPath = $file->storeAs('identitas', $filename, 'public');
        }

        // Create new user account with identity photo
        $akun = AkunUbsc::create([
            'nama_lengkap' => $signupData['nama_lengkap'],
            'email' => $signupData['email'],
            'password' => Hash::make($signupData['password']),
            'no_hp' => $signupData['no_hp'],
            'kategori' => $signupData['kategori'], // true = warga_ub
            'foto_identitas' => $fotoIdentitasPath,
            'status_verifikasi' => 'pending', // Warga UB needs admin verification
            'tgl_daftar' => now()->toDateString(),
        ]);

        // Clear session data
        Session::forget('signup_data');

        return redirect()->route('signup.verification-pending')
            ->with('email', $akun->email);
    }

    /**
     * Show verification pending page (for Warga UB after uploading identity)
     */
    public function showVerificationPending()
    {
        $email = session('email');
        
        if (!$email) {
            return redirect()->route('login');
        }

        return view('verification-pending', compact('email'));
    }
    
}