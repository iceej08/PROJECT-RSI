@extends('layouts.admin')

@section('title', 'Tambah FAQ')
@section('page-title', 'Tambah FAQ')

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow-lg p-8">
    
    <form action="{{ route('admin.faq.store') }}" method="POST">
        @csrf
        
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Pertanyaan</label>
            <textarea name="Pertanyaan" rows="3" 
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Pertanyaan') border-red-500 @enderror" 
                      required>{{ old('Pertanyaan') }}</textarea>
            @error('Pertanyaan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Jawaban</label>
            <textarea name="Jawaban" rows="5" 
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('Jawaban') border-red-500 @enderror" 
                      required>{{ old('Jawaban') }}</textarea>
            @error('Jawaban')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg">
                Simpan
            </button>
            <a href="{{ route('admin.faq.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg inline-block">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection