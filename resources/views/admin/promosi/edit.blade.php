@extends('layouts.admin')

@section('title', 'Edit Promosi')
@section('page-title', 'Edit Promosi')

@section('content')
<div class="max-w-2xl bg-white rounded-lg shadow-lg p-8">
    
    <form action="{{ route('admin.promosi.update', $promosi->Id_promosi) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Judul Promosi</label>
            <input type="text" name="Judul" 
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('Judul') border-red-500 @enderror" 
                   value="{{ old('Judul', $promosi->Judul) }}" required>
            @error('Judul')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Deskripsi</label>
            <textarea name="Deskripsi" rows="5" 
                      class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('Deskripsi') border-red-500 @enderror" 
                      required>{{ old('Deskripsi', $promosi->Deskripsi) }}</textarea>
            @error('Deskripsi')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-semibold mb-2">Gambar Promosi</label>
            
            @if($promosi->Gambar)
            <div class="mb-3">
                <img src="{{ asset('storage/' . $promosi->Gambar) }}" 
                     alt="Current Image" 
                     class="w-40 h-40 object-cover rounded-lg shadow">
                <p class="text-sm text-gray-500 mt-2">Gambar saat ini</p>
            </div>
            @endif
            
            <input type="file" name="Gambar" accept="image/*"
                   class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('Gambar') border-red-500 @enderror">
            <p class="text-gray-500 text-sm mt-1">Biarkan kosong jika tidak ingin mengubah gambar</p>
            @error('Gambar')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Mulai</label>
                <input type="datetime-local" name="Tgl_mulai" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('Tgl_mulai') border-red-500 @enderror" 
                       value="{{ old('Tgl_mulai', $promosi->Tgl_mulai->format('Y-m-d\TH:i')) }}" required>
                @error('Tgl_mulai')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Tanggal Berakhir</label>
                <input type="datetime-local" name="Tgl_berakhir" 
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('Tgl_berakhir') border-red-500 @enderror" 
                       value="{{ old('Tgl_berakhir', $promosi->Tgl_berakhir->format('Y-m-d\TH:i')) }}" required>
                @error('Tgl_berakhir')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div class="flex gap-4">
            <button type="submit" 
                    class="bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-3 rounded-lg">
                Update
            </button>
            <a href="{{ route('admin.promosi.index') }}" 
               class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg inline-block">
                Batal
            </a>
        </div>
    </form>

</div>
@endsection