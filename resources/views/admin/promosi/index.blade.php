@extends('layouts.admin')

@section('title', 'Promosi Management')
@section('page-title', 'Promosi Management')

@section('content')
<!-- Tombol Tambah -->
<div class="mb-6">
    <a href="{{ route('admin.promosi.create') }}" class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center">
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
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">Gambar</th>
                <th class="px-6 py-3 text-left">Judul</th>
                <th class="px-6 py-3 text-left">Deskripsi</th>
                <th class="px-6 py-3 text-left">Periode</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($promosis as $index => $promosi)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4">
                    @if($promosi->Gambar)
                        <img src="{{ asset('storage/' . $promosi->Gambar) }}" 
                             alt="Gambar Promosi" 
                             class="w-20 h-20 object-cover rounded">
                    @else
                        <span class="text-gray-400">No Image</span>
                    @endif
                </td>
                <td class="px-6 py-4 font-semibold">{{ $promosi->Judul }}</td>
                <td class="px-6 py-4">{{ Str::limit($promosi->Deskripsi, 60) }}</td>
                <td class="px-6 py-4 text-sm">
                    <div>{{ \Carbon\Carbon::parse($promosi->Tgl_mulai)->format('d M Y') }}</div>
                    <div class="text-gray-500">s/d</div>
                    <div>{{ \Carbon\Carbon::parse($promosi->Tgl_berakhir)->format('d M Y') }}</div>
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('admin.promosi.edit', $promosi->Id_promosi) }}" 
                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded mr-2 inline-block">
                        Edit
                    </a>
                    <form action="{{ route('admin.promosi.destroy', $promosi->Id_promosi) }}" 
                          method="POST" class="inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                onclick="return confirm('Yakin ingin menghapus promosi ini?')"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            Hapus
                        </button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center py-8 text-gray-500">
                    Belum ada data promosi
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection