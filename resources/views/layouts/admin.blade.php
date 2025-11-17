<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Panel - UB Sport Center')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { font-family: 'Poppins', sans-serif; }
    </style>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->

        <aside class="w-64 bg-[#004a73] text-white flex-shrink-0">
            <div class="p-6">
                <span class="flex justify-center mb-3">
                    <img src="{{ asset('images/ubsc-logo.png') }}">
                </span>
                <h1 class="text-2xl text-center font-bold">UB Sport Center</h1>
                <p class="text-sm text-center text-blue-200">Admin Panel</p>
            </div>
            
            <nav class="mt-6">

                <a href="{{ route('admin.dashboard') }}" 
                class="flex items-center px-6 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-[#003d5e] border-l-4 border-white' : 'hover:bg-[#003d5e]' }} transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Dashboard
                </a>
                

                <a href="{{ route('admin.verification.index') }}" 
                class="flex items-center px-6 py-3 {{ request()->routeIs('admin.verification.*') ? 'bg-[#003d5e] border-l-4 border-white' : 'hover:bg-[#003d5e]' }} transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Verifikasi UBSC
                </a>
                

                <a href="{{ route('admin.ubsc_account.index') }}" 
                class="flex items-center px-6 py-3 {{ request()->routeIs('admin.ubsc_account.*') ? 'bg-[#003d5e] border-l-4 border-white' : 'hover:bg-[#003d5e]' }} transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    Akun UBSC
                </a>
                

                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#003d5e] transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Akun Member
                </a>
                

                <a href="#" class="flex items-center px-6 py-3 hover:bg-[#003d5e] transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Verifikasi Pembayaran
                </a>
                
                <!-- FAQ Management -->
                <a href="{{ route('admin.faq.index') }}" 
                   class="flex items-center px-6 py-3 {{ request()->routeIs('admin.faq.*') ? 'bg-[#003d5e] border-l-4 border-white' : 'hover:bg-[#003d5e]' }} transition">

                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    FAQ
                </a>

                <!-- Promosi Management -->
                <a href="{{ route('admin.promosi.index') }}" 
                   class="flex items-center px-6 py-3 {{ request()->routeIs('admin.promosi.*') ? 'bg-[#003d5e] border-l-4 border-white' : 'hover:bg-[#003d5e]' }} transition">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                    </svg>
                    Promosi
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
                    <h2 class="text-2xl font-bold text-gray-800">@yield('page-title', 'Dashboard')</h2>
                    <div class="flex items-center space-x-4">

                        <span class="text-gray-600">Admin: <span class="font-semibold text-[#004a73]">{{ Auth::guard('admin')->user()->nama_lengkap }}</span></span>
                        <div class="w-10 h-10 bg-[#004a73] rounded-full flex items-center justify-center text-white font-bold">
                            {{ strtoupper(substr(Auth::guard('admin')->user()->nama_lengkap, 0, 1)) }}
                        </div>
                    </div>
                </div>
            </header>

            <!-- Success/Error Messages -->
            @if(session('success'))
                <div class="m-8 p-4 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-green-600 font-semibold">✓ {{ session('success') }}</p>
                </div>
            @endif


            @if(session('info'))
                <div class="m-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <p class="text-blue-600 font-semibold">ℹ {{ session('info') }}</p>
                </div>
            @endif

            @if(session('error'))
                <div class="m-8 p-4 bg-red-50 border border-red-200 rounded-lg">
                    <p class="text-red-600 font-semibold">✗ {{ session('error') }}</p>
                </div>
            @endif

            <!-- Page Content -->
            <main class="p-8">
                @yield('content')
            </main>
        </div>
    </div>

    @stack('scripts')
</body>
</html>