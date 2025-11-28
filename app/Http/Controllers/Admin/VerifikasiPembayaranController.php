<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class VerifikasiPembayaranController extends Controller
{
    // Menampilkan daftar pembayaran
    public function index()
    {
        $pembayarans = Pembayaran::with(['invoice.transaksi.membership.akun', 'membership'])
            ->whereIn('status_pembayaran', ['pending', 'verified', 'rejected'])
            ->orderByRaw("
                CASE 
                    WHEN status_pembayaran = 'pending' THEN 1
                    WHEN status_pembayaran = 'verified' THEN 2
                    WHEN status_pembayaran = 'rejected' THEN 3
                    ELSE 4
                END
            ")
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.verifikasi-pembayaran.index', compact('pembayarans'));
    }

  // Menampilkan detail bukti pembayaran
    public function viewBukti($id)
    {
        $pembayaran = Pembayaran::with(['invoice.transaksi.membership.akun'])
            ->findOrFail($id);
        
        if (!$pembayaran->bukti_pembayaran) {
            return response()->json([
                'success' => false,
                'error' => 'Tidak ada bukti pembayaran'
            ], 404);
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

    // Approve pembayaran
    public function approve($id)
    {
        DB::beginTransaction();
        try {
            $pembayaran = Pembayaran::with(['invoice.transaksi.membership.akun'])->findOrFail($id);
            
            if ($pembayaran->status_pembayaran !== 'pending') {
                return redirect()->back()->with('warning', 'Pembayaran ini sudah diproses sebelumnya.');
            }
            $updateData = ['status_pembayaran' => 'verified'];
            
            if ($this->hasAlasanPenolakanColumn()) {
                $updateData['alasan_penolakan'] = null;
            }
            $pembayaran->update($updateData);

            $pembayaran->invoice->transaksi->update([
                'status_transaksi' => 'success'
            ]);

            $membership = $pembayaran->membership;
            $user = $pembayaran->invoice->transaksi->membership->akun;
            
            $tglMulai = Carbon::now();
            $tglBerakhir = $pembayaran->jenis_paket === 'harian' 
                ? Carbon::now()->addDay() 
                : Carbon::now()->addMonth();
            
            $membership->update([
                'status' => true,
                'tgl_mulai' => $tglMulai,
                'tgl_berakhir' => $tglBerakhir,
            ]);

            DB::commit();

            Log::info('Payment approved and membership activated:', [
                'id_pembayaran' => $id, 
                'id_membership' => $membership->id_membership,
                'user' => $user->nama_lengkap,
                'admin' => auth()->guard('admin')->user()->nama_lengkap ?? 'System'
            ]);

            return redirect()->route('admin.verifikasi-pembayaran.index')
                ->with('success', 'Pembayaran berhasil diverifikasi! Membership ' . $user->nama_lengkap . ' telah diaktifkan dari ' . $tglMulai->format('d M Y') . ' hingga ' . $tglBerakhir->format('d M Y') . '.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to approve payment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memverifikasi pembayaran: ' . $e->getMessage());
        }
    }

// Reject pembayaran
    public function reject(Request $request, $id)
    {
        $request->validate([
            'alasan' => 'required|string|min:10|max:500'
        ], [
            'alasan.required' => 'Alasan penolakan wajib diisi',
            'alasan.min' => 'Alasan penolakan minimal 10 karakter',
            'alasan.max' => 'Alasan penolakan maksimal 500 karakter',
        ]);

        DB::beginTransaction();
        try {
            $pembayaran = Pembayaran::with(['invoice.transaksi.membership.akun'])->findOrFail($id);
            
            if ($pembayaran->status_pembayaran !== 'pending') {
                return redirect()->back()->with('warning', 'Pembayaran ini sudah diproses sebelumnya.');
            }
            $user = $pembayaran->invoice->transaksi->membership->akun;
            $updateData = ['status_pembayaran' => 'rejected'];
            
            if ($this->hasAlasanPenolakanColumn()) {
                $updateData['alasan_penolakan'] = $request->alasan;
            } else {
                // Log to file if column doesn't exist
                Log::warning('alasan_penolakan column does not exist. Reason not saved to DB.', [
                    'id_pembayaran' => $id,
                    'alasan' => $request->alasan
                ]);
            }
            $pembayaran->update($updateData);
            $pembayaran->invoice->transaksi->update([
                'status_transaksi' => 'failed'
            ]);
            $pembayaran->membership->update([
                'status' => false
            ]);
            DB::commit();

            Log::info('Payment rejected:', [
                'id_pembayaran' => $id,
                'user' => $user->nama_lengkap,
                'alasan' => $request->alasan,
                'admin' => auth()->guard('admin')->user()->nama_lengkap ?? 'System'
            ]);
            return redirect()->route('admin.verifikasi-pembayaran.index')
                ->with('info', 'Pembayaran ' . $user->nama_lengkap . ' ditolak. Alasan: ' . $request->alasan);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to reject payment: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menolak pembayaran: ' . $e->getMessage());
        }
    }
     private function hasAlasanPenolakanColumn()
    {
        return Schema::hasColumn('pembayaran', 'alasan_penolakan');
    }
}