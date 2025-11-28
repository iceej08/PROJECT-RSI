<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkunUbsc;
use App\Models\AkunMembership;
use App\Models\Invoice;
use App\Models\Transaksi;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AkunMemberController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        
        $members = AkunUbsc::with(['memberships' => function($query) {
                $query->whereHas('pembayarans', function($q) {
                    $q->where('status_pembayaran', 'verified');
                })->latest();
            }])
            ->whereHas('memberships.pembayarans', function($query) {
                $query->where('status_pembayaran', 'verified');
            })
            ->when($search, function($query, $search) {
                return $query->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%")
                            ->orWhere('id_akun', 'like', "%{$search}%");
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.akun-member.index', compact('members', 'search'));
    }

    public function tambahMember(Request $request)
    {
        $request->validate([
            'id_akun' => 'required|exists:akun_ubsc,id_akun',
            'jenis_paket' => 'required|in:harian,bulanan',
            'metode_pembayaran' => 'required|in:transfer_bank,qris',
        ]);

        DB::beginTransaction();
        try {
            $user = AkunUbsc::findOrFail($request->id_akun);
            $hasHistory = AkunMembership::where('id_akun', $user->id_akun)->exists();
            
            // Hitung harga berdasarkan kategori
            if ($user->kategori) {
                // Warga UB
                $prices = [
                    'harian' => 25000,
                    'bulanan' => 130000,
                    'biaya_pendaftaran' => $hasHistory ? 0 : 25000,
                ];
            } else {
                // Warga Umum
                $prices = [
                    'harian' => 35000,
                    'bulanan' => 162000,
                    'biaya_pendaftaran' => $hasHistory ? 0 : 27000,
                ];
            }

            // Calculate total
            $hargaPaket = $prices[$request->jenis_paket];
            $biayaPendaftaran = $prices['biaya_pendaftaran'];
            $subtotal = $hargaPaket + $biayaPendaftaran;
            $tax = $subtotal * 0.10;
            $total = $subtotal + $tax;

            // Calculate membership dates
            $tglMulai = Carbon::now();
            $tglBerakhir = $request->jenis_paket === 'harian' 
                ? Carbon::now()->addDay() 
                : Carbon::now()->addMonth();

            // Create membership (langsung aktif karena dari admin)
            $membership = AkunMembership::create([
                'id_akun' => $request->id_akun,
                'tgl_mulai' => $tglMulai,
                'tgl_berakhir' => $tglBerakhir,
                'status' => true, // Langsung aktif
            ]);

            // Create transaction
            $transaksi = Transaksi::create([
                'id_membership' => $membership->id_membership,
                'jenis_paket' => $request->jenis_paket,
                'tgl_transaksi' => now(),
                'total_tagihan' => $total,
                'status_transaksi' => 'success',
            ]);

            // Create invoice
            $invoice = Invoice::create([
                'id_transaksi' => $transaksi->id_transaksi,
                'jenis_paket' => $request->jenis_paket,
                'tgl_terbit' => now(),
                'total_tagihan' => $total,
                'status_kirim' => 'sent',
            ]);

            // Create payment record (verified)
            Pembayaran::create([
                'id_invoice' => $invoice->id_invoice,
                'id_membership' => $membership->id_membership,
                'total_pembayaran' => $total,
                'metode' => $request->metode_pembayaran,
                'bukti_pembayaran' => null, // Admin tidak perlu bukti
                'status_pembayaran' => 'verified', // Langsung verified
                'jenis_paket' => $request->jenis_paket,
                'tgl_pembayaran' => now(),
            ]);

            DB::commit();

            return redirect()->route('admin.akun-member.index')
                ->with('success', 'Member berhasil ditambahkan dengan paket ' . ($request->jenis_paket === 'harian' ? 'Harian' : 'Bulanan') . '!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Gagal menambahkan member: ' . $e->getMessage());
        }
    }
    
    public function update(Request $request, $membershipId)
    {
        $request->validate([
            'tgl_mulai' => 'required|date',
            'tgl_berakhir' => 'required|date|after:tgl_mulai',
            'status' => 'required|boolean',
        ]);

        $membership = AkunMembership::findOrFail($membershipId);
        $membership->update([
            'tgl_mulai' => $request->tgl_mulai,
            'tgl_berakhir' => $request->tgl_berakhir,
            'status' => $request->status,
        ]);

        return redirect()->back()
            ->with('success', 'Membership berhasil diupdate!');
    }

    /**
     * Toggle membership status (Aktif/Non-aktif)
     */
    // public function toggleStatus($membershipId)
    // {
    //     $membership = AkunMembership::findOrFail($membershipId);
    //     $membership->status = !$membership->status;
    //     $membership->save();

    //     $status = $membership->status ? 'Aktif' : 'Non-aktif';
        
    //     return redirect()->back()
    //         ->with('success', "Status membership berhasil diubah menjadi {$status}!");
    // }

    /**
     * Delete member account
     */
    public function destroy($membershipId)
    {
        try {
            DB::beginTransaction();
            
            $membership = AkunMembership::findOrFail($membershipId);
            $membership->delete();

            DB::commit();
            
            return redirect()->route('admin.akun-member.index')
                ->with('success', 'Akun member berhasil dihapus!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            
            return redirect()->route('admin.akun-member.index')
                ->with('error', 'Gagal menghapus akun member: ' . $e->getMessage());
        }
    }

    public function getUsersWithoutMembership()
    {
        $users = AkunUbsc::whereDoesntHave('memberships')
            ->where('status_verifikasi', '!=', 'pending')
            ->orderBy('nama_lengkap')
            ->get();

        return response()->json($users);
    }
}