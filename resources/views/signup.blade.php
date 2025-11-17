<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
=======
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login UBSC</title>
    <link href="https://fonts.googleapis.com/css2?family=Alkatra:wght@400..700&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</head>
<body style="background-image: linear-gradient(#00263ab0, #00263ab0), url({{ asset('images/Sport-Center-UB.jpg') }})">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-4xl">
            <div class="flex justify-center">
                <div class="w-full md:w-3/4 bg-gradient-to-br from-[#ccd9e0] to-[#CEDDE6] md:p-12 flex items-center justify-center rounded-3xl shadow-2xl">
                    <div class="w-full max-w-lg">
                        <h1 class="text-4xl text-center font-bold text-[#004a73] mb-8 italic">
                            Let's Burn Together!
                        </h1>
                        @if($errors->any())
                            <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl">
                                <ul class="text-red-600 text-sm space-y-1">
                                    @foreach($errors->all() as $error)
                                        {{ $error }} <br>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('signup.post') }}" method="POST" class="mb-0">
                            @csrf
                            {{-- nama --}}
                            <div class="relative mb-5">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-[#004a73]">
                                    <img src="{{ asset('images/user.svg') }}" class="ml-1">
                                </span>
                                <input 
                                    type="text" 
                                    name="nama_lengkap" 
                                    value="{{ old('nama_lengkap') }}"
                                    placeholder="Nama Lengkap"
                                    required
                                    class="w-full pl-12 pr-4 py-4 bg-white rounded-full border-2 border-gray-200 focus:border-[#004a73] focus:outline-none transition-colors @error('nama_lengkap') border-red-500 @enderror"
                                >
                            </div>

                            {{-- email --}}
                            <div class="relative mb-5">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#004a73]">
                                    <img src="{{ asset('images/mail.svg') }}" class="ml-1">
                                </span>
                                <input 
                                    type="email" 
                                    name="email" 
                                    id="email"
                                    placeholder="Email"
                                    value="{{ old('email') }}"
                                    required
                                    class="w-full pl-12 pr-4 py-4 bg-white rounded-full border-0 focus:ring-2 focus:ring-[#004a73] outline-none text-gray-700 placeholder-gray-400"
                                >
                            </div>

                            {{-- password --}}
                            <div class="relative mb-5">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#004a73]">
                                    <img src="{{ asset('images/lock.svg') }}" class="ml-1">
                                </span>
                                <input 
                                    type="password" 
                                    name="password" 
                                    id="password"
                                    placeholder="Password"
                                    required
                                    class="w-full pl-12 pr-12 py-4 bg-white rounded-full border-0 focus:ring-2 focus:ring-[#004a73] outline-none text-gray-700 placeholder-gray-400">
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password', 'eyeIcon1')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[#004a73] hover:text-[#003d5e]">
                                    <span id="eyeIcon1">
                                        <img src="{{ asset('images/eye-off.svg') }}" class="mr-1">
                                    </span>
                                </button>
                            </div>

                            {{-- konfirmasi passowrd --}}
                            <div class="relative mb-5">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#004a73]">
                                    <img src="{{ asset('images/lock.svg') }}" class="ml-1">
                                </span>
                                <input 
                                    type="password" 
                                    name="password_confirmation" 
                                    id="password_confirmation"
                                    placeholder="Konfirmasi Password"
                                    required
                                    class="w-full pl-12 pr-12 py-4 bg-white rounded-full border-2 border-gray-200 focus:border-[#004a73] focus:outline-none transition-colors"
                                >
                                <button 
                                    type="button" 
                                    onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[#004a73] hover:text-[#003d5e]">
                                    <span id="eyeIcon2">
                                        <img src="{{ asset('images/eye-off.svg') }}" class="mr-1">
                                    </span>
                                </button>
                            </div>

                            {{-- terms n condition --}}
                            <div class="flex items-center justify-center space-x-2 mb-3">
                                <input 
                                    type="checkbox" 
                                    name="terms" 
                                    id="terms"
                                    required
                                    class="w-4 h-4 text-[#004a73] bg-white border-gray-300 rounded focus:ring-[#004a73] focus:ring-2">
                                <label for="terms" class="text-sm text-gray-700">
                                    Saya telah membaca dan menyetujui
                                    <a href="#" class="text-[#004a73] font-semibold hover:underline">Syarat & Ketentuan</a>
                                </label>
                            </div>

                            <div class="space-y-2">
                                <div class="flex gap-3">
                                    <button 
                                        type="button"
                                        value="umum"
                                        onclick="pilihKategori('umum')"
                                        id="btn-umum"
                                        class="flex-1 bg-white text-[#004a73] font-bold py-4 px-6 rounded-full border-2 border-[#004a73] hover:bg-gray-100 transition duration-300 uppercase tracking-wide">
                                        Warga Umum
                                    </button>

                                    <button 
                                        type="button"
                                        value="warga_ub"
                                        onclick="pilihKategori('warga_ub')"
                                        id="btn-warga_ub"
                                        class="flex-1 bg-white text-[#004a73] font-bold py-4 px-6 rounded-full border-2 border-[#004a73] hover:bg-gray-100 transition duration-300 uppercase tracking-wide">
                                        Warga UB
                                    </button>
                                </div>
                                <input type="hidden" name="kategori" id="kategori" value="" required>
                                @error('kategori')
                                    <p class="text-red-500 text-sm text-center mt-2">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="pt-4">
                                <button 
                                    type="submit"
                                    class="w-full bg-[#004a73] text-white font-bold py-4 px-6 rounded-full hover:bg-[#003d5e] transition duration-300 uppercase tracking-wide shadow-lg hover:shadow-xl">
                                    Sign Up
                                </button>
                            </div>
                            
                            <p class="text-center text-gray-600 mt-4 mb-0">
                                Sudah punya akun? 
                                <a href="{{ route('login') }}" class="text-[#004a73] font-semibold hover:underline">
                                    Log In
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
        let pilihanKategori = '';

        function pilihKategori(category) {
            pilihanKategori = category;
            document.getElementById('kategori').value = category;
            
            // Reset all buttons to default style
            document.getElementById('btn-umum').className = 'flex-1 bg-white text-[#004a73] font-bold py-4 px-6 rounded-full border-2 border-[#004a73] hover:bg-gray-50 transition duration-300 uppercase tracking-wide';
            document.getElementById('btn-warga_ub').className = 'flex-1 bg-white text-[#004a73] font-bold py-4 px-6 rounded-full border-2 border-[#004a73] hover:bg-gray-50 transition duration-300 uppercase tracking-wide';
            
            // Highlight selected button
            if (category === 'umum') {
                document.getElementById('btn-umum').className = 'flex-1 bg-[#004a73] text-white font-bold py-4 px-6 rounded-full border-2 border-[#004a73] transition duration-300 uppercase tracking-wide shadow-lg';
            } else if (category === 'warga_ub') {
                document.getElementById('btn-warga_ub').className = 'flex-1 bg-[#004a73] text-white font-bold py-4 px-6 rounded-full border-2 border-[#004a73] transition duration-300 uppercase tracking-wide shadow-lg';
            }
        }
</script>
<script>
        function togglePassword(inputId, iconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = '<img src="{{ asset('images/eye-on.svg') }}" class="mr-1">';
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = '<img src="{{ asset('images/eye-off.svg') }}" class="mr-1">';
            }
        }
</script>
</body>
</html>