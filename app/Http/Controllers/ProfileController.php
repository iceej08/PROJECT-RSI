<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\AkunUbsc; 
use App\Models\AkunMembership;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman profil pengguna dengan data akun dan membership.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Ambil ID User yang sedang login
        $id_akun = Auth::id();

        // 2. Ambil data Akun UBSC
        $akun = AkunUbsc::with('memberships')->find($id_akun);

        if (!$akun) {
            // Jika akun tidak ditemukan (mungkin user terhapus dari DB tapi session masih ada)
            Auth::logout();
            return redirect('/login')->withErrors('Akun tidak ditemukan.');
        }

        // 3. Ambil data membership terbaru (latestOfMany)
        // Memanggil relasi 'membership()' yang sudah kita definisikan di AkunUbsc
        $membership = $akun->membership; // Mengakses relasi HasOne secara langsung

        // 4. KHitung data membership terbaru untuk ditampilkan di kartu status
        $member_data = $this->calculateMembershipData($membership);
        
        // 5. Hitung data riwayat membership untuk ditampilkan di Toggle
        // Mengirim semua riwayat (memberikan array kosong jika tidak ada)
        $history_data = $this->calculateHistoryData($akun->memberships); 

        // 6. Return view
        return view('profile', [
            'akun' => $akun,
            'membership' => $membership,
            'member_data' => $member_data,
            'history_data' => $history_data, 
        ]);
    }

    public function showProfile()
    {
        return $this->index();
    }


    /**
     * Mengolah dan menghitung data membership terbaru.
     *
     * @param AkunMembership|null $membership Objek membership terbaru.
     * @return array
     */
    protected function calculateMembershipData(?AkunMembership $membership): array
    {
        Carbon::setLocale('id');

        // Nilai default jika user tidak memiliki membership
        $data = [
            'is_active' => false,
            'status_text' => 'TIDAK AKTIF',
            'tgl_mulai_formatted' => '-',
            'tgl_berakhir_formatted' => '-',
            'sisa_waktu_text' => '0 Hari',
            'progress_width' => 0,
        ];

        if (!$membership || !$membership->tgl_berakhir) {
            return $data;
        }

        // Tanggal Hari Ini
        $today = Carbon::now()->startOfDay(); 

        // Parsing Tanggal Membership (sudah di-cast di Model)
        $tgl_mulai = $membership->tgl_mulai->startOfDay();
        $tgl_berakhir = $membership->tgl_berakhir->startOfDay();

        $is_active = $today->between($tgl_mulai, $tgl_berakhir);
        $data['is_active'] = $is_active;

        // B. Formatting Tanggal
        $data['tgl_mulai_formatted'] = $tgl_mulai->translatedFormat('d F Y');
        $data['tgl_berakhir_formatted'] = $tgl_berakhir->translatedFormat('d F Y');

        if ($is_active) {
            // C. Perhitungan Sisa Waktu & Progress (Hanya jika aktif)
            $total_durasi_hari = $tgl_mulai->diffInDays($tgl_berakhir); 
            $hari_berlalu = $tgl_mulai->diffInDays($today); 
            $sisa_hari = $today->diffInDays($tgl_berakhir); 
            $progress = ($hari_berlalu / $total_durasi_hari) * 100;

            // Keterangan status
            $status_detail = '';
            if ($sisa_hari <= 7) {
                $status_detail = ' (SEGERA BERAKHIR)';
            } elseif ($sisa_hari <= 30) {
                $status_detail = ' (PERPANJANG!)';
            }

            // Update data
            $data['status_text'] = 'AKTIF' . $status_detail;
            $data['sisa_waktu_text'] = $sisa_hari . ' hari lagi';
            $data['progress_width'] = min(100, max(0, $progress));

        } else {
            // D. Jika Tidak Aktif / Kadaluarsa
            $data['status_text'] = 'KADALUARSA';
            $data['sisa_waktu_text'] = '0 Hari Tersisa';
            $data['progress_width'] = 100;
        }

        return $data;
    }
    
    /**
     *
     * @param \Illuminate\Database\Eloquent\Collection|\App\Models\AkunMembership[] $memberships Koleksi riwayat membership.
     * @return array
     */
    protected function calculateHistoryData($memberships): array
    {
        Carbon::setLocale('id');
        $history = [];

        foreach($memberships as $m) {
            $nama_paket = $m->nama_paket ?? 'Paket Premium'; 
            
            $tgl_mulai = $m->tgl_mulai;
            $tgl_berakhir = $m->tgl_berakhir;
            
            $is_active = $m->isActive(); // Menggunakan method dari AkunMembership Model
            
            // LogikaDurasi 
            $durasi_hari = $tgl_mulai->diffInDays($tgl_berakhir);
            $durasi_text = $durasi_hari > 30 ? (round($durasi_hari/30) . ' Bulan') : ($durasi_hari . ' Hari');

            // Logika Status & Warna
            if ($is_active) {
                $status = 'Aktif';
                $status_color = 'text-green-600';
            } elseif ($tgl_berakhir->isPast()) {
                $status = 'Kadaluarsa';
                $status_color = 'text-red-600';
            } else {
                 $status = 'Pending';
                 $status_color = 'text-yellow-600';
            }

            $history[] = [
                'nama_paket' => $nama_paket,
                'tgl_mulai' => $tgl_mulai->translatedFormat('d M Y'),
                'tgl_berakhir' => $tgl_berakhir->translatedFormat('d M Y'),
                'durasi' => $durasi_text,
                'status' => $status,
                'status_color' => $status_color,
            ];
        }

        // Mengurutkan riwayat dari yang terbaru (terbalik dari created_at)
        return array_reverse($history); 
    }

    public function edit()
    {
        $akun = Auth::user();
        return route('profile.edit', compact('akun'));
    }
}