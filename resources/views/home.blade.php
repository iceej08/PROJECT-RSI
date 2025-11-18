<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UB Sport Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="text-gray-800">

    <header class="fixed top-0 left-0 w-full z-50 flex justify-between items-center px-10 py-4 bg-gray-500 text-white shadow-md">
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
        <a href="{{ route('login') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-5 rounded-lg">
            Login
        </a>
    </header>

    <section id="home" class="relative bg-cover bg-center h-[650px]" style="background-image: url('{{ asset('images/bg.png') }}');">
        <div class="absolute inset-0 bg-black bg-opacity-60 flex flex-col justify-center items-start px-10">
            <h2 class="text-4xl md:text-5xl font-extrabold text-white">UNIVERSITAS BRAWIJAYA</h2>
            <h3 class="text-5xl md:text-6xl font-extrabold text-yellow-400 mt-2">SPORT CENTER</h3>
            <p class="text-gray-200 mt-4 max-w-lg leading-relaxed">
                UB Sport Center menyediakan unit usaha di bawah PT. Brawijaya Multi Usaha (BMU)
                dengan berbagai fasilitas olahraga indoor dan outdoor untuk civitas akademika & umum.
            </p>
        </div>
    </section>

    <!-- SECTION PROMOSI (DINAMIS DARI DATABASE) -->
    <section id="promosi" class="py-16 px-6 md:px-20 bg-white">
        <h2 class="text-center text-2xl font-bold text-gray-800 mb-10 tracking-wide">NEWS</h2>

        @forelse($promosis as $index => $promosi)
        <div class="flex flex-col md:flex-row mb-10 gap-6">
            @if($promosi->Gambar)
            <img src="{{ asset('storage/' . $promosi->Gambar) }}" alt="{{ $promosi->Judul }}" class="w-full md:w-1/3 rounded-xl shadow-lg object-cover">
            @else
            <img src="{{ asset('images/default-promo.png') }}" alt="Default" class="w-full md:w-1/3 rounded-xl shadow-lg">
            @endif
            
            <div class="flex flex-col justify-center md:w-2/3">
                <span class="text-sm text-gray-500 mb-1">
                    {{ $promosi->created_at->diffForHumans() }} • Event News
                </span>
                <h3 class="text-xl font-bold mb-2">{{ $promosi->Judul }}</h3>
                <p class="text-gray-600 leading-relaxed mb-4">
                    {{ Str::limit($promosi->Deskripsi, 150) }}
                    <span class="hidden" id="extra-text-{{ $index }}">
                        {{ Str::substr($promosi->Deskripsi, 150) }}
                    </span>
                </p>
                @if(strlen($promosi->Deskripsi) > 150)
                <button onclick="toggleReadMore({{ $index }})" id="btn-{{ $index }}"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md w-fit">
                    Read More
                </button>
                @endif
            </div>
        </div>
        @empty
        <p class="text-center text-gray-500">Belum ada promosi tersedia.</p>
        @endforelse

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

    <!-- SECTION FAQ (DINAMIS DARI DATABASE) -->
    <section id="faq" class="bg-gray-50 py-16 px-6 md:px-20">
        <h2 class="text-center text-2xl font-bold mb-10 tracking-wide">FAQ</h2>

        <div class="max-w-2xl mx-auto space-y-4">
            @forelse($faqs as $faq)
            <details class="bg-white shadow-md rounded-lg p-4">
                <summary class="font-semibold text-gray-800 cursor-pointer">{{ $faq->Pertanyaan }}</summary>
                <p class="mt-2 text-gray-600">{{ $faq->Jawaban }}</p>
            </details>
            @empty
            <p class="text-center text-gray-500">Belum ada FAQ tersedia.</p>
            @endforelse

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
                <a href="mailto:yourgirl794@gmail.com">
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