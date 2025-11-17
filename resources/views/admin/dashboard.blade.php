@extends('layouts.admin')

@section('title', 'Dashboard - Admin UB Sport Center')
@section('page-title', 'Dashboard Admin')

@section('content')
<!-- Menu Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    
    <!-- Card FAQ -->
    <a href="{{ route('admin.faq.index') }}" class="block">
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="bg-blue-500 p-4 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-xl font-semibold text-gray-800">FAQ Management</h3>
                    <p class="text-gray-600">Kelola pertanyaan dan jawaban</p>
                </div>
                <div class="text-3xl font-bold text-gray-800">
                    {{ \App\Models\FAQ::count() }}
                </div>
            </div>
        </div>
    </a>

    <!-- Card Promosi -->
    <a href="{{ route('admin.promosi.index') }}" class="block">
        <div class="bg-white rounded-lg shadow-lg p-6 hover:shadow-xl transition transform hover:-translate-y-1">
            <div class="flex items-center">
                <div class="bg-orange-500 p-4 rounded-full">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path>
                    </svg>
                </div>
                <div class="ml-4 flex-1">
                    <h3 class="text-xl font-semibold text-gray-800">Promosi Management</h3>
                    <p class="text-gray-600">Kelola berita dan promosi</p>
                </div>
                <div class="text-3xl font-bold text-gray-800">
                    {{ \App\Models\Promosi::count() }}
                </div>
            </div>
        </div>
    </a>

</div>

<!-- Quick Stats -->
<div class="bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Ringkasan Cepat</h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="border-l-4 border-blue-500 pl-4">
            <p class="text-gray-600 text-sm">Total FAQ</p>
            <p class="text-3xl font-bold text-gray-800">{{ \App\Models\FAQ::count() }}</p>
        </div>
        <div class="border-l-4 border-orange-500 pl-4">
            <p class="text-gray-600 text-sm">Total Promosi</p>
            <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Promosi::count() }}</p>
        </div>
        <div class="border-l-4 border-green-500 pl-4">
            <p class="text-gray-600 text-sm">Promosi Aktif</p>
            <p class="text-3xl font-bold text-gray-800">{{ \App\Models\Promosi::where('Tgl_berakhir', '>=', now())->count() }}</p>
        </div>
    </div>
</div>

<!-- Recent Activity (Optional) -->
<div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-6">
    
    <!-- Latest FAQ -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">FAQ Terbaru</h3>
        <div class="space-y-3">
            @forelse(\App\Models\FAQ::latest()->take(5)->get() as $faq)
            <div class="border-b pb-2">
                <p class="font-semibold text-gray-700">{{ Str::limit($faq->Pertanyaan, 50) }}</p>
                <p class="text-sm text-gray-500">{{ $faq->created_at->diffForHumans() }}</p>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">Belum ada FAQ</p>
            @endforelse
        </div>
    </div>

    <!-- Latest Promosi -->
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h3 class="text-lg font-bold text-gray-800 mb-4">Promosi Terbaru</h3>
        <div class="space-y-3">
            @forelse(\App\Models\Promosi::latest()->take(5)->get() as $promosi)
            <div class="border-b pb-2">
                <p class="font-semibold text-gray-700">{{ Str::limit($promosi->Judul, 50) }}</p>
                <p class="text-sm text-gray-500">{{ $promosi->created_at->diffForHumans() }}</p>
            </div>
            @empty
            <p class="text-gray-500 text-center py-4">Belum ada promosi</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
