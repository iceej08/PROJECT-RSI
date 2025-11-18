<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran; // <-- PENTING: Import model Pembayaran
use App\Models\AkunMembership; // <-- PENTING: Import model AkunMembership

class AdminController extends Controller
{
    /**
     * Fungsi ini untuk dashboard (sudah ada di rute Anda).
     */
    public function dashboard()
    {
        // Pastikan Anda punya file 'resources/views/admin/dashboard.blade.php'
        return view('admin.dashboard'); 
    }

    /**
     * Fungsi BARU: Menampilkan halaman verifikasi pembayaran (Method GET).
     */
    public function verifikasiPembayaran()
    {
        // --- PERBAIKAN 1 ---
        // Memastikan kita memanggil relasi yang benar: membership.akunUbsc
        $daftarPembayaran = Pembayaran::with('membership.akunUbsc') 
                                    ->orderByRaw("FIELD(status_pembayaran, 'pending', 'verified', 'rejected')")
                                    ->latest() // Tampilkan yang terbaru
                                    ->get();

        // Kirim data ke view
        return view('admin.paymentverification', [
            'daftarPembayaran' => $daftarPembayaran
        ]);
    }

    /**
     * Fungsi BARU: Memproses 'Accept' atau 'Reject' (Method PATCH).
     */
    public function prosesVerifikasi(Request $request, Pembayaran $pembayaran)
    {
        // Validasi input dari tombol (pastikan 'status' adalah 'verified' atau 'rejected')
        $request->validate([
            'status' => 'required|in:verified,rejected',
        ]);

        // 1. Update status_pembayaran di tabel 'pembayaran'
        $pembayaran->status_pembayaran = $request->status;
        $pembayaran->save();

        // 2. Logika Tambahan (UC-07): Jika DITERIMA, aktifkan membership
        if ($request->status == 'verified') {
            // Ambil akun membership yang terkait
            $akunMembership = $pembayaran->membership;
            
            if ($akunMembership) {
                // --- PERBAIKAN 2 ---
                // Menggunakan 'status' (sesuai tabel akun_membership), BUKAN 'status_membership'
                $akunMembership->status = 'active';
                $akunMembership->save();
            }
        }
        
        // 3. Beri pesan sukses dan redirect kembali ke halaman verifikasi
        return redirect()->route('admin.verifikasi-pembayaran')
                         ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}