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

    <!-- Gymshark Style Announcement Ticker Bar -->
    <div id="nano-banner" class="bg-black text-white py-2.5 px-4 text-center text-[11px] font-black uppercase tracking-widest relative z-50 flex items-center justify-center gap-4">
        <span>FREE STANDARD SHIPPING OVER $75 | 30-DAY EASY RETURNS | EXTRA 20% OFF CODE: <span class="text-amber-300">SM20</span></span>
    </div>

    <!-- Gymshark Pure White Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-zinc-200 shadow-none transition duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Gymshark Bold Brand Logo -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 group">
                        <div class="w-9 h-9 bg-black rounded-lg flex items-center justify-center text-white shadow-xs group-hover:scale-105 transition duration-200">
                            <i class="fa-solid fa-cube text-lg"></i>
                        </div>
                        <div>
                            <span class="text-2xl font-black tracking-tighter text-black uppercase">SM SHOP</span>
                        </div>
                    </a>

                    <!-- Gymshark Desktop Nav Links -->
                    <nav class="hidden lg:flex items-center gap-7 text-xs font-black uppercase tracking-widest text-black">
                        <a href="{{ route('shop.index') }}" class="hover:text-zinc-500 transition {{ request()->routeIs('shop.index') && !request('category') ? 'underline underline-offset-8 decoration-2' : '' }}">All Products</a>
                        <a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="hover:text-zinc-500 transition {{ request('category') === 'electronics-gadgets' ? 'underline underline-offset-8 decoration-2' : '' }}">Tech & Gadgets</a>
                        <a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="hover:text-zinc-500 transition {{ request('category') === 'fashion-apparel' ? 'underline underline-offset-8 decoration-2' : '' }}">Apparel</a>
                        <a href="{{ route('shop.index', ['category' => 'smart-watches-wearables']) }}" class="hover:text-zinc-500 transition {{ request('category') === 'smart-watches-wearables' ? 'underline underline-offset-8 decoration-2' : '' }}">Wearables</a>
                        <a href="{{ route('shop.index', ['category' => 'audio-headphones']) }}" class="hover:text-zinc-500 transition {{ request('category') === 'audio-headphones' ? 'underline underline-offset-8 decoration-2' : '' }}">Audio</a>
                        <a href="{{ route('shop.index', ['sort' => 'popular']) }}" class="text-red-600 hover:text-red-700 transition">Sale 🔥</a>
                    </nav>
                </div>

                <!-- Search Bar -->
                <div class="hidden md:flex flex-1 max-w-sm mx-4">
                    <form action="{{ route('shop.index') }}" method="GET" class="w-full relative group">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}"
                            placeholder="SEARCH PRODUCTS..." 
                            class="w-full pl-10 pr-4 py-2 bg-zinc-100 border border-transparent rounded-full text-xs font-bold text-black placeholder-zinc-400 focus:outline-none focus:bg-white focus:border-black transition duration-200 uppercase"
                        >
                        <button type="submit" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-500 hover:text-black transition">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
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

    <!-- Gymshark Newsletter Bar -->
    <div class="bg-zinc-100 border-t border-zinc-200 py-12 mt-20">
        <div class="max-w-3xl mx-auto px-4 text-center space-y-4">
            <h3 class="text-xl sm:text-2xl font-black uppercase tracking-tight text-black">BE THE FIRST TO KNOW</h3>
            <p class="text-xs text-zinc-600 uppercase tracking-wider font-semibold">Sign up for exclusive 3D drops, early sale access, and 20% off your first order.</p>
            <form action="#" onsubmit="event.preventDefault(); alert('Subscribed! Use code SM20 for 20% off.');" class="flex flex-col sm:flex-row gap-2 max-w-md mx-auto pt-2">
                <input type="email" placeholder="ENTER YOUR EMAIL..." class="flex-1 px-5 py-3.5 bg-white border border-zinc-300 rounded-full text-xs font-bold uppercase placeholder-zinc-400 focus:outline-none focus:border-black" required>
                <button type="submit" class="bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-widest px-8 py-3.5 rounded-full transition cursor-pointer">SIGN UP</button>
            </form>
        </div>
    </div>

    <!-- Gymshark Clean Structured Footer -->
    <footer class="bg-white text-zinc-900 border-t border-zinc-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-black mb-4">HELP & SUPPORT</h4>
                    <ul class="space-y-2 text-xs font-bold text-zinc-600 uppercase">
                        <li><a href="#" class="hover:text-black transition">FAQ & Orders</a></li>
                        <li><a href="#" class="hover:text-black transition">Delivery Info</a></li>
                        <li><a href="#" class="hover:text-black transition">Returns Policy</a></li>
                        <li><a href="#" class="hover:text-black transition">Contact Us</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-black mb-4">PAGES</h4>
                    <ul class="space-y-2 text-xs font-bold text-zinc-600 uppercase">
                        <li><a href="{{ route('home') }}" class="hover:text-black transition">Home</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-black transition">3D Catalog</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-black transition">Shopping Bag</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-black transition">Admin Portal</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-black mb-4">COLLECTIONS</h4>
                    <ul class="space-y-2 text-xs font-bold text-zinc-600 uppercase">
                        <li><a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="hover:text-black transition">Tech & Gadgets</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="hover:text-black transition">Apparel</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'smart-watches-wearables']) }}" class="hover:text-black transition">Smart Wearables</a></li>
                        <li><a href="{{ route('shop.index', ['category' => 'audio-headphones']) }}" class="hover:text-black transition">Audio Gear</a></li>
                    </ul>
                </div>
                <div>
                    <h4 class="text-xs font-black uppercase tracking-widest text-black mb-4">MORE ABOUT US</h4>
                    <ul class="space-y-2 text-xs font-bold text-zinc-600 uppercase">
                        <li><a href="#" class="hover:text-black transition">3D Tech Innovation</a></li>
                        <li><a href="#" class="hover:text-black transition">Sustainability</a></li>
                        <li><a href="#" class="hover:text-black transition">Careers</a></li>
                        <li><a href="#" class="hover:text-black transition">About SM Group</a></li>
                    </ul>
                </div>
            </div>

            <div class="mt-12 pt-6 border-t border-zinc-200 flex flex-col sm:flex-row justify-between items-center gap-4 text-[11px] font-bold uppercase text-zinc-500">
                <p>&copy; 2026 SM SHOP 3D. ALL RIGHTS RESERVED.</p>
                <div class="flex items-center gap-4 text-sm text-black">
                    <a href="#"><i class="fa-brands fa-instagram"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook"></i></a>
                    <a href="#"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#"><i class="fa-brands fa-tiktok"></i></a>
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