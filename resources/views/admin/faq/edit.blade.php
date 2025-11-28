@extends('layouts.admin')

@section('title', 'Edit FAQ')
@section('page-title', 'Edit FAQ')

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow-lg p-8">
    
    <form action="{{ route('admin.faq.update', $faq->id_faq) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Pertanyaan</label>
            <textarea name="pertanyaan" rows="3" 
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('pertanyaan') border-red-500 @enderror" 
                      required>{{ old('pertanyaan', $faq->pertanyaan) }}</textarea>
            @error('pertanyaan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Jawaban</label>
            <textarea name="jawaban" rows="5" 
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('jawaban') border-red-500 @enderror" 
                      required>{{ old('jawaban', $faq->jawaban) }}</textarea>
            @error('jawaban')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-4">
            <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-3 rounded-lg transition duration-150">
                Update
            </button>
            <a href="{{ route('admin.faq.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg inline-block transition duration-150">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection