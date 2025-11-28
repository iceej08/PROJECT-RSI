<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promosi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PromosiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $promosis = Promosi::orderBy('created_at', 'desc')->get();
        return view('admin.promosi.index', compact('promosis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.promosi.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Judul' => 'required|string|max:255',
            'Deskripsi' => 'required|string',
            'Gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Tgl_mulai' => 'required|date',
            'Tgl_berakhir' => 'required|date|after_or_equal:Tgl_mulai',
        ]);

        $gambarPath = null;
        if ($request->hasFile('Gambar')) {
            $gambarPath = $request->file('Gambar')->store('promosi', 'public');
        }

        Promosi::create([
            'Id_admin' => 1, // Hardcode karena tanpa auth
            'Judul' => $request->Judul,
            'Deskripsi' => $request->Deskripsi,
            'Gambar' => $gambarPath,
            'Tgl_mulai' => $request->Tgl_mulai,
            'Tgl_berakhir' => $request->Tgl_berakhir,
        ]);

        return redirect()->route('admin.promosi.index')
                         ->with('success', 'Promosi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $promosi = Promosi::findOrFail($id);
        return route('admin.promosi.show', compact('promosi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $promosi = Promosi::findOrFail($id);
        return view('admin.promosi.edit', compact('promosi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'Judul' => 'required|string|max:255',
            'Deskripsi' => 'required|string',
            'Gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'Tgl_mulai' => 'required|date',
            'Tgl_berakhir' => 'required|date|after_or_equal:Tgl_mulai',
        ]);

        $promosi = Promosi::findOrFail($id);

        $gambarPath = $promosi->Gambar;
        
        // Jika ada gambar baru diupload
        if ($request->hasFile('Gambar')) {
            // Hapus gambar lama jika ada
            if ($promosi->Gambar && Storage::disk('public')->exists($promosi->Gambar)) {
                Storage::disk('public')->delete($promosi->Gambar);
            }
            // Simpan gambar baru
            $gambarPath = $request->file('Gambar')->store('promosi', 'public');
        }

        $promosi->update([
            'Judul' => $request->Judul,
            'Deskripsi' => $request->Deskripsi,
            'Gambar' => $gambarPath,
            'Tgl_mulai' => $request->Tgl_mulai,
            'Tgl_berakhir' => $request->Tgl_berakhir,
        ]);

        return redirect()->route('admin.promosi.index')
                         ->with('success', 'Promosi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $promosi = Promosi::findOrFail($id);
        
        // Hapus gambar dari storage jika ada
        if ($promosi->Gambar && Storage::disk('public')->exists($promosi->Gambar)) {
            Storage::disk('public')->delete($promosi->Gambar);
        }
        
        $promosi->delete();

        return redirect()->route('admin.promosi.index')
                         ->with('success', 'Promosi berhasil dihapus!');
    }
}