<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\AkunUbsc; 
use App\Models\AkunMembership;

class ProfileController extends Controller
{
    public function index()
    {
        $id_akun = Auth::id();
        $akun = AkunUbsc::with('memberships')->find($id_akun);

        if (!$akun) {
            Auth::logout();
            return redirect('/login')->withErrors('Akun tidak ditemukan.');
        }

        $membership = $akun->membership;
        $member_data = $this->calculateMembershipData($membership);
        $history_data = $this->calculateHistoryData($akun->memberships);

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

    protected function calculateMembershipData(?AkunMembership $membership): array
    {
        Carbon::setLocale('id');

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

        $today = Carbon::now()->startOfDay();
        $tgl_mulai = $membership->tgl_mulai->startOfDay();
        $tgl_berakhir = $membership->tgl_berakhir->startOfDay();

        $is_active = $membership->isActive();
        $data['is_active'] = $is_active;

        $data['tgl_mulai_formatted'] = $tgl_mulai->translatedFormat('d F Y');
        $data['tgl_berakhir_formatted'] = $tgl_berakhir->translatedFormat('d F Y');

        if ($is_active) {
            $total_durasi_hari = $tgl_mulai->diffInDays($tgl_berakhir);
            $hari_berlalu = $tgl_mulai->diffInDays($today);
            $sisa_hari = $today->diffInDays($tgl_berakhir, false);
            if ($sisa_hari < 0) $sisa_hari = 0;

            $progress = ($hari_berlalu / max($total_durasi_hari, 1)) * 100;

            $status_detail = '';
            if ($sisa_hari <= 7) {
                $status_detail = ' (SEGERA BERAKHIR)';
            } elseif ($sisa_hari <= 30) {
                $status_detail = ' (PERPANJANG!)';
            }

            $data['status_text'] = 'AKTIF' . $status_detail;
            $data['sisa_waktu_text'] = $sisa_hari . ' hari lagi';
            $data['progress_width'] = min(100, max(0, $progress));

        } else {
            $data['status_text'] = 'KADALUARSA';
            $data['sisa_waktu_text'] = '0 Hari Tersisa';
            $data['progress_width'] = 100;
        }

        return $data;
    }

    protected function calculateHistoryData($memberships): array
    {
        Carbon::setLocale('id');
        $history = [];

        foreach($memberships as $m) {
            $nama_paket = $m->nama_paket ?? 'Paket Premium';
            $tgl_mulai = $m->tgl_mulai;
            $tgl_berakhir = $m->tgl_berakhir;
            $is_active = $m->isActive();

            $durasi_hari = $tgl_mulai->diffInDays($tgl_berakhir);
            $durasi_text = $durasi_hari > 30 ? (round($durasi_hari/30) . ' Bulan') : ($durasi_hari . ' Hari');

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

        return array_reverse($history);
    }

    public function edit()
    {
        $akun = Auth::user();
        return route('profile_edit', compact('akun'));
    }
}
