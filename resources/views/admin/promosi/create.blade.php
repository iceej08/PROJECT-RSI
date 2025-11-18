@extends('layouts.admin')

@section('title', 'Tambah Promosi')
@section('page-title', 'Tambah Promosi')

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow-lg p-8">
    
    <form action="{{ route('admin.promosi.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Judul Promosi</label>
            <input type="text" name="Judul" 
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('Judul') border-red-500 @enderror" 
                   value="{{ old('Judul') }}" required>
            @error('Judul')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
            <textarea name="Deskripsi" rows="5" 
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('Deskripsi') border-red-500 @enderror" 
                      required>{{ old('Deskripsi') }}</textarea>
            @error('Deskripsi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Gambar Promosi</label>
            <input type="file" name="Gambar" accept="image/*"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('Gambar') border-red-500 @enderror">
            <p class="text-gray-500 text-sm mt-1">Format: JPG, PNG, GIF (Max: 2MB)</p>
            @error('Gambar')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Mulai</label>
                <input type="datetime-local" name="Tgl_mulai" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('Tgl_mulai') border-red-500 @enderror" 
                       value="{{ old('Tgl_mulai') }}" required>
                @error('Tgl_mulai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Berakhir</label>
                <input type="datetime-local" name="Tgl_berakhir" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('Tgl_berakhir') border-red-500 @enderror" 
                       value="{{ old('Tgl_berakhir') }}" required>
                @error('Tgl_berakhir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" 
                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg">
                Simpan
            </button>
            <a href="{{ route('admin.promosi.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg inline-block">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection