<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FAQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FAQController extends Controller
{
    // Tampilkan semua FAQ
    public function index()
    {
        $faqs = FAQ::orderBy('created_at', 'desc')->get();
        return view('admin.faq.index', compact('faqs'));
    }

    // Form tambah FAQ
    public function create()
    {
        return view('admin.faq.create');
    }

    // Simpan FAQ baru
    public function store(Request $request)
    {
        $request->validate([
            'Pertanyaan' => 'required',
            'Jawaban' => 'required',
        ]);

        FAQ::create([
            'Id_admin' => 1,
            'Pertanyaan' => $request->Pertanyaan,
            'Jawaban' => $request->Jawaban,
        ]);

        return redirect()->route('admin.faq.index')
                         ->with('success', 'FAQ berhasil ditambahkan!');
    }

    // Form edit FAQ
    public function edit($id)
    {
        $faq = FAQ::findOrFail($id);
        return view('admin.faq.edit', compact('faq'));
    }

    // Update FAQ
    public function update(Request $request, $id)
    {
        $request->validate([
            'Pertanyaan' => 'required',
            'Jawaban' => 'required',
        ]);

        $faq = FAQ::findOrFail($id);
        $faq->update([
            'Pertanyaan' => $request->Pertanyaan,
            'Jawaban' => $request->Jawaban,
        ]);

        return redirect()->route('admin.faq.index')
                         ->with('success', 'FAQ berhasil diupdate!');
    }

    // Hapus FAQ
    public function destroy($id)
    {
        $faq = FAQ::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')
                         ->with('success', 'FAQ berhasil dihapus!');
    }
}