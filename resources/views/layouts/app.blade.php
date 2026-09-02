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

    <!-- Modern Geometric & Clean Typography: Plus Jakarta Sans & Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Inter:ital,opsz,wght@0,14..32,400..800;1,14..32,400..800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js"></script>

    <!-- Vite Assets -->
    @if(file_exists(public_path('build/manifest.json')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <script src="https://cdn.tailwindcss.com"></script>
    @endif

    <style>
        [x-cloak] { display: none !important; }
        body, h1, h2, h3, h4, h5, h6, p, a, input, select, textarea, button, label, span:not(.fa-solid):not(.fa-regular):not(.fa-brands):not(.svg-inline--fa) {
            font-family: 'Plus Jakarta Sans', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif !important;
        }
    </style>
</head>
<body 
    x-data="storefrontApp()"
    class="relative min-h-screen bg-white text-black font-sans antialiased selection:bg-black selection:text-white"
>

    <!-- Top Announcement Ticker Bar -->
    <div id="nano-banner" class="bg-black text-white py-2 px-3 sm:px-4 text-center text-[11px] sm:text-xs font-bold tracking-wider relative z-50 flex items-center justify-center gap-2">
        <span>Free standard shipping over $75 | 30-day returns | Code: <span class="text-amber-300 font-black">SM20</span> (20% Off)</span>
    </div>

    <!-- =========================================================================
         1:1 AUTHENTIC GYMSHARK TOP HEADER & RESPONSIVE NAVIGATION
         ========================================================================= -->
    <header class="sticky top-0 z-40 bg-white border-b border-zinc-200" @mouseleave="megaMenu = null">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20 lg:h-24 relative">
                
                <!-- 1. Left (Desktop): Women, Men, Accessories Nav Links (Exact Gymshark Navigation) -->
                <nav class="hidden lg:flex items-center gap-6 xl:gap-8 text-xs font-bold tracking-wide text-black h-full">
                    
                    <!-- Women Tab -->
                    <div class="h-full flex items-center" @mouseenter="megaMenu = 'women'; activeSubTab = 'trending'">
                        <a 
                            href="{{ route('shop.index', ['category' => 'women']) }}" 
                            class="py-8 transition whitespace-nowrap border-b-2 hover:text-zinc-500 flex items-center"
                            :class="megaMenu === 'women' ? 'border-black text-black font-black' : 'border-transparent text-zinc-900 font-bold'"
                        >
                            Women
                        </a>
                    </div>

                    <!-- Men Tab -->
                    <div class="h-full flex items-center" @mouseenter="megaMenu = 'men'; activeSubTab = 'trending'">
                        <a 
                            href="{{ route('shop.index', ['category' => 'men']) }}" 
                            class="py-8 transition whitespace-nowrap border-b-2 hover:text-zinc-500 flex items-center"
                            :class="megaMenu === 'men' ? 'border-black text-black font-black' : 'border-transparent text-zinc-900 font-bold'"
                        >
                            Men
                        </a>
                    </div>

                    <!-- Accessories Tab -->
                    <div class="h-full flex items-center" @mouseenter="megaMenu = 'accessories'; activeSubTab = 'trending'">
                        <a 
                            href="{{ route('shop.index', ['category' => 'accessories']) }}" 
                            class="py-8 transition whitespace-nowrap border-b-2 hover:text-zinc-500 flex items-center"
                            :class="megaMenu === 'accessories' ? 'border-black text-black font-black' : 'border-transparent text-zinc-900 font-bold'"
                        >
                            Accessories
                        </a>
                    </div>
                </nav>

                <!-- 1. Left (Mobile & Tablet): Clean Hamburger Menu & Search Trigger -->
                <div class="flex lg:hidden items-center gap-1 sm:gap-2">
                    <button 
                        type="button" 
                        @click="mobileMenuOpen = true"
                        class="w-9 h-9 rounded-full flex items-center justify-center text-black hover:bg-zinc-100 transition cursor-pointer"
                        aria-label="Open navigation menu"
                    >
                        <i class="fa-solid fa-bars text-lg"></i>
                    </button>

                    <button 
                        type="button" 
                        @click="searchOpen = true; $nextTick(() => $refs.searchInput.focus())"
                        class="w-9 h-9 rounded-full flex items-center justify-center text-black hover:bg-zinc-100 transition cursor-pointer"
                        title="Search Activewear"
                    >
                        <i class="fa-solid fa-magnifying-glass text-base"></i>
                    </button>
                </div>

                <!-- 2. Center: Centered Authentic SM Shop Logo (Responsive Scaling) -->
                <a href="{{ route('home') }}" class="absolute left-1/2 -translate-x-1/2 flex items-center justify-center group py-1" aria-label="SM Shop">
                    <img src="{{ asset('images/logo.png') }}" alt="SM Shop" class="h-8 sm:h-12 lg:h-18 max-w-[150px] sm:max-w-[220px] lg:max-w-[320px] w-auto object-contain group-hover:scale-105 transition duration-300">
                </a>

                <!-- 3. Right: Desktop Search & Action Icons -->
                <div class="flex items-center gap-1.5 sm:gap-3 shrink-0">
                    
                    <!-- Desktop Search Bar -->
                    <div class="relative hidden lg:block w-48 xl:w-64">
                        <form action="{{ route('shop.index') }}" method="GET">
                            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-zinc-400 text-xs pointer-events-none"></i>
                            <input 
                                type="text" 
                                name="q" 
                                placeholder="What are you looking for tod..." 
                                class="w-full pl-9 pr-3 py-2 bg-zinc-100 hover:bg-zinc-200/70 focus:bg-white rounded-lg text-xs font-semibold text-black placeholder-zinc-400 focus:outline-none focus:ring-1 focus:ring-black transition"
                            >
                        </form>
                    </div>

                    <!-- Wishlist Icon -->
                    <a href="{{ route('shop.index') }}" class="w-8 sm:w-9 h-8 sm:h-9 rounded-full flex items-center justify-center text-black hover:bg-zinc-100 transition" title="Wishlist">
                        <i class="fa-regular fa-heart text-base sm:text-lg"></i>
                    </a>

                    <!-- Account / Admin Direct Icon -->
                    <a href="{{ route('admin.dashboard') }}" class="w-8 sm:w-9 h-8 sm:h-9 rounded-full flex items-center justify-center text-black hover:bg-zinc-100 transition" title="Account / Admin Panel">
                        <i class="fa-regular fa-user text-base sm:text-lg"></i>
                    </a>

                    <!-- Cart Bag Trigger -->
                    @php
                        $cart = session()->get('cart', []);
                        $cartCount = array_sum(array_column($cart, 'quantity'));
                    @endphp
                    <button 
                        type="button"
                        x-on:click="drawerOpen = true"
                        class="w-8 sm:w-9 h-8 sm:h-9 rounded-full flex items-center justify-center text-black hover:bg-zinc-100 transition relative cursor-pointer"
                        title="Shopping Bag"
                    >
                        <i class="fa-solid fa-bag-shopping text-base sm:text-lg"></i>
                        @if($cartCount > 0)
                            <span id="nav-cart-badge" class="absolute -top-1 -right-1 bg-[#1b84ff] text-white text-[10px] font-black w-4.5 h-4.5 rounded-full flex items-center justify-center border-2 border-white">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </button>
                </div>

            </div>
        </div>

        <!-- =====================================================================
             1:1 GYMSHARK 2-COLUMN MEGA MENU FLYOUT DROPDOWN (Desktop Only)
             ===================================================================== -->
        <div 
            x-show="megaMenu !== null" 
            x-transition:enter="transition ease-out duration-150"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-100"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1"
            class="hidden lg:block absolute top-full left-0 right-0 w-full bg-white border-b border-zinc-200 shadow-2xl z-40" 
            style="display: none;"
            @mouseenter="/* keep open */"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex min-h-[380px] max-h-[500px]">
                    
                    <!-- COLUMN 1: LEFT SUB-CATEGORY TABS -->
                    <div class="w-56 sm:w-64 border-r border-zinc-200 py-6 pr-4 overflow-y-auto space-y-1">
                        
                        <!-- ACCESSORIES TABS -->
                        <div x-show="megaMenu === 'accessories'" class="space-y-1">
                            <button 
                                @mouseenter="activeSubTab = 'trending'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'trending' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Trending</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'bags'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'bags' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Bags</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'equipment'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'equipment' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Equipment</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'socks'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'socks' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Socks</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'underwear'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'underwear' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Underwear</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'headwear'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'headwear' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Headwear</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'last-chance'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'last-chance' ? 'font-black text-red-600 bg-red-50' : 'font-semibold text-zinc-700 hover:text-red-600'"
                            >
                                <span>Last Chance</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                        </div>

                        <!-- WOMEN TABS -->
                        <div x-show="megaMenu === 'women'" class="space-y-1">
                            <button 
                                @mouseenter="activeSubTab = 'trending'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'trending' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Trending</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'leggings'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'leggings' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Leggings</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'sports-bras'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'sports-bras' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Sports Bras</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'hoodies'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'hoodies' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Hoodies & Sweatshirts</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'shorts'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'shorts' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Shorts</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                        </div>

                        <!-- MEN TABS -->
                        <div x-show="megaMenu === 'men'" class="space-y-1">
                            <button 
                                @mouseenter="activeSubTab = 'trending'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'trending' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Trending</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 't-shirts'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 't-shirts' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>T-Shirts & Tops</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'tanks'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'tanks' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Tanks & Stringers</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'hoodies'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'hoodies' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Hoodies & Sweatshirts</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                            <button 
                                @mouseenter="activeSubTab = 'joggers'" 
                                class="w-full text-left py-2.5 px-3 rounded-lg text-xs tracking-wide flex items-center justify-between transition cursor-pointer"
                                :class="activeSubTab === 'joggers' ? 'font-black text-black bg-zinc-100' : 'font-semibold text-zinc-700 hover:text-black'"
                            >
                                <span>Joggers & Sweatpants</span>
                                <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                            </button>
                        </div>

                    </div>

                    <!-- COLUMN 2: CENTER SUBCATEGORY ITEMS -->
                    <div class="w-72 sm:w-80 py-6 px-8 border-r border-zinc-200 overflow-y-auto space-y-3.5">
                        
                        <!-- ACCESSORIES SUBCATEGORIES -->
                        <div x-show="megaMenu === 'accessories'">
                            <div x-show="activeSubTab === 'trending'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'accessories']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All Accessories</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'sort' => 'latest']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">New Arrivals</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Back in Stock</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'sort' => 'popular']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Best Sellers</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Seasonal Accessories</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Running Accessories</a>
                            </div>

                            <div x-show="activeSubTab === 'bags'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'bag']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All Gym Bags</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'backpack']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Everyday Backpacks</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'duffle']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Duffle Bags</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'crossbody']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Crossbody & Waist Packs</a>
                            </div>

                            <div x-show="activeSubTab === 'equipment'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'lifting']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Lifting Belts & Straps</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'band']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Resistance Bands</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'bottle']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Water Bottles & Shakers</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'mat']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Yoga Mats</a>
                            </div>

                            <div x-show="activeSubTab === 'socks'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'socks']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All Socks</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'crew socks']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Crew Socks</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'quarter socks']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Quarter Socks</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'trainer socks']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Trainer Socks</a>
                            </div>

                            <div x-show="activeSubTab === 'underwear'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'underwear']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All Performance Underwear</a>
                                <a href="{{ route('shop.index', ['category' => 'briefs']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Sports Briefs & Thongs</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'boxers']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Seamless Boxers</a>
                            </div>

                            <div x-show="activeSubTab === 'headwear'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'cap']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All Headwear</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'trucker cap']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Dad Caps & Snapbacks</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'beanie']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Knit Beanies</a>
                            </div>

                            <div x-show="activeSubTab === 'last-chance'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'accessories', 'sort' => 'popular']) }}" class="block text-xs font-black text-red-600 hover:underline">Accessories Outlet Sale</a>
                                <a href="{{ route('shop.index', ['category' => 'accessories']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Final Stock Clearance</a>
                            </div>
                        </div>

                        <!-- WOMEN SUBCATEGORIES -->
                        <div x-show="megaMenu === 'women'">
                            <div x-show="activeSubTab === 'trending'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'women']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All Women's Apparel</a>
                                <a href="{{ route('shop.index', ['category' => 'seamless']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Vital Seamless 2.0</a>
                                <a href="{{ route('shop.index', ['category' => 'women', 'sort' => 'latest']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">New Releases</a>
                                <a href="{{ route('shop.index', ['category' => 'women', 'sort' => 'popular']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Best Sellers</a>
                                <a href="{{ route('shop.index', ['category' => 'women', 'q' => 'squat proof']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Squat-Proof Sets</a>
                            </div>

                            <div x-show="activeSubTab === 'leggings'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'women', 'q' => 'leggings']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All Leggings</a>
                                <a href="{{ route('shop.index', ['category' => 'seamless', 'q' => 'leggings']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">High Waisted Seamless</a>
                                <a href="{{ route('shop.index', ['category' => 'women', 'q' => 'pocket leggings']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Pocket Leggings</a>
                            </div>

                            <div x-show="activeSubTab === 'sports-bras'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'women', 'q' => 'bra']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All Sports Bras</a>
                                <a href="{{ route('shop.index', ['category' => 'women', 'q' => 'high support bra']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">High Support Bras</a>
                            </div>

                            <div x-show="activeSubTab === 'hoodies'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'hoodies-sweats']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All Hoodies & Sweats</a>
                                <a href="{{ route('shop.index', ['category' => 'hoodies-sweats', 'q' => 'oversized']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Oversized Pump Covers</a>
                            </div>

                            <div x-show="activeSubTab === 'shorts'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'women', 'q' => 'shorts']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All Cycling Shorts</a>
                                <a href="{{ route('shop.index', ['category' => 'seamless', 'q' => 'shorts']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Seamless Gym Shorts</a>
                            </div>
                        </div>

                        <!-- MEN SUBCATEGORIES -->
                        <div x-show="megaMenu === 'men'">
                            <div x-show="activeSubTab === 'trending'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'men']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All Men's Gymwear</a>
                                <a href="{{ route('shop.index', ['category' => 'men', 'q' => 'power']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Power Collection</a>
                                <a href="{{ route('shop.index', ['category' => 'men', 'q' => 'pump cover']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Heavyweight Pump Covers</a>
                                <a href="{{ route('shop.index', ['category' => 'men', 'sort' => 'latest']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">New Releases</a>
                                <a href="{{ route('shop.index', ['category' => 'men', 'sort' => 'popular']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Best Sellers</a>
                            </div>

                            <div x-show="activeSubTab === 't-shirts'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'men', 'q' => 't-shirt']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">All T-Shirts & Tops</a>
                                <a href="{{ route('shop.index', ['category' => 'men', 'q' => 'oversized tee']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Oversized T-Shirts</a>
                            </div>

                            <div x-show="activeSubTab === 'tanks'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'men', 'q' => 'stringer']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Drop Arm Stringers</a>
                                <a href="{{ route('shop.index', ['category' => 'men', 'q' => 'tank']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Workout Tanks & Vests</a>
                            </div>

                            <div x-show="activeSubTab === 'hoodies'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'hoodies-sweats', 'q' => 'men']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Heavyweight Pullover Hoodies</a>
                            </div>

                            <div x-show="activeSubTab === 'joggers'" class="space-y-3.5">
                                <a href="{{ route('shop.index', ['category' => 'men', 'q' => 'joggers']) }}" class="block text-xs font-bold text-zinc-900 hover:underline">Tapered Fit Joggers</a>
                            </div>
                        </div>

                    </div>

                    <!-- Right Empty Space inside container -->
                    <div class="flex-1 py-6 px-8 hidden md:block">
                        <div class="h-full flex items-center justify-end text-zinc-400 text-xs font-semibold">
                            <span class="hover:text-black cursor-pointer" @click="megaMenu = null">Press ESC to close &times;</span>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- Full-Page Dimming Backdrop for Mega Menu -->
        <div 
            x-show="megaMenu !== null" 
            @click="megaMenu = null"
            class="hidden lg:block fixed inset-0 top-[81px] sm:top-[97px] bg-black/40 backdrop-blur-xs z-30" 
            style="display: none;"
        ></div>

        <!-- Mobile Search Dropdown -->
        <div 
            x-show="searchOpen" 
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-2"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-2"
            @click.away="searchOpen = false"
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
                    placeholder="SEARCH ACTIVEWEAR, LEGGINGS, HOODIES..." 
                    class="flex-1 py-3 text-xs sm:text-sm font-bold text-black placeholder-zinc-400 uppercase border-none focus:outline-none focus:ring-0 bg-transparent"
                >
                <button type="button" @click="searchOpen = false" class="p-2 text-zinc-400 hover:text-black cursor-pointer">
                    <i class="fa-solid fa-xmark text-xl"></i>
                </button>
            </form>
        </div>
    </header>

    <!-- =========================================================================
         MOBILE CATEGORIES & NAVIGATION SLIDE-OVER DRAWER (FULL INTERACTIVE)
         ========================================================================= -->
    <div 
        x-show="mobileMenuOpen" 
        x-on:keydown.escape.window="mobileMenuOpen = false"
        class="fixed inset-0 z-50 overflow-hidden lg:hidden" 
        style="display: none;"
    >
        <!-- Backdrop -->
        <div 
            x-show="mobileMenuOpen"
            x-transition:enter="ease-in-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="ease-in-out duration-300"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/60 backdrop-blur-xs transition-opacity" 
            @click="mobileMenuOpen = false"
        ></div>

        <div class="fixed inset-y-0 left-0 max-w-full flex pr-10">
            <div 
                x-show="mobileMenuOpen"
                x-transition:enter="transform transition ease-in-out duration-300"
                x-transition:enter-start="-translate-x-full"
                x-transition:enter-end="translate-x-0"
                x-transition:leave="transform transition ease-in-out duration-300"
                x-transition:leave-start="translate-x-0"
                x-transition:leave-end="-translate-x-full"
                class="w-screen max-w-xs sm:max-w-sm bg-white shadow-2xl flex flex-col justify-between"
                x-data="{ mobileAccordion: 'women' }"
            >
                <!-- Drawer Header -->
                <div class="p-4 sm:p-5 border-b border-zinc-200 flex items-center justify-between bg-zinc-50">
                    <a href="{{ route('home') }}" @click="mobileMenuOpen = false">
                        <img src="{{ asset('images/logo.png') }}" alt="SM Shop" class="h-8 w-auto object-contain">
                    </a>
                    <button @click="mobileMenuOpen = false" class="w-8 h-8 rounded-full bg-zinc-200 text-zinc-600 hover:text-black flex items-center justify-center cursor-pointer">
                        <i class="fa-solid fa-xmark text-base"></i>
                    </button>
                </div>

                <!-- Drawer Content -->
                <div class="p-4 flex-1 overflow-y-auto space-y-2.5">
                    
                    <!-- 1. WOMEN ACCORDION -->
                    <div class="border border-zinc-200 rounded-2xl overflow-hidden shadow-2xs">
                        <button 
                            @click="mobileAccordion = mobileAccordion === 'women' ? null : 'women'" 
                            class="w-full p-3.5 text-left font-black text-xs uppercase tracking-wider flex items-center justify-between bg-zinc-50 hover:bg-zinc-100 transition cursor-pointer"
                        >
                            <span class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-black"></span> WOMEN
                            </span>
                            <i class="fa-solid text-[11px]" :class="mobileAccordion === 'women' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="mobileAccordion === 'women'" class="p-4 bg-white border-t border-zinc-200 space-y-3 text-xs font-bold text-zinc-800">
                            <a href="{{ route('shop.index', ['category' => 'women']) }}" class="block text-black font-black hover:underline pb-1 border-b border-zinc-100">&rarr; All Women's Apparel</a>
                            <a href="{{ route('shop.index', ['category' => 'seamless']) }}" class="block hover:underline">Vital Seamless 2.0</a>
                            <a href="{{ route('shop.index', ['category' => 'women', 'q' => 'leggings']) }}" class="block hover:underline">Leggings</a>
                            <a href="{{ route('shop.index', ['category' => 'women', 'q' => 'bra']) }}" class="block hover:underline">Sports Bras</a>
                            <a href="{{ route('shop.index', ['category' => 'hoodies-sweats']) }}" class="block hover:underline">Hoodies & Sweatshirts</a>
                            <a href="{{ route('shop.index', ['category' => 'women', 'q' => 'shorts']) }}" class="block hover:underline">Cycling Shorts</a>
                        </div>
                    </div>

                    <!-- 2. MEN ACCORDION -->
                    <div class="border border-zinc-200 rounded-2xl overflow-hidden shadow-2xs">
                        <button 
                            @click="mobileAccordion = mobileAccordion === 'men' ? null : 'men'" 
                            class="w-full p-3.5 text-left font-black text-xs uppercase tracking-wider flex items-center justify-between bg-zinc-50 hover:bg-zinc-100 transition cursor-pointer"
                        >
                            <span class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-black"></span> MEN
                            </span>
                            <i class="fa-solid text-[11px]" :class="mobileAccordion === 'men' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="mobileAccordion === 'men'" class="p-4 bg-white border-t border-zinc-200 space-y-3 text-xs font-bold text-zinc-800">
                            <a href="{{ route('shop.index', ['category' => 'men']) }}" class="block text-black font-black hover:underline pb-1 border-b border-zinc-100">&rarr; All Men's Gymwear</a>
                            <a href="{{ route('shop.index', ['category' => 'men', 'q' => 'power']) }}" class="block hover:underline">Power Collection</a>
                            <a href="{{ route('shop.index', ['category' => 'men', 'q' => 'pump cover']) }}" class="block hover:underline">Heavyweight Pump Covers</a>
                            <a href="{{ route('shop.index', ['category' => 'men', 'q' => 't-shirt']) }}" class="block hover:underline">T-Shirts & Tops</a>
                            <a href="{{ route('shop.index', ['category' => 'men', 'q' => 'tank']) }}" class="block hover:underline">Tanks & Stringers</a>
                            <a href="{{ route('shop.index', ['category' => 'men', 'q' => 'joggers']) }}" class="block hover:underline">Joggers & Sweatpants</a>
                        </div>
                    </div>

                    <!-- 3. ACCESSORIES ACCORDION -->
                    <div class="border border-zinc-200 rounded-2xl overflow-hidden shadow-2xs">
                        <button 
                            @click="mobileAccordion = mobileAccordion === 'accessories' ? null : 'accessories'" 
                            class="w-full p-3.5 text-left font-black text-xs uppercase tracking-wider flex items-center justify-between bg-zinc-50 hover:bg-zinc-100 transition cursor-pointer"
                        >
                            <span class="flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-black"></span> ACCESSORIES
                            </span>
                            <i class="fa-solid text-[11px]" :class="mobileAccordion === 'accessories' ? 'fa-chevron-up' : 'fa-chevron-down'"></i>
                        </button>
                        <div x-show="mobileAccordion === 'accessories'" class="p-4 bg-white border-t border-zinc-200 space-y-3 text-xs font-bold text-zinc-800">
                            <a href="{{ route('shop.index', ['category' => 'accessories']) }}" class="block text-black font-black hover:underline pb-1 border-b border-zinc-100">&rarr; All Accessories</a>
                            <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'bag']) }}" class="block hover:underline">Gym Bags & Backpacks</a>
                            <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'lifting']) }}" class="block hover:underline">Equipment & Lifting Straps</a>
                            <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'socks']) }}" class="block hover:underline">Performance Socks</a>
                            <a href="{{ route('shop.index', ['category' => 'accessories', 'q' => 'cap']) }}" class="block hover:underline">Headwear & Caps</a>
                        </div>
                    </div>

                    <!-- 4. QUICK LINKS -->
                    <div class="pt-2 space-y-2">
                        <a href="{{ route('shop.index', ['category' => 'seamless']) }}" class="p-3 bg-zinc-100 rounded-xl block font-bold text-xs text-zinc-900 hover:bg-zinc-200">
                            ⚡ Seamless Activewear Drop
                        </a>
                        <button 
                            type="button"
                            @click="mobileMenuOpen = false; toggleChat(); sendQuickPrompt('Track Order: SM-1001')" 
                            class="w-full p-3 bg-zinc-100 rounded-xl text-left font-bold text-xs text-zinc-900 hover:bg-zinc-200 flex items-center justify-between cursor-pointer"
                        >
                            <span>📦 Live Order Tracking</span>
                            <i class="fa-solid fa-chevron-right text-[10px] text-zinc-400"></i>
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="p-3 bg-black text-white rounded-xl flex items-center gap-2 font-bold text-xs hover:bg-zinc-800">
                            <i class="fa-solid fa-gauge-high text-xs"></i> Admin Control Panel
                        </a>
                    </div>

                </div>

                <!-- Drawer Bottom -->
                <div class="p-4 border-t border-zinc-200 bg-zinc-50 flex items-center justify-between text-xs font-bold text-zinc-600">
                    <span class="flex items-center gap-1.5"><span class="text-base">🌐</span> Region: <span x-text="selectedRegion"></span></span>
                    <a href="{{ route('shop.index') }}" class="underline text-black">Shop All &rarr;</a>
                </div>

            </div>
        </div>
    </div>

    <!-- Mobile Slide-Over Cart Drawer -->
    <div 
        x-show="drawerOpen" 
        x-on:keydown.escape.window="drawerOpen = false"
        class="fixed inset-0 z-50 overflow-hidden" 
        style="display: none;"
    >
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
                <div class="p-6 border-b border-zinc-200 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-bag-shopping text-black"></i>
                        <h3 class="font-bold text-black text-sm">Your Bag ({{ $cartCount }})</h3>
                    </div>
                    <button x-on:click="drawerOpen = false" class="p-1 rounded-lg text-zinc-400 hover:text-black">
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

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
                    <i class="fa-solid fa-circle-check text-emerald-400 text-base"></i>
                    <p>{{ session('success') }}</p>
                </div>
                <button onclick="this.parentElement.remove()" class="text-zinc-400 hover:text-white text-sm">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-900 text-white px-4 py-3 rounded-2xl flex items-center justify-between shadow-xs mb-4 text-xs font-semibold" role="alert">
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

    <!-- =========================================================================
         EXACT OFFICIAL GYMSHARK FOOTER (COLORFUL SOCIAL MEDIA ICONS)
         ========================================================================= -->
    <footer class="bg-white border-t border-zinc-200 text-black pt-16 pb-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="grid grid-cols-2 md:grid-cols-12 gap-8 lg:gap-12 mb-12 sm:mb-16">
                
                <!-- Col 1: Help -->
                <div class="col-span-1 md:col-span-2 space-y-4">
                    <h3 class="text-xs font-black text-black tracking-tight uppercase">Help</h3>
                    <ul class="space-y-2.5 text-xs text-zinc-600 font-semibold">
                        <li><a href="javascript:void(0)" @click="toggleChat()" class="hover:text-black hover:underline">FAQ & Live Chat</a></li>
                        <li><a href="javascript:void(0)" @click="toggleChat()" class="hover:text-black hover:underline">Track Your Order</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Delivery Information</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Returns Policy</a></li>
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-black hover:underline">Admin Control</a></li>
                    </ul>
                </div>

                <!-- Col 2: My Account -->
                <div class="col-span-1 md:col-span-2 space-y-4">
                    <h3 class="text-xs font-black text-black tracking-tight uppercase">My Account</h3>
                    <ul class="space-y-2.5 text-xs text-zinc-600 font-semibold">
                        <li><a href="{{ route('admin.dashboard') }}" class="hover:text-black hover:underline font-bold text-black flex items-center gap-1.5"><i class="fa-solid fa-gauge-high text-[11px]"></i> Admin Panel</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-black hover:underline">View Bag</a></li>
                        <li><a href="{{ route('checkout.index') }}" class="hover:text-black hover:underline">Checkout</a></li>
                    </ul>
                </div>

                <!-- Col 3: Pages -->
                <div class="col-span-2 sm:col-span-1 md:col-span-3 space-y-4">
                    <h3 class="text-xs font-black text-black tracking-tight uppercase">Pages</h3>
                    <ul class="space-y-2.5 text-xs text-zinc-600 font-semibold">
                        <li><a href="{{ route('shop.index') }}" class="hover:text-black hover:underline">Stores</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Refer a Friend</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">SM Shop Loyalty</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">About Us</a></li>
                        <li><a href="#" class="hover:text-black hover:underline">Careers</a></li>
                    </ul>
                </div>

                <!-- Col 4: More About SM Shop -->
                <div class="col-span-2 sm:col-span-2 md:col-span-5 space-y-3 sm:space-y-4">
                    <h3 class="text-xs font-black text-black tracking-tight uppercase">More About SM Shop</h3>
                    <div class="grid grid-cols-3 gap-2 sm:gap-3">
                        <a href="#" class="bg-[#f4f4f5] hover:bg-zinc-200 transition p-2.5 sm:p-4 rounded-xl flex flex-col items-center justify-center text-center space-y-2 group min-h-[95px]">
                            <span class="font-black text-[10px] sm:text-[13px] tracking-tight uppercase text-black">SM SHOP</span>
                            <span class="text-[10px] sm:text-xs font-bold text-black group-hover:underline">Blog</span>
                        </a>

                        <a href="#" class="bg-[#f4f4f5] hover:bg-zinc-200 transition p-2.5 sm:p-4 rounded-xl flex flex-col items-center justify-center text-center space-y-1.5 group min-h-[95px]">
                            <div class="w-6 h-6 rounded-full border-2 border-black flex items-center justify-center font-black text-[10px] text-black shrink-0">
                                %
                            </div>
                            <span class="text-[9.5px] sm:text-[11px] font-bold text-black leading-tight group-hover:underline">Students get 10% off</span>
                        </a>

                        <a href="#nano-banner" class="bg-[#f4f4f5] hover:bg-zinc-200 transition p-2.5 sm:p-4 rounded-xl flex flex-col items-center justify-center text-center space-y-1.5 group min-h-[95px]">
                            <i class="fa-regular fa-envelope text-base text-black"></i>
                            <span class="text-[10px] sm:text-xs font-bold text-black group-hover:underline">Email Sign Up</span>
                        </a>
                    </div>
                </div>

            </div>

            <!-- Middle Bar: Payment Methods & VIBRANT COLORFUL Social Media Icons -->
            <div class="pt-8 pb-6 border-t border-zinc-200 flex flex-col lg:flex-row items-center justify-between gap-6">
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
                </div>

                <!-- VIBRANT COLORFUL SOCIAL ICONS (100% Brand Colors) -->
                <div class="flex items-center gap-2.5">
                    <!-- Facebook -->
                    <a href="https://facebook.com" target="_blank" class="w-9 h-9 rounded-full bg-[#1877F2] text-white flex items-center justify-center text-sm shadow-md hover:scale-110 transition duration-200" title="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <!-- Instagram Gradient -->
                    <a href="https://instagram.com" target="_blank" class="w-9 h-9 rounded-full bg-gradient-to-tr from-[#f09433] via-[#dc2743] to-[#bc1888] text-white flex items-center justify-center text-sm shadow-md hover:scale-110 transition duration-200" title="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                    <!-- TikTok -->
                    <a href="https://tiktok.com" target="_blank" class="w-9 h-9 rounded-full bg-[#000000] text-white border border-zinc-700 flex items-center justify-center text-sm shadow-md hover:scale-110 transition duration-200" title="TikTok">
                        <i class="fa-brands fa-tiktok text-xs"></i>
                    </a>
                    <!-- YouTube -->
                    <a href="https://youtube.com" target="_blank" class="w-9 h-9 rounded-full bg-[#FF0000] text-white flex items-center justify-center text-sm shadow-md hover:scale-110 transition duration-200" title="YouTube">
                        <i class="fa-brands fa-youtube"></i>
                    </a>
                    <!-- WhatsApp -->
                    <a href="https://whatsapp.com" target="_blank" class="w-9 h-9 rounded-full bg-[#25D366] text-white flex items-center justify-center text-sm shadow-md hover:scale-110 transition duration-200" title="WhatsApp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>
                    <!-- Discord -->
                    <a href="https://discord.com" target="_blank" class="w-9 h-9 rounded-full bg-[#5865F2] text-white flex items-center justify-center text-sm shadow-md hover:scale-110 transition duration-200" title="Discord">
                        <i class="fa-brands fa-discord"></i>
                    </a>
                    <!-- Pinterest -->
                    <a href="https://pinterest.com" target="_blank" class="w-9 h-9 rounded-full bg-[#E60023] text-white flex items-center justify-center text-sm shadow-md hover:scale-110 transition duration-200" title="Pinterest">
                        <i class="fa-brands fa-pinterest-p"></i>
                    </a>
                </div>
            </div>

            <!-- Bottom Legal Bar -->
            <div class="pt-6 border-t border-zinc-200 flex flex-col lg:flex-row items-center justify-between text-xs text-zinc-500 font-medium gap-4">
                <p class="text-center lg:text-left">
                    &copy; {{ date('Y') }} | SM Shop Fashion &amp; Apparel Ltd. | All Rights Reserved.
                </p>

                <div class="flex items-center gap-1.5 font-bold text-black text-xs cursor-pointer hover:underline" @click="regionOpen = true">
                    <span class="text-base leading-none">🌐</span>
                    <span x-text="selectedRegion + ' | English'"></span>
                    <i class="fa-solid fa-chevron-up text-[9px] text-zinc-400"></i>
                </div>
            </div>

        </div>
    </footer>

    <!-- =========================================================================
         2. EXACT GYMSHARK FLOATING REGION SWITCHER (Desktop Only Floating)
         ========================================================================= -->
    <div 
        x-show="regionOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="hidden md:block bg-[#121212] text-white p-5 rounded-2xl shadow-2xl border border-zinc-800 w-80 max-w-[calc(100vw-2rem)]"
        style="position: fixed !important; bottom: 85px !important; right: 24px !important; z-index: 9999 !important; display: none;"
    >
        <div class="flex items-center justify-between mb-4">
            <span class="text-xs font-black tracking-wider uppercase">ARE YOU IN THE RIGHT PLACE?</span>
            <button @click="regionOpen = false" class="text-zinc-400 hover:text-white text-sm cursor-pointer p-1">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="space-y-2">
            <!-- Active Option: ROW -->
            <button 
                @click="selectedRegion = 'ROW'" 
                class="w-full py-2.5 px-4 rounded-lg text-xs font-bold flex items-center justify-between transition cursor-pointer"
                :class="selectedRegion === 'ROW' ? 'bg-white text-black font-black shadow-md' : 'bg-zinc-900 text-zinc-300 hover:bg-zinc-800'"
            >
                <div class="flex items-center gap-2.5">
                    <i class="fa-solid fa-globe text-sm"></i>
                    <span>ROW</span>
                </div>
                <i x-show="selectedRegion === 'ROW'" class="fa-solid fa-check text-xs"></i>
            </button>

            <!-- Flags row -->
            <div class="flex items-center gap-2 pt-1">
                <button 
                    @click="selectedRegion = 'US'" 
                    class="flex-1 py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition cursor-pointer"
                    :class="selectedRegion === 'US' ? 'bg-white text-black font-black' : 'bg-zinc-900 border border-zinc-800 text-zinc-300 hover:bg-zinc-800'"
                >
                    <span class="text-sm">🇺🇸</span>
                    <span>US</span>
                </button>
                <button 
                    @click="selectedRegion = 'UK'" 
                    class="flex-1 py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition cursor-pointer"
                    :class="selectedRegion === 'UK' ? 'bg-white text-black font-black' : 'bg-zinc-900 border border-zinc-800 text-zinc-300 hover:bg-zinc-800'"
                >
                    <span class="text-sm">🇬🇧</span>
                    <span>UK</span>
                </button>
                <button 
                    @click="selectedRegion = 'BD'" 
                    class="flex-1 py-2 px-3 rounded-lg text-xs font-bold flex items-center justify-center gap-2 transition cursor-pointer"
                    :class="selectedRegion === 'BD' ? 'bg-white text-black font-black' : 'bg-zinc-900 border border-zinc-800 text-zinc-300 hover:bg-zinc-800'"
                >
                    <span class="text-sm">🇧🇩</span>
                    <span>BD</span>
                </button>
            </div>
        </div>
    </div>

    <!-- =========================================================================
         3. SMART SM SHARK AI ASSISTANT CHATBOT WIDGET (100% REACTIVE)
         ========================================================================= -->
    
    <!-- Floating Chat Trigger Button (Fixed at Bottom-Right) -->
    <div style="position: fixed !important; bottom: 20px !important; right: 24px !important; z-index: 9999 !important;">
        <button 
            type="button" 
            @click="toggleChat()" 
            class="h-14 w-14 rounded-full bg-black text-white hover:bg-zinc-800 shadow-2xl flex items-center justify-center text-xl transition-transform duration-200 hover:scale-105 cursor-pointer relative border-2 border-white"
            title="Open SM Shark Assistant"
        >
            <i class="fa-solid" :class="chatOpen ? 'fa-xmark' : 'fa-headset'"></i>
            <span class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-500 border-2 border-white rounded-full"></span>
        </button>
    </div>

    <!-- Floating Chatbot Window -->
    <div 
        x-show="chatOpen" 
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 scale-95"
        class="w-88 sm:w-96 max-w-[calc(100vw-2rem)] bg-white border border-zinc-200 rounded-3xl shadow-2xl overflow-hidden flex flex-col h-[520px]"
        style="position: fixed !important; bottom: 85px !important; right: 24px !important; z-index: 9999 !important; display: none;"
    >
        <!-- Chat Header -->
        <div class="bg-black text-white p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-full bg-zinc-800 flex items-center justify-center text-white text-base">
                    <i class="fa-solid fa-bolt"></i>
                </div>
                <div>
                    <div class="text-xs font-black uppercase tracking-wider">SM Shark Assistant</div>
                    <div class="text-[10px] text-emerald-400 font-semibold flex items-center gap-1">
                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span> Online &bull; Instant Support
                    </div>
                </div>
            </div>
            <button @click="chatOpen = false" class="text-zinc-400 hover:text-white p-1 cursor-pointer">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>

        <!-- Chat Quick Actions / Chips -->
        <div class="p-3 bg-zinc-50 border-b border-zinc-200 flex items-center gap-1.5 overflow-x-auto text-[11px] font-bold">
            <button 
                type="button"
                @click="sendQuickPrompt('Track Order: SM-1001')" 
                class="px-2.5 py-1 bg-white border border-zinc-200 rounded-full hover:bg-black hover:text-white hover:border-black transition shrink-0 cursor-pointer"
            >
                📦 Track Order
            </button>
            <button 
                type="button"
                @click="sendQuickPrompt('What are the best-selling gym leggings?')" 
                class="px-2.5 py-1 bg-white border border-zinc-200 rounded-full hover:bg-black hover:text-white hover:border-black transition shrink-0 cursor-pointer"
            >
                🔥 Best Sellers
            </button>
            <button 
                type="button"
                @click="sendQuickPrompt('What is the promo code for discounts?')" 
                class="px-2.5 py-1 bg-white border border-zinc-200 rounded-full hover:bg-black hover:text-white hover:border-black transition shrink-0 cursor-pointer"
            >
                🏷️ Promo Codes
            </button>
            <button 
                type="button"
                @click="sendQuickPrompt('How long does shipping take?')" 
                class="px-2.5 py-1 bg-white border border-zinc-200 rounded-full hover:bg-black hover:text-white hover:border-black transition shrink-0 cursor-pointer"
            >
                🚚 Shipping Time
            </button>
        </div>

        <!-- Chat Conversation Messages Scroll Container -->
        <div id="chat-messages-container" class="flex-1 p-4 overflow-y-auto space-y-3 bg-white text-xs">
            <template x-for="(msg, idx) in chatMessages" :key="idx">
                <div :class="msg.sender === 'user' ? 'flex justify-end' : 'flex justify-start'">
                    <div 
                        class="max-w-[80%] p-3 rounded-2xl leading-relaxed"
                        :class="msg.sender === 'user' ? 'bg-black text-white rounded-br-none font-semibold' : 'bg-zinc-100 text-zinc-800 rounded-bl-none font-medium border border-zinc-200'"
                    >
                        <span x-html="msg.text"></span>
                    </div>
                </div>
            </template>

            <!-- Typing indicator -->
            <div x-show="isTyping" class="flex justify-start" style="display: none;">
                <div class="bg-zinc-100 text-zinc-500 p-3 rounded-2xl rounded-bl-none border border-zinc-200 flex items-center gap-1.5">
                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-400 animate-bounce"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-400 animate-bounce" style="animation-delay: 0.2s"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-zinc-400 animate-bounce" style="animation-delay: 0.4s"></span>
                </div>
            </div>
        </div>

        <!-- Chat Input Form -->
        <form 
            @submit.prevent="handleChatSubmit()" 
            class="p-3 border-t border-zinc-200 bg-zinc-50 flex items-center gap-2"
        >
            <input 
                type="text" 
                x-model="chatInput" 
                placeholder="Ask about activewear, sizing, or order..." 
                class="flex-1 px-3.5 py-2.5 bg-white border border-zinc-200 rounded-full text-xs font-semibold focus:outline-none focus:border-black transition"
            >
            <button 
                type="submit" 
                class="w-9 h-9 rounded-full bg-black text-white hover:bg-zinc-800 flex items-center justify-center transition shrink-0 cursor-pointer"
            >
                <i class="fa-solid fa-paper-plane text-xs"></i>
            </button>
        </form>
    </div>

    <!-- Storefront App & Chatbot Core Script -->
    <script>
        function storefrontApp() {
            return {
                drawerOpen: false,
                mobileMenuOpen: false,
                searchOpen: false,
                megaMenu: null,
                activeSubTab: 'trending',
                regionOpen: true,
                selectedRegion: 'ROW',
                chatOpen: false,
                chatMessages: [
                    { sender: 'bot', text: '👋 Hi there! Welcome to SM Shop. How can I help you today? You can track an order, explore drops, or get promo codes!' }
                ],
                chatInput: '',
                isTyping: false,

                toggleChat() {
                    this.chatOpen = !this.chatOpen;
                    if (this.chatOpen) {
                        this.$nextTick(() => {
                            const el = document.getElementById('chat-messages-container');
                            if (el) el.scrollTop = el.scrollHeight;
                        });
                    }
                },

                sendQuickPrompt(prompt) {
                    this.chatInput = prompt;
                    this.handleChatSubmit();
                },

                async handleChatSubmit() {
                    const text = this.chatInput.trim();
                    if (!text) return;

                    this.chatMessages.push({ sender: 'user', text: text });
                    this.chatInput = '';
                    this.isTyping = true;
                    
                    this.$nextTick(() => {
                        const el = document.getElementById('chat-messages-container');
                        if (el) el.scrollTop = el.scrollHeight;
                    });

                    const lower = text.toLowerCase();

                    // 1. Order tracking logic
                    if (lower.includes('track') || lower.includes('sm-') || lower.includes('order')) {
                        const match = text.match(/SM-\d+/i);
                        if (match) {
                            const orderNum = match[0].toUpperCase();
                            try {
                                const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                                const res = await fetch('/api/track-order', {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                        'X-CSRF-TOKEN': token || ''
                                    },
                                    body: JSON.stringify({ order_number: orderNum })
                                });
                                const result = await res.json();
                                this.isTyping = false;
                                if (result.found) {
                                    this.chatMessages.push({
                                        sender: 'bot',
                                        text: `📦 <strong>Order Found:</strong> ${result.order_number}<br>
                                               <strong>Status:</strong> <span class="text-emerald-600 font-black">${result.status}</span><br>
                                               <strong>Courier:</strong> ${result.courier}<br>
                                               <strong>Consignment ID:</strong> ${result.consignment}<br>
                                               <strong>Total:</strong> ${result.amount}<br>
                                               <strong>Date:</strong> ${result.date}`
                                    });
                                } else {
                                    this.chatMessages.push({
                                        sender: 'bot',
                                        text: `⚠️ Order <strong>${orderNum}</strong> was not found in our live system. Please double check the order number on your confirmation receipt.`
                                    });
                                }
                            } catch (e) {
                                this.isTyping = false;
                                this.chatMessages.push({
                                    sender: 'bot',
                                    text: `Your order <strong>${orderNum}</strong> is confirmed and being prepared for express courier dispatch!`
                                });
                            }
                        } else {
                            setTimeout(() => {
                                this.isTyping = false;
                                this.chatMessages.push({
                                    sender: 'bot',
                                    text: 'Please type your order number (e.g. <strong>SM-1001</strong>) so I can fetch your live tracking status.'
                                });
                            }, 500);
                        }
                    } 
                    // 2. Best sellers / leggings
                    else if (lower.includes('best') || lower.includes('legging') || lower.includes('recommend') || lower.includes('women')) {
                        setTimeout(() => {
                            this.isTyping = false;
                            this.chatMessages.push({
                                sender: 'bot',
                                text: '🔥 Our #1 Best Seller is the <strong>Vital Seamless 2.0 High Waisted Leggings</strong>! Features squat-proof compression and sweat-wicking technology. <a href="/shop?category=seamless" class="underline font-bold text-black block mt-1">Explore Seamless &rarr;</a>'
                            });
                        }, 500);
                    } 
                    // 3. Promo code
                    else if (lower.includes('promo') || lower.includes('coupon') || lower.includes('code') || lower.includes('discount')) {
                        setTimeout(() => {
                            this.isTyping = false;
                            this.chatMessages.push({
                                sender: 'bot',
                                text: '🎉 Use coupon code <strong class="text-indigo-600 font-black">SM20</strong> at checkout to get an instant <strong>20% OFF</strong> on your order!'
                            });
                        }, 500);
                    } 
                    // 4. Shipping / Delivery
                    else if (lower.includes('ship') || lower.includes('deliver') || lower.includes('time')) {
                        setTimeout(() => {
                            this.isTyping = false;
                            this.chatMessages.push({
                                sender: 'bot',
                                text: '🚚 We offer <strong>Free Standard Shipping</strong> on all orders over $75. Standard delivery takes 2-4 business days via Steadfast / DHL express.'
                            });
                        }, 500);
                    }
                    // 5. Default Fallback
                    else {
                        setTimeout(() => {
                            this.isTyping = false;
                            this.chatMessages.push({
                                sender: 'bot',
                                text: 'Thanks for reaching out! You can browse all gym apparel in our <a href="/shop" class="underline font-bold text-black">Shop Catalog</a> or check the <a href="/admin" class="underline font-bold text-black">Admin Panel</a> for backend management.'
                            });
                        }, 500);
                    }

                    this.$nextTick(() => {
                        const el = document.getElementById('chat-messages-container');
                        if (el) el.scrollTop = el.scrollHeight;
                    });
                }
            };
        }
    </script>

    @stack('scripts')
</body>
</html>