<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkunUbsc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    public function index()
    {
        $accounts = AkunUbsc::orderBy('id_akun', 'desc')->get();
        
        return view('admin.verification.index', compact('accounts'));
    }

    public function viewPhoto($id)
    {
        $account = AkunUbsc::findOrFail($id);
        
        if (!$account->foto_identitas) {
            return response()->json(['error' => 'Tidak ada foto identitas'], 404);
        }

        return response()->json([
            'success' => true,
            'photo_url' => asset('storage/' . $account->foto_identitas),
            'nama' => $account->nama_lengkap,
            'email' => $account->email,
            'status' => $account->status_verifikasi
        ]);
    }

    public function approve($id)
    {
        $account = AkunUbsc::findOrFail($id);
        
        $account->update([
            'kategori' => 1, // Warga UB
            'status_verifikasi' => 'approved',
            'tgl_daftar' => $account->tgl_daftar ?? now()
        ]);

        // TODO: Send email notification to user
        Mail::to($account->email)->send(new VerificationApproved($account));
        
        return redirect()->back()->with('success', 'Akun berhasil diverifikasi sebagai Warga UB!');
    }

    public function reject($id)
    {
        $account = AkunUbsc::findOrFail($id);
        
        $account->update([
            'kategori' => 0, // Umum
            'status_verifikasi' => 'terverifikasi',
            'tgl_daftar' => now()
        ]);

        // TODO: Send email notification to user
        
        return redirect()->back()->with('info', 'Akun ditolak dan dikategorikan sebagai Umum.');
    }
}