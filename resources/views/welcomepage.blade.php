<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UB Sport Center</title>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body class="text-gray-800">

        <header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-10 py-4 bg-white text-black shadow-md">
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/logo.png') }}" alt="UB Logo" class="h-10">
            <h1 class="text-xl font-semibold text-blue-700">UB SPORT CENTER</h1>
        </div>
        <nav class="flex space-x-8 text-sm font-medium">
        <a href="#home" class="hover:text-yellow-400">Home</a>
        <a href="#promosi" class="hover:text-yellow-400">Promosi</a>
        <a href="#faq" class="hover:text-yellow-400">FAQ</a>
        <a href="#pusat-bantuan" class="hover:text-yellow-400">Pusat Bantuan</a>
    </nav>
    </header>

    <section id="home" class="relative bg-cover bg-center h-screen" style="background-image: url('{{ asset('images/welcome.png') }}'); background-position:top;">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-center items-start px-10">
            <h2 class="text-6xl md:text-7xl font-extrabold text-white">WELCOME</h2>
            <h3 class="text-5xl md:text-6xl font-extrabold text-yellow-400 mt-2">{{ Auth::guard('web')->user()->nama_lengkap }}</h3>
            <p class="text-gray-200 mt-4 max-w-lg leading-relaxed">
                Let's burn our colories with Gym & Fitness membership
            </p>
            <a href="{{ route('pelanggan.pilih-paket') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold mt-2 py-2 px-5 rounded-lg">
            GET SPECIAL PRICE WITH MEMBERSHIP
        </a>
        </div>

    </section>

   <section id="promosi" class="py-16 px-6 md:px-20 bg-white">
    <h2 class="text-center text-2xl font-bold text-gray-800 mb-10 tracking-wide">NEWS</h2>

    <div class="flex flex-col md:flex-row mb-10 gap-6">
        <img src="{{ asset('images/foto 1.png') }}" alt="News 1" class="w-full md:w-1/3 rounded-xl shadow-lg">
        <div class="flex flex-col justify-center md:w-2/3">
            <span class="text-sm text-gray-500 mb-1">2 days ago • Event News</span>
            <h3 class="text-xl font-bold mb-2">Bela Diri</h3>
            <p class="text-gray-600 leading-relaxed mb-4">
                Bela diri adalah seni mempertahankan diri dan melindungi diri dari ancaman menggunakan kekuatan fisik, 
                yang bertujuan untuk menjaga keselamatan dan kesehatan diri, serta melatih kedisiplinan dan mental.  
                <span class="hidden" id="extra-text-1">
                    Berbagai jenis bela diri seperti pencak silat, karate, dan taekwondo tersebar di seluruh dunia, 
                    masing-masing dengan teknik dan ciri khasnya sendiri.
                </span>
            </p>
            <button onclick="toggleReadMore(1)" id="btn-1"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md w-fit">
                Read More
            </button>
        </div>
    </div>

    <div class="flex flex-col md:flex-row mb-10 gap-6">
        <img src="{{ asset('images/foto 2.png') }}" alt="News 2" class="w-full md:w-1/3 rounded-xl shadow-lg">
        <div class="flex flex-col justify-center md:w-2/3">
            <span class="text-sm text-gray-500 mb-1">1 day ago • Event News</span>
            <h3 class="text-xl font-bold mb-2">Lapangan Olahraga</h3>
            <p class="text-gray-600 leading-relaxed mb-4">
                Olahraga lapangan adalah aktivitas fisik yang dimainkan di area terbuka, seperti sepak bola, bola basket, dan voli. 
                <span class="hidden" id="extra-text-2">
                     Ciri utamanya adalah memerlukan lapangan dengan ukuran dan aturan spesifik untuk setiap cabang olahraga, 
                     yang bisa berbentuk lapangan besar untuk tim besar atau lapangan kecil untuk permainan individu atau tim kecil. 
                </span>
            </p>
            <button onclick="toggleReadMore(2)" id="btn-2"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md w-fit">
                Read More
            </button>
        </div>
    </div>

    <div class="text-center mt-6">
        <a href="#" class="text-orange-500 hover:underline font-semibold">SEE ALL NEWS</a>
    </div>
</section>

<script>
    function toggleReadMore(id) {
        const extraText = document.getElementById(`extra-text-${id}`);
        const btn = document.getElementById(`btn-${id}`);

        if (extraText.classList.contains('hidden')) {
            extraText.classList.remove('hidden');
            btn.textContent = 'Read Less';
        } else {
            extraText.classList.add('hidden');
            btn.textContent = 'Read More';
        }
    }
</script>


    <section id="faq" class="bg-gray-50 py-16 px-6 md:px-20">

        <h2 class="text-center text-2xl font-bold mb-10 tracking-wide">FAQ</h2>

        <div class="max-w-2xl mx-auto space-y-4">
            <details class="bg-white shadow-md rounded-lg p-4">
                <summary class="font-semibold text-gray-800 cursor-pointer">Bagaimana metode untuk pembayaran</summary>
                <p class="mt-2 text-gray-600">Kita menerima metode transfer melalui QRIS yang dapat discan dengan mudah.</p>
            </details>

            <details class="bg-white shadow-md rounded-lg p-4">
                <summary class="font-semibold text-gray-800 cursor-pointer">Apakah saya bisa melihat pilihan paket untuk membership?</summary>
                <p class="mt-2 text-gray-600">Tentu saja bisa, pelanggan dapat melihat pilihan paket membership pada saat mendaftarkan member.</p>
            </details>

            <details class="bg-white shadow-md rounded-lg p-4">
                <summary class="font-semibold text-gray-800 cursor-pointer">Berapa lama akun member saya berlaku?</summary>
                <p class="mt-2 text-gray-600">Akun member akan aktif selama 2 bulan setelah masa membership berakhir.</p>
            </details>

            <div class="text-center mt-6">
                <a href="#" class="text-orange-500 hover:underline font-semibold">SEE ALL FAQ</a>
            </div>
        </div>
    </section>

    <section id="pusat-bantuan" class="bg-white py-12 px-6 md:px-20">
        <div class="max-w-2xl mx-auto text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-6 tracking-wide">PUSAT BANTUAN</h2>
            <p class="text-gray-600 mb-8">
                Ada pertanyaan lebih lanjut? Hubungi kami langsung melalui WhatsApp admin atau media sosial kami di bawah ini.
            </p>

            <a href="https://wa.me/6285230559478"
               target="_blank"
               class="inline-block bg-green-500 hover:bg-green-600 text-white font-semibold py-4 px-10 rounded-xl shadow-lg transition transform hover:-translate-y-1 duration-200">
                💬 Hubungi Pusat Bantuan
            </a>

            <div class="flex justify-center space-x-6 mt-10">
                <a href="https://instagram.com/chocolateflaws" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" 
                         alt="Instagram" class="h-6 hover:scale-110 transition">
                </a>
                <a href="https://twitter.com/filkomUB" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733579.png" 
                         alt="Twitter" class="h-6 hover:scale-110 transition">
                </a>
                <a href="yourgirl794@gmail.com">
                    <img src="https://cdn-icons-png.flaticon.com/512/732/732200.png" 
                         alt="Email" class="h-6 hover:scale-110 transition">
                </a>
            </div>
        </div>
    </section>
    <footer class="bg-blue-900 text-white py-10 px-6 md:px-20">
        <div class="flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h3 class="text-2xl font-bold">UB SPORT CENTER</h3>
                <p class="text-sm text-gray-300 mt-2">© 2025 UB Sport Center. All rights reserved.</p>
            </div>
            <div class="flex space-x-6 text-sm">
                <a href="#home" class="hover:underline">Home</a>
                <a href="#promosi" class="hover:underline">Promosi</a>
                <a href="#faq" class="hover:underline">FAQ</a>
                <a href="#pusat-bantuan" class="hover:underline">Pusat Bantuan</a>
            </div>
            <div class="flex space-x-3">
                <a href="#"><img src="{{ asset('images/logo.png') }}" class="h-10"></a>
            </div>
        </div>
    </footer>

</body>
</html>
