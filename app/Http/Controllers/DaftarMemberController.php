<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AkunMembership;
use App\Models\Transaksi;
use App\Models\Invoice;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DaftarMemberController extends Controller
{
    // menampilkan pilihan paket membership
    public function showPilihanPaket()
    {
        $user = Auth::guard('web')->user();
        
        // CEK APAKAH USER SUDAH PUNYA INVOICE PENDING
        $pendingInvoice = $this->getPendingInvoice($user->id_akun);
        
        if ($pendingInvoice) {
            // Jika ada invoice pending, redirect langsung ke invoice
            return redirect()->route('pelanggan.invoice.show', $pendingInvoice->id_invoice)
                ->with('info', 'Anda masih memiliki invoice yang belum dibayar. Silakan selesaikan pembayaran terlebih dahulu.');
        }
        
        // Cek apakah user sudah pernah punya membership yang VERIFIED (bukan pending)
        $hasVerifiedHistory = AkunMembership::where('id_akun', $user->id_akun)
            ->whereHas('pembayarans', function($query) {
                $query->where('status_pembayaran', 'verified');
            })
            ->exists();
        
        // Tentukan harga berdasarkan kategori user
        $harga = $this->getHarga($user->kategori, $hasVerifiedHistory);
        
        return view('pelanggan.pilih-paket', compact('harga', 'hasVerifiedHistory'));
    }

    private function getPendingInvoice($idAkun)
    {
        return Invoice::whereHas('transaksi.membership', function($query) use ($idAkun) {
                $query->where('id_akun', $idAkun);
            })
            ->where(function($query) {
                $query->whereDoesntHave('pembayaran')
                    ->orWhereHas('pembayaran', function($q) {
                        $q->where('status_pembayaran', 'pending');
                    });
            })
            ->whereHas('transaksi', function($query) {
                $query->where('status_transaksi', 'pending');
            })
            ->latest()
            ->first();
    }

    // harga berdasarkan kategori dan apkh pernah daftar sebagai member
    private function getHarga($kategori, $hasVerifiedHistory)
    {
        if ($kategori) {
            $harga = [
                'harian' => 25000,
                'bulanan' => 130000,
                'biaya_pendaftaran'=> $hasVerifiedHistory ? 0 : 25000,
            ];
        } else {
            $harga = [
                'harian' => 35000,
                'bulanan' => 162000,
                'biaya_pendaftaran'=> $hasVerifiedHistory ? 0 : 27000,
            ];
        }
        
        return $harga;
    }

    // pembuatan invoice
    public function buatInvoice(Request $request)
    {
        $request->validate([
            'jenis_paket' => 'required|in:harian,bulanan',
        ]);

        $user = Auth::guard('web')->user();
        
        // CEK LAGI APAKAH ADA INVOICE PENDING (double check)
        $pendingInvoice = $this->getPendingInvoice($user->id_akun);
        
        if ($pendingInvoice) {
            return redirect()->route('pelanggan.invoice.show', $pendingInvoice->id_invoice)
                ->with('info', 'Anda masih memiliki invoice yang belum dibayar.');
        }
        
        // Cek history membership yang VERIFIED
        $hasVerifiedHistory = AkunMembership::where('id_akun', $user->id_akun)
            ->whereHas('pembayarans', function($query) {
                $query->where('status_pembayaran', 'verified');
            })
            ->exists();
            
        $harga = $this->getHarga($user->kategori, $hasVerifiedHistory);

        DB::beginTransaction();
        try {
            // Calculate total
            $hargaPaket = $harga[$request->jenis_paket];
            $biayaPendaftaran = $harga['biaya_pendaftaran'];
            $subtotal = $hargaPaket + $biayaPendaftaran;
            $tax = $subtotal * 0.10; // 10% tax
            $total = $subtotal + $tax;

            // Calculate membership dates
            $tglMulai = Carbon::now();
            $tglBerakhir = $request->jenis_paket === 'harian' 
                ? Carbon::now()->addDay() 
                : Carbon::now()->addMonth();

            // Create membership (status pending)
            $membership = AkunMembership::create([
                'id_akun' => $user->id_akun,
                'tgl_mulai' => $tglMulai,
                'tgl_berakhir' => $tglBerakhir,
                'status' => false, // Pending until payment verified
            ]);

            // Create transaction
            $transaksi = Transaksi::create([
                'id_membership' => $membership->id_membership,
                'jenis_paket' => $request->jenis_paket,
                'tgl_transaksi' => now(),
                'total_tagihan' => $total,
                'status_transaksi' => 'pending',
            ]);

            // Create invoice
            $invoice = Invoice::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'jenis_paket' => $request->jenis_paket,
                'tgl_terbit' => now(),
                'total_tagihan' => $total,
                'status_kirim' => 'sent',
            ]);

            DB::commit();

            return redirect()->route('pelanggan.invoice.show', $invoice->id_invoice);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat invoice: ' . $e->getMessage());
        }
    }

    public function showInvoice($invoiceId)
    {
        $invoice = Invoice::with(['transaksi.membership.akun', 'pembayaran'])
            ->findOrFail($invoiceId);
        
        // Check if user owns this invoice
        if ($invoice->transaksi->membership->id_akun !== Auth::guard('web')->user()->id_akun) {
            abort(403);
        }

        $user = $invoice->transaksi->membership->akun;
        
        // Hitung hasHistory berdasarkan membership yang VERIFIED
        $hasHistory = AkunMembership::where('id_akun', $user->id_akun)
            ->where('id_membership', '!=', $invoice->transaksi->id_membership)
            ->whereHas('pembayarans', function($query) {
                $query->where('status_pembayaran', 'verified');
            })
            ->exists();
        
        $harga = $this->getHarga($user->kategori, $hasHistory);

        return view('pelanggan.invoice', compact('invoice', 'harga', 'hasHistory'));
    }

    // kalau user kembali ke halaman sebelumnya
    public function cancelInvoice($id)
    {
        $user = Auth::guard('web')->user();
        $invoice = Invoice::with(['transaksi.membership.akun', 'pembayaran'])
            ->findOrFail($id);

        // Pastikan invoice milik user
        $invoice = 
        DB::table('invoice')->join('transaksi', 'transaksi.id_transaksi', '=', 'invoice.id_transaksi')
            ->join('akun_membership', 'akun_membership.id_membership', '=', 'transaksi.id_membership')
            ->join('akun_ubsc', 'akun_ubsc.id_akun', '=', 'akun_membership.id_akun')
            ->where('invoice.id_invoice', $id)
            ->where('akun_ubsc.id_akun', $user->id_akun)
            ->where('invoice.status_kirim', 'sent')
            ->select('invoice.id_invoice')
            ->first();

        if (!$invoice) {
            return redirect()->back()->with('error', 'Invoice tidak ditemukan atau tidak dapat dibatalkan.');
        }

        // Hapus atau batalkan invoice
        DB::table('invoice')->where('id_invoice', $id)->delete();
        
        return redirect()->route('pelanggan.pilih-paket')
                        ->with('info', 'Silakan pilih paket membership.');
    }


    public function unggahBuktiBayar(Request $request, $invoiceId)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'metode' => 'required|in:transfer_bank,qris',
        ]);

        $invoice = Invoice::findOrFail($invoiceId);

        // Check if user owns this invoice
        if ($invoice->transaksi->membership->id_akun !== Auth::guard('web')->user()->id_akun) {
            abort(403);
        }

        DB::beginTransaction();
        try {
            // Upload file
            $file = $request->file('bukti_pembayaran');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('bukti_pembayaran', $filename, 'public');

            // Create or update payment record
            $pembayaran = Pembayaran::updateOrCreate(
                ['id_invoice' => $invoice->id_invoice],
                [
                    'id_membership' => $invoice->transaksi->id_membership,
                    'total_pembayaran' => $invoice->total_tagihan,
                    'metode' => $request->metode,
                    'bukti_pembayaran' => $path,
                    'status_pembayaran' => 'pending',
                    'jenis_paket' => $invoice->jenis_paket,
                    'tgl_pembayaran' => now(),
                ]
            );

            DB::commit();

            return redirect()->back()
                ->with('success', 'Bukti pembayaran berhasil diupload! Menunggu verifikasi admin.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal upload bukti pembayaran: ' . $e->getMessage());
        }
    }
}