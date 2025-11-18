<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UB Sport Center</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#152259] min-h-screen">
@php
    use Illuminate\Support\Facades\Auth;
    $akun = Auth::user();
    $membership = $akun->membership ?? null;
    $is_active = $membership && now()->lte($membership->tgl_berakhir);
@endphp

<header class="bg-[#F4F6FF] shadow-md sticky top-0 z-10">
    <div class="mx-auto flex items-center justify-between px-12 py-2">
        
        <div class="flex items-center space-x-2">
            <img src='{{ asset('images/LogoBMU.svg') }}' alt="UB Sport Center Logo" class="h-10 sm:h-14 w-10 sm:w-16">
            <img src='{{ asset('images/LogoUBSC.svg') }}' alt="UB Sport Center Logo" class="h-10 sm:h-14 w-10 sm:w-16">
        </div>
        
        <nav class="hidden md:flex space-x-6 lg:space-x-8">
            <a href="#" class="text-gray-700 hover:text-gray-900 font-medium hover:font-bold transition-colors duration-200">Home</a>
            <a href="#promosi" class="text-gray-700 hover:text-gray-900 font-medium hover:font-bold transition-colors duration-200">Promosi</a>
            <a href="#faq" class="text-gray-700 hover:text-gray-900 font-medium hover:font-bold transition-colors duration-200">FAQ</a>
            <a href="#pusat-bantuan" class="text-gray-700 hover:text-gray-900 font-medium hover:font-bold transition-colors duration-200">Pusat Bantuan</a>
        </nav>
</a>
<a href="{{ route('login') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-2 px-5 rounded-lg">
            Login
        </a>
            </form>
        </div>
    </div>
</header>

    <section id="home" class="relative bg-cover bg-center h-[650px]" style="background-image: url('{{ asset('images/bg.png') }}');">
        <div class="absolute inset-0 flex flex-col justify-center items-start px-16">
            <h2 class="text-6xl md:text-6xl font-extrabold 
        bg-gradient-to-t from-yellow-200 to-white
        text-transparent bg-clip-text">UNIVERSITAS BRAWIJAYA</h2>
            <h3 class="text-6xl md:text-8xl font-extrabold
        bg-gradient-to-t from-yellow-300 to-yellow-200
        text-transparent bg-clip-text">SPORT CENTER</h3>
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
                a href="https://instagram.com/ubsportcenter" target="_blank">
                    <img src="https://cdn-icons-png.flaticon.com/512/733/733558.png" 
                         alt="Instagram" class="h-6 hover:scale-110 transition">
                </a>
                <a href="https://twitter.com/ubsportcenter" target="_blank">
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

    <footer class="bg-[#F4F6FF] text-[#152259] py-10 px-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-20">

        <!-- KOLOM 1 — LOGO -->
        <div>
            <div class="flex items-start">
    <a href="#" class="flex">
        <img src="{{ asset('images/LogoBMU.svg') }}" class="h-32">
        <img src="{{ asset('images/LogoUBSC.svg') }}" class="h-32">
    </a>
</div>
    <p class="text-sm px-8 mt-4 ml-6">© 2025 UB Sport Center. All rights reserved.</p>
        </div>

        <!-- KOLOM 2 — NAVBAR (MENURUN) -->
        <div class="flex flex-col space-y-2 text-sm">
            <h4 class="font-bold text-lg mt-4 mb-2">Navigasi</h4>
            <a href="/welcome#home" class="hover:underline">Home</a>
            <a href="/welcome#promosi" class="hover:underline">Promosi</a>
            <a href="/welcome#faq" class="hover:underline">FAQ</a>
            <a href="/welcome#pusat-bantuan" class="hover:underline">Pusat Bantuan</a>
        </div>

    </div>
</footer>

</body>
</html>