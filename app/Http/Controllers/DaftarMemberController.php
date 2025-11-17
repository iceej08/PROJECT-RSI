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
    /**
     * Show membership package selection
     */
    public function showPilihanPaket()
    {
        $user = Auth::guard('web')->user();
        
        // Cek apakah user sudah pernah punya membership sebelumnya
        $hasHistory = AkunMembership::where('id_akun', $user->id_akun)->exists();
        
        // Tentukan harga berdasarkan kategori user
        $harga = $this->getHarga($user->kategori, $hasHistory);
        
        return view('pelanggan.pilih-paket', compact('harga', 'hasHistory'));
    }

    /**
     * Get harga based on user category
     */
    private function getHarga($kategori, $hasHistory)
    {
        if ($kategori) {
            $harga = [
                'harian' => 25000,
                'bulanan' => 130000,
                'biaya_pendaftaran'=> $hasHistory ? 0 : 25000,
            ];
        } else {
            $harga = [
                'harian' => 35000,
                'bulanan' => 162000,
                'biaya_pendaftaran'=> $hasHistory ? 0 : 27000,
            ];
        }
        
        return $harga;
    }

    /**
     * Process package selection and create invoice
     */
    public function buatInvoice(Request $request)
    {
        $request->validate([
            'jenis_paket' => 'required|in:harian,bulanan',
        ]);

        $user = Auth::guard('web')->user();
        $hasHistory = AkunMembership::where('id_akun', $user->id_akun)->exists();
        $harga = $this->getHarga($user->kategori, $hasHistory);

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
        $hasHistory = AkunMembership::where('id_akun', $user->id_akun)
            ->where('id_membership', '!=', $invoice->transaksi->id_membership)
            ->exists();
        
        $harga = $this->getHarga($user->kategori, $hasHistory);

        return view('pelanggan.invoice', compact('invoice', 'harga', 'hasHistory'));
    }

    public function unggahBuktiBayar(Request $request, $invoiceId)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'metode' => 'required|in:transfer_bank,e_wallet,qris',
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