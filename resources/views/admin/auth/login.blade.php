<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#f4f6f9]" data-kt-theme="true" data-kt-theme-mode="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Sign In - SM Shop Admin</title>

    <!-- Google Fonts: Plus Jakarta Sans / Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- FontAwesome 6 (CSS + SVG Vector Engine) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>

    <!-- Metronic Official Styles -->
    <link href="https://keenthemes.com/metronic/tailwind/dist/assets/css/styles.css" rel="stylesheet"/>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }
        
        body, h1, h2, h3, h4, h5, h6, p, a, input, select, textarea, button, label, span:not(.fa-solid):not(.fa-regular):not(.fa-brands):not(.svg-inline--fa) {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        }

        i.fa-solid, i.fa-regular, i.fa-brands, .svg-inline--fa {
            font-family: inherit;
            display: inline-block;
        }
    </style>
</head>
<body class="h-full bg-[#f4f6f9] text-gray-800 antialiased flex flex-col justify-between p-4 sm:p-6 selection:bg-[#1b84ff] selection:text-white" x-data="{ showPassword: false }">

    <!-- Top Header -->
    <header class="w-full max-w-6xl mx-auto flex items-center justify-between py-2">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <img src="{{ asset('images/logo.png') }}" alt="SM Shop" class="h-8 w-auto object-contain">
            <span class="text-sm font-black text-gray-900 uppercase tracking-tight">SM SHOP ADMIN</span>
        </a>

        <a href="{{ route('home') }}" class="text-xs font-bold text-gray-600 hover:text-primary transition flex items-center gap-1.5">
            <span>Live Storefront</span>
            <i class="fa-solid fa-arrow-up-right-from-square text-[11px]"></i>
        </a>
    </header>

    <!-- Main Auth Card Container -->
    <div class="w-full max-w-md mx-auto my-auto py-6">
        
        <!-- Clean Modern Card -->
        <div class="bg-white border border-gray-200/90 rounded-2xl p-8 sm:p-10 shadow-xl shadow-gray-200/60 space-y-6">
            
            <!-- Header -->
            <div class="text-center space-y-1 pb-2">
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Sign In</h1>
                <p class="text-xs text-gray-500 font-medium">Welcome back to SM Shop Control Center</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
                <div class="p-3.5 rounded-xl bg-rose-50 border border-rose-200 text-rose-800 text-xs font-semibold flex items-start gap-2.5">
                    <i class="fa-solid fa-circle-exclamation text-base text-rose-600 shrink-0 mt-0.5"></i>
                    <div>
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            @endif

            @if(session('success'))
                <div class="p-3.5 rounded-xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-xs font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-base text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            <!-- Sign In Form -->
            <form action="{{ route('admin.login.post') }}" method="POST" class="space-y-4">
                @csrf

                <!-- Email Input -->
                <div class="space-y-1.5">
                    <label for="email" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Email Address</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <i class="fa-solid fa-envelope text-xs"></i>
                        </span>
                        <input 
                            type="email" 
                            id="email" 
                            name="email" 
                            value="{{ old('email') }}" 
                            required 
                            autocomplete="email"
                            placeholder="name@domain.com" 
                            class="w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20 transition"
                        >
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between">
                        <label for="password" class="block text-xs font-bold text-gray-700 uppercase tracking-wider">Password</label>
                    </div>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3.5 pointer-events-none text-gray-400">
                            <i class="fa-solid fa-lock text-xs"></i>
                        </span>
                        <input 
                            :type="showPassword ? 'text' : 'password'" 
                            id="password" 
                            name="password" 
                            required 
                            autocomplete="current-password"
                            placeholder="••••••••••••" 
                            class="w-full pl-9 pr-10 py-2.5 bg-gray-50 border border-gray-200 rounded-lg text-xs font-semibold text-gray-900 placeholder-gray-400 focus:outline-none focus:border-primary focus:bg-white focus:ring-2 focus:ring-primary/20 transition"
                        >
                        <button 
                            type="button" 
                            @click="showPassword = !showPassword" 
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 hover:text-gray-600 transition cursor-pointer"
                        >
                            <i class="fa-solid" :class="showPassword ? 'fa-eye-slash' : 'fa-eye'"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-xs pt-1">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-600">
                        <input type="checkbox" name="remember" checked class="rounded border-gray-300 text-[#1b84ff] focus:ring-0">
                        <span>Remember session</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button 
                    type="submit" 
                    class="w-full mt-2 py-3 px-4 bg-[#1b84ff] hover:bg-[#006ae6] text-white font-bold rounded-lg text-xs tracking-wide shadow-md shadow-blue-500/20 flex items-center justify-center gap-2 transition-all cursor-pointer"
                >
                    <span>Sign In to Dashboard</span>
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </form>

        </div>

    </div>

    <!-- Footer -->
    <footer class="w-full max-w-6xl mx-auto py-3 text-center text-xs text-gray-500 flex flex-col sm:flex-row items-center justify-between gap-2 border-t border-gray-200">
        <div>
            {{ date('Y') }} &copy; <a href="{{ route('home') }}" class="font-bold text-gray-800 hover:text-primary">SM Shop</a> &bull; Control Center
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('home') }}" class="hover:text-primary transition">Storefront</a>
            <a href="{{ route('shop.index') }}" class="hover:text-primary transition">Catalog</a>
        </div>
    </footer>

</body>
</html>