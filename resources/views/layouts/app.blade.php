<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'SM E-Commerce - Premium Online Store')</title>

    <!-- Modern Variable Fonts (Inter Variable & Plus Jakarta Sans) & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite Assets or Tailwind CDN Fallback -->
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <script>
        // Init theme from localStorage or system preference
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="flex flex-col min-h-screen bg-app text-content-primary font-sans antialiased selection:bg-brand-primary selection:text-white transition-colors duration-200">

    <!-- Interactive 3D Nano Announcement Banner -->
    <div id="nano-banner" class="relative z-50 bg-gradient-to-r from-slate-950 via-indigo-950 to-slate-950 text-white border-b border-indigo-500/30 overflow-hidden">
        <div class="absolute inset-0 bg-gradient-to-r from-violet-600/10 via-indigo-500/20 to-amber-500/10 animate-gradient-border"></div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5 relative flex flex-wrap items-center justify-between gap-3 text-xs">
            
            <!-- Left: Nano Promo Info -->
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-gradient-to-r from-indigo-500 to-violet-600 text-white font-extrabold text-[10px] uppercase tracking-wider shadow-xs shadow-indigo-500/40">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-ping"></span>
                    ⚡ Nano Flash Deal
                </span>
                <p class="font-medium text-slate-200 hidden sm:inline">
                    Extra <strong class="text-amber-300 font-extrabold">20% OFF</strong> with code: 
                    <span class="bg-white/10 px-2 py-0.5 rounded border border-white/20 font-mono text-amber-300 font-bold">SM20</span>
                </p>
            </div>

            <!-- Center: Live Dynamic Countdown Timer -->
            <div class="flex items-center gap-2 bg-slate-900/80 px-3 py-1 rounded-full border border-indigo-400/20 shadow-inner">
                <span class="text-slate-400 text-[11px]"><i class="fa-regular fa-clock mr-1 text-amber-400"></i> Ends in:</span>
                <span id="nano-banner-timer" class="font-mono font-black text-amber-300 text-xs tracking-wider">05:42:19</span>
            </div>

            <!-- Right: Action CTA & Close -->
            <div class="flex items-center gap-3">
                <a href="{{ route('shop.index', ['sort' => 'popular']) }}" class="hidden md:inline-flex items-center gap-1 text-xs font-bold text-white bg-indigo-600 hover:bg-indigo-500 px-3 py-1 rounded-lg transition duration-200 shadow-sm shadow-indigo-600/50">
                    Claim Deal <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
                <button onclick="document.getElementById('nano-banner').remove()" class="text-slate-400 hover:text-white transition p-1" title="Close Banner">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/90 backdrop-blur-xl border-b border-slate-200/80 shadow-xs transition duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo with 3D Effect -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-12 h-12 bg-gradient-to-tr from-indigo-600 via-violet-600 to-indigo-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/25 group-hover:scale-110 group-hover:rotate-6 transition duration-300 transform-style-3d">
                            <i class="fa-solid fa-bag-shopping text-xl translate-z-10"></i>
                        </div>
                        <div>
                            <span class="text-2xl font-black tracking-tight bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 bg-clip-text text-transparent">SM</span>
                            <span class="text-2xl font-bold text-slate-900">Shop</span>
                            <span class="block text-[10px] font-bold uppercase tracking-widest text-indigo-500 -mt-1">3D E-Commerce</span>
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
                    <form action="{{ route('shop.index') }}" method="GET" class="w-full relative group">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}"
                            placeholder="Search next-gen tech, gadgets, styles..." 
                            class="w-full pl-11 pr-4 py-2.5 bg-slate-100/90 border border-slate-200/80 rounded-2xl text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:bg-white transition duration-200 shadow-inner"
                        >
                        <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-hover:text-indigo-600 transition">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Actions: Theme Toggle, Cart & CTA -->
                @php
                    $cart = session()->get('cart', []);
                    $cartCount = array_sum(array_column($cart, 'quantity'));
                @endphp
                <div class="flex items-center gap-2 sm:gap-3">
                    
                    <!-- Theme Toggle Switcher -->
                    <button 
                        type="button" 
                        onclick="toggleTheme()" 
                        id="theme-toggle-btn"
                        class="p-2.5 text-content-secondary hover:text-brand-primary hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl transition duration-200 cursor-pointer"
                        title="Toggle Light/Dark Theme"
                        aria-label="Toggle Theme"
                    >
                        <i class="fa-solid fa-moon text-lg dark:hidden"></i>
                        <i class="fa-solid fa-sun text-lg hidden dark:inline text-amber-400"></i>
                    </button>

                    <a href="{{ route('cart.index') }}" class="relative p-2.5 text-content-secondary hover:text-brand-primary hover:bg-slate-100 dark:hover:bg-slate-800 rounded-2xl transition flex items-center gap-2 group">
                        <i class="fa-solid fa-cart-shopping text-xl group-hover:scale-110 transition duration-200"></i>
                        @if($cartCount > 0)
                            <span id="nav-cart-badge" class="absolute -top-0.5 -right-0.5 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-[11px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-md shadow-indigo-500/50">
                                {{ $cartCount }}
                            </span>
                        @else
                            <span id="nav-cart-badge" class="hidden absolute -top-0.5 -right-0.5 bg-indigo-600 text-white text-[11px] font-black w-5 h-5 rounded-full items-center justify-center">0</span>
                        @endif
                        <span class="hidden sm:inline text-sm font-semibold">Cart</span>
                    </a>

                    <a href="{{ route('shop.index') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-indigo-600 via-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 rounded-xl shadow-md shadow-indigo-500/25 transition duration-200 active:scale-95">
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

    <script>
        function toggleTheme() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
    </script>
</body>
</html>