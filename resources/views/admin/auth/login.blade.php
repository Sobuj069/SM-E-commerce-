<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#151521]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Admin Login - SM Shop Metronic Hub</title>

    <!-- Inter & Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-[#151521] text-gray-200 font-sans antialiased flex items-center justify-center p-4 selection:bg-indigo-600 selection:text-white" x-data="{ showPassword: false }">

    <!-- Background Atmospheric Glows -->
    <div class="fixed inset-0 pointer-events-none overflow-hidden">
        <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-600/15 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-violet-600/15 rounded-full blur-3xl"></div>
    </div>

    <!-- Metronic Login Container -->
    <div class="relative z-10 w-full max-w-md">
        
        <!-- Logo & Branding Header -->
        <div class="text-center mb-8 space-y-3">
            <a href="{{ route('home') }}" class="inline-block hover:scale-105 transition-transform duration-300">
                <img src="{{ asset('images/logo.png') }}" alt="SM Shop" class="h-12 w-auto mx-auto object-contain drop-shadow-md">
            </a>
            <div>
                <span class="inline-flex items-center gap-1.5 px-3 py-1 bg-indigo-500/10 border border-indigo-500/20 rounded-full text-[11px] font-bold text-indigo-400 uppercase tracking-widest">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Metronic Demo 1 Core
                </span>
            </div>
        </div>

        <!-- Login Card -->
        <div class="bg-[#1e1e2d] border border-[#2b2b40] rounded-2xl p-8 shadow-2xl space-y-6 backdrop-blur-md">
            
            <div class="text-left space-y-1 border-b border-[#2b2b40] pb-5">
                <h1 class="text-xl font-black text-white tracking-tight">Executive Sign In</h1>
                <p class="text-xs text-gray-400">Enter your administrative credentials to manage store operations.</p>
            </div>

            <!-- Flash Error Message -->
            @if($errors->any())
                <div class="p-3.5 rounded-xl bg-rose-950/60 border border-rose-500/30 text-rose-300 text-xs font-semibold flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-sm shrink-0 mt-0.5"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="p-3.5 rounded-xl bg-emerald-950/60 border border-emerald-500/30 text-emerald-300 text-xs font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Form -->
            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold text-gray-300 uppercase tracking-wider">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <i class="fa-regular fa-envelope text-xs"></i>
                        </span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email', 'admin@smcloudit.top') }}" 
                            required 
                            autocomplete="email"
                            placeholder="admin@smcloudit.top" 
                            class="w-full pl-10 pr-4 py-3 bg-[#151521] border border-[#2b2b40] rounded-xl text-xs font-semibold text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition"
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-xs font-bold text-gray-300 uppercase tracking-wider">Password</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            id="password" 
                            name="password" 
                            value="password123"
                            required 
                            placeholder="••••••••" 
                            class="w-full pl-10 pr-10 py-3 bg-[#151521] border border-[#2b2b40] rounded-xl text-xs font-semibold text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-1 focus:ring-indigo-500 transition"
                        >
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword"
                            class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-gray-400 hover:text-white cursor-pointer"
                        >
                            <i :class="showPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye'" class="text-xs"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember & Demo Credentials Button -->
                <div class="flex items-center justify-between pt-1">
                    <label class="flex items-center gap-2 cursor-pointer text-xs text-gray-400 hover:text-gray-300">
                        <input type="checkbox" name="remember" value="1" checked class="rounded border-[#2b2b40] bg-[#151521] text-indigo-600 focus:ring-0">
                        <span>Remember session</span>
                    </label>

                    <button 
                        type="button" 
                        onclick="document.getElementById('email').value='admin@smcloudit.top'; document.getElementById('password').value='password123';"
                        class="text-[11px] font-bold text-indigo-400 hover:text-indigo-300 transition underline underline-offset-2 cursor-pointer"
                    >
                        Auto-fill Demo Credentials
                    </button>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full py-3.5 px-4 rounded-xl bg-indigo-600 hover:bg-indigo-700 active:scale-[0.99] text-white text-xs font-black uppercase tracking-wider transition shadow-lg shadow-indigo-600/30 flex items-center justify-center gap-2 cursor-pointer"
                >
                    <span>Sign In to Dashboard</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

            <!-- Quick Storefront Link -->
            <div class="pt-4 border-t border-[#2b2b40] text-center">
                <a href="{{ route('home') }}" class="text-xs text-gray-400 hover:text-white transition flex items-center justify-center gap-1.5 font-medium">
                    <i class="fa-solid fa-arrow-left text-[10px]"></i>
                    <span>Back to SM Shop Storefront</span>
                </a>
            </div>

        </div>

        <!-- Footer Note -->
        <p class="text-center text-[11px] text-gray-500 mt-6">
            &copy; {{ date('Y') }} SM Shop &bull; Metronic Tailwind Demo 1 Architecture
        </p>

    </div>

</body>
</html>