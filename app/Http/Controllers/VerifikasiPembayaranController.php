<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\AkunMembership;

class VerifikasiPembayaranController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard'); 
    }

    public function verifikasiPembayaran()
    {
        $daftarPembayaran = Pembayaran::with('membership.akun') 
                                    ->orderByRaw("FIELD(status_pembayaran, 'pending', 'verified', 'rejected')")
                                    ->latest() // Tampilkan yang terbaru
                                    ->get();

        return view('admin.verifikasi-pembayaran.paymentverification', [
            'daftarPembayaran' => $daftarPembayaran
        ]);
    }

    public function prosesVerifikasi(Request $request, Pembayaran $pembayaran)
    {
        $request->validate([
            'status' => 'required|in:verified,rejected',
        ]);

        $pembayaran->status_pembayaran = $request->status;
        $pembayaran->save();

        if ($request->status_pembayaran == 'verified') {
            
            $akunMembership = $pembayaran->membership; 
            
            if ($akunMembership) {
                $akunMembership->update(['status' => true]);
                $akunMembership->save();

            }
        }

        return redirect()->route('admin.verifikasi-pembayaran')
                         ->with('success', 'Status pembayaran berhasil diperbarui.');
    }
}