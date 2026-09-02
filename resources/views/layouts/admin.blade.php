<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#151521]">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - SM Shop Metronic Hub</title>

    <!-- Inter Variable Typography & FontAwesome -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body 
    class="h-full bg-[#151521] text-gray-200 font-sans antialiased overflow-x-hidden selection:bg-indigo-600 selection:text-white"
    x-data="{ sidebarOpen: false, profileDropdown: false }"
>
    
    <div class="min-h-full flex">
        
        <!-- =====================================================================
             1. METRONIC DEMO 1 DARK SIDEBAR (Authentic #1e1e2d / #151521)
             ===================================================================== -->
        <aside 
            class="w-72 bg-[#1e1e2d] border-r border-[#2b2b40] flex flex-col justify-between shrink-0 fixed inset-y-0 left-0 z-50 lg:static transition-transform duration-300 ease-in-out shadow-2xl lg:shadow-none"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0'"
        >
            <div class="flex flex-col h-full">
                
                <!-- Sidebar Header: Logo & Branding -->
                <div class="h-20 flex items-center justify-between px-6 border-b border-[#2b2b40] bg-[#1a1a27]">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 group">
                        <img src="{{ asset('images/logo.png') }}" alt="SM Shop Logo" class="h-9 w-auto object-contain">
                        <div>
                            <div class="font-black text-sm text-white tracking-tight uppercase group-hover:text-indigo-400 transition">SM SHOP</div>
                            <div class="text-[9px] font-bold text-indigo-400 uppercase tracking-widest flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                                Metronic Core
                            </div>
                        </div>
                    </a>

                    <!-- Mobile Close Button -->
                    <button 
                        type="button" 
                        @click="sidebarOpen = false" 
                        class="lg:hidden p-2 text-gray-400 hover:text-white rounded-lg hover:bg-[#2b2b40]"
                    >
                        <i class="fa-solid fa-xmark text-lg"></i>
                    </button>
                </div>

                <!-- Sidebar Navigation Menu Links -->
                <div class="flex-1 overflow-y-auto px-4 py-6 space-y-6 scrollbar-thin scrollbar-thumb-zinc-700">
                    
                    <!-- Section 1: DASHBOARDS -->
                    <div class="space-y-1">
                        <div class="px-3 text-[10px] font-black uppercase tracking-wider text-gray-500">
                            Dashboards
                        </div>
                        <a 
                            href="{{ route('admin.dashboard') }}" 
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-gray-400 hover:text-white hover:bg-[#2b2b40]/60' }}"
                        >
                            <i class="fa-solid fa-chart-pie text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-indigo-400' }}"></i>
                            <span>Executive Analytics</span>
                            <span class="ml-auto px-2 py-0.5 rounded-full text-[9px] font-black bg-indigo-500/20 text-indigo-300">Live</span>
                        </a>
                    </div>

                    <!-- Section 2: ECOMMERCE MANAGEMENT -->
                    <div class="space-y-1">
                        <div class="px-3 text-[10px] font-black uppercase tracking-wider text-gray-500">
                            eCommerce Management
                        </div>

                        <!-- Products -->
                        <a 
                            href="{{ route('admin.products.index') }}" 
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.products.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-gray-400 hover:text-white hover:bg-[#2b2b40]/60' }}"
                        >
                            <i class="fa-solid fa-box text-sm {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-amber-400' }}"></i>
                            <span>Catalog & Products</span>
                        </a>

                        <!-- Orders -->
                        <a 
                            href="{{ route('admin.orders.index') }}" 
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-gray-400 hover:text-white hover:bg-[#2b2b40]/60' }}"
                        >
                            <i class="fa-solid fa-bag-shopping text-sm {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-emerald-400' }}"></i>
                            <span>Orders & Invoices</span>
                        </a>

                        <!-- Coupons -->
                        <a 
                            href="{{ route('admin.coupons.index') }}" 
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.coupons.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-gray-400 hover:text-white hover:bg-[#2b2b40]/60' }}"
                        >
                            <i class="fa-solid fa-ticket text-sm {{ request()->routeIs('admin.coupons.*') ? 'text-white' : 'text-rose-400' }}"></i>
                            <span>Coupon Engine</span>
                        </a>

                        <!-- Reviews -->
                        <a 
                            href="{{ route('admin.reviews.index') }}" 
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold transition {{ request()->routeIs('admin.reviews.*') ? 'bg-indigo-600 text-white shadow-lg shadow-indigo-600/30' : 'text-gray-400 hover:text-white hover:bg-[#2b2b40]/60' }}"
                        >
                            <i class="fa-solid fa-star-half-stroke text-sm {{ request()->routeIs('admin.reviews.*') ? 'text-white' : 'text-yellow-400' }}"></i>
                            <span>Review Moderation</span>
                        </a>
                    </div>

                    <!-- Section 3: CHANNELS & SHORTCUTS -->
                    <div class="space-y-1">
                        <div class="px-3 text-[10px] font-black uppercase tracking-wider text-gray-500">
                            Storefront Channels
                        </div>

                        <a 
                            href="{{ route('home') }}" 
                            target="_blank" 
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-gray-400 hover:text-white hover:bg-[#2b2b40]/60 transition"
                        >
                            <i class="fa-solid fa-store text-sm text-cyan-400"></i>
                            <span>Live Storefront</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-auto text-gray-500"></i>
                        </a>

                        <a 
                            href="{{ route('shop.index') }}" 
                            target="_blank" 
                            class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold text-gray-400 hover:text-white hover:bg-[#2b2b40]/60 transition"
                        >
                            <i class="fa-solid fa-compass text-sm text-violet-400"></i>
                            <span>Catalog Explorer</span>
                        </a>
                    </div>

                </div>

                <!-- Sidebar Footer: Admin Profile & Logout -->
                <div class="p-4 border-t border-[#2b2b40] bg-[#1a1a27]">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-[#151521] border border-[#2b2b40]">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center text-xs font-black text-white shrink-0 shadow-md">
                                SA
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs font-black text-white truncate">SM Administrator</div>
                                <div class="text-[10px] text-emerald-400 font-bold flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Online
                                </div>
                            </div>
                        </div>

                        <!-- Logout Icon Button -->
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button 
                                type="submit" 
                                title="Sign Out" 
                                class="p-2 text-gray-400 hover:text-rose-400 hover:bg-[#2b2b40] rounded-lg transition cursor-pointer"
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
            class="fixed inset-0 bg-black/60 z-40 lg:hidden"
            style="display: none;"
        ></div>

        <!-- =====================================================================
             2. MAIN CONTENT CANVAS & TOPBAR
             ===================================================================== -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Metronic Topbar Header -->
            <header class="h-20 bg-[#1e1e2d] border-b border-[#2b2b40] px-4 sm:px-8 flex items-center justify-between sticky top-0 z-30 shadow-md">
                
                <!-- Left: Hamburger & Breadcrumb Title -->
                <div class="flex items-center gap-4">
                    <button 
                        type="button" 
                        @click="sidebarOpen = true" 
                        class="lg:hidden p-2.5 rounded-xl bg-[#151521] border border-[#2b2b40] text-gray-400 hover:text-white"
                    >
                        <i class="fa-solid fa-bars text-sm"></i>
                    </button>

                    <div class="flex flex-col">
                        <div class="flex items-center gap-2 text-[11px] text-gray-500 font-bold uppercase tracking-wider">
                            <span>Admin</span>
                            <span>/</span>
                            <span class="text-indigo-400">@yield('breadcrumb', 'Dashboard')</span>
                        </div>
                        <h2 class="text-base sm:text-lg font-black text-white tracking-tight leading-tight">
                            @yield('title', 'Executive Overview')
                        </h2>
                    </div>
                </div>

                <!-- Right: Quick Actions & Profile Dropdown -->
                <div class="flex items-center gap-3">
                    
                    <a 
                        href="{{ route('home') }}" 
                        target="_blank"
                        class="hidden sm:inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-[#151521] hover:bg-[#2b2b40] border border-[#2b2b40] text-xs font-bold text-gray-300 hover:text-white transition"
                    >
                        <i class="fa-solid fa-store text-xs text-indigo-400"></i>
                        <span>Storefront</span>
                    </a>

                    <a 
                        href="{{ route('admin.products.create') }}" 
                        class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-black transition shadow-md shadow-indigo-600/30 flex items-center gap-1.5"
                    >
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span class="hidden sm:inline">Add Product</span>
                    </a>

                    <!-- Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button 
                            type="button" 
                            @click="open = !open" 
                            class="flex items-center gap-2 p-1.5 rounded-xl bg-[#151521] border border-[#2b2b40] hover:border-indigo-500/50 transition cursor-pointer"
                        >
                            <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center text-xs font-black text-white">
                                SA
                            </div>
                            <i class="fa-solid fa-chevron-down text-[10px] text-gray-400 pr-1"></i>
                        </button>

                        <div 
                            x-show="open" 
                            @click.away="open = false" 
                            x-transition:enter="transition ease-out duration-100"
                            x-transition:enter-start="opacity-0 scale-95"
                            x-transition:enter-end="opacity-100 scale-100"
                            class="absolute right-0 mt-2 w-56 bg-[#1e1e2d] border border-[#2b2b40] rounded-xl p-2 shadow-2xl z-50 space-y-1 text-xs"
                            style="display: none;"
                        >
                            <div class="px-3 py-2 border-b border-[#2b2b40] mb-1">
                                <div class="font-bold text-white">SM Administrator</div>
                                <div class="text-[10px] text-gray-400 font-mono">admin@smcloudit.top</div>
                            </div>

                            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-300 hover:text-white hover:bg-[#2b2b40] transition">
                                <i class="fa-solid fa-chart-pie text-indigo-400 text-xs"></i>
                                <span>Dashboard Analytics</span>
                            </a>

                            <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-300 hover:text-white hover:bg-[#2b2b40] transition">
                                <i class="fa-solid fa-box text-amber-400 text-xs"></i>
                                <span>Product Catalog</span>
                            </a>

                            <form action="{{ route('admin.logout') }}" method="POST" class="pt-1 border-t border-[#2b2b40]">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-rose-400 hover:bg-rose-500/10 hover:text-rose-300 transition text-left cursor-pointer">
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
                <div class="m-6 mb-0 p-4 rounded-xl bg-emerald-950/60 border border-emerald-500/30 text-emerald-300 text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="m-6 mb-0 p-4 rounded-xl bg-rose-950/60 border border-rose-500/30 text-rose-300 text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Main Page Body Slot -->
            <main class="p-4 sm:p-8 flex-1">
                @yield('content')
            </main>

        </div>

    </div>

    @stack('scripts')
</body>
</html>