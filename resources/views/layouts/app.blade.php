<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>@yield('title', 'SM Shop - Fashion & Apparel')</title>
    <meta name="description" content="Shop trendy fashion, athletic gym clothes, seamless workout leggings, and apparel engineered for peak performance at SM Shop.">
    <meta name="keywords" content="sm shop, fashion, apparel, gym clothes, workout clothes, seamless leggings, fitness apparel, activewear, hoodies">
    <meta name="author" content="SM Shop">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'SM Shop - Fashion & Apparel')">
    <meta property="og:description" content="Shop trendy fashion, seamless gymwear, squat-proof leggings, and heavyweight pump covers with express delivery at SM Shop.">
    <meta property="og:image" content="{{ asset('images/gymshark_hero_banner.jpg') }}">

    <!-- Twitter Card -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', 'SM Shop - Fashion & Apparel')">
    <meta name="twitter:description" content="Shop trendy fashion, seamless gymwear, squat-proof leggings, and heavyweight pump covers at SM Shop.">
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
      'name' => 'SM Shark',
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
    x-data="{ drawerOpen: false, mobileMenuOpen: false, searchOpen: false }"
    class="flex flex-col min-h-screen bg-white text-black font-sans antialiased selection:bg-black selection:text-white transition-colors duration-200"
>

    <!-- Top Announcement Ticker Bar -->
    <div id="nano-banner" class="bg-black text-white py-2 px-4 text-center text-xs font-bold tracking-wider relative z-50 flex items-center justify-center gap-4">
        <span>Free standard shipping over $75 | 30-day easy returns | Use Code: <span class="text-amber-300 font-black">SM20</span> for 20% off</span>
    </div>

    <!-- 100% Authentic Gymshark Header -->
    <header class="sticky top-0 z-40 bg-white/95 backdrop-blur-md border-b border-zinc-200 transition duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 gap-4">
                
                <!-- 1. Left: Official SM Shop Fashion & Apparel Logo -->
                <a href="{{ route('home') }}" class="flex items-center shrink-0 group py-1" aria-label="SM Shop Fashion & Apparel Home">
                    <img src="{{ asset('images/logo.png') }}" alt="SM Shop - Fashion & Apparel" class="h-8 sm:h-10 w-auto object-contain group-hover:opacity-90 transition duration-300">
                </a>

                <!-- 2. Center: Gymshark Apparel Nav Links -->
                @php
                    $catLabels = [
                        'women' => 'WOMEN',
                        'men' => 'MEN',
                        'seamless' => 'SEAMLESS',
                        'hoodies-sweats' => 'HOODIES & SWEATS',
                        'accessories' => 'ACCESSORIES',
                    ];
                @endphp
                <nav class="hidden lg:flex items-center gap-6 xl:gap-8 text-xs font-black uppercase tracking-wider text-black">
                    <a href="{{ route('shop.index') }}" class="hover:text-zinc-500 py-1.5 transition whitespace-nowrap {{ request()->routeIs('shop.index') && !request('category') ? 'border-b-2 border-black' : '' }}">
                        ALL APPAREL
                    </a>
                    @if(isset($navCategories) && $navCategories->count() > 0)
                        @foreach($navCategories as $navCat)
                            <a href="{{ route('shop.index', ['category' => $navCat->slug]) }}" class="hover:text-zinc-500 py-1.5 transition whitespace-nowrap {{ request('category') === $navCat->slug ? 'border-b-2 border-black' : '' }}">
                                {{ $catLabels[$navCat->slug] ?? Str::upper($navCat->name) }}
                            </a>
                        @endforeach
                    @else
                        <a href="{{ route('shop.index', ['category' => 'women']) }}" class="hover:text-zinc-500 py-1.5 transition whitespace-nowrap">WOMEN</a>
                        <a href="{{ route('shop.index', ['category' => 'men']) }}" class="hover:text-zinc-500 py-1.5 transition whitespace-nowrap">MEN</a>
                        <a href="{{ route('shop.index', ['category' => 'seamless']) }}" class="hover:text-zinc-500 py-1.5 transition whitespace-nowrap">SEAMLESS</a>
                        <a href="{{ route('shop.index', ['category' => 'hoodies-sweats']) }}" class="hover:text-zinc-500 py-1.5 transition whitespace-nowrap">HOODIES & SWEATS</a>
                        <a href="{{ route('shop.index', ['category' => 'accessories']) }}" class="hover:text-zinc-500 py-1.5 transition whitespace-nowrap">ACCESSORIES</a>
                    @endif
                    <a href="{{ route('shop.index', ['sort' => 'popular']) }}" class="text-red-600 hover:text-red-700 py-1.5 transition whitespace-nowrap flex items-center gap-1 font-black">
                        OUTLET <span class="w-1.5 h-1.5 rounded-full bg-red-600 animate-ping"></span>
                    </a>
                </nav>

                <!-- 3. Right: Gymshark Minimal Action Icons -->
                <div class="flex items-center gap-2 sm:gap-3 shrink-0">
                    
                    <!-- Search Icon Button -->
                    <button 
                        type="button" 
                        @click="searchOpen = true; $nextTick(() => $refs.searchInput.focus())"
                        class="w-9 h-9 rounded-full flex items-center justify-center text-black hover:bg-zinc-100 transition cursor-pointer"
                        title="Search Activewear"
                        aria-label="Search Activewear"
                    >
                        <i class="fa-solid fa-magnifying-glass text-base" aria-hidden="true"></i>
                    </button>

                    <!-- Wishlist Icon -->
                    <a href="{{ route('shop.index') }}" class="w-9 h-9 rounded-full flex items-center justify-center text-black hover:bg-zinc-100 transition" title="Wishlist" aria-label="View Wishlist">
                        <i class="fa-regular fa-heart text-base" aria-hidden="true"></i>
                    </a>

                    <!-- Cart Bag Trigger -->
                    @php
                        $cart = session()->get('cart', []);
                        $cartCount = array_sum(array_column($cart, 'quantity'));
                    @endphp
                    <button 
                        type="button"
                        x-on:click="drawerOpen = true"
                        class="w-9 h-9 rounded-full flex items-center justify-center text-black hover:bg-zinc-100 transition relative cursor-pointer"
                        title="Shopping Bag"
                        aria-label="Open Shopping Bag ({{ $cartCount }} items)"
                    >
                        <i class="fa-solid fa-bag-shopping text-base" aria-hidden="true"></i>
                        @if($cartCount > 0)
                            <span id="nav-cart-badge" class="absolute -top-0.5 -right-0.5 bg-black text-white text-[10px] font-black w-4.5 h-4.5 rounded-full flex items-center justify-center border-2 border-white">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </button>

                    <!-- Black Pill CTA -->
                    <a href="{{ route('shop.index', ['category' => 'seamless']) }}" class="hidden sm:inline-flex items-center justify-center px-5 py-2.5 text-xs font-black text-white bg-black hover:bg-zinc-800 rounded-full transition shadow-sm cursor-pointer whitespace-nowrap uppercase tracking-wider">
                        SHOP SEAMLESS
                    </a>

                    <!-- Mobile Menu Toggle Button -->
                    <button 
                        type="button" 
                        x-on:click="mobileMenuOpen = !mobileMenuOpen"
                        class="lg:hidden w-9 h-9 rounded-full flex items-center justify-center text-black hover:bg-zinc-100 transition"
                        aria-label="Toggle mobile menu"
                    >
                        <i class="fa-solid fa-bars text-lg" aria-hidden="true"></i>
                    </button>
                </div>

            </div>
        </div>

        <!-- Full-Width Slide-Down Search Overlay -->
        <div 
            x-show="searchOpen" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            @click.away="searchOpen = false"
            @keydown.escape.window="searchOpen = false"
            class="absolute inset-x-0 top-0 h-16 sm:h-20 bg-white border-b border-zinc-200 z-50 px-4 sm:px-8 flex items-center shadow-md" 
            style="display: none;"
        >
            <form action="{{ route('shop.index') }}" method="GET" class="w-full max-w-4xl mx-auto flex items-center gap-3">
                <i class="fa-solid fa-magnifying-glass text-zinc-400 text-lg"></i>
                <input 
                    type="text" 
                    name="q" 
                    x-ref="searchInput"
                    value="{{ request('q') }}"
                    placeholder="SEARCH WOMEN'S, MEN'S, LEGGINGS, HOODIES, SHORTS..." 
                    class="flex-1 py-3 text-sm sm:text-base font-bold text-black placeholder-zinc-400 uppercase border-none focus:outline-none focus:ring-0 bg-transparent"
                >
                <button type="button" @click="searchOpen = false" class="p-2 text-zinc-400 hover:text-black cursor-pointer" aria-label="Close search">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </form>
        </div>

        <!-- Mobile Navigation Dropdown -->
        <div x-show="mobileMenuOpen" class="lg:hidden bg-white border-t border-zinc-200 px-4 py-6 space-y-4 shadow-xl" style="display: none;">
            <form action="{{ route('shop.index') }}" method="GET" class="w-full relative mb-4" role="search">
                <label for="mobile-search-input" class="sr-only">Search activewear</label>
                <input 
                    id="mobile-search-input"
                    type="text" 
                    name="q" 
                    value="{{ request('q') }}"
                    placeholder="SEARCH ACTIVEWEAR..." 
                    class="w-full pl-10 pr-4 py-2.5 bg-zinc-100 rounded-full text-xs font-bold text-black uppercase"
                >
                <button 
                    type="submit" 
                    aria-label="Submit search" 
                    title="Search" 
                    class="absolute left-2 top-1/2 -translate-y-1/2 w-8 h-8 flex items-center justify-center text-zinc-500 cursor-pointer"
                >
                    <i class="fa-solid fa-magnifying-glass text-xs" aria-hidden="true"></i>
                    <span class="sr-only">Search</span>
                </button>
            </form>

            <nav class="flex flex-col space-y-3 text-xs font-black uppercase tracking-widest text-black">
                <a href="{{ route('shop.index') }}" class="py-2 hover:text-zinc-500">All Apparel</a>
                @if(isset($navCategories) && $navCategories->count() > 0)
                    @foreach($navCategories as $navCat)
                        <a href="{{ route('shop.index', ['category' => $navCat->slug]) }}" class="py-2 hover:text-zinc-500">{{ $navCat->name }}</a>
                    @endforeach
                @else
                    <a href="{{ route('shop.index', ['category' => 'women']) }}" class="py-2 hover:text-zinc-500">Women's Activewear</a>
                    <a href="{{ route('shop.index', ['category' => 'men']) }}" class="py-2 hover:text-zinc-500">Men's Gymwear</a>
                    <a href="{{ route('shop.index', ['category' => 'seamless']) }}" class="py-2 hover:text-zinc-500">Seamless Collection</a>
                    <a href="{{ route('shop.index', ['category' => 'hoodies-sweats']) }}" class="py-2 hover:text-zinc-500">Hoodies & Sweats</a>
                    <a href="{{ route('shop.index', ['category' => 'accessories']) }}" class="py-2 hover:text-zinc-500">Accessories & Gear</a>
                @endif
                <a href="{{ route('shop.index', ['sort' => 'popular']) }}" class="py-2 text-red-600 font-black">Outlet 🔥</a>
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
                        <i class="fa-solid fa-bag-shopping text-black" aria-hidden="true"></i>
                        <h3 class="font-bold text-black text-sm">Your Bag ({{ $cartCount }})</h3>
                    </div>
                    <button x-on:click="drawerOpen = false" class="p-1 rounded-lg text-zinc-400 hover:text-black" aria-label="Close bag drawer">
                        <i class="fa-solid fa-xmark text-lg" aria-hidden="true"></i>
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
            <div class="bg-zinc-900 text-white px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs mb-4 text-xs font-semibold" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-check text-emerald-400 text-base" aria-hidden="true"></i>
                    <p>{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-zinc-400 hover:text-white text-sm" aria-label="Dismiss notification">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-900 text-white px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs mb-4 text-xs font-semibold" role="alert">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-circle-exclamation text-base" aria-hidden="true"></i>
                    <p>{{ session('error') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-zinc-400 hover:text-white text-sm" aria-label="Dismiss notification">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>
        @endif
    </div>

    <!-- Main Content Body -->
    <main class="flex-1">
        @yield('content')
    </main>

    <!-- =========================================================================
         EXACT OFFICIAL GYMSHARK FOOTER (PIXEL-PERFECT MATCH TO GYMSHARK.COM)
         ========================================================================= -->
    <footer class="bg-white border-t border-zinc-200 text-black pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Top 4 Columns Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-8 lg:gap-12 mb-16">
                
                <!-- Col 1: Help -->
                <div class="md:col-span-2 space-y-4">
                    <h3 class="text-xs font-black text-black tracking-tight uppercase">Help</h3>
                    <ul class="space-y-2.5 text-xs text-zinc-600 font-semibold">
                        <li><a href="#" class="hover:text-black hover:underline">FAQ</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Track Your Order</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Delivery Information</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Returns Policy</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Make A Return</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Orders</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Submit a Fake</a></li>
                    </ul>
                </div>

                <!-- Col 2: My Account -->
                <div class="md:col-span-2 space-y-4">
                    <h3 class="text-xs font-black text-black tracking-tight uppercase">My Account</h3>
                    <ul class="space-y-2.5 text-xs text-zinc-600 font-semibold">
                        <li><a href="{{ route('cart.index') }}" class="hover:text-black hover:underline">Login</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-black hover:underline">Register</a></li>
                    </ul>
                </div>

                <!-- Col 3: Pages -->
                <div class="md:col-span-3 space-y-4">
                    <h3 class="text-xs font-black text-black tracking-tight uppercase">Pages</h3>
                    <ul class="space-y-2.5 text-xs text-zinc-600 font-semibold">
                        <li><a href="{{ route('shop.index') }}" class="hover:text-black hover:underline">Stores</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Refer a Friend</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">SM Shop Central</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">SM Shop Loyalty</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">About Us</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Careers</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Student Discount</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Military and Government Discount</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Accessibility Statement</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Factory List</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Sustainability</a></li>
                    </ul>
                </div>

                <!-- Col 4: More About SM Shop (3 Rich Cards) -->
                <div class="md:col-span-5 space-y-4">
                    <h3 class="text-xs font-black text-black tracking-tight uppercase">More About SM Shop</h3>
                    
                    <!-- 3 Feature Cards Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                        
                        <!-- Card 1: Blog -->
                        <a href="#" class="bg-[#f4f4f5] hover:bg-zinc-200 transition p-4 rounded-xl flex flex-col items-center justify-center text-center space-y-3 group min-h-[120px]">
                            <div class="flex flex-col items-center">
                                <span class="font-black text-[13px] tracking-tight uppercase leading-none text-black">SM SHOP</span>
                                <span class="text-[8px] font-bold tracking-widest text-zinc-600 uppercase">CENTRAL</span>
                            </div>
                            <span class="text-xs font-bold text-black group-hover:underline">Blog</span>
                        </a>

                        <!-- Card 2: Student Discount -->
                        <a href="#" class="bg-[#f4f4f5] hover:bg-zinc-200 transition p-4 rounded-xl flex flex-col items-center justify-center text-center space-y-2.5 group min-h-[120px]">
                            <div class="w-8 h-8 rounded-full border-2 border-black flex items-center justify-center font-black text-xs text-black">
                                %
                            </div>
                            <span class="text-[11px] font-bold text-black leading-tight group-hover:underline">Students get an extra 10% off</span>
                        </a>

                        <!-- Card 3: Email Sign Up -->
                        <a href="#nano-banner" class="bg-[#f4f4f5] hover:bg-zinc-200 transition p-4 rounded-xl flex flex-col items-center justify-center text-center space-y-2.5 group min-h-[120px]">
                            <i class="fa-regular fa-envelope text-xl text-black"></i>
                            <span class="text-xs font-bold text-black group-hover:underline">Email Sign Up</span>
                        </a>

                    </div>
                </div>

            </div>

            <!-- Middle Bar: Payment Methods & Social Media Icons -->
            <div class="pt-8 pb-6 border-t border-zinc-200 flex flex-col lg:flex-row items-center justify-between gap-6">
                
                <!-- Payment Badges -->
                <div class="flex flex-wrap items-center justify-center lg:justify-start gap-2">
                    <span class="px-2.5 py-1 bg-[#1A1F71] text-white text-[10px] font-black tracking-widest rounded italic shadow-xs">VISA</span>
                    <span class="px-2 py-1 bg-black text-white text-[10px] font-black rounded flex items-center gap-0.5 shadow-xs">
                        <span class="w-3 h-3 rounded-full bg-red-600 inline-block -mr-1.5 opacity-95"></span>
                        <span class="w-3 h-3 rounded-full bg-amber-400 inline-block opacity-95"></span>
                    </span>
                    <span class="px-2.5 py-1 bg-[#003087] text-white text-[10px] font-black rounded italic shadow-xs">PayPal</span>
                    <span class="px-2.5 py-1 bg-black text-white text-[10px] font-black rounded flex items-center gap-1 shadow-xs">
                        <i class="fa-brands fa-apple text-xs"></i> Pay
                    </span>
                    <span class="px-2.5 py-1 bg-[#FFB3C7] text-black text-[10px] font-black rounded shadow-xs">Klarna.</span>
                    <span class="px-2.5 py-1 bg-[#007BC1] text-white text-[10px] font-black rounded shadow-xs">AMEX</span>
                    <span class="px-2.5 py-1 bg-[#B2FCE4] text-black text-[10px] font-black rounded shadow-xs">afterpay<span class="text-[8px]">&copy;</span></span>
                    <span class="px-2.5 py-1 bg-[#4E008E] text-white text-[10px] font-black rounded shadow-xs">sezzle</span>
                </div>

                <!-- Social Media Icons (Vibrant Brand Hovers) -->
                <div class="flex items-center gap-2.5 text-black">
                    <a href="#" class="w-8 h-8 rounded-full bg-zinc-100 hover:bg-[#5865F2] hover:text-white transition flex items-center justify-center text-sm shadow-xs" aria-label="Discord">
                        <i class="fa-brands fa-discord"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-zinc-100 hover:bg-[#1877F2] hover:text-white transition flex items-center justify-center text-sm shadow-xs" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-zinc-100 hover:bg-[#E60023] hover:text-white transition flex items-center justify-center text-sm shadow-xs" aria-label="Pinterest">
                        <i class="fa-brands fa-pinterest-p"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-zinc-100 hover:bg-[#FF0000] hover:text-white transition flex items-center justify-center text-sm shadow-xs" aria-label="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-zinc-100 hover:bg-[#E1306C] hover:text-white transition flex items-center justify-center text-sm shadow-xs" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-zinc-100 hover:bg-black hover:text-white transition flex items-center justify-center text-sm shadow-xs" aria-label="X">
                        <i class="fa-brands fa-x-twitter"></i>
                    </a>
                    <a href="#" class="w-8 h-8 rounded-full bg-zinc-100 hover:bg-black hover:text-white transition flex items-center justify-center text-sm shadow-xs" aria-label="TikTok">
                        <i class="fa-brands fa-tiktok"></i>
                    </a>
                </div>

            </div>

            <!-- Bottom Legal Bar (Exact Company Name & Clean Country Selector) -->
            <div class="pt-6 border-t border-zinc-200 flex flex-col lg:flex-row items-center justify-between text-xs text-zinc-500 font-medium gap-4">
                <p class="text-center lg:text-left">
                    &copy; {{ date('Y') }} | SM Shop Fashion &amp; Apparel Ltd. | All Rights Reserved.
                </p>

                <div class="flex flex-wrap items-center justify-center gap-4 text-xs">
                    <a href="#" class="hover:text-black underline underline-offset-2">Terms & Conditions</a>
                    <a href="#" class="hover:text-black underline underline-offset-2">Terms of Use</a>
                    <a href="#" class="hover:text-black underline underline-offset-2">Privacy Notice</a>
                    <a href="#" class="hover:text-black underline underline-offset-2">Cookie Policy</a>
                    <a href="#" class="hover:text-black underline underline-offset-2">Modern Slavery</a>
                </div>

                <!-- Country Selector -->
                <div class="flex items-center gap-1.5 font-bold text-black text-xs cursor-pointer hover:underline">
                    <span class="text-base leading-none">🇺🇸</span>
                    <span>US | English</span>
                    <i class="fa-solid fa-chevron-down text-[9px] text-zinc-400"></i>
                </div>
            </div>

        </div>
    </footer>

</body>
</html>