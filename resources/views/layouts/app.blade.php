<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SM E-Commerce - Premium Online Store')</title>

    <!-- Google Fonts & Tailwind CDN fallback / FontAwesome Icons -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen text-slate-800 antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-indigo-900 text-white text-xs py-2 px-4">
        <div class="max-w-7xl mx-auto flex flex-col sm:flex-row justify-between items-center gap-2">
            <p class="font-medium text-center sm:text-left flex items-center justify-center gap-2">
                <span class="bg-indigo-500/30 text-indigo-200 px-2 py-0.5 rounded text-[11px] font-semibold uppercase tracking-wider">Special Offer</span>
                <span>Free shipping on all orders over $100! Fast delivery nationwide.</span>
            </p>
            <div class="flex items-center gap-4 text-slate-300 text-xs">
                <span class="hover:text-white transition"><i class="fa-solid fa-phone mr-1"></i> +880 1700-000000</span>
                <span class="hidden md:inline hover:text-white transition"><i class="fa-solid fa-envelope mr-1"></i> support@smecom.com</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-slate-200 shadow-xs">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div class="w-11 h-11 bg-gradient-to-tr from-indigo-600 to-violet-500 rounded-xl flex items-center justify-center text-white shadow-md shadow-indigo-200 group-hover:scale-105 transition duration-200">
                            <i class="fa-solid fa-bag-shopping text-xl"></i>
                        </div>
                        <div>
                            <span class="text-2xl font-extrabold tracking-tight bg-gradient-to-r from-indigo-700 via-indigo-600 to-purple-600 bg-clip-text text-transparent">SM</span>
                            <span class="text-2xl font-bold text-slate-800">Shop</span>
                        </div>
                    </a>

                    <!-- Desktop Nav Links -->
                    <nav class="hidden lg:flex items-center gap-6 text-sm font-semibold text-slate-600">
                        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition {{ request()->routeIs('home') ? 'text-indigo-600 font-bold' : '' }}">Home</a>
                        <a href="{{ route('shop.index') }}" class="hover:text-indigo-600 transition {{ request()->routeIs('shop.*') ? 'text-indigo-600 font-bold' : '' }}">All Products</a>
                        <a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="hover:text-indigo-600 transition">Electronics</a>
                        <a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="hover:text-indigo-600 transition">Fashion</a>
                    </nav>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-md mx-4">
                    <form action="{{ route('shop.index') }}" method="GET" class="w-full relative">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}"
                            placeholder="Search products, brands, tech..." 
                            class="w-full pl-11 pr-4 py-2.5 bg-slate-100/80 border border-slate-200 rounded-full text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition"
                        >
                        <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-indigo-600 transition">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Actions: Cart & CTA -->
                @php
                    $cart = session()->get('cart', []);
                    $cartCount = array_sum(array_column($cart, 'quantity'));
                @endphp
                <div class="flex items-center gap-3">
                    <a href="{{ route('cart.index') }}" class="relative p-2.5 text-slate-700 hover:text-indigo-600 hover:bg-slate-100 rounded-full transition flex items-center gap-2">
                        <i class="fa-solid fa-cart-shopping text-xl"></i>
                        @if($cartCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 bg-indigo-600 text-white text-[11px] font-bold w-5 h-5 rounded-full flex items-center justify-center shadow-xs">
                                {{ $cartCount }}
                            </span>
                        @endif
                        <span class="hidden sm:inline text-sm font-semibold">Cart</span>
                    </a>

                    <a href="{{ route('shop.index') }}" class="hidden sm:inline-flex items-center justify-center px-4 py-2.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-xs shadow-indigo-200 transition active:scale-95">
                        Shop Now
                    </a>
                </div>

            </div>
        </div>
    </header>

    <!-- Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-50 border border-emerald-200 text-emerald-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-xs mb-4">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                    <p class="text-sm font-medium">{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-800 text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-50 border border-rose-200 text-rose-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-xs mb-4">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-rose-500 text-lg"></i>
                    <p class="text-sm font-medium">{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-rose-500 hover:text-rose-800 text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('info'))
            <div class="bg-indigo-50 border border-indigo-200 text-indigo-800 px-4 py-3 rounded-xl flex items-center justify-between shadow-xs mb-4">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-info text-indigo-500 text-lg"></i>
                    <p class="text-sm font-medium">{{ session('info') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-indigo-500 hover:text-indigo-800 text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content Body -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-slate-900 text-slate-300 mt-20 border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                
                <!-- About Column -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md">
                            <i class="fa-solid fa-bag-shopping text-lg"></i>
                        </div>
                        <span class="text-2xl font-bold text-white">SM Shop</span>
                    </div>
                    <p class="text-sm text-slate-400 leading-relaxed max-w-sm">
                        Your trusted modern e-commerce destination for cutting-edge electronics, fashion, smart wearables, and lifestyle products.
                    </p>
                    <div class="flex items-center gap-3 pt-2 text-slate-400">
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-facebook-f"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-twitter"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-instagram"></i></a>
                        <a href="#" class="w-9 h-9 rounded-full bg-slate-800 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-github"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-white transition">All Products</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-white transition">My Cart</a></li>
                        <li><a href="{{ route('checkout.index') }}" class="hover:text-white transition">Checkout</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-4">Categories</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li><a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="hover:text-white transition">Electronics</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="hover:text-white transition">Fashion</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'smart-watches-wearables']) }}" class="hover:text-white transition">Smart Watches</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'audio-headphones']) }}" class="hover:text-white transition">Audio Gear</a></li>
                    </ul>
                </div>

                <!-- Contact & Support -->
                <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wider text-white mb-4">Contact Info</h4>
                    <ul class="space-y-2.5 text-sm text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot mt-1 text-indigo-400"></i>
                            <span>Dhaka, Bangladesh</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-indigo-400"></i>
                            <span>support@smecom.com</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-indigo-400"></i>
                            <span>+880 1700-000000</span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="mt-12 pt-8 border-t border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; {{ date('Y') }} SM E-Commerce. Powered by Laravel 12.</p>
                <div class="flex items-center gap-6">
                    <span class="hover:text-slate-400">Privacy Policy</span>
                    <span class="hover:text-slate-400">Terms of Service</span>
                    <span class="hover:text-slate-400">Security</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>