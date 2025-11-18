@extends('layouts.admin')

@section('title', 'FAQ Management')
@section('page-title', 'FAQ Management')

@section('content')
<!-- Tombol Tambah -->
<div class="mb-6">
    <a href="{{ route('admin.faq.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg inline-flex items-center">
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
                <th class="px-6 py-3 text-left">No</th>
                <th class="px-6 py-3 text-left">Pertanyaan</th>
                <th class="px-6 py-3 text-left">Jawaban</th>
                <th class="px-6 py-3 text-center">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($faqs as $index => $faq)
            <tr class="hover:bg-gray-50">
                <td class="px-6 py-4">{{ $index + 1 }}</td>
                <td class="px-6 py-4">{{ $faq->Pertanyaan }}</td>
                <td class="px-6 py-4">{{ Str::limit($faq->Jawaban, 50) }}</td>
                <td class="px-6 py-4">
                    <div class="flex justify-center gap-2">
                        <a href="{{ route('admin.faq.edit', $faq->Id_FAQ) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded">
                            Edit
                        </a>
                        <form action="{{ route('admin.faq.destroy', $faq->Id_FAQ) }}" 
                              method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    onclick="return confirm('Yakin ingin menghapus?')"
                                    class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" class="text-center py-8 text-gray-500">
                    Belum ada data FAQ
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection