<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sign Up UBSC - Unggah Foto</title>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-200 min-h-screen flex items-center justify-center p-4">
    @include('alert')
    <div class="w-full max-w-lg">
        <!-- Card Container -->
        <div class="bg-white/90 backdrop-blur-sm rounded-3xl shadow-2xl p-8 text-center">
            <!-- Success Icon with Animation -->
            <div class="mb-6">
                <div class="w-24 h-24 bg-yellow-100 rounded-full mx-auto flex items-center justify-center pulse-slow">
                    <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>

            <!-- Title -->
            <h1 class="text-3xl font-bold text-[#004a73] mb-4">
                Verifikasi Sedang Diproses
            </h1>

            <!-- Message -->
            <p class="text-gray-600 mb-6 leading-relaxed">
                Terima kasih telah mendaftar sebagai <span class="font-semibold text-[#004a73]">Warga UB</span>! 
                Foto identitas Anda sedang dalam proses verifikasi oleh admin kami.
            </p>

            <!-- Info Box -->
            <div class="bg-blue-50 border-2 border-blue-200 rounded-2xl p-6 mb-6 text-left">
                <h3 class="font-semibold text-[#004a73] mb-3 flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Informasi Penting
                </h3>
                <ul class="text-sm text-gray-700 space-y-2">
                    <li class="flex items-start">
                        <span class="text-blue-500 mr-2">•</span>
                        <span>Proses verifikasi dilakukan maksimal dalam waktu <strong>1x24 Jam</strong></span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-blue-500 mr-2">•</span>
                        <span>Anda akan menerima <strong>email notifikasi</strong> setelah akun terverifikasi</span>
                    </li>
                    <li class="flex items-start">
                        <span class="text-blue-500 mr-2">•</span>
                        <span>Setelah verifikasi disetujui, Anda dapat <strong>login</strong> untuk mengakses layanan</span>
                    </li>
                </ul>
            </div>

            <!-- Email Info -->
            @if($email)
            <div class="mb-6 p-4 bg-gray-50 rounded-xl">
                <p class="text-sm text-gray-600 mb-1">Akun Terdaftar:</p>
                <p class="font-semibold text-[#004a73]">{{ $email }}</p>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="space-y-3">
                <!-- Back to Login -->
                <a 
                    href="{{ route('login') }}"
                    class="block w-full bg-[#004a73] text-white font-bold py-4 px-6 rounded-full hover:bg-[#003d5e] transition duration-300 uppercase tracking-wide shadow-lg hover:shadow-xl"
                >
                    Kembali ke Login
                </a>

                <!-- Contact Support -->
                <p class="text-sm text-gray-600">
                    Ada pertanyaan? 
                    <a href="mailto:support@ubsportcenter.com" class="text-[#004a73] font-semibold hover:underline">
                        Hubungi Support
                    </a>
                </p>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                💡 <strong>Tips:</strong> Pastikan email Anda aktif untuk menerima notifikasi verifikasi, atau coba login secara berkala
            </p>
        </div>
    </div>
</body>
</html>