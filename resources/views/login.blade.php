<!DOCTYPE html>
<html lang="en">
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
<body>
<body style="background-image: linear-gradient(#00263ab0, #00263ab0), url({{ asset('images/Sport-Center-UB.jpg') }})">
    <div class="min-h-screen flex items-center justify-center p-4">
        <!-- Login Card -->
        <div class="w-full max-w-5xl">
            <div class="flex justify-center">
                <div class="w-full md:w-3/4 bg-gradient-to-br from-[#ccd9e0] to-[#CEDDE6] md:p-12 flex items-center justify-center rounded-3xl shadow-2xl">
                    <div class="w-full max-w-md py-3">
                        <h1 class="text-3xl text-center font-bold text-[#004a73] mb-8 italic">
                            Hello there! Ready to hit it?
                        </h1>

                        {{-- @if(session('success'))
                            <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                                {{ session('success') }}
                            </div>
                        @endif --}}

                        {{-- @if($errors->any())
                            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                                <ul class="list-disc list-inside">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif --}}

                        <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                            @csrf
                            {{-- email --}}
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#004a73]">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
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

                            <!-- Login Button -->
                            <button 
                                type="submit"
                                class="w-full bg-[#004a73] hover:bg-[#005a8a] text-white font-bold py-4 px-6 rounded-full transition duration-300 uppercase tracking-wide">
                                Login
                            </button>

                            <p class="text-center text-gray-600">
                                Don't have an account? 
                                <a href="{{ route('signup') }}" class="text-[#004a73] font-semibold hover:underline">
                                    Sign Up
                                </a>
                            </p>
                        </form>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
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