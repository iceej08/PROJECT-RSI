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
<body class="" style="background-color: #002E48">
    <div class="min-h-screen flex items-center justify-center p-4">
        <!-- Login Card -->
        <div class="w-full max-w-6xl bg-gradient-to-br from-[#004a73] to-[#003d5e] rounded-3xl shadow-2xl overflow-hidden">
            <div class="flex flex-col lg:flex-row">
                <!-- Left Side - Login Form -->
                <div class="w-full lg:w-3/4 bg-gradient-to-br from-blue-50 to-blue-100 p-8 lg:p-12 flex items-center justify-center">
                    <div class="w-full max-w-md">
                        <h1 class="text-3xl lg:text-3xl font-bold text-[#004a73] mb-8 italic">
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
                            
                            <!-- Email Input -->
                            <div>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#004a73]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
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
                            </div>

                            <!-- Password Input -->
                            <div>
                                <div class="relative">
                                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-[#004a73]">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </span>
                                    <input 
                                        type="password" 
                                        name="password" 
                                        id="password"
                                        placeholder="Password"
                                        required
                                        class="w-full pl-12 pr-12 py-4 bg-white rounded-full border-0 focus:ring-2 focus:ring-[#004a73] outline-none text-gray-700 placeholder-gray-400"
                                    >
                                    <button 
                                        type="button" 
                                        onclick="togglePassword()"
                                        class="absolute right-4 top-1/2 -translate-y-1/2 text-[#004a73] hover:text-[#003d5e]"
                                    >
                                        <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Login Button -->
                            <button 
                                type="submit"
                                class="w-full bg-[#004a73] hover:bg-[#00507C] text-white font-bold py-4 px-6 rounded-full transition duration-300 uppercase tracking-wide">
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

                <!-- Right Side - Image -->
                <div class="hidden lg:block lg:w-1/2 relative">
                    <div class="absolute inset-0 bg-cover bg-center" 
                         style="background-image: url({{ asset('images/Sport-Center-UB.jpg') }})" >
                        <div class="absolute inset-0 bg-gradient-to-l from-transparent to-[#004a73]/30"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>