@extends('layouts.admin')

@section('title', 'Promosi Management')
@section('page-title', 'Promosi Management')

@section('content')

<!-- Alert Success -->
@if(session('success'))
<div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
    <span class="block sm:inline">{{ session('success') }}</span>
    <button type="button" class="absolute top-0 bottom-0 right-0 px-4 py-3" onclick="this.parentElement.remove()">
        <span class="text-2xl">&times;</span>
    </button>
</div>
@endif

<!-- Tombol Tambah -->
<div class="mb-6">
    <a href="{{ route('admin.promosi.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center transition duration-150">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Promosi
    </a>
</div>

<!-- Tabel Promosi -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Gambar</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Judul</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Deskripsi</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Periode</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($promosis as $promosi)
            <tr class="hover:bg-gray-50 transition duration-150">
                <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                <td class="px-6 py-4">
                    @if($promosi->Gambar)
                        <img src="{{ asset('storage/' . $promosi->Gambar) }}" 
                             alt="Gambar Promosi" 
                             class="w-20 h-20 object-cover rounded-lg shadow-sm"
                             onerror="this.onerror=null; this.src='data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22><rect fill=%22%23e5e7eb%22 width=%22100%22 height=%22100%22/><text x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%239ca3af%22 font-size=%2214%22>No Image</text></svg>';">
                    @else
                        <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $promosi->Judul }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">
                    <div class="max-w-md">
                        {{ Str::limit($promosi->Deskripsi, 60) }}
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-700">
                    <div>{{ \Carbon\Carbon::parse($promosi->Tgl_mulai)->format('d M Y') }}</div>
                    <div class="text-xs text-gray-500">s/d</div>
                    <div>{{ \Carbon\Carbon::parse($promosi->Tgl_berakhir)->format('d M Y') }}</div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('admin.promosi.edit', $promosi->Id_promosi) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md transition duration-150 inline-flex items-center">
                            Edit
                        </a>
                        
                        <form action="{{ route('admin.promosi.destroy', $promosi->Id_promosi) }}" 
                              method="POST" 
                              class="inline" 
                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus promosi ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition duration-150 inline-flex items-center">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-sm font-medium">Tidak ada data promosi</p>
                        <p class="text-xs mt-1">Klik tombol "Tambah Promosi" untuk menambahkan data baru</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection