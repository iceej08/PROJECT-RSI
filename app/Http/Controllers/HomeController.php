<?php

namespace App\Http\Controllers;

use App\Models\FAQ;
use App\Models\Promosi;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil semua FAQ
        $faqs = FAQ::orderBy('created_at', 'desc')->get();
        
        // Ambil promosi yang masih aktif
        $promosis = Promosi::where('Tgl_berakhir', '>=', now())
                          ->orderBy('created_at', 'desc')
                          ->get();
        
        return view('home', compact('faqs', 'promosis'));
    }
}