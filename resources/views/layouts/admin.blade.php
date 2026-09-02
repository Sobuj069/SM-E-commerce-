<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#0f172a]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Executive Dashboard') - Metronic Demo 1 | SM Shop</title>

    <!-- Inter Google Font & FontAwesome 6 -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        /* Custom Metronic Scrollbar */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #0f172a; }
        ::-webkit-scrollbar-thumb { background: #334155; border-radius: 9999px; }
        ::-webkit-scrollbar-thumb:hover { background: #475569; }
    </style>
</head>
<body 
    class="h-full bg-[#0b0f19] text-slate-200 font-sans antialiased overflow-x-hidden selection:bg-indigo-600 selection:text-white"
    x-data="{ 
        sidebarOpen: false, 
        sidebarCollapsed: false,
        profileMenuOpen: false,
        notifMenuOpen: false,
        searchModalOpen: false,
        activeMenu: '{{ request()->routeIs('admin.dashboard') ? 'dashboards' : (request()->routeIs('admin.products.*') || request()->routeIs('admin.orders.*') ? 'ecommerce' : 'dashboards') }}'
    }"
    @keydown.window.escape="profileMenuOpen = false; notifMenuOpen = false; searchModalOpen = false;"
    @keydown.window.ctrl.k.prevent="searchModalOpen = true"
    @keydown.window.cmd.k.prevent="searchModalOpen = true"
>
    
    <div class="min-h-full flex flex-row">
        
        <!-- =====================================================================
             1. METRONIC DEMO 1 AUTHENTIC DARK SIDEBAR (#0f172a / #111827)
             ===================================================================== -->
        <aside 
            class="bg-[#0f172a] border-r border-slate-800 flex flex-col justify-between shrink-0 fixed inset-y-0 left-0 z-50 lg:static transition-all duration-300 ease-in-out shadow-2xl lg:shadow-none"
            :class="{
                'w-72': !sidebarCollapsed,
                'w-20': sidebarCollapsed,
                'translate-x-0': sidebarOpen,
                '-translate-x-full lg:translate-x-0': !sidebarOpen
            }"
        >
            <div class="flex flex-col h-full">
                
                <!-- Sidebar Header: Logo & Collapse Toggle -->
                <div class="h-20 flex items-center justify-between px-5 border-b border-slate-800/80 bg-[#090d16]">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group overflow-hidden">
                        <img src="{{ asset('images/logo.png') }}" alt="SM Shop Logo" class="h-9 w-auto object-contain shrink-0 drop-shadow-sm">
                        <div x-show="!sidebarCollapsed" class="transition-opacity duration-200 min-w-0">
                            <div class="font-black text-sm text-white tracking-tight uppercase flex items-center gap-1.5 truncate">
                                <span>SM SHOP</span>
                                <span class="px-1.5 py-0.2 rounded bg-indigo-500/20 text-indigo-400 text-[9px] font-black border border-indigo-500/30">PRO</span>
                            </div>
                            <div class="text-[9.5px] font-bold text-slate-400 tracking-wider uppercase flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                <span>Metronic Demo 1</span>
                            </div>
                        </div>
                    </a>

                    <!-- Sidebar Toggle Button (Desktop & Mobile) -->
                    <div class="flex items-center gap-1">
                        <button 
                            type="button" 
                            @click="sidebarCollapsed = !sidebarCollapsed" 
                            class="hidden lg:flex w-7 h-7 rounded-lg items-center justify-center text-slate-400 hover:text-white hover:bg-slate-800 transition cursor-pointer"
                            title="Toggle Sidebar width"
                        >
                            <i class="fa-solid fa-angles-left text-xs transition-transform duration-300" :class="{ 'rotate-180': sidebarCollapsed }"></i>
                        </button>
                        <button 
                            type="button" 
                            @click="sidebarOpen = false" 
                            class="lg:hidden p-2 text-slate-400 hover:text-white rounded-lg hover:bg-slate-800"
                        >
                            <i class="fa-solid fa-xmark text-base"></i>
                        </button>
                    </div>
                </div>

                <!-- Global Quick Search Trigger in Sidebar -->
                <div x-show="!sidebarCollapsed" class="px-4 pt-5 pb-2">
                    <button 
                        type="button" 
                        @click="searchModalOpen = true" 
                        class="w-full px-3.5 py-2.5 rounded-xl bg-slate-900/90 border border-slate-800 hover:border-slate-700 text-slate-400 hover:text-slate-200 text-xs font-semibold flex items-center justify-between transition cursor-pointer shadow-inner"
                    >
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-magnifying-glass text-slate-500 text-xs"></i>
                            <span>Search dashboard...</span>
                        </div>
                        <kbd class="px-1.5 py-0.5 rounded bg-slate-800 border border-slate-700 text-[10px] font-mono text-slate-400 font-bold">⌘K</kbd>
                    </button>
                </div>

                <!-- Sidebar Navigation Menu -->
                <div class="flex-1 overflow-y-auto px-3.5 py-4 space-y-6 scrollbar-thin scrollbar-thumb-slate-800">
                    
                    <!-- GROUP 1: DASHBOARDS -->
                    <div class="space-y-1">
                        <div x-show="!sidebarCollapsed" class="px-3 text-[10px] font-black uppercase tracking-wider text-slate-500">
                            Dashboards
                        </div>

                        <!-- Active Dashboard Pill -->
                        <a 
                            href="{{ route('admin.dashboard') }}" 
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition group relative {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                        >
                            <i class="fa-solid fa-gauge-high text-sm shrink-0 {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-indigo-400 group-hover:text-white' }}"></i>
                            <span x-show="!sidebarCollapsed" class="truncate">Executive Analytics</span>
                            <span x-show="!sidebarCollapsed" class="ml-auto px-2 py-0.5 rounded-full text-[9px] font-black bg-indigo-500/20 text-indigo-300">Live</span>
                        </a>
                    </div>

                    <!-- GROUP 2: ECOMMERCE & STORE -->
                    <div class="space-y-1">
                        <div x-show="!sidebarCollapsed" class="px-3 text-[10px] font-black uppercase tracking-wider text-slate-500">
                            eCommerce & Catalog
                        </div>

                        <!-- Products Catalog -->
                        <a 
                            href="{{ route('admin.products.index') }}" 
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('admin.products.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                        >
                            <i class="fa-solid fa-box text-sm shrink-0 {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-amber-400 group-hover:text-white' }}"></i>
                            <span x-show="!sidebarCollapsed" class="truncate">Product Catalog</span>
                        </a>

                        <!-- Orders & Sales -->
                        <a 
                            href="{{ route('admin.orders.index') }}" 
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                        >
                            <i class="fa-solid fa-bag-shopping text-sm shrink-0 {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-emerald-400 group-hover:text-white' }}"></i>
                            <span x-show="!sidebarCollapsed" class="truncate">Orders & Invoices</span>
                        </a>

                        <!-- Coupon Engine -->
                        <a 
                            href="{{ route('admin.coupons.index') }}" 
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('admin.coupons.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                        >
                            <i class="fa-solid fa-ticket text-sm shrink-0 {{ request()->routeIs('admin.coupons.*') ? 'text-white' : 'text-rose-400 group-hover:text-white' }}"></i>
                            <span x-show="!sidebarCollapsed" class="truncate">Coupon Engine</span>
                        </a>

                        <!-- Review Moderation -->
                        <a 
                            href="{{ route('admin.reviews.index') }}" 
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold transition group {{ request()->routeIs('admin.reviews.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}"
                        >
                            <i class="fa-solid fa-star-half-stroke text-sm shrink-0 {{ request()->routeIs('admin.reviews.*') ? 'text-white' : 'text-yellow-400 group-hover:text-white' }}"></i>
                            <span x-show="!sidebarCollapsed" class="truncate">Review Moderation</span>
                        </a>
                    </div>

                    <!-- GROUP 3: CHANNELS & SHORTCUTS -->
                    <div class="space-y-1">
                        <div x-show="!sidebarCollapsed" class="px-3 text-[10px] font-black uppercase tracking-wider text-slate-500">
                            Storefront Channels
                        </div>

                        <a 
                            href="{{ route('home') }}" 
                            target="_blank" 
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-400 hover:text-white hover:bg-slate-800/60 transition group"
                        >
                            <i class="fa-solid fa-store text-sm shrink-0 text-cyan-400 group-hover:text-white"></i>
                            <span x-show="!sidebarCollapsed" class="truncate">Live Storefront</span>
                            <i x-show="!sidebarCollapsed" class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-auto text-slate-500"></i>
                        </a>

                        <a 
                            href="{{ route('shop.index') }}" 
                            target="_blank" 
                            class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-xs font-bold text-slate-400 hover:text-white hover:bg-slate-800/60 transition group"
                        >
                            <i class="fa-solid fa-compass text-sm shrink-0 text-violet-400 group-hover:text-white"></i>
                            <span x-show="!sidebarCollapsed" class="truncate">Catalog Explorer</span>
                        </a>
                    </div>

                </div>

                <!-- Sidebar Footer: Profile Card & Logout -->
                <div class="p-3 border-t border-slate-800/80 bg-[#090d16]">
                    <div class="flex items-center justify-between p-2.5 rounded-xl bg-[#0f172a] border border-slate-800">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 via-indigo-600 to-violet-600 flex items-center justify-center text-xs font-black text-white shrink-0 shadow-md">
                                SA
                            </div>
                            <div x-show="!sidebarCollapsed" class="min-w-0">
                                <div class="text-xs font-black text-white truncate">SM Administrator</div>
                                <div class="text-[10px] text-emerald-400 font-bold flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Online
                                </div>
                            </div>
                        </div>

                        <!-- Sign Out Form -->
                        <form action="{{ route('admin.logout') }}" method="POST" x-show="!sidebarCollapsed">
                            @csrf
                            <button 
                                type="submit" 
                                title="Sign Out" 
                                class="p-2 text-slate-400 hover:text-rose-400 hover:bg-slate-800 rounded-lg transition cursor-pointer"
                            >
                                <i class="fa-solid fa-right-from-bracket text-xs"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </aside>

        <!-- Background Overlay for Mobile Sidebar -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/70 z-40 lg:hidden"
            style="display: none;"
        ></div>

        <!-- =====================================================================
             2. MAIN CONTENT CANVAS & METRONIC TOPBAR
             ===================================================================== -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Metronic Topbar Header -->
            <header class="h-20 bg-[#0f172a]/90 backdrop-blur-md border-b border-slate-800/80 px-4 sm:px-8 flex items-center justify-between sticky top-0 z-30 shadow-md">
                
                <!-- Left: Mobile Toggle & Breadcrumb Title -->
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        @click="sidebarOpen = true" 
                        class="lg:hidden p-2.5 rounded-xl bg-slate-900 border border-slate-800 text-slate-400 hover:text-white"
                    >
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>

                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 text-[11px] text-slate-500 font-bold uppercase tracking-wider">
                            <span>Admin</span>
                            <span>/</span>
                            <span class="text-indigo-400">@yield('breadcrumb', 'Dashboard')</span>
                        </div>
                        <h2 class="text-base sm:text-lg font-black text-white tracking-tight leading-tight">
                            @yield('title', 'Executive Overview')
                        </h2>
                    </div>
                </div>

                <!-- Right: Quick Actions, Notifications & Profile Menu -->
                <div class="flex items-center gap-3">
                    
                    <!-- Search Hotkey Button -->
                    <button 
                        type="button" 
                        @click="searchModalOpen = true" 
                        class="hidden sm:flex items-center gap-2 px-3 py-2 rounded-xl bg-slate-900 border border-slate-800 text-xs text-slate-400 hover:text-white transition cursor-pointer"
                    >
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                        <span>Search</span>
                        <kbd class="px-1.5 py-0.5 rounded bg-slate-800 text-[10px] font-mono text-slate-400 font-bold">⌘K</kbd>
                    </button>

                    <!-- Storefront Button -->
                    <a 
                        href="{{ route('home') }}" 
                        target="_blank"
                        class="hidden md:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-slate-900 hover:bg-slate-800 border border-slate-800 text-xs font-bold text-slate-300 hover:text-white transition"
                    >
                        <i class="fa-solid fa-store text-xs text-indigo-400"></i>
                        <span>Live Store</span>
                    </a>

                    <!-- Add Product Button -->
                    <a 
                        href="{{ route('admin.products.create') }}" 
                        class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black transition shadow-md shadow-indigo-600/30 flex items-center gap-1.5"
                    >
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span class="hidden sm:inline">Add Product</span>
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button 
                            type="button" 
                            @click="profileMenuOpen = !profileMenuOpen" 
                            class="flex items-center gap-2 p-1.5 rounded-xl bg-slate-900 border border-slate-800 hover:border-indigo-500/50 transition cursor-pointer"
                        >
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center text-xs font-black text-white shadow-xs">
                                SA
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-slate-400 pr-1"></i>
                        </button>

                        <div 
                            x-show="profileMenuOpen" 
                            @click.away="profileMenuOpen = false" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-56 bg-[#0f172a] border border-slate-800 rounded-xl p-2 shadow-2xl z-50 space-y-1 text-xs"
                            style="display: none;"
                        >
                            <div class="px-3 py-2 border-b border-slate-800 mb-1">
                                <div class="font-bold text-white">SM Administrator</div>
                                <div class="text-[10px] text-slate-400 font-mono">admin@smcloudit.top</div>
                            </div>

                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition">
                                <i class="fa-solid fa-chart-pie text-indigo-400 text-xs"></i>
                                <span>Dashboard Analytics</span>
                            </a>

                            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-slate-300 hover:text-white hover:bg-slate-800 transition">
                                <i class="fa-solid fa-box text-amber-400 text-xs"></i>
                                <span>Product Catalog</span>
                            </a>

                            <form action="{{ route('admin.logout') }}" method="POST" class="pt-1 border-t border-slate-800">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition text-left cursor-pointer font-bold">
                                    <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                    <span>Sign Out</span>
                                </button>
                            </form>
                        </div>
                    </div>

                </div>

            </header>

            <!-- Notification Messages -->
            @if(session('success'))
                <div class="m-6 mb-0 p-4 rounded-xl bg-emerald-950/70 border border-emerald-500/30 text-emerald-300 text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="m-6 mb-0 p-4 rounded-xl bg-rose-950/70 border border-rose-500/30 text-rose-300 text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Main Page Content Slot -->
            <main class="p-4 sm:p-8 flex-1">
                @yield('content')
            </main>

        </div>

    </div>

    <!-- Quick Search Command Modal (⌘K) -->
    <div 
        x-show="searchModalOpen" 
        class="fixed inset-0 z-50 flex items-start justify-center pt-24 p-4 bg-black/70 backdrop-blur-xs" 
        style="display: none;"
    >
        <div 
            @click.away="searchModalOpen = false" 
            class="bg-[#0f172a] border border-slate-800 rounded-2xl w-full max-w-xl shadow-2xl overflow-hidden"
        >
            <div class="p-4 border-b border-slate-800 flex items-center gap-3">
                <i class="fa-solid fa-magnifying-glass text-slate-400 text-sm"></i>
                <input 
                    type="text" 
                    placeholder="Search activewear catalog, orders, coupons..." 
                    class="w-full bg-transparent border-none text-white text-xs font-bold focus:outline-none placeholder-slate-500"
                    autofocus
                >
                <kbd class="px-2 py-1 rounded bg-slate-800 text-[10px] font-mono text-slate-400">ESC</kbd>
            </div>
            <div class="p-4 space-y-2 text-xs">
                <div class="text-[10px] font-bold text-slate-500 uppercase">Quick Jump</div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-slate-800 text-slate-300 hover:text-white transition">
                    <i class="fa-solid fa-chart-pie text-indigo-400"></i> Executive Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-slate-800 text-slate-300 hover:text-white transition">
                    <i class="fa-solid fa-box text-amber-400"></i> Activewear Catalog
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-slate-800 text-slate-300 hover:text-white transition">
                    <i class="fa-solid fa-bag-shopping text-emerald-400"></i> Customer Orders
                </a>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>