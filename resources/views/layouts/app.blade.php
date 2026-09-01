<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'SM Shop 3D - 2026 Next-Gen E-Commerce Experience')</title>
    <meta name="description" content="Immerse in next-generation 3D product previews, instant checkout, and curated tech & luxury fashion at SM Shop 3D.">
    <meta name="keywords" content="e-commerce, 3D product viewer, tech gadgets, smartwatches, luxury fashion, audio headphones, online store 2026">
    <meta name="author" content="SM Shop">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'SM Shop 3D - Next-Gen E-Commerce Experience')">
    <meta property="og:description" content="Explore 3D interactive electronics, audio gear, and fashion with instant delivery.">
    <meta property="og:image" content="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1200&q=80">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'SM Shop 3D - Next-Gen E-Commerce Experience')">
    <meta name="twitter:description" content="Explore 3D interactive electronics, audio gear, and fashion with instant delivery.">
    <meta name="twitter:image" content="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=1200&q=80">

    <!-- PWA Web App Manifest & Theme Color -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#4f46e5">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">

    <!-- JSON-LD Structured Data Schema -->
    <script type="application/ld+json">
    {!! json_encode([
      '@context' => 'https://schema.org',
      '@type' => 'WebSite',
      'name' => 'SM Shop 3D',
      'url' => url('/'),
      'potentialAction' => [
        '@type' => 'SearchAction',
        'target' => route('shop.index') . '?q={search_term_string}',
        'query-input' => 'required name=search_term_string'
      ]
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) !!}
    </script>

    <!-- Modern Geometric & Clean Typography: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Inter:ital,opsz,wght@0,14..32,400..800;1,14..32,400..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Vite Assets or Tailwind CSS fallback -->
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <script>
        // Set clean pure light mode as standard
        document.documentElement.classList.remove('dark');
        if (localStorage.theme === 'dark') {
            localStorage.removeItem('theme');
        }
    </script>
</head>
<body 
    x-data="{ drawerOpen: false }"
    class="flex flex-col min-h-screen bg-app text-content-primary font-sans antialiased selection:bg-brand-primary selection:text-white transition-colors duration-200"
>

    <!-- Clean Modern Nano Announcement Banner -->
    <div id="nano-banner" class="relative z-50 bg-gradient-to-r from-indigo-600 via-violet-600 to-indigo-700 text-white shadow-xs overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-2.5 relative flex flex-wrap items-center justify-between gap-3 text-xs">
            
            <!-- Left: Nano Promo Info -->
            <div class="flex items-center gap-3">
                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-white/20 text-white font-bold text-[11px]">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-300"></span>
                    ⚡ 2026 Deal
                </span>
                <p class="font-medium text-white/90 hidden sm:inline">
                    Extra <strong class="text-amber-200 font-bold">20% OFF</strong> with code: 
                    <span class="bg-white/15 px-2 py-0.5 rounded border border-white/20 font-mono text-amber-200 font-bold">SM20</span>
                </p>
            </div>

            <!-- Center: Live Dynamic Countdown Timer -->
            <div class="flex items-center gap-2 bg-black/20 px-3 py-1 rounded-full border border-white/10">
                <span class="text-white/80 text-[11px]"><i class="fa-regular fa-clock mr-1 text-amber-300"></i> Flash Ends:</span>
                <span id="nano-banner-timer" class="font-mono font-bold text-amber-200 text-xs tracking-wider">05:42:19</span>
            </div>

            <!-- Right: Action CTA & Close -->
            <div class="flex items-center gap-3">
                <a href="{{ route('shop.index', ['sort' => 'popular']) }}" class="hidden md:inline-flex items-center gap-1 text-xs font-bold text-indigo-900 bg-white hover:bg-slate-100 px-3 py-1 rounded-lg transition duration-200 shadow-sm">
                    Claim Deal <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
                <button onclick="document.getElementById('nano-banner').remove()" class="text-white/70 hover:text-white transition p-1" title="Close Banner">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </button>
            </div>

        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-surface/90 backdrop-blur-xl border-b border-line-subtle shadow-xs transition duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Logo with 3D Effect -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-12 h-12 bg-gradient-to-tr from-indigo-600 via-violet-600 to-indigo-400 rounded-2xl flex items-center justify-center text-white shadow-lg shadow-indigo-500/25 group-hover:scale-110 group-hover:rotate-6 transition duration-300 transform-style-3d">
                            <i class="fa-solid fa-cube text-xl translate-z-10"></i>
                        </div>
                        <div>
                            <span class="text-2xl font-black tracking-tight bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 bg-clip-text text-transparent">SM</span>
                            <span class="text-2xl font-bold text-content-primary">Shop</span>
                            <span class="block text-[10px] font-bold uppercase tracking-widest text-indigo-500 -mt-1">3D E-Commerce</span>
                        </div>
                    </a>

                    <!-- Desktop Nav Links -->
                    <nav class="hidden lg:flex items-center gap-6 text-sm font-semibold text-content-secondary">
                        <a href="{{ route('home') }}" class="hover:text-brand-primary transition {{ request()->routeIs('home') ? 'text-brand-primary font-bold' : '' }}">Home</a>
                        <a href="{{ route('shop.index') }}" class="hover:text-brand-primary transition {{ request()->routeIs('shop.*') ? 'text-brand-primary font-bold' : '' }}">3D Catalog</a>
                        <a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="hover:text-brand-primary transition">Tech & Gadgets</a>
                        <a href="{{ route('shop.index', ['category' => 'smart-watches-wearables']) }}" class="hover:text-brand-primary transition">Wearables</a>
                        <a href="{{ route('shop.index', ['category' => 'audio-headphones']) }}" class="hover:text-brand-primary transition">Audio</a>
                    </nav>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-md mx-4">
                    <form action="{{ route('shop.index') }}" method="GET" class="w-full relative group">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}"
                            placeholder="Search next-gen 3D tech, gadgets, styles..." 
                            class="w-full pl-11 pr-4 py-2.5 bg-surface-elevated border border-line-subtle rounded-2xl text-xs font-bold text-content-primary focus:outline-none focus:ring-2 focus:ring-brand-primary focus:bg-surface transition duration-200 shadow-inner"
                        >
                        <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-content-muted group-hover:text-brand-primary transition">
                            <i class="fa-solid fa-magnifying-glass text-sm"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Actions: Theme Toggle, Admin Link, Cart & CTA -->
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
                        class="p-2.5 text-content-secondary hover:text-brand-primary hover:bg-surface-elevated rounded-2xl transition duration-200 cursor-pointer"
                        title="Toggle Light/Dark Theme"
                        aria-label="Toggle Theme"
                    >
                        <i class="fa-solid fa-moon text-lg dark:hidden"></i>
                        <i class="fa-solid fa-sun text-lg hidden dark:inline text-amber-400"></i>
                    </button>

                    <!-- Admin Portal Quick Access Button -->
                    <a href="{{ route('admin.dashboard') }}" class="p-2.5 text-content-secondary hover:text-brand-primary hover:bg-surface-elevated rounded-2xl transition duration-200" title="Admin Analytics Panel">
                        <i class="fa-solid fa-chart-line text-lg"></i>
                    </a>

                    <!-- Cart Trigger (Opens Slide-Over Drawer on Mobile / Goes to Cart) -->
                    <button 
                        type="button"
                        x-on:click="drawerOpen = true"
                        class="relative p-2.5 text-content-secondary hover:text-brand-primary hover:bg-surface-elevated rounded-2xl transition flex items-center gap-2 group cursor-pointer"
                    >
                        <i class="fa-solid fa-cart-shopping text-xl group-hover:scale-110 transition duration-200"></i>
                        @if($cartCount > 0)
                            <span id="nav-cart-badge" class="absolute -top-0.5 -right-0.5 bg-gradient-to-r from-indigo-600 to-violet-600 text-white text-[11px] font-black w-5 h-5 rounded-full flex items-center justify-center shadow-md shadow-indigo-500/50">
                                {{ $cartCount }}
                            </span>
                        @else
                            <span id="nav-cart-badge" class="hidden absolute -top-0.5 -right-0.5 bg-indigo-600 text-white text-[11px] font-black w-5 h-5 rounded-full items-center justify-center">0</span>
                        @endif
                        <span class="hidden sm:inline text-xs font-bold">Cart</span>
                    </button>

                    <a href="{{ route('shop.index') }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 text-xs font-extrabold text-white bg-gradient-to-r from-indigo-600 via-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 rounded-xl shadow-md shadow-indigo-500/25 transition duration-200 active:scale-95">
                        Shop 3D
                    </a>
                </div>

            </div>
        </div>
    </header>

    <!-- Mobile Slide-Over Bottom-Sheet Cart Drawer -->
    <div 
        x-show="drawerOpen" 
        x-on:keydown.escape.window="drawerOpen = false"
        class="fixed inset-0 z-50 overflow-hidden" 
        style="display: none;"
    >
        <!-- Backdrop -->
        <div 
            x-show="drawerOpen"
            x-transition:enter="ease-in-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-slate-950/70 backdrop-blur-sm transition-opacity" 
            x-on:click="drawerOpen = false"
        ></div>

        <!-- Drawer Content Panel -->
        <div class="fixed inset-y-0 right-0 max-w-full flex pl-10">
            <div 
                x-show="drawerOpen"
                x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="translate-x-full"
                class="w-screen max-w-md bg-surface border-l border-line-subtle shadow-2xl flex flex-col justify-between"
            >
                <!-- Drawer Header -->
                <div class="p-6 border-b border-line-subtle flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-bag-shopping text-brand-primary"></i>
                        <h3 class="font-black text-content-primary text-base">Your Cart ({{ $cartCount }})</h3>
                    </div>
                    <button x-on:click="drawerOpen = false" class="p-1 rounded-lg text-content-muted hover:text-content-primary">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Items Scroll Area -->
                <div class="p-6 flex-1 overflow-y-auto divide-y divide-line-subtle space-y-4">
                    @forelse($cart as $item)
                        <div class="pt-4 first:pt-0 flex items-center gap-3">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-14 h-14 rounded-xl object-cover border border-line-subtle shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-xs text-content-primary truncate">{{ $item['name'] }}</h4>
                                <div class="text-[11px] text-content-muted">Qty: {{ $item['quantity'] }} &times; ${{ number_format($item['price'], 2) }}</div>
                            </div>
                            <span class="font-black text-xs text-content-primary">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </div>
                    @empty
                        <div class="py-12 text-center text-content-muted text-xs italic">
                            Your cart is empty.
                        </div>
                    @endforelse
                </div>

                <!-- Drawer Foot -->
                @php
                    $drawerSubtotal = 0;
                    if(is_array($cart)) {
                        foreach($cart as $dItem) {
                            $drawerSubtotal += ($dItem['price'] ?? 0) * ($dItem['quantity'] ?? 1);
                        }
                    }
                @endphp
                <div class="p-6 border-t border-line-subtle space-y-4 bg-surface-elevated">
                    <div class="flex items-center justify-between text-sm font-black text-content-primary">
                        <span>Cart Total</span>
                        <span class="text-lg text-brand-primary">${{ number_format($drawerSubtotal, 2) }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('cart.index') }}" class="px-4 py-3 rounded-xl border border-line-subtle text-xs font-bold text-content-primary text-center hover:bg-surface transition">
                            View Cart
                        </a>
                        <a href="{{ route('checkout.index') }}" class="px-4 py-3 rounded-xl bg-brand-primary text-white text-xs font-bold text-center hover:opacity-90 transition shadow-md shadow-indigo-500/25">
                            Checkout
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Flash Notifications -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 w-full">
        @if(session('success'))
            <div class="bg-emerald-500/10 border border-emerald-500/30 text-status-success px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs mb-4 text-xs font-bold">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-base"></i>
                    <p>{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-status-success hover:opacity-80 text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-rose-500/10 border border-rose-500/30 text-status-danger px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs mb-4 text-xs font-bold">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-base"></i>
                    <p>{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-status-danger hover:opacity-80 text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content Body -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- Modern Light Clean Footer -->
    <footer class="bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-400 mt-20 border-t border-slate-200/80 dark:border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-10">
                
                <!-- About Column -->
                <div class="lg:col-span-2 space-y-4">
                    <div class="flex items-center gap-2.5">
                        <div class="w-10 h-10 bg-indigo-600 rounded-xl flex items-center justify-center text-white shadow-md shadow-indigo-500/20">
                            <i class="fa-solid fa-cube text-lg"></i>
                        </div>
                        <span class="text-2xl font-bold text-slate-900 dark:text-white">SM Shop 3D</span>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed max-w-sm">
                        Your trusted next-gen 2026 e-commerce platform for cutting-edge electronics, fashion, smart wearables, and spatial audio gear.
                    </p>
                    <div class="flex items-center gap-3 pt-2 text-slate-500">
                        <a href="#" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-twitter text-xs"></i></a>
                        <a href="#" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-instagram text-xs"></i></a>
                        <a href="https://github.com/Sobuj069/SM-E-commerce-" target="_blank" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-indigo-600 hover:text-white flex items-center justify-center transition"><i class="fa-brands fa-github text-xs"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-4">Quick Links</h4>
                    <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400">
                        <li><a href="{{ route('home') }}" class="hover:text-indigo-600 dark:hover:text-white transition">Home</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-indigo-600 dark:hover:text-white transition">3D Catalog</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-indigo-600 dark:hover:text-white transition">Shopping Cart</a></li>
                        <li><a href="{{ route('checkout.index') }}" class="hover:text-indigo-600 dark:hover:text-white transition">Secure Checkout</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="text-indigo-600 dark:text-indigo-400 hover:underline transition font-bold">Admin Panel</a></li>
                    </ul>
                </div>

                <!-- Categories -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-4">Collections</h4>
                    <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400">
                        <li><a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="hover:text-indigo-600 dark:hover:text-white transition">Electronics</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="hover:text-indigo-600 dark:hover:text-white transition">Fashion</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'smart-watches-wearables']) }}" class="hover:text-indigo-600 dark:hover:text-white transition">Smart Watches</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'audio-headphones']) }}" class="hover:text-indigo-600 dark:hover:text-white transition">Audio Gear</a></li>
                    </ul>
                </div>

                <!-- Contact & Support -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-900 dark:text-white mb-4">Contact Info</h4>
                    <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400">
                        <li class="flex items-start gap-2.5">
                            <i class="fa-solid fa-location-dot mt-1 text-indigo-600"></i>
                            <span>Dhaka, Bangladesh</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-envelope text-indigo-600"></i>
                            <span>support&#64;smcloudit.top</span>
                        </li>
                        <li class="flex items-center gap-2.5">
                            <i class="fa-solid fa-phone text-indigo-600"></i>
                            <span>+880 1700-000000</span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="mt-12 pt-8 border-t border-slate-100 dark:border-slate-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-xs text-slate-500">
                <p>&copy; 2026 SM Shop 3D E-Commerce. Powered by Laravel 12 & Tailwind CSS v4.</p>
                <div class="flex items-center gap-6">
                    <span class="hover:text-slate-600">Privacy Policy</span>
                    <span class="hover:text-slate-600">Terms of Service</span>
                    <span class="hover:text-slate-600">256-Bit SSL Security</span>
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

        // PWA Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js').catch(err => {
                    console.log('Service Worker registration failed: ', err);
                });
            });
        }
    </script>
</body>
</html>