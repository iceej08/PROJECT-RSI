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
        $faqs = FAQ::all();
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
            'pertanyaan' => 'required|string|max:500',
            'jawaban' => 'required|string',
        ], [
            'pertanyaan.required' => 'Pertanyaan wajib diisi',
            'jawaban.required' => 'Jawaban wajib diisi',
        ]);

        FAQ::create([
            'Id_admin' => Auth::id() ?? 1,
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
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

    // Update FAQ - METHOD INI YANG HILANG!
    public function update(Request $request, $id)
    {
        $request->validate([
            'pertanyaan' => 'required|string|max:500',
            'jawaban' => 'required|string',
        ], [
            'pertanyaan.required' => 'Pertanyaan wajib diisi',
            'jawaban.required' => 'Jawaban wajib diisi',
        ]);

        $faq = FAQ::findOrFail($id);
        $faq->update([
            'pertanyaan' => $request->pertanyaan,
            'jawaban' => $request->jawaban,
        ]);

        return redirect()->route('admin.faq.index')
                         ->with('success', 'FAQ berhasil diupdate!');
    }

    // Hapus FAQ - METHOD INI JUGA HILANG!
    public function destroy($id)
    {
        $faq = FAQ::findOrFail($id);
        $faq->delete();

        return redirect()->route('admin.faq.index')
                         ->with('success', 'FAQ berhasil dihapus!');
    }
}