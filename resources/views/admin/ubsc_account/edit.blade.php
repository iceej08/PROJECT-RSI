@extends('layouts.admin')

@section('title', 'Edit Akun UBSC - Admin Panel')
@section('page-title', 'Edit Akun UBSC')

@section('content')
@include('alert')
<div class="max-w-2xl">
    <div class="bg-white rounded-xl shadow-md p-6">
        <form action="{{ route('admin.ubsc_account.update', $account->id_akun) }}" method="POST">
            @csrf
            @method('PUT')
            
            <!-- Nama Lengkap -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" 
                       name="nama_lengkap" 
                       value="{{ old('nama_lengkap', $account->nama_lengkap) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('nama_lengkap') border-red-500 @enderror"
                       required>
                @error('nama_lengkap')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" 
                       name="email" 
                       value="{{ old('email', $account->email) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                       required>
                @error('email')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password <span class="text-gray-500 text-xs">(Kosongkan jika tidak ingin mengubah)</span></label>
                <input type="password" 
                       name="password" 
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('password') border-red-500 @enderror">
                @error('password')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                <select name="kategori" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('kategori') border-red-500 @enderror"
                        required>
                    <option value="">Pilih Kategori</option>
                    <option value ="0" {{ old('kategori', $account->kategori) == '0' ? 'selected' : '' }}>Umum</option>
                    <option value="1" {{ old('kategori', $account->kategori) == '1' ? 'selected' : '' }}>Warga UB</option>
                </select>
                @error('kategori')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Buttons -->
            <div class="flex gap-4">
                <a href="{{ route('admin.ubsc_account.index') }}" class="flex-1 px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 text-center rounded-lg transition">
                    Batal
                </a>
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                    Update
                </button>
            </div>
        </form>
    </div>
</div>
@endsection