@extends('layouts.admin')

@section('title', 'FAQ Management')
@section('page-title', 'FAQ Management')

@section('content')
<!-- Tombol Tambah -->
<div class="mb-6">
    <a href="{{ route('admin.faq.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center transition duration-150">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah FAQ
    </a>
</div>

<!-- Tabel FAQ -->
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    <table class="min-w-full">
        <thead class="bg-gray-800 text-white">
            <tr>
                <th class="px-6 py-4 text-left text-sm font-semibold">No</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Pertanyaan</th>
                <th class="px-6 py-4 text-left text-sm font-semibold">Jawaban</th>
                <th class="px-6 py-4 text-center text-sm font-semibold">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($faqs as $faq)
            <tr class="hover:bg-gray-50 transition duration-150">
                <td class="px-6 py-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                <td class="px-6 py-4 text-sm text-gray-900 font-medium">{{ $faq->pertanyaan }}</td>
                <td class="px-6 py-4 text-sm text-gray-700">
                    <div class="max-w-md">
                        {{ Str::limit($faq->jawaban, 100) }}
                    </div>
                </td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('admin.faq.edit', $faq->id_faq) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-2 px-4 rounded-md transition duration-150 inline-flex items-center">
                            Edit
                        </a>
                        
                        <form action="{{ route('admin.faq.destroy', $faq->id_faq) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus FAQ ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white font-medium py-2 px-4 rounded-md transition duration-150 inline-flex items-center">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <svg class="w-12 h-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        <p class="text-sm font-medium">Tidak ada data FAQ</p>
                        <p class="text-xs mt-1">Klik tombol "Tambah FAQ" untuk menambahkan data baru</p>
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection