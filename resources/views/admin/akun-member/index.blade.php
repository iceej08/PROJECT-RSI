<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Akun Member</title>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Sidebar -->
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-1/8 bg-[#004a73] text-white">
            <div class="p-6">
                <span class="flex justify-center mr-5 mb-3">
                    <img src="{{ asset('images/ubsc-logo.png') }}">
                </span>
                <h1 class="text-2xl font-bold">UB Sport Center</h1>
                <p class="text-sm text-blue-200">Admin Panel</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center px-6 py-3 hover:bg-[#003d5e] transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                
                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#003d5e] transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Verifikasi Akun
                </a>
                
                <a href="{{ route('admin.akun-member.index') }}" class="flex items-center px-6 py-3 bg-[#003d5e] border-l-4 border-white">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Akun Member
                </a>
                
                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#003d5e] transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Verifikasi Pembayaran
                </a>
                
                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#003d5e] transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    FAQ
                </a>
            </nav>
            
            <!-- Logout at bottom -->
            <div class="absolute bottom-0 w-64 p-6">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center text-white hover:text-red-300 transition w-full">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <!-- Top Bar -->
            <header class="bg-white shadow-md">
                <div class="flex items-center justify-between px-8 py-4">
                    <h2 class="text-2xl font-bold text-gray-800">Akun Membership</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Admin: <span class="font-semibold text-[#004a73]">{{ Auth::guard('admin')->user()->nama_lengkap }}</span></span>
                        <div class="w-10 h-10 bg-[#004a73] rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->nama_lengkap, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="py-10 px-6">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            {{ session('success') }}
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                            </svg>
                            {{ session('error') }}
                        </div>
                    </div>
                @endif

                <!-- Header -->
                <div class="mb-8 flex justify-between items-start">
                    <button onclick="openAddModal()" class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-lg flex items-center transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Tambah Akun Member
                    </button>
                    <div class="flex items-center grow max-w-md">
                        <svg class="w-5 h-5 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <form action="{{ route('admin.akun-member.index') }}" method="GET" class="grow">
                            <input 
                                type="text" 
                                name="search"
                                value="{{ $search ?? '' }}"
                                placeholder="Cari Akun Member"
                                class="w-full px-3 py-1 border-0 focus:outline-none">
                        </form>
                    </div>
                </div>

                <!-- Add Member Modal -->
                <div id="addModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                    <div class="relative top-20 mx-auto p-8 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-lg bg-white">
                        <div class="flex justify-between items-center pb-3 border-b mb-6">
                            <h3 class="text-2xl font-bold text-gray-800">Tambah Member</h3>
                            <button onclick="closeAddModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <form action="{{ route('admin.akun-member.tambahMember') }}" method="POST" id="addMemberForm">
                            @csrf
                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilih User</label>
                                <select name="id_akun" id="id_akun_select" required onchange="updatePrices()"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                    <option value="">-- Pilih User --</option>
                                    @foreach(App\Models\AkunUbsc::whereDoesntHave('memberships')->where('status_verifikasi', '!=', 'pending')->orderBy('nama_lengkap')->get() as $user)
                                        <option value="{{ $user->id_akun }}" 
                                                data-kategori="{{ $user->kategori ? '1' : '0' }}"
                                                data-has-history="0">
                                            {{ $user->nama_lengkap }} ({{ $user->email }}) - {{ $user->kategori ? 'Warga UB' : 'Umum' }}
                                        </option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Hanya menampilkan user yang belum memiliki membership</p>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Pilihan Paket Member</label>
                                <select name="jenis_paket" id="jenis_paket_select" required onchange="updatePrices()"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                    <option value="">Pilihan Paket</option>
                                    <option value="harian">Harian</option>
                                    <option value="bulanan">Bulanan</option>
                                </select>
                            </div>

                            <!-- Price Breakdown (dinamis berdasarkan kategori user) -->
                            <div id="price_breakdown" class="hidden b-6 p-4 bg-gray-50 rounded-lg">
                                <h4 class="font-semibold text-gray-800 mb-3">Rincian Biaya:</h4>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Paket <span id="paket_name"></span></span>
                                        <span class="font-medium" id="paket_price"></span>
                                    </div>
                                    <div id="biaya_pendaftaran_row" class="hidden justify-between">
                                        <span class="text-gray-600">Biaya Pendaftaran Awal</span>
                                        <span class="font-medium" id="biaya_pendaftaran"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Subtotal</span>
                                        <span class="font-medium" id="subtotal_price"></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Pajak (10%)</span>
                                        <span class="font-medium" id="tax_price"></span>
                                    </div>
                                    <div class="border-t pt-2 flex justify-between">
                                        <span class="font-bold text-gray-800">Total</span>
                                        <span class="font-bold text-[#004a73]" id="total_price"></span>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-6">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Metode Pembayaran</label>
                                <select name="metode_pembayaran" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                    <option value="transfer_bank">Transfer Bank</option>
                                    <option value="qris">QRIS</option>
                                </select>
                            </div>

                            <div class="flex justify-end space-x-3 mt-8">
                                <button type="button" onclick="closeAddModal()" 
                                        class="px-6 py-3 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                    Batal
                                </button>
                                <button type="submit" 
                                        class="px-6 py-3 bg-[#004a73] text-white rounded-lg hover:bg-[#003d5e] transition">
                                    Tambah Akun
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Table -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Mulai</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal Berakhir</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Action</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($members as $member)
                                    @php
                                        $member = $member->status_pembayaran === true;
                                        $membership = $member->activeMembership ?? $member->memberships->first();
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 text-sm text-gray-900">{{ str_pad($membership->id_membership, 6, '0', STR_PAD_LEFT) }}</td>
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900">{{ $member->nama_lengkap }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">{{ $member->email }}</td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            @if($membership)
                                                {{ $membership->tgl_mulai->format('d F Y') }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            @if($membership)
                                                {{ $membership->tgl_berakhir->format('d F Y') }}
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            @if($membership->status === true)
                                                @if($membership->status && $membership->tgl_berakhir >= now())
                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">Aktif</span>
                                                @elseif($membership->tgl_berakhir < now() && $membership->tgl_berakhir->copy()->addMonths(2) > now())
                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-800">Non-aktif</span>
                                                @else
                                                    <span class="px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">Kedaluwarsa</span>
                                                @endif
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <button 
                                                onclick="openEditModal({{ $member->id_akun }})" 
                                                class="text-blue-600 hover:text-blue-800 mr-3"
                                                title="Edit">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>
                                            <button 
                                                onclick="confirmDelete({{ $member->id_akun }})"
                                                class="text-red-600 hover:text-red-800"
                                                title="Delete">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>

                                            <!-- Delete Form (Hidden) -->
                                            <form id="delete-form-{{ $member->id_akun }}" 
                                                  action="{{ route('admin.akun-member.destroy', $membership->id_membership) }}" 
                                                  method="POST" 
                                                  class="hidden">
                                                @csrf
                                                @method('DELETE')
                                            </form>

                                            <!-- Edit Modal -->
                                            <div id="editModal{{ $member->id_akun }}" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
                                                <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-lg bg-white">
                                                    <div class="flex justify-between items-center pb-3 border-b">
                                                        <h3 class="text-xl font-bold">Edit Member Account</h3>
                                                        <button onclick="closeEditModal({{ $member->id_akun }})" class="text-gray-400 hover:text-gray-600">
                                                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                    
                                                    <form action="{{ route('admin.akun-member.updateMembership', $membership->id_membership) }}" method="POST" class="mt-4">
                                                        @csrf
                                                        @method('PUT')
                                                        
                                                        <div class="grid grid-cols-2 gap-4 mb-4">
                                                            <div>
                                                                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                                                                <input type="text" name="nama_lengkap" value="{{ $member->nama_lengkap }}" disabled
                                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                                                                <input type="email" name="email" value="{{ $member->email }}" disabled
                                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                                            </div>
                                                            <div>
                                                                <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                                                                <input type="text" value="{{ $member->kategori ? 'Warga UB' : 'Umum' }}" disabled
                                                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-100">
                                                            </div>
                                                        </div>

                                                        @if($membership)
                                                            <hr class="my-4">
                                                            <h4 class="font-semibold mb-4">Membership Details</h4>
                                                            <div class="grid grid-cols-2 gap-4 mb-4">
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Mulai</label>
                                                                    <input type="date" name="tgl_mulai" value="{{ $membership->tgl_mulai->format('Y-m-d') }}"
                                                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                                                </div>
                                                                <div>
                                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Berakhir</label>
                                                                    <input type="date" name="tgl_berakhir" value="{{ $membership->tgl_berakhir->format('Y-m-d') }}"
                                                                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                                                </div>
                                                                <div class="col-span-2">
                                                                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Membership</label>
                                                                    <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:border-blue-500">
                                                                        <option value="1" {{ $membership->status ? 'selected' : '' }}>Aktif</option>
                                                                        <option value="0" {{ !$membership->status ? 'selected' : '' }}>Non-aktif</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <input type="hidden" name="membership_id" value="{{ $membership->id_membership }}">
                                                        @endif

                                                        <div class="flex justify-end space-x-3 mt-6">
                                                            <button type="button" onclick="closeEditModal({{ $member->id_akun }})" 
                                                                    class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition">
                                                                Batal
                                                            </button>
                                                            <button type="submit" 
                                                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                                                Simpan Perubahan
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                            </svg>
                                            <p class="text-gray-500">Tidak ada data member</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Pagination -->
                <div class="mt-6">
                    {{ $members->links() }}
                </div>
            </main>
        </div>
    </div>

    <script>
        function openAddModal() {
            document.getElementById('addModal').classList.remove('hidden');
        }

        function closeAddModal() {
            document.getElementById('addModal').classList.add('hidden');
        }

        function updateTotalBayar() {
            const select = document.getElementById('jenis_paket');
            const selectedOption = select.options[select.selectedIndex];
            const price = selectedOption.getAttribute('data-price');
            
            if (price) {
                document.getElementById('total_bayar').value = price;
                document.getElementById('total_bayar_display').value = 'Rp ' + parseInt(price).toLocaleString('id-ID');
            } else {
                document.getElementById('total_bayar').value = '0';
                document.getElementById('total_bayar_display').value = 'Rp 0';
            }
        }

        function openEditModal(id) {
            document.getElementById('editModal' + id).classList.remove('hidden');
        }

        function closeEditModal(id) {
            document.getElementById('editModal' + id).classList.add('hidden');
        }

        function confirmDelete(id) {
            if (confirm('Apakah Anda yakin ingin menghapus akun member ini? Semua data membership terkait juga akan dihapus.')) {
                document.getElementById('delete-form-' + id).submit();
            }
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            if (event.target.classList.contains('bg-opacity-50')) {
                event.target.classList.add('hidden');
            }
        }
    </script>
</body>
</html>