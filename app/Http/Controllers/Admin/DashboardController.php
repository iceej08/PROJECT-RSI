<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkunUbsc;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Stats Cards
        $totalAkunUbsc = AkunUbsc::count();
        $pendingVerification = AkunUbsc::where('status_verifikasi', 'pending')->count();
        
        // Note: You'll need to create akun_membership table later
        // For now, let's use a placeholder
        $activeMemberships = 0; // AkunMembership::where('status', 'active')->count();

        // Recent Activities (Last 10)
        $recentActivities = $this->getRecentActivities();

        return view('admin.dashboard', compact(
            'totalAkunUbsc',
            'pendingVerification',
            'activeMemberships',
            'recentActivities'
        ));
    }
    private function getRecentActivities()
    {
        $activities = collect();

        // Get recent registrations (last 10)
        $recentRegistrations = AkunUbsc::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        foreach ($recentRegistrations as $account) {
            $activity = [
                'id' => $account->id_akun,
                'time' => $account->time_ago,
                'created_at' => $account->created_at,
            ];

            if ($account->kategori == 0) {
                // Umum user
                $activity['type'] = 'umum_registration';
                $activity['icon'] = 'user';
                $activity['icon_bg'] = 'bg-blue-100';
                $activity['icon_color'] = 'text-blue-600';
                $activity['title'] = 'Pendaftaran Pengguna Umum';
                $activity['description'] = $account->email;
            } else {
                // Warga UB user
                if ($account->status_verifikasi == 'pending') {
                    $activity['type'] = 'warga_ub_pending';
                    $activity['icon'] = 'clock';
                    $activity['icon_bg'] = 'bg-yellow-100';
                    $activity['icon_color'] = 'text-yellow-600';
                    $activity['title'] = 'Pendaftaran Warga UB - Menunggu Verifikasi';
                    $activity['description'] = $account->email;
                } elseif ($account['status_verifikasi'] == 'approved') {
                    $activity['type'] = 'warga_ub_approved';
                    $activity['icon'] = 'check-circle';
                    $activity['icon_bg'] = 'bg-green-100';
                    $activity['icon_color'] = 'text-green-600';
                    $activity['title'] = 'Warga UB Disetujui';
                    $activity['description'] = $account->email;
                } else {
                    $activity['type'] = 'warga_ub_rejected';
                    $activity['icon'] = 'x-circle';
                    $activity['icon_bg'] = 'bg-red-100';
                    $activity['icon_color'] = 'text-red-600';
                    $activity['title'] = 'Warga UB Ditolak';
                    $activity['description'] = $account->email;
                }
            }

            $activities->push($activity);
        }

        // TODO: Add payment activities when pembayaran table is ready
        // $pendingPayments = Pembayaran::where('status_pembayaran', 'pending')
        //     ->orderBy('created_at', 'desc')
        //     ->limit(5)
        //     ->get();

        // Sort by created_at and limit to 10
        return $activities->sortByDesc('created_at')->take(10)->values();
    }
}