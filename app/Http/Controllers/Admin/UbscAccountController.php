<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkunUbsc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class UbscAccountController extends Controller
{
    public function index()
    {
        // Get all accounts (both Umum and Warga UB that are approved/rejected)
        $accounts = AkunUbsc::whereIn('status_verifikasi', ['approved', 'rejected'])
            ->orWhere('kategori', 0) // Include all Umum users
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.ubsc_account.index', compact('accounts'));
    }

    public function create()
    {
        return view('admin.ubsc_account.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:akun_ubsc,email',
            'password' => 'required|string|min:8',
            'kategori' => 'required|in:0,1',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'kategori.required' => 'Kategori wajib dipilih',
        ]);

        AkunUbsc::create([
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'kategori' => $validated['kategori'],
            'foto_identitas' => null,
            'status_verifikasi' => 'approved', // Auto approved when created by admin
            'tgl_daftar' => now()
        ]);

        Log::info('UBSC Account created by admin:', ['email' => $validated['email']]);

        return redirect()->route('admin.ubsc_account.index')
            ->with('success', 'Akun UBSC berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $account = AkunUbsc::findOrFail($id);
        return view('admin.ubsc_account.edit', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $account = AkunUbsc::findOrFail($id);

        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:255|unique:akun_ubsc,email,' . $id . ',id_akun',
            'password' => 'nullable|string|min:8',
            'kategori' => 'required|in:0,1',
        ], [
            'nama_lengkap.required' => 'Nama lengkap wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.min' => 'Password minimal 8 karakter',
            'kategori.required' => 'Kategori wajib dipilih',
        ]);

        $updateData = [
            'nama_lengkap' => $validated['nama_lengkap'],
            'email' => $validated['email'],
            'kategori' => $validated['kategori'],
        ];

        // Only update password if provided
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $account->update($updateData);

        Log::info('UBSC Account updated by admin:', ['id' => $id, 'email' => $validated['email']]);

        return redirect()->route('admin.ubsc_account.index')
            ->with('success', 'Akun UBSC berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $account = AkunUbsc::findOrFail($id);
        
        Log::info('UBSC Account deleted by admin:', ['id' => $id, 'email' => $account->email]);
        
        $account->delete();

        return redirect()->route('admin.ubsc_account.index')
            ->with('success', 'Akun UBSC berhasil dihapus!');
    }
}