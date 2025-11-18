<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkunUbsc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\VerificationApproved;
use App\Mail\VerificationRejected;

class VerificationController extends Controller
{
    public function index()
    {
        $accounts = AkunUbsc::where('kategori', 1)
            ->where('status_verifikasi', 'pending')
            ->whereNotNull('foto_identitas')
            ->orderBy('created_at', 'desc')
            ->get();
        
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
        Log::info('Account approved:', ['id' => $id, 'email' => $account->email]);

        // Send email notification
        try {
            Mail::to($account->email)->send(new VerificationApproved($account));
            Log::info('Approval email sent to: ' . $account->email);
        } catch (\Exception $e) {
            Log::error('Failed to send approval email: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', 'Akun berhasil diverifikasi sebagai Warga UB dan email notifikasi telah dikirim!');
    }

    public function reject($id)
    {
        $account = AkunUbsc::findOrFail($id);
        
        $account->update([
            'kategori' => 0, // Change to Umum
            'status_verifikasi' => 'rejected',
            'tgl_daftar' => $account->tgl_daftar ?? now()
        ]);

        Log::info('Account rejected:', ['id' => $id, 'email' => $account->email]);

        // TODO: Send email notification
        try {
            Mail::to($account->email)->send(new VerificationRejected($account));
            Log::info('Rejection email sent to: ' . $account->email);
        } catch (\Exception $e) {
            Log::error('Failed to send rejection email: ' . $e->getMessage());
            // Continue even if email fails
        }
        
       return redirect()->back()->with('info', 'Akun ditolak dan dikategorikan sebagai Umum. Email notifikasi telah dikirim.');
    }
}