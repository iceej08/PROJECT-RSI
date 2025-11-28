<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Promosi;
use App\Models\FAQ; // Tambahkan ini

class WelcomeController extends Controller
{
    public function index()
    {
        $promosis = Promosi::all();
        $faqs = FAQ::all(); // Tambahkan ini
        
        return view('welcomepage', compact('promosis', 'faqs')); // Update compact
    }
}