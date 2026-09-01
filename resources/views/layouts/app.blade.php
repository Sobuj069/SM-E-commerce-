<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'SM Shop 3D - 2026 Next-Gen E-Commerce Experience')</title>
    <meta name="description" content="Immerse in next-generation 3D product previews, instant checkout, and curated tech & luxury activewear at SM Shop 3D.">
    <meta name="keywords" content="e-commerce, 3D product viewer, tech gadgets, smartwatches, luxury fashion, audio headphones, online store 2026">
    <meta name="author" content="SM Shop">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'SM Shop 3D - Next-Gen E-Commerce Experience')">
    <meta property="og:description" content="Explore 3D interactive electronics, audio gear, and fashion with instant delivery.">
    <meta property="og:image" content="{{ asset('images/gymshark_hero_banner.jpg') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'SM Shop 3D - Next-Gen E-Commerce Experience')">
    <meta name="twitter:description" content="Explore 3D interactive electronics, audio gear, and fashion with instant delivery.">
    <meta name="twitter:image" content="{{ asset('images/gymshark_hero_banner.jpg') }}">

    <!-- PWA Web App Manifest & Theme Color -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#000000">
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

    <!-- Vite Assets -->
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <script>
        document.documentElement.classList.remove('dark');
        if (localStorage.theme === 'dark') {
            localStorage.removeItem('theme');
        }
    </script>
</head>
<body 
    x-data="{ drawerOpen: false, mobileMenuOpen: false }"
    class="flex flex-col min-h-screen bg-white text-black font-sans antialiased selection:bg-black selection:text-white transition-colors duration-200"
>

    <!-- Top Announcement Ticker Bar (Readable 12px Baseline) -->
    <div id="nano-banner" class="bg-black text-white py-2.5 px-4 text-center text-xs font-bold tracking-wider relative z-50 flex items-center justify-center gap-4">
        <span>Free standard shipping over $75 | 30-day easy returns | Code: <span class="text-amber-300 font-black">SM20</span></span>
    </div>

    <!-- Gymshark Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-zinc-200 transition duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-20 gap-4">
                
                <!-- Modern Brand Logo -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-black rounded-xl flex items-center justify-center text-white shadow-sm group-hover:scale-105 transition duration-300">
                            <!-- Geometric 3D Polygon Logo -->
                            <svg class="w-5 h-5 fill-current text-white" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" fill="none"/>
                            </svg>
                        </div>
                        <div class="flex flex-col">
                            <span class="text-2xl font-black tracking-tighter text-black uppercase leading-none font-sans">SM SHOP</span>
                            <span class="text-xs font-semibold text-zinc-400 mt-0.5">3D Performance Gear</span>
                        </div>
                    </a>

                    <!-- Desktop Nav Links (Title Case & Clear Font Scale) -->
                    <nav class="hidden xl:flex items-center gap-7 text-sm font-semibold text-black">
                        <a href="{{ route('shop.index') }}" class="hover:text-zinc-500 py-1 transition relative {{ request()->routeIs('shop.index') && !request('category') ? 'border-b-2 border-black font-bold' : '' }}">All Products</a>
                        @if(isset($navCategories) && $navCategories->count() > 0)
                            @foreach($navCategories as $navCat)
                                <a href="{{ route('shop.index', ['category' => $navCat->slug]) }}" class="hover:text-zinc-500 py-1 transition relative {{ request('category') === $navCat->slug ? 'border-b-2 border-black font-bold' : '' }}">
                                    {{ $navCat->name }}
                                </a>
                            @endforeach
                        @else
                            <a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="hover:text-zinc-500 py-1 transition relative">Tech & Gadgets</a>
                            <a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="hover:text-zinc-500 py-1 transition relative">Apparel</a>
                            <a href="{{ route('shop.index', ['category' => 'smart-watches-wearables']) }}" class="hover:text-zinc-500 py-1 transition relative">Wearables</a>
                            <a href="{{ route('shop.index', ['category' => 'audio-headphones']) }}" class="hover:text-zinc-500 py-1 transition relative">Audio</a>
                        @endif
                        <a href="{{ route('shop.index', ['sort' => 'popular']) }}" class="text-red-600 hover:text-red-700 py-1 transition font-bold flex items-center gap-1.5">
                            Sale <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-ping"></span>
                        </a>
                    </nav>
                </div>

                <!-- Expanded Search Bar -->
                <div class="hidden md:flex flex-1 max-w-xs lg:max-w-sm mx-2">
                    <form action="{{ route('shop.index') }}" method="GET" class="w-full relative group">
                        <input 
                            type="text" 
                            name="q" 
                            value="{{ request('q') }}"
                            placeholder="Search products..." 
                            class="w-full pl-10 pr-4 py-2.5 bg-zinc-100 hover:bg-zinc-200/70 border border-transparent rounded-full text-xs font-semibold text-black placeholder-zinc-400 focus:outline-none focus:bg-white focus:border-black focus:ring-1 focus:ring-black transition duration-200"
                        >
                        <button type="submit" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-500 hover:text-black transition">
                            <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        </button>
                    </form>
                </div>

                <!-- Right Actions -->
                @php
                    $cart = session()->get('cart', []);
                    $cartCount = array_sum(array_column($cart, 'quantity'));
                @endphp
                <div class="flex items-center gap-2 sm:gap-4">
                    
                    <!-- Wishlist Icon -->
                    <a href="{{ route('shop.index') }}" class="p-2 text-black hover:text-zinc-500 transition" title="Wishlist">
                        <i class="fa-regular fa-heart text-lg"></i>
                    </a>

                    <!-- Cart Bag Trigger -->
                    <button 
                        type="button"
                        x-on:click="drawerOpen = true"
                        class="relative p-2 text-black hover:text-zinc-500 transition flex items-center gap-1.5 cursor-pointer"
                        title="Shopping Bag"
                    >
                        <i class="fa-solid fa-bag-shopping text-xl"></i>
                        @if($cartCount > 0)
                            <span id="nav-cart-badge" class="bg-black text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Standard Action Button -->
                    <a href="{{ route('shop.index') }}" class="hidden sm:inline-flex items-center justify-center px-6 py-2.5 text-xs font-bold text-white bg-black hover:bg-zinc-800 rounded-full transition shadow-sm cursor-pointer">
                        Explore 3D
                    </a>

                    <!-- Mobile Menu Toggle Button -->
                    <button 
                        type="button" 
                        x-on:click="mobileMenuOpen = !mobileMenuOpen"
                        class="xl:hidden p-2 text-black hover:text-zinc-500 transition"
                    >
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Mobile Navigation Dropdown -->
        <div x-show="mobileMenuOpen" class="xl:hidden bg-white border-t border-zinc-200 px-4 py-6 space-y-4 shadow-xl" style="display: none;">
            <form action="{{ route('shop.index') }}" method="GET" class="w-full relative mb-4">
                <input 
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}"
                    placeholder="Search products..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-zinc-100 rounded-full text-xs font-semibold text-black"
                >
                <button type="submit" class="absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-500">
                    <i class="fa-solid fa-magnifying-glass text-xs"></i>
                </button>
            </form>

            <nav class="flex flex-col space-y-3 text-sm font-semibold text-black">
                <a href="{{ route('shop.index') }}" class="py-2 hover:text-zinc-500">All Products</a>
                @if(isset($navCategories) && $navCategories->count() > 0)
                    @foreach($navCategories as $navCat)
                        <a href="{{ route('shop.index', ['category' => $navCat->slug]) }}" class="py-2 hover:text-zinc-500">{{ $navCat->name }}</a>
                    @endforeach
                @else
                    <a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="py-2 hover:text-zinc-500">Tech & Gadgets</a>
                    <a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="py-2 hover:text-zinc-500">Apparel</a>
                    <a href="{{ route('shop.index', ['category' => 'smart-watches-wearables']) }}" class="py-2 hover:text-zinc-500">Wearables</a>
                    <a href="{{ route('shop.index', ['category' => 'audio-headphones']) }}" class="py-2 hover:text-zinc-500">Audio</a>
                @endif
                <a href="{{ route('shop.index', ['sort' => 'popular']) }}" class="py-2 text-red-600 font-bold">Sale 🔥</a>
            </nav>
        </div>
    </header>

    <!-- Mobile Slide-Over Cart Drawer -->
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
            class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity" 
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
                class="w-screen max-w-md bg-white border-l border-zinc-200 shadow-2xl flex flex-col justify-between"
            >
                <!-- Drawer Header -->
                <div class="p-6 border-b border-zinc-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-bag-shopping text-black"></i>
                        <h3 class="font-bold text-black text-sm">Your Bag ({{ $cartCount }})</h3>
                    </div>
                    <button x-on:click="drawerOpen = false" class="p-1 rounded-lg text-zinc-400 hover:text-black">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Items Scroll Area -->
                <div class="p-6 flex-1 overflow-y-auto divide-y divide-zinc-200 space-y-4">
                    @forelse($cart as $item)
                        <div class="pt-4 first:pt-0 flex items-center gap-3">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-14 h-16 rounded-xl object-cover bg-[#f4f4f5] border border-zinc-200 shrink-0">
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-xs text-black truncate">{{ $item['name'] }}</h4>
                                <div class="text-xs text-zinc-500 font-medium">Qty: {{ $item['quantity'] }} &times; ${{ number_format($item['price'], 2) }}</div>
                            </div>
                            <span class="font-bold text-xs text-black">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                        </div>
                    @empty
                        <div class="py-12 text-center text-zinc-400 text-xs font-semibold">
                            Your bag is currently empty.
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
                <div class="p-6 border-t border-zinc-200 space-y-4 bg-zinc-50">
                    <div class="flex items-center justify-between text-xs font-bold text-black">
                        <span>Subtotal</span>
                        <span class="text-base font-bold text-black">${{ number_format($drawerSubtotal, 2) }}</span>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <a href="{{ route('cart.index') }}" class="px-4 py-3 rounded-full border border-zinc-300 text-xs font-bold text-black text-center hover:bg-white transition">
                            View Bag
                        </a>
                        <a href="{{ route('checkout.index') }}" class="px-4 py-3 rounded-full bg-black text-white text-xs font-bold text-center hover:bg-zinc-800 transition shadow-md">
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
            <div class="bg-zinc-900 text-white px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs mb-4 text-xs font-semibold">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
                    <p>{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-zinc-400 hover:text-white text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-900 text-white px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs mb-4 text-xs font-semibold">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-base"></i>
                    <p>{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-zinc-400 hover:text-white text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content Body -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- 4-Column Structured Footer (Accessible & Public-Facing) -->
    <footer class="bg-white border-t border-zinc-200 text-black py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-10">
                
                <!-- Col 1: Help -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-black uppercase tracking-wider">Help & Support</h4>
                    <ul class="space-y-2 text-xs text-zinc-500 font-medium">
                        <li><a href="#" class="hover:text-black">FAQ</a></li>
                        <li><a href="#" class="hover:text-black">Delivery Information</a></li>
                        <li><a href="#" class="hover:text-black">Returns Policy</a></li>
                        <li><a href="#" class="hover:text-black">Make A Return</a></li>
                        <li><a href="#" class="hover:text-black">Orders & Tracking</a></li>
                    </ul>
                </div>

                <!-- Col 2: My Account (Removed Internal Admin Link) -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-black uppercase tracking-wider">My Account</h4>
                    <ul class="space-y-2 text-xs text-zinc-500 font-medium">
                        <li><a href="{{ route('cart.index') }}" class="hover:text-black">View Bag</a></li>
                        <li><a href="{{ route('checkout.index') }}" class="hover:text-black">Checkout</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-black">Track Order</a></li>
                        <li><a href="{{ route('shop.index') }}" class="hover:text-black">Wishlist</a></li>
                    </ul>
                </div>

                <!-- Col 3: Dynamic Collections -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-black uppercase tracking-wider">Collections</h4>
                    <ul class="space-y-2 text-xs text-zinc-500 font-medium">
                        @if(isset($navCategories) && $navCategories->count() > 0)
                            @foreach($navCategories as $navCat)
                                <li><a href="{{ route('shop.index', ['category' => $navCat->slug]) }}" class="hover:text-black">{{ $navCat->name }}</a></li>
                            @endforeach
                        @else
                            <li><a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="hover:text-black">Tech & Gadgets</a></li>
                            <li><a href="{{ route('shop.index', ['category' => 'smart-watches-wearables']) }}" class="hover:text-black">Smart Wearables</a></li>
                            <li><a href="{{ route('shop.index', ['category' => 'audio-headphones']) }}" class="hover:text-black">Audio & Studio</a></li>
                            <li><a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="hover:text-black">Techwear & Apparel</a></li>
                        @endif
                    </ul>
                </div>

                <!-- Col 4: More About SM Shop -->
                <div class="space-y-3">
                    <h4 class="text-xs font-bold text-black uppercase tracking-wider">About SM Shop</h4>
                    <ul class="space-y-2 text-xs text-zinc-500 font-medium">
                        <li><a href="#" class="hover:text-black">About Us</a></li>
                        <li><a href="#" class="hover:text-black">Sustainability</a></li>
                        <li><a href="#" class="hover:text-black">3D Modeling Hub</a></li>
                        <li><a href="#" class="hover:text-black">Privacy Notice</a></li>
                    </ul>
                </div>

            </div>

            <div class="mt-12 pt-8 border-t border-zinc-200 flex flex-col md:flex-row items-center justify-between text-xs text-zinc-400 font-medium gap-4">
                <p>&copy; {{ date('Y') }} SM SHOP. All rights reserved.</p>
                <div class="flex items-center gap-6">
                    <a href="#" class="hover:text-black">Privacy Notice</a>
                    <a href="#" class="hover:text-black">Terms & Conditions</a>
                    <a href="#" class="hover:text-black">Cookie Policy</a>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>