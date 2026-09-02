<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>@yield('title', 'Metronic - Dark Sidebar') | SM Shop Enterprise</title>

    <!-- Official Keenthemes Metronic CSS Bundle -->
    <link href="https://keenthemes.com/metronic/tailwind/dist/assets/vendors/apexcharts/apexcharts.css" rel="stylesheet"/>
    <link href="https://keenthemes.com/metronic/tailwind/dist/assets/vendors/keenicons/styles.bundle.css" rel="stylesheet"/>
    <link href="https://keenthemes.com/metronic/tailwind/dist/assets/css/styles.css" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>

    <!-- Lucide Icons Bundle -->
    <script src="https://unpkg.com/lucide@latest"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        [x-cloak] { display: none !important; }
        
        /* Times New Roman Global Typography */
        *, body, h1, h2, h3, h4, h5, h6, p, span, a, input, select, textarea, button, table, th, td, kbd, div, label {
            font-family: 'Times New Roman', Times, Georgia, serif !important;
        }

        /* Sidebar Custom Smooth Scrollbar */
        .sidebar-scrollable::-webkit-scrollbar {
            width: 5px;
        }
        .sidebar-scrollable::-webkit-scrollbar-track {
            background: #13141a;
        }
        .sidebar-scrollable::-webkit-scrollbar-thumb {
            background: #2b2b40;
            border-radius: 4px;
        }
        .sidebar-scrollable::-webkit-scrollbar-thumb:hover {
            background: #1b84ff;
        }

        /* Global Crisp Table Borders */
        table, .kt-card table {
            border-collapse: collapse !important;
            border: 1px solid #cbd5e1 !important;
            width: 100% !important;
        }
        th, .kt-card table th {
            background-color: #f1f5f9 !important;
            color: #0f172a !important;
            border: 1px solid #cbd5e1 !important;
            padding: 10px 14px !important;
            font-size: 14px !important;
            font-weight: 700 !important;
            letter-spacing: 0.02em;
        }
        td, .kt-card table td {
            border: 1px solid #e2e8f0 !important;
            padding: 10px 14px !important;
            font-size: 14px !important;
        }
        tbody tr:nth-child(even), .kt-card table tbody tr:nth-child(even) {
            background-color: #f8fafc !important;
        }
        tbody tr:hover, .kt-card table tbody tr:hover {
            background-color: #eff6ff !important;
        }

        /* Crisp Borders on Cards & Containers */
        .kt-card {
            border: 1px solid #cbd5e1 !important;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05) !important;
        }
    </style>
</head>
<body 
    class="antialiased flex h-full text-base text-foreground bg-[#f8fafc] demo1 kt-sidebar-fixed kt-header-fixed selection:bg-[#1b84ff] selection:text-white"
    x-data="{ 
        sidebarOpen: false, 
        profileMenuOpen: false,
        searchModalOpen: false
    }"
    @keydown.window.escape="profileMenuOpen = false; searchModalOpen = false;"
    @keydown.window.ctrl.k.prevent="searchModalOpen = true"
    @keydown.window.cmd.k.prevent="searchModalOpen = true"
>

    <!-- Page Wrapper -->
    <div class="flex grow min-h-full">
        
        <!-- =====================================================================
             1. OFFICIAL METRONIC DARK SIDEBAR (#13141a) WITH WORKING SCROLLBAR
             ===================================================================== -->
        <div 
            class="kt-sidebar dark bg-[#13141a] border-e border-[#1e1e2d] fixed top-0 bottom-0 left-0 z-20 flex flex-col items-stretch w-[280px] h-screen max-h-screen overflow-hidden transition-transform duration-300 shadow-2xl lg:shadow-none"
            :class="{ 'translate-x-0': sidebarOpen, '-translate-x-full lg:translate-x-0': !sidebarOpen }"
            id="sidebar"
        >
            <!-- Sidebar Header: Logo & Branding (Fixed at Top) -->
            <div class="kt-sidebar-header flex items-center justify-between px-6 shrink-0 h-[70px] border-b border-[#1e1e2d] bg-[#0f1015]">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <img class="h-8 w-auto object-contain shrink-0" src="{{ asset('images/logo.png') }}" alt="SM Shop"/>
                    <div class="flex flex-col">
                        <div class="flex items-center gap-1.5">
                            <span class="text-sm font-black text-white tracking-tight uppercase">METRONIC</span>
                            <span class="kt-badge kt-badge-sm kt-badge-primary text-[10px] font-bold">DEMO 1</span>
                        </div>
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-widest flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                            Dark Sidebar
                        </span>
                    </div>
                </a>

                <!-- Mobile Close -->
                <button type="button" @click="sidebarOpen = false" class="lg:hidden p-2 text-gray-400 hover:text-white">
                    <i class="fa-solid fa-xmark text-base"></i>
                </button>
            </div>

            <!-- Quick Search Input in Sidebar (Fixed) -->
            <div class="px-5 pt-4 pb-2 shrink-0">
                <div class="kt-input bg-[#1a1b24] border-[#2b2b40] rounded-lg cursor-pointer" @click="searchModalOpen = true">
                    <i class="fa-solid fa-magnifying-glass text-gray-400 text-xs"></i>
                    <input 
                        type="text" 
                        placeholder="Search dashboard..." 
                        class="bg-transparent text-xs text-gray-200 placeholder-gray-500 cursor-pointer pointer-events-none" 
                        readonly
                    />
                    <kbd class="px-1.5 py-0.5 rounded bg-[#2b2b40] text-[10px] font-mono text-gray-400 font-bold">⌘K</kbd>
                </div>
            </div>

            <!-- Sidebar Content & Navigation Menu (100% FULLY SCROLLABLE) -->
            <div class="kt-sidebar-content flex-1 min-h-0 py-2 px-1 overflow-y-auto overflow-x-hidden sidebar-scrollable" style="scrollbar-width: thin; scrollbar-color: #2b2b40 #13141a;">
                <div class="kt-menu flex flex-col gap-1 px-3 pb-8" data-kt-menu="true">
                    
                    <!-- Section: Dashboards -->
                    <div class="kt-menu-item pt-2 pb-1">
                        <span class="kt-menu-heading uppercase text-[11px] font-bold text-gray-400 tracking-wider px-2.5">
                            Executive
                        </span>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2.5 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.dashboard') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-gauge-high text-sm {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-indigo-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Dark Sidebar</span>
                            <span class="ms-auto kt-badge kt-badge-sm {{ request()->routeIs('admin.dashboard') ? 'bg-white/20 text-white' : 'kt-badge-outline kt-badge-success' }}">
                                Live
                            </span>
                        </a>
                    </div>

                    <!-- Section: Catalog Management -->
                    <div class="kt-menu-item pt-4 pb-1">
                        <span class="kt-menu-heading uppercase text-[11px] font-bold text-gray-400 tracking-wider px-2.5">
                            Catalog Management
                        </span>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.products.*') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.products.index') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-box text-sm {{ request()->routeIs('admin.products.*') ? 'text-white' : 'text-amber-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Products Catalog</span>
                        </a>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.categories.*') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.categories.index') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-shapes text-sm {{ request()->routeIs('admin.categories.*') ? 'text-white' : 'text-cyan-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Categories</span>
                        </a>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.brands.*') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.brands.index') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-tags text-sm {{ request()->routeIs('admin.brands.*') ? 'text-white' : 'text-purple-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Brands</span>
                        </a>
                    </div>

                    <!-- Section: Inventory & Purchases -->
                    <div class="kt-menu-item pt-4 pb-1">
                        <span class="kt-menu-heading uppercase text-[11px] font-bold text-gray-400 tracking-wider px-2.5">
                            Stock & Inflow
                        </span>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.stocks.*') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.stocks.*') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.stocks.index') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-warehouse text-sm {{ request()->routeIs('admin.stocks.*') ? 'text-white' : 'text-emerald-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Product Stock</span>
                        </a>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.purchases.*') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.purchases.*') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.purchases.index') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-truck-ramp-box text-sm {{ request()->routeIs('admin.purchases.*') ? 'text-white' : 'text-blue-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Supplier Purchases</span>
                        </a>
                    </div>

                    <!-- Section: Orders, Courier & Fraud -->
                    <div class="kt-menu-item pt-4 pb-1">
                        <span class="kt-menu-heading uppercase text-[11px] font-bold text-gray-400 tracking-wider px-2.5">
                            Logistics & Orders
                        </span>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.orders.*') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.orders.index') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-bag-shopping text-sm {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-emerald-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Web Order List</span>
                        </a>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.courier.*') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.courier.*') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.courier.index') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-truck-fast text-sm {{ request()->routeIs('admin.courier.*') ? 'text-white' : 'text-cyan-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Courier Panel</span>
                        </a>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.fraud.*') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.fraud.*') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.fraud.index') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-shield-halved text-sm {{ request()->routeIs('admin.fraud.*') ? 'text-white' : 'text-rose-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Fraud Checker</span>
                        </a>
                    </div>

                    <!-- Section: Customers & Marketing -->
                    <div class="kt-menu-item pt-4 pb-1">
                        <span class="kt-menu-heading uppercase text-[11px] font-bold text-gray-400 tracking-wider px-2.5">
                            Community & Marketing
                        </span>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.customers.*') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.customers.index') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-users text-sm {{ request()->routeIs('admin.customers.*') ? 'text-white' : 'text-indigo-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Athletes & Users</span>
                        </a>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.coupons.*') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.coupons.index') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-ticket text-sm {{ request()->routeIs('admin.coupons.*') ? 'text-white' : 'text-rose-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Coupon Engine</span>
                        </a>
                    </div>

                    <div class="kt-menu-item {{ request()->routeIs('admin.reviews.*') ? 'active' : '' }}">
                        <a 
                            class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold {{ request()->routeIs('admin.reviews.*') ? 'bg-[#1b84ff] text-white shadow-md shadow-blue-500/20' : 'text-gray-300 hover:text-white hover:bg-[#1a1b24]' }} transition" 
                            href="{{ route('admin.reviews.index') }}"
                        >
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-star-half-stroke text-sm {{ request()->routeIs('admin.reviews.*') ? 'text-white' : 'text-yellow-400' }}"></i>
                            </span>
                            <span class="kt-menu-title font-semibold">Reviews</span>
                        </a>
                    </div>

                    <!-- Storefront Channels -->
                    <div class="kt-menu-item pt-4 pb-1">
                        <span class="kt-menu-heading uppercase text-[11px] font-bold text-gray-400 tracking-wider px-2.5">
                            Storefront Channels
                        </span>
                    </div>

                    <div class="kt-menu-item">
                        <a class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-gray-300 hover:text-white hover:bg-[#1a1b24] transition" href="{{ route('home') }}" target="_blank">
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-store text-sm text-cyan-400"></i>
                            </span>
                            <span class="kt-menu-title">Live Storefront</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs ms-auto text-gray-500"></i>
                        </a>
                    </div>

                    <div class="kt-menu-item">
                        <a class="kt-menu-link flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-semibold text-gray-300 hover:text-white hover:bg-[#1a1b24] transition" href="{{ route('shop.index') }}" target="_blank">
                            <span class="w-5 text-center">
                                <i class="fa-solid fa-compass text-sm text-violet-400"></i>
                            </span>
                            <span class="kt-menu-title">Catalog Explorer</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-xs ms-auto text-gray-500"></i>
                        </a>
                    </div>

                </div>
            </div>

            <!-- Sidebar Footer: Profile Card (Fixed at Bottom) -->
            <div class="p-3 border-t border-[#1e1e2d] bg-[#0f1015] shrink-0">
                <div class="flex items-center justify-between p-2 rounded-lg bg-[#161720] border border-[#2b2b40]">
                    <div class="flex items-center gap-2.5 min-w-0">
                        <div class="w-8 h-8 rounded-lg bg-gradient-to-tr from-indigo-500 to-blue-600 flex items-center justify-center text-xs font-black text-white shrink-0">
                            SA
                        </div>
                        <div class="min-w-0">
                            <div class="text-xs font-bold text-white truncate">SM Administrator</div>
                            <div class="text-[10px] text-emerald-400 font-medium flex items-center gap-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Online
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" title="Sign Out" class="p-2 text-gray-400 hover:text-rose-400 hover:bg-[#2b2b40] rounded-lg transition cursor-pointer">
                            <i class="fa-solid fa-right-from-bracket text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Mobile Sidebar Overlay Backdrop -->
        <div 
            x-show="sidebarOpen" 
            @click="sidebarOpen = false" 
            x-transition:enter="transition-opacity ease-linear duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            class="fixed inset-0 bg-black/60 z-10 lg:hidden"
            style="display: none;"
        ></div>

        <!-- =====================================================================
             2. MAIN WRAPPER: OFFICIAL METRONIC TOPBAR & LIGHT BODY CANVAS
             ===================================================================== -->
        <div class="flex flex-col grow lg:ps-[280px] pt-[70px] min-w-0 bg-[#f8fafc]">
            
            <!-- Metronic Official Topbar Header (Crisp White / Light) -->
            <header class="kt-header fixed top-0 end-0 start-0 z-10 flex items-stretch shrink-0 bg-white border-b border-gray-300 h-[70px] lg:ps-[280px]">
                <div class="kt-container-fluid flex items-center justify-between w-full px-4 lg:px-8">
                    
                    <!-- Left: Mobile Toggle & Breadcrumbs -->
                    <div class="flex items-center gap-3">
                        <button 
                            type="button" 
                            @click="sidebarOpen = true" 
                            class="lg:hidden p-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition"
                        >
                            <i class="fa-solid fa-bars text-sm"></i>
                        </button>

                        <div class="flex items-center gap-2 text-sm text-gray-600 font-medium">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition font-bold text-gray-700">Dashboards</a>
                            <span class="text-gray-400">/</span>
                            <span class="text-gray-950 font-bold">@yield('breadcrumb', 'Dark Sidebar')</span>
                        </div>
                    </div>

                    <!-- Right: Search, Live Store, Add Drop & Profile Dropdown -->
                    <div class="flex items-center gap-3">
                        
                        <!-- Search Trigger Button -->
                        <button 
                            type="button" 
                            @click="searchModalOpen = true" 
                            class="hidden sm:flex items-center gap-2 px-3 py-1.5 rounded-lg border border-gray-300 bg-gray-50 hover:bg-gray-100 text-xs text-gray-600 transition cursor-pointer"
                        >
                            <i class="fa-solid fa-magnifying-glass text-xs text-gray-500"></i>
                            <span>Search...</span>
                            <kbd class="px-1.5 py-0.2 rounded bg-white border border-gray-300 text-[10px] font-mono text-gray-600">⌘K</kbd>
                        </button>

                        <!-- Live Storefront Link -->
                        <a 
                            href="{{ route('home') }}" 
                            target="_blank"
                            class="hidden md:inline-flex kt-btn kt-btn-outline kt-btn-sm text-xs font-semibold text-gray-700 hover:text-primary gap-1.5 border border-gray-300"
                        >
                            <i class="fa-solid fa-store text-xs text-primary"></i>
                            <span>Live Store</span>
                        </a>

                        <!-- Primary CTA: Add Product Drop -->
                        <a 
                            href="{{ route('admin.products.create') }}" 
                            class="kt-btn kt-btn-primary kt-btn-sm text-xs font-bold shadow-xs flex items-center gap-1.5"
                        >
                            <i class="fa-solid fa-plus text-xs"></i>
                            <span class="hidden sm:inline">Add Product</span>
                        </a>

                        <!-- User Profile Dropdown -->
                        <div class="relative">
                            <button 
                                type="button" 
                                @click="profileMenuOpen = !profileMenuOpen" 
                                class="flex items-center gap-2 p-1 rounded-full hover:ring-2 hover:ring-primary/20 transition cursor-pointer"
                            >
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-blue-600 flex items-center justify-center text-xs font-bold text-white shadow-xs">
                                    SA
                                </div>
                            </button>

                            <div 
                                x-show="profileMenuOpen" 
                                @click.away="profileMenuOpen = false" 
                                x-transition:enter="transition ease-out duration-100"
                                x-transition:enter-start="opacity-0 scale-95"
                                x-transition:enter-end="opacity-100 scale-100"
                                class="absolute right-0 mt-2 w-56 bg-white border border-gray-300 rounded-xl p-2 shadow-xl z-50 space-y-1 text-xs"
                                style="display: none;"
                            >
                                <div class="px-3 py-2 border-b border-gray-200 mb-1">
                                    <div class="font-bold text-gray-900 text-sm">SM Administrator</div>
                                    <div class="text-[11px] text-gray-500 font-mono">admin@smcloudit.top</div>
                                </div>

                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:text-primary hover:bg-gray-50 transition font-medium">
                                    <i class="fa-solid fa-gauge-high text-primary text-xs"></i>
                                    <span>Dashboard</span>
                                </a>

                                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:text-primary hover:bg-gray-50 transition font-medium">
                                    <i class="fa-solid fa-bag-shopping text-emerald-500 text-xs"></i>
                                    <span>Web Orders</span>
                                </a>

                                <a href="{{ route('admin.courier.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:text-primary hover:bg-gray-50 transition font-medium">
                                    <i class="fa-solid fa-truck-fast text-cyan-500 text-xs"></i>
                                    <span>Courier Panel</span>
                                </a>

                                <a href="{{ route('admin.fraud.index') }}" class="flex items-center gap-2 px-3 py-2 rounded-lg text-gray-700 hover:text-primary hover:bg-gray-50 transition font-medium">
                                    <i class="fa-solid fa-shield-halved text-rose-500 text-xs"></i>
                                    <span>Fraud Checker</span>
                                </a>

                                <form action="{{ route('admin.logout') }}" method="POST" class="pt-1 border-t border-gray-200">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2 px-3 py-2 rounded-lg text-rose-600 hover:bg-rose-50 transition text-left cursor-pointer font-semibold">
                                        <i class="fa-solid fa-right-from-bracket text-xs"></i>
                                        <span>Sign Out</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>

                </div>
            </header>

            <!-- Notification Messages -->
            @if(session('success'))
                <div class="mx-6 lg:mx-8 mt-6 p-4 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-900 text-sm font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-base text-emerald-600"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="mx-6 lg:mx-8 mt-6 p-4 rounded-xl bg-rose-50 border border-rose-300 text-rose-900 text-sm font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-base text-rose-600"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Main Page Content Canvas -->
            <main class="kt-container-fluid px-4 lg:px-8 py-6 flex-1">
                @yield('content')
            </main>

            <!-- Metronic Footer -->
            <footer class="kt-container-fluid px-4 lg:px-8 py-4 border-t border-gray-300 bg-white flex flex-col sm:flex-row items-center justify-between text-xs text-gray-600 gap-2 font-medium">
                <div>
                    {{ date('Y') }} &copy; <a href="{{ route('home') }}" class="font-bold text-gray-900 hover:text-primary">SM Shop</a> &bull; Metronic Tailwind Demo 1
                </div>
                <div class="flex items-center gap-4">
                    <a href="{{ route('admin.dashboard') }}" class="hover:text-primary transition">Dashboard</a>
                    <a href="{{ route('admin.products.index') }}" class="hover:text-primary transition">Catalog</a>
                    <a href="{{ route('admin.orders.index') }}" class="hover:text-primary transition">Orders</a>
                    <a href="{{ route('admin.courier.index') }}" class="hover:text-primary transition">Courier</a>
                    <a href="{{ route('admin.fraud.index') }}" class="hover:text-primary transition">Fraud Checker</a>
                </div>
            </footer>

        </div>

    </div>

    <!-- Quick Search Command Modal (⌘K) -->
    <div 
        x-show="searchModalOpen" 
        class="fixed inset-0 z-50 flex items-start justify-center pt-24 p-4 bg-black/50 backdrop-blur-xs" 
        style="display: none;"
    >
        <div 
            @click.away="searchModalOpen = false" 
            class="bg-white border border-gray-300 rounded-2xl w-full max-w-xl shadow-2xl overflow-hidden"
        >
            <div class="p-4 border-b border-gray-200 flex items-center gap-3">
                <i class="fa-solid fa-magnifying-glass text-gray-400 text-sm"></i>
                <input 
                    type="text" 
                    placeholder="Search activewear catalog, orders, couriers, fraud checker..." 
                    class="w-full bg-transparent border-none text-gray-900 text-xs font-semibold focus:outline-none placeholder-gray-400"
                    autofocus
                >
                <kbd class="px-2 py-1 rounded bg-gray-100 text-[10px] font-mono text-gray-500 font-bold">ESC</kbd>
            </div>
            <div class="p-4 space-y-2 text-xs">
                <div class="text-[10px] font-bold text-gray-400 uppercase tracking-wider">Quick Navigation</div>
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-primary transition font-medium">
                    <i class="fa-solid fa-gauge-high text-primary"></i> Executive Dashboard
                </a>
                <a href="{{ route('admin.products.index') }}" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-primary transition font-medium">
                    <i class="fa-solid fa-box text-amber-500"></i> Activewear Catalog
                </a>
                <a href="{{ route('admin.stocks.index') }}" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-primary transition font-medium">
                    <i class="fa-solid fa-warehouse text-emerald-500"></i> Product Stock
                </a>
                <a href="{{ route('admin.purchases.index') }}" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-primary transition font-medium">
                    <i class="fa-solid fa-truck-ramp-box text-blue-500"></i> Supplier Purchases
                </a>
                <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-primary transition font-medium">
                    <i class="fa-solid fa-bag-shopping text-purple-500"></i> Web Orders
                </a>
                <a href="{{ route('admin.courier.index') }}" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-primary transition font-medium">
                    <i class="fa-solid fa-truck-fast text-cyan-500"></i> Courier Panel
                </a>
                <a href="{{ route('admin.fraud.index') }}" class="flex items-center gap-2.5 p-2 rounded-lg hover:bg-gray-50 text-gray-700 hover:text-primary transition font-medium">
                    <i class="fa-solid fa-shield-halved text-rose-500"></i> Fraud Checker
                </a>
            </div>
        </div>
    </div>

    @stack('scripts')
    <script>
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }
    </script>
</body>
</html>