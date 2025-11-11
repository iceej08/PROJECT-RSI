<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AkunUbsc;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAccounts = AkunUbsc::count();
        $verifiedAccounts = AkunUbsc::where('status_verifikasi', 'terverifikasi')->count();
        $pendingAccounts = AkunUbsc::where('status_verifikasi', 'belum_terverif')->count();
        $wargaUB = AkunUbsc::where('kategori', 1)->count();
        $umum = AkunUbsc::where('kategori', 0)->count();

        return view('admin.dashboard', compact(
            'totalAccounts',
            'verifiedAccounts',
            'pendingAccounts',
            'wargaUB',
            'umum'
        ));
    }
}