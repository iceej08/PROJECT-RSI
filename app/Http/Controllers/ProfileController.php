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
     * 
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // 1. Ambil ID User yang sedang login
        $id_akun = Auth::id();

        // 2. Ambil data Akun UBSC
        $akun = AkunUbsc::find($id_akun);

        if (!$akun) {
            // Jika akun tidak ditemukan (mungkin user terhapus dari DB tapi session masih ada)
            Auth::logout();
            return redirect('/login')->withErrors('Akun tidak ditemukan.');
        }

        // 3. Ambil data membership terbaru
        // Memanggil relasi 'membership()' yang sudah kita definisikan di AkunUbsc
        $membership = $akun->membership()->first();

        // 4. Kalkulasi data membership untuk ditampilkan di view
        $member_data = $this->calculateMembershipData($membership);

        // 5. Return view
        return view('profile', [
            'akun' => $akun,
            'membership' => $membership,
            'member_data' => $member_data,
        ]);
    }

    /**
     * Metode alias untuk index() jika Anda menggunakannya untuk route terpisah.
     */
    public function showProfile()
    {
        return $this->index();
    }


    /**
     * Mengolah dan menghitung data membership.
     *
     * @param AkunMembership|null $membership <-- PERBAIKAN TYPE HINT
     * @return array
     */
    protected function calculateMembershipData(?AkunMembership $membership): array // <-- PERBAIKAN TYPE HINT
    {
        // Set locale Carbon ke Bahasa Indonesia
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

        // Cek jika objek membership tidak ada atau tanggal berakhirnya null
        if (!$membership || !$membership->tgl_berakhir) {
            return $data;
        }

        // Tanggal Hari Ini
        $today = Carbon::now()->startOfDay(); // Mulai dari awal hari untuk perbandingan

        // Parsing Tanggal Membership (sudah di-cast di Model, jadi aman dipanggil)
        $tgl_mulai = $membership->tgl_mulai->startOfDay();
        $tgl_berakhir = $membership->tgl_berakhir->endOfDay();

        // A. Tentukan Status
        // Membership dianggap aktif jika hari ini <= tanggal berakhir (akhir hari)
        $is_active = $tgl_berakhir->greaterThanOrEqualTo($today);
        $data['is_active'] = $is_active;

        // B. Formatting Tanggal
        $data['tgl_mulai_formatted'] = $tgl_mulai->translatedFormat('d F Y');
        $data['tgl_berakhir_formatted'] = $tgl_berakhir->translatedFormat('d F Y');

        if ($is_active) {
            // C. Perhitungan Sisa Waktu & Progress (Hanya jika aktif)

            // Hitung total durasi hari (ditambah 1 untuk inklusif)
            $total_durasi_hari = $tgl_mulai->diffInDays($tgl_berakhir) + 1; 

            // Hitung hari yang sudah berlalu (dari mulai sampai hari ini)
            $hari_berlalu = $tgl_mulai->diffInDays($today); 

            // Hitung sisa hari (dari hari ini sampai berakhir)
            $sisa_hari = $today->diffInDays($tgl_berakhir) + 1; // Ditambah 1 agar inklusif

            // Perhitungan Persentase Progress
            $progress = ($hari_berlalu / $total_durasi_hari) * 100;

            // Update data
            $data['status_text'] = 'AKTIF HINGGA ' . $tgl_berakhir->translatedFormat('d M Y');
            $data['sisa_waktu_text'] = $sisa_hari . ' Hari Tersisa';
            $data['progress_width'] = min(100, max(0, $progress)); // Pastikan antara 0-100

        } else {
            // D. Jika Tidak Aktif / Kadaluarsa
            $data['status_text'] = 'KADALUARSA';
            $data['sisa_waktu_text'] = '0 Hari Tersisa';
            $data['progress_width'] = 100; // Progress penuh karena sudah lewat
        }

        return $data;
    }

    /**
     * Metode untuk menampilkan form edit (opsional)
     * Asumsi: Relasi user ke akun AkunUbsc adalah langsung (Auth::user() adalah AkunUbsc)
     */
    public function edit()
    {
        $akun = Auth::user(); // Karena AkunUbsc extends Authenticatable
        return route('profile.edit', compact('akun'));
    }
}