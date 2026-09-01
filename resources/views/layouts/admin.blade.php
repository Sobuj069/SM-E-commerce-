<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin Dashboard') - SM Shop 3D Admin</title>

    <!-- Inter Variable Modern Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full bg-slate-950 text-slate-100 font-sans antialiased overflow-x-hidden">
    
    <div class="min-h-full flex">
        
        <!-- Sidebar Navigation -->
        <aside class="w-64 bg-slate-900/90 border-r border-slate-800 flex flex-col justify-between shrink-0 hidden lg:flex">
            <div>
                <!-- Brand Header -->
                <div class="h-20 flex items-center gap-3 px-6 border-b border-slate-800">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-tr from-indigo-500 via-indigo-600 to-violet-600 flex items-center justify-center text-white text-lg font-black shadow-lg shadow-indigo-500/25">
                        <i class="fa-solid fa-cube"></i>
                    </div>
                    <div>
                        <div class="font-black text-sm text-white tracking-tight">SM SHOP 3D</div>
                        <div class="text-[10px] font-bold text-indigo-400 uppercase tracking-widest">Admin Control</div>
                    </div>
                </div>

                <!-- Nav Menu -->
                <nav class="p-4 space-y-1.5 text-xs font-bold">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.dashboard') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30 font-black' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-chart-pie text-sm"></i>
                        <span>Dashboard Analytics</span>
                    </a>

                    <a href="{{ route('admin.products.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.products.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30 font-black' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-box text-sm"></i>
                        <span>Product Management</span>
                    </a>

                    <a href="{{ route('admin.orders.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.orders.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30 font-black' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-bag-shopping text-sm"></i>
                        <span>Orders & Invoices</span>
                    </a>

                    <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.coupons.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30 font-black' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-ticket text-sm"></i>
                        <span>Coupon Engine</span>
                    </a>

                    <a href="{{ route('admin.reviews.index') }}" class="flex items-center gap-3 px-4 py-3 rounded-2xl transition {{ request()->routeIs('admin.reviews.*') ? 'bg-indigo-600 text-white shadow-md shadow-indigo-600/30 font-black' : 'text-slate-400 hover:text-white hover:bg-slate-800/60' }}">
                        <i class="fa-solid fa-star-half-stroke text-sm"></i>
                        <span>Review Moderation</span>
                    </a>

                    <div class="pt-4 pb-2 px-4 text-[10px] font-black uppercase tracking-wider text-slate-500">
                        Quick Links
                    </div>

                    <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-2.5 rounded-2xl text-slate-400 hover:text-amber-300 hover:bg-slate-800/60 transition">
                        <i class="fa-solid fa-store text-sm"></i>
                        <span>View Live Storefront</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px] ml-auto"></i>
                    </a>
                </nav>
            </div>

            <!-- Admin Profile Foot -->
            <div class="p-4 border-t border-slate-800">
                <div class="flex items-center gap-3 p-3 rounded-2xl bg-slate-800/40 border border-slate-800">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-600 flex items-center justify-center text-xs font-black text-white">
                        SA
                    </div>
                    <div>
                        <div class="text-xs font-black text-white">Super Administrator</div>
                        <div class="text-[10px] text-emerald-400 flex items-center gap-1 font-bold">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Online
                        </div>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content View Area -->
        <div class="flex-1 flex flex-col min-w-0">
            
            <!-- Topbar -->
            <header class="h-20 bg-slate-900/60 backdrop-blur-md border-b border-slate-800 px-6 flex items-center justify-between sticky top-0 z-30">
                <div class="flex items-center gap-3">
                    <h2 class="text-base font-black text-white">@yield('title', 'Admin Overview')</h2>
                </div>

                <div class="flex items-center gap-4">
                    <span class="text-xs font-bold text-slate-400 bg-slate-800/80 px-3.5 py-1.5 rounded-full border border-slate-700/60">
                        ⚡ Laravel 12 & Spatie Active
                    </span>
                    <a href="{{ route('home') }}" class="px-4 py-2 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold transition shadow-md shadow-indigo-600/20">
                        Live Store
                    </a>
                </div>
            </header>

            <!-- Notification Messages -->
            @if(session('success'))
                <div class="m-6 mb-0 p-4 rounded-2xl bg-emerald-950/60 border border-emerald-500/30 text-emerald-300 text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-check text-sm"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if(session('error'))
                <div class="m-6 mb-0 p-4 rounded-2xl bg-rose-950/60 border border-rose-500/30 text-rose-300 text-xs font-bold flex items-center gap-2">
                    <i class="fa-solid fa-circle-exclamation text-sm"></i>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Main Page Body Slot -->
            <main class="p-6 lg:p-8 flex-1">
                @yield('content')
            </main>

        </div>

    </div>

    @stack('scripts')
</body>
</html>