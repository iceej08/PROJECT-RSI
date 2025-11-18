<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Pembayaran</title>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen" x-data="{ showModal: false, imageUrl: '' }">
        <!-- Sidebar (Ini sudah benar) -->
        <aside class="w-64 bg-[#152259] text-white">
            <div class="p-6">
                <h1 class="text-2xl font-bold">UB Sport Center</h1>
                <p class="text-sm text-blue-200">Admin Panel</p>
            </div>
            
            <nav class="mt-6">
                <a href="{{ route('admin.dashboard') }}" 
                   class="flex items-center px-6 py-3 transition 
                          {{ request()->routeIs('admin.dashboard') ? 'bg-[#509CDB] border-l-4 border-white' : 'hover:bg-[#509CDB]' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    Dashboard
                </a>
                
                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#509CDB] transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    Verifikasi Users
                </a>

                <a href="{{ route('admin.verifikasi-pembayaran') }}" 
                   class="flex items-center px-6 py-3 transition 
                          {{ request()->routeIs('admin.verifikasi-pembayaran') ? 'bg-[#509CDB] border-l-4 border-white' : 'hover:bg-[#509CDB]' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    Verifikasi Pembayaran
                </a>
                
                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#509CDB] transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    Manage Users
                </a>
                
                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#509CDB] transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                    Membership
                </a>
                
                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#509CDB] transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    FAQ
                </a>
            </nav>
            
            <div class="absolute bottom-0 w-64 p-6">
                <form action="{{ route('admin.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="flex items-center text-white hover:text-red-300 transition w-full">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        Logout
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 overflow-y-auto">
            <header class="bg-white shadow-md">
                <div class="flex items-center justify-between px-8 py-4">
                    <h2 class="text-2xl font-bold text-gray-800">Verifikasi Pembayaran</h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-gray-600">Admin: <span class="font-semibold text-[#004a73]">{{ Auth::guard('admin')->user()->nama_lengkap }}</span></span>
                        <div class="w-10 h-10 bg-[#004a73] rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->nama_lengkap, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            @if(session('success'))
                <div class="m-8 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-600 font-semibold">{{ session('success') }}</p>
                </div>
            @endif

            <main class="p-8">
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h3 class="text-xl font-bold text-gray-800 mb-4">Daftar Transaksi Pembayaran</h3>
                    
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                                <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                                    <table class="min-w-full divide-y divide-gray-200">
                                        
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <!-- 
                                                  --- INI PERBAIKANNYA ---
                                                  Mengganti "ID Transaksi" menjadi "ID Pembayaran"
                                                -->
                                                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                                    ID Pembayaran
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                                    Nama
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                                    Total
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                                    Metode
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                                    Status
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                                    Bukti Pembayaran
                                                </th>
                                                <th scope="col" class="px-6 py-3 text-left text-sm font-semibold text-gray-700">
                                                    Action
                                                </th>
                                            </tr>
                                        </thead>

                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @forelse ($daftarPembayaran as $item)
                                            <tr>
                                                <!-- Datanya sudah benar, yaitu id_pembayaran -->
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $item->id_pembayaran }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800">{{ $item->membership->akunUbsc->nama_lengkap ?? 'User Dihapus' }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                    Rp {{ number_format($item->total_pembayaran, 0, ',', '.') }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                                    {{ ucfirst($item->metode) }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    @if($item->status_pembayaran == 'pending')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                    @elseif($item->status_pembayaran == 'verified')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Berhasil</span>
                                                    @elseif($item->status_pembayaran == 'rejected')
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Gagal</span>
                                                    @endif
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                    <button 
                                                        type="button" 
                                                        class="text-blue-600 hover:text-blue-800 hover:underline text-sm font-medium"
                                                        @click="showModal = true; imageUrl = '{{ asset('storage/' . $item->bukti_pembayaran) }}'">
                                                        Lihat Bukti
                                                    </button>
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                                    @if($item->status_pembayaran == 'pending')
                                                        <form action="{{ route('admin.proses-verifikasi', $item->id_pembayaran) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="verified">
                                                            <button type="submit" class="px-3 py-1 bg-green-600 text-white text-xs font-medium rounded-md hover:bg-green-700">Accept</button>
                                                        </form>
                                                        
                                                        <form action="{{ route('admin.proses-verifikasi', $item->id_pembayaran) }}" method="POST" class="inline">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="hidden" name="status" value="rejected">
                                                            <button type="submit" class="px-3 py-1 bg-red-600 text-white text-xs font-medium rounded-md hover:bg-red-700">Reject</button>
                                                        </form>
                                                    @else
                                                        <span>-</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">Tidak ada data transaksi.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </main>
        </div>

        <!-- Modal (Ini sudah benar) -->
        <div x-cloak x-show="showModal" class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="showModal" 
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" 
                     @click="showModal = false" 
                     aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div x-show="showModal"
                     x-transition:enter="ease-out duration-300"
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave="ease-in duration-200"
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                    Bukti Pembayaran
                                </h3>
                                <div class="mt-2">
                                    <img :src="imageUrl" alt="Bukti Pembayaran" class="w-full h-auto object-contain">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="button" 
                                class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 sm:ml-3 sm:w-auto sm:text-sm"
                                @click="showModal = false">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>
</html>