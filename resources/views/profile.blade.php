<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profil UBSC - Member</title>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-[#152259] min-h-screen">
    @include('alert')
    
    {{-- LOGIC INITIATOR --}}
    @php
        $is_active = $member_data['is_active'] ?? false;
        
        $status_class = $is_active ? 'bg-green-500' : 'bg-red-500';
        $icon_class = $is_active ? 'text-green-500' : 'text-red-500';
        $progress_color = $is_active ? 'bg-green-500' : 'bg-red-500';
        $kategori = ($akun->kategori ?? 0) == 1 ? 'Warga UB' : 'Umum';
        
        // Formatting tanggal bergabung (asumsi 'created_at' di model AkunUbsc)
        $tgl_daftar = isset($akun->created_at) ? \Carbon\Carbon::parse($akun->created_at)->translatedFormat('d F Y') : '-';
    @endphp
    <!-- NAVBAR START -->
    <header class="bg-[#F4F6FF] shadow-md sticky top-0 z-10">
        <div class="mx-auto flex items-center justify-between px-12 py-2">
            
            <div class="flex items-center space-x-2">
                <img src='{{ asset('images/LogoBMU.SVG') }}' alt="UB Sport Center Logo" class="h-10 sm:h-14 w-10 sm:w-16">
                <img src='{{ asset('images/LogoUBSC.SVG') }}' alt="UB Sport Center Logo" class="h-10 sm:h-14 w-10 sm:w-16">
            </div>
            
            <nav class="hidden md:flex space-x-6 lg:space-x-8">
                <a href="/homepage" class="text-gray-700 hover:text-gray-900 font-medium hover:font-bold transition-colors duration-200">Home</a>
                <a href="#" class="text-gray-700 hover:text-gray-900 font-medium transition-colors duration-200">Facilities</a>
                <a href="#" class="text-gray-700 hover:text-gray-900 font-medium transition-colors duration-200">Recent News</a>
                <a href="#" class="text-gray-700 hover:text-gray-900 font-medium transition-colors duration-200">Gallery</a>
                <a href="#" class="text-gray-700 hover:text-gray-900 font-medium transition-colors duration-200">FAQ</a>
            </nav>
    
            <div class="flex items-center space-x-3">
                <img src='{{ asset('images/profilBas.svg') }}' alt="Profil User" class="h-12 w-12 rounded-full object-cover">
                <div class="hidden sm:block">
                    <p class="font-semibold text-sm text-gray-900 leading-tight">{{ $akun->nama_lengkap ?? 'Nama Pengguna' }}</p>
                    <p class="text-xs text-gray-700 leading-tight">
                        @if ($is_active)
                            Premium Member
                        @else
                            Non-Member
                        @endif
                    </p>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" title="Logout" class="p-2 rounded-full hover:bg-gray-100 transition duration-150">
                        <i class="fas fa-sign-out-alt text-gray-700 h-5 w-5"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>
    <!-- NAVBAR END -->

    <!-- PROFILE TITLE START -->
    <div x-data="{ detailOpen: false }" class=" mx-auto min-h-screen text-gray-900 flex"> 
        {{-- Main Content --}}
        <main class="flex-1 p-4 bg-[#152259] overflow-y-auto">
            
            <div class="flex flex-col sm:flex-row justify-between text-gray-900 items-center px-12 pb-4 sm:items-center">
                <div class="text-[#CEDDE6]">
                    <h1 class="text-3xl font-bold">Profil Saya</h1>
                    <p class="text-sm">Kelola informasi profil dan status membership Anda</p>
                </div>
                
                <div class="flex items-center mt-4 sm:mt-0 space-x-4">
                    <a href="" class="bg-[#3B82F6] hover:bg-blue-600 text-white py-2 px-4 rounded-lg flex items-center text-sm font-medium transition duration-150 shadow-md">
                        <i class="fas fa-edit h-4 w-4 mr-2"></i>
                        Edit Profil
                    </a>
                    <div class="relative">
                        <button title="Notifications" class="h-10 w-10 flex items-center justify-center rounded-full bg-white hover:bg-gray-100 transition duration-150">
                            <i class="fas fa-bell text-gray-700"></i>
                        </button>
                        <span class="absolute top-0 right-0 h-3 w-3 rounded-full bg-red-500 border-2 border-white"></span>
                    </div>
                </div>
            </div>
            <!-- PROFILE TITLE END -->

            <!-- CARD PROFILE START -->
            <div x-data="{ detailOpen: true }" class="flex flex-col gap-6 px-12">
                
                <section class="profile-container p-2 md:p-8 bg-white rounded-xl shadow-lg border border-gray-50">
        
                    <div class="flex justify-between items-center pb-2 border-b border-gray-100">
                        <h2 class="text-2xl font-semibold text-gray-800">Informasi Profil</h2>
                        
                        <button 
                            @click="detailOpen = !detailOpen"
                            class="bg-[#3B82F6] text-white py-2 px-4 rounded-lg flex items-center text-sm font-medium transition duration-50 shadow-md hover:bg-blue-600"
                        >
                            <span x-show="detailOpen" class="flex items-center"><img src='{{ asset('images/info.svg') }}' class="mr-2">Tutup Detail</span>
                            <span x-show="!detailOpen" class="flex items-center"><img src='{{ asset('images/info.svg') }}' class="mr-2">Tampilkan Detail</span>
                        </button>
                    </div>

                    <div class="flex flex-col lg:flex-row gap-8 pt-6">
                        
                        <div class="left-panel flex-grow lg:w-2/3">
                            
                            <div class="flex flex-col sm:flex-row justify-between items-start pb-8">
                                <div class="flex items-start">
                                    <img 
                                        src="{{ $akun->foto_identitas ? asset('storage/' . $akun->foto_identitas) : asset('images/profilBas.svg') }}" 
                                        alt="{{ $akun->nama_lengkap ?? 'Profil User' }}" 
                                        class="h-24 w-24 rounded-full mr-5 object-cover"
                                    >
                                    <div class="pt-2">
                                        <p class="text-xl font-bold text-gray-800">{{ $akun->nama_lengkap ?? 'Nama Tidak Diketahui' }}</p>
                                        <p class="text-sm text-gray-600">ID Akun: **UBSC{{ str_pad($akun->id_akun ?? 0, 5, '0', STR_PAD_LEFT) }}**</p>
                                        @if (isset($membership) && $membership)
                                            <p class="text-sm text-gray-600">ID Member: **MBR{{ str_pad($membership->id_membership ?? 0, 7, '0', STR_PAD_LEFT) }}**</p>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="flex-shrink-0 mt-4 sm:mt-0">
                                    <img src="{{ asset('images/qrcode.svg') }}" alt="QR Code Member" class="h-28 w-28 p-2 border border-gray-200 rounded-lg"> 
                                </div>
                            </div>
                            
                            <div class="space-y-6">
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-10 gap-x-10">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-2">Nama Lengkap</p>
                                        <p class="bg-[#F9FAFB] rounded-lg text-lg font-semibold text-gray-700 py-2 pl-4">{{ $akun->nama_lengkap ?? '-' }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-2">Email</p>
                                        <p class="bg-[#F9FAFB] rounded-lg text-lg font-semibold text-gray-700 py-2 pl-4">{{ $akun->email ?? '-' }}</p>
                                    </div>
                                </div>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-y-6 gap-x-10">
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-2">Kategori Akun</p>
                                        <p class="bg-[#F9FAFB] rounded-lg text-lg font-semibold text-gray-700 py-2 pl-4">{{ $kategori }}</p>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-700 mb-2">Bergabung Sejak</p>
                                        <p class="bg-[#F9FAFB] rounded-lg text-lg font-semibold text-gray-700 py-2 pl-4">{{ $tgl_daftar }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        
                        @if (isset($membership) && $membership)
                            {{-- BLOK MEMBER --}}
                            <div x-show="detailOpen" x-transition.duration.500ms class="right-panel lg:w-1/3 rounded-xl flex flex-col gap-6">
                                
                                <div class="text-center">
                                    <h3 class="text-lg font-semibold text-gray-800 pb-2">Status Membership </h3>
                                    
                                    <div class="flex justify-center items-center mx-auto mb-4 ">
                                        <img src='{{ asset('images/member.SVG') }}' alt="UB Sport Center Logo" class="h-16 sm:h-18 w-16 sm:w-18">
                                    </div>
                                    
                                    <span class="inline-block px-4 py-1.5 bg-green-600 text-white text-xs font-bold rounded-full uppercase tracking-wider mb-2shadow-sm mb-2">
                                        AKTIF
                                    </span>
                                    <p class="text-sm text-gray-800">Mulai: 15 November 2025</p>
                                    <p class="text-sm text-gray-800">Berakhir: 15 Desember 2025</p>
                                </div>

                                <div class="">
                                    <div class="flex justify-between items-center mb-2">
                                        <p class="text-sm font-medium text-green-500">Sisa waktu</p>
                                        <p class="text-base font-bold text-green-800">
                                            30 hari lagi
                                        </p>
                                    </div>
                                    
                                    <div class="w-full bg-green-200 rounded-full h-2.5">
                                        <div class="{{ $progress_color }} h-2.5 rounded-full transition-all duration-700" style="width: {{ $member_data['progress_width'] }}%;"></div>
                                    </div>
                                    
                                    @if (!$is_active)
                                        <a href="#" class="mt-4 block w-full text-center bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg text-sm font-medium transition duration-150 shadow-md">
                                            Perpanjang Membership
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @else
                        {{-- BLOK NON-MEMBER --}}
                        <div x-show="detailOpen" x-transition.duration.500ms class="right-panel lg:w-1/3 rounded-xl flex flex-col gap-4 text-center justify-center items-center">
                            <h3 class="text-lg font-semibold text-gray-800 pb-2">Status Membership </h3>
                                 <div class="flex justify-center items-center mx-auto mb-4 ">
                                        <img src='{{ asset('images/nonMember.SVG') }}' alt="UB Sport Center Logo" class="h-16 sm:h-18 w-16 sm:w-18">
                                    </div>
                                <span class="inline-block px-4 py-1.5 bg-red-600 text-white text-xs font-bold rounded-full uppercase tracking-wider mb-2 shadow-sm mb-2">
                                       NON-AKTIF
                                    </span>
                                <p class="text-sm text-gray-600 mb-2">Anda belum memiliki status Premium Membership. Dapatkan akses eksklusif sekarang!</p>
                                <a href="#" class="w-full text-center bg-red-500 hover:bg-red-600 text-white py-2 rounded-lg text-sm font-medium transition duration-150 shadow-md">
                                    Daftar Membership
                                </a>
                            </div>
                        @endif
                        
                    </div>
                </section>
            <!-- CARD PROFILE END -->

            <!-- CARD OTHERS START -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    {{-- AKSI CEPAT --}}
                    <section class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold mb-4 border-b pb-3 border-gray-100">Aksi Cepat ⚡</h2>
                        <ul class="divide-y divide-gray-100">
                            <li class="group flex justify-between items-center py-3 hover:bg-gray-50 px-2 -mx-2 rounded transition duration-150 cursor-pointer">
                                <div class="flex items-center">
                                    <img src='{{ asset('images/riwayat.SVG') }}' alt="UB Sport Center Logo" class="mr-4 h-2 sm:h-5 w-2 sm:w-5">
                                    <p class="font-medium">Riwayat Membership</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-500 text-sm"></i>
                            </li>
                            <li class="group flex justify-between items-center py-3 hover:bg-gray-50 px-2 -mx-2 rounded transition duration-150 cursor-pointer">
                                <div class="flex items-center">
                                    <img src='{{ asset('images/kartu.SVG') }}' alt="UB Sport Center Logo" class="mr-4 h-2 sm:h-5 w-2 sm:w-5">
                                    <p class="font-medium">Metode Pembayaran</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-500 text-sm"></i>
                            </li>
                            <li class="group flex justify-between items-center py-3 hover:bg-gray-50 px-2 -mx-2 rounded transition duration-150 cursor-pointer">
                                <div class="flex items-center">
                                    <img src='{{ asset('images/bantuan.SVG') }}' alt="UB Sport Center Logo" class="mr-4 h-2 sm:h-5 w-2 sm:w-5">
                                    <p class="font-medium">Bantuan & Support</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-blue-500 text-sm"></i>
                            </li>
                        </ul>
                    </section>
                    {{-- KEUNTUNGAN MEMBER --}}
                    <section class="bg-white rounded-xl shadow-lg p-6">
                        <h2 class="text-xl font-semibold mb-4 border-b pb-3 border-gray-100">Keuntungan Member ✨</h2>
                        <ul class="space-y-3">
                            <li class="flex items-start">
                                <img src='images/check.svg' alt="Check Icon" class="w-5 h-5 mt-1 mr-3"> 
                                <p>Akses unlimited konten premium dan fasilitas utama.</p>
                            </li>
                            <li class="flex items-start">
                                <img src='images/check.svg' alt="Check Icon" class="w-5 h-5 mt-1 mr-3"> 
                                <p>Diskon 20% untuk semua produk dan penyewaan lapangan.</p>
                            </li>
                            <li class="flex items-start">
                                <img src='images/check.svg' alt="Check Icon" class="w-5 h-5 mt-1 mr-3"> 
                                <p>Support prioritas 24/7 melalui live chat.</p>
                            </li>
                            <li class="flex items-start">
                                <img src='images/check.svg' alt="Check Icon" class="w-5 h-5 mt-1 mr-3"> 
                                <p>Akses early access untuk fitur dan event baru.</p>
                            </li>
                        </ul>
                    </section>
                </div>
            </div>
            <!-- CARD OTHERS END -->
             
        </main>
    </div>

</body>
</html>