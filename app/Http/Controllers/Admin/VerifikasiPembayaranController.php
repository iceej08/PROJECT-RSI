<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use App\Models\Invoice;
use App\Models\Transaksi;
use App\Models\AkunMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class VerifikasiPembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayaran::with(['invoice.transaksi.membership.akun', 'membership'])
            ->whereIn('status_pembayaran', ['pending', 'verified', 'rejected'])
            // ->whereNotNull('bukti_pembayaran')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.verifikasi-pembayaran.index', compact('pembayarans'));
    }

    public function viewBukti($id)
    {
        $pembayaran = Pembayaran::with(['invoice.transaksi.membership.akun'])
            ->findOrFail($id);
        
        if (!$pembayaran->bukti_pembayaran) {
            return response()->json(['error' => 'Tidak ada bukti pembayaran'], 404);
        }

        $user = $pembayaran->invoice->transaksi->membership->akun;

        return response()->json([
            'success' => true,
            'bukti_url' => asset('storage/' . $pembayaran->bukti_pembayaran),
            'nama' => $user->nama_lengkap,
            'email' => $user->email,
            'jenis_paket' => ucfirst($pembayaran->jenis_paket),
            'total_pembayaran' => number_format($pembayaran->total_pembayaran, 0, ',', '.'),
            'metode' => ucwords(str_replace('_', ' ', $pembayaran->metode)),
            'tgl_pembayaran' => $pembayaran->tgl_pembayaran->format('d M Y H:i'),
            'id_pembayaran' => $pembayaran->id_pembayaran,
            'invoice_number' => 'INV-' . date('Ymd', strtotime($pembayaran->invoice->tgl_terbit)) . '-' . str_pad($pembayaran->invoice->id_invoice, 6, '0', STR_PAD_LEFT)
        ]);
    }

    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $pembayaran = Pembayaran::with(['invoice.transaksi.membership'])->findOrFail($id);
            
            // Update payment status to verified
            $pembayaran->update([
                'status_pembayaran' => 'verified'
            ]);

            // Update transaction status to success
            $pembayaran->invoice->transaksi->update([
                'status_transaksi' => 'success'
            ]);

            // Activate membership and set proper dates
            $membership = $pembayaran->membership;
            
            // Hitung ulang tanggal berdasarkan jenis paket
            $tglMulai = Carbon::now();
            $tglBerakhir = $pembayaran->jenis_paket === 'harian' 
                ? Carbon::now()->addDay() 
                : Carbon::now()->addMonth();
            
            $membership->update([
                'status' => true, // AKTIFKAN MEMBERSHIP
                'tgl_mulai' => $tglMulai,
                'tgl_berakhir' => $tglBerakhir,
            ]);

            DB::commit();

            Log::info('Payment approved and membership activated:', [
                'id_pembayaran' => $id, 
                'id_membership' => $membership->id_membership,
                'invoice_id' => $pembayaran->id_invoice,
                'tgl_mulai' => $tglMulai->format('Y-m-d'),
                'tgl_berakhir' => $tglBerakhir->format('Y-m-d'),
                'status' => true
            ]);

            return redirect()->back()->with('success', 'Pembayaran berhasil diverifikasi! Membership telah diaktifkan dari ' . $tglMulai->format('d M Y') . ' hingga ' . $tglBerakhir->format('d M Y') . '.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to approve payment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memverifikasi pembayaran: ' . $e->getMessage());
        }
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'nullable|string|max:500'
        ]);

        DB::beginTransaction();
        try {
            $pembayaran = Pembayaran::with(['invoice.transaksi.membership'])->findOrFail($id);
            
            // Update payment status to rejected
            $pembayaran->update([
                'status_pembayaran' => 'rejected'
            ]);

            // Update transaction status to failed
            $pembayaran->invoice->transaksi->update([
                'status_transaksi' => 'failed'
            ]);

            // Keep membership status as false (inactive)
            $pembayaran->membership->update([
                'status' => false
            ]);

            DB::commit();

            Log::info('Payment rejected:', [
                'id_pembayaran' => $id, 
                'id_invoice' => $pembayaran->id_invoice, 
                'alasan' => $request->alasan
            ]);

            return redirect()->back()->with('info', 'Pembayaran ditolak. User dapat mengupload ulang bukti pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to reject payment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menolak pembayaran: ' . $e->getMessage());
        }
    }
}