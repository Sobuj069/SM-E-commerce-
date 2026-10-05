@extends('layouts.app')

@section('title', 'SM Shop - Leading Computer, Laptop & Gadget Shop in Bangladesh')

@section('content')
<div class="max-w-[1320px] mx-auto px-4 py-4 space-y-6">

    <!-- =========================================================================
         1. NOTICE BAR
         ========================================================================= -->
    <div class="bg-white rounded-full py-2.5 px-6 shadow-sm border border-slate-100 flex items-center justify-center text-xs md:text-sm text-slate-700 text-center font-normal">
        <span class="inline-block truncate">
            স্বাগতম SM Shop এ! ঢাকা সহ সারাদেশে দ্রুত হোম ডেলিভারি ও অরিজিনাল টেক প্রোডাক্টের অফিসিয়াল ওয়ারেন্টি। হেল্পলাইন: 16793
        </span>
    </div>

    <!-- =========================================================================
         2. HERO PROMO BANNERS (TECHLAND BD SIGNATURE SLIDER + DUAL SIDE CARDS)
         ========================================================================= -->
    <section 
        class="grid grid-cols-1 lg:grid-cols-4 gap-4" 
        data-purpose="hero-promotions"
        x-data="{
            activeSlide: 0,
            slidesCount: 4,
            timer: null,
            init() {
                this.startTimer();
            },
            startTimer() {
                this.timer = setInterval(() => {
                    this.nextSlide();
                }, 5500);
            },
            stopTimer() {
                clearInterval(this.timer);
            },
            nextSlide() {
                this.activeSlide = (this.activeSlide + 1) % this.slidesCount;
            },
            prevSlide() {
                this.activeSlide = (this.activeSlide - 1 + this.slidesCount) % this.slidesCount;
            }
        }"
        @mouseenter="stopTimer()"
        @mouseleave="startTimer()"
    >
        <!-- Main Promotional Slider Area (Col Span 3) -->
        <div class="lg:col-span-3 relative rounded-2xl overflow-hidden shadow-xl min-h-[340px] sm:min-h-[380px] md:min-h-[420px] bg-slate-950 flex flex-col justify-between border border-slate-800/80 group">
            
            <!-- SLIDE 1: ASUS ROG & TUF GAMING LAPTOP FIESTA -->
            <div 
                x-show="activeSlide === 0"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-8"
                class="w-full h-full min-h-[340px] sm:min-h-[380px] md:min-h-[420px] bg-gradient-to-r from-[#170529] via-[#0d1428] to-[#2b0811] p-6 sm:p-8 md:p-10 flex flex-col justify-between relative overflow-hidden"
            >
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center h-full z-10">
                    <!-- Text Content (7 cols) -->
                    <div class="md:col-span-7 space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-red-600 to-rose-600 text-white text-[10px] sm:text-xs uppercase px-3 py-1 rounded-full font-black tracking-wider shadow-md">
                                <i class="fa-solid fa-fire text-amber-300 animate-pulse"></i> TECHLAND SPECIAL OFFER
                            </span>
                            <span class="bg-white/10 text-amber-300 text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-white/10">
                                ASUS ROG &amp; TUF
                            </span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight tracking-tight text-white">
                            ASUS ল্যাপটপে <span class="text-transparent bg-clip-text bg-gradient-to-r from-red-500 via-orange-400 to-amber-300 font-extrabold">১৫,০০০৳ ক্যাশ ডিসকাউন্ট!</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-200">
                            AMD Ryzen™ 7 ও Intel Core i7 প্রসেসর সহ আল্ট্রা-ফাস্ট RTX 40-Series গ্রাফিক্স।
                        </p>
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20 inline-block shadow-lg">
                            <p class="text-xs sm:text-sm font-bold text-amber-300 flex items-center gap-2">
                                <i class="fa-solid fa-gift text-red-400 text-base sm:text-lg"></i>
                                <span>কিনলেই ফ্রি পাচ্ছেন: প্রিমিয়াম ব্যাকপ্যাক, মাউস ও মাউসপ্যাড!</span>
                            </p>
                        </div>
                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <a href="{{ route('shop.index', ['category' => 'laptop', 'q' => 'asus']) }}" class="bg-gradient-to-r from-starOrange to-red-600 hover:from-red-600 hover:to-starOrange text-white text-xs sm:text-sm font-black px-6 py-2.5 rounded-full inline-flex items-center gap-2 shadow-lg shadow-red-900/40 transition-transform hover:scale-105">
                                <span>অফার লুফে নিন</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <span class="text-[11px] text-gray-300 font-medium">✓ ০% EMI • ২ বছরের অফিসিয়াল ওয়ারেন্টি</span>
                        </div>
                    </div>

                    <!-- Product Graphic Showcase (5 cols) -->
                    <div class="md:col-span-5 flex items-center justify-center relative mt-4 md:mt-0">
                        <div class="relative w-full max-w-[340px] flex items-center justify-center group">
                            <!-- Laptop Image -->
                            <img 
                                src="{{ asset('images/banners/asus_laptop.jpg') }}" 
                                alt="ASUS ROG Gaming Laptop" 
                                class="w-full h-48 sm:h-56 md:h-60 object-cover rounded-2xl shadow-2xl border-2 border-red-500/40 transform -rotate-1 group-hover:rotate-0 transition-transform duration-500"
                            />
                            <!-- Floating Free Gifts Badge -->
                            <div class="absolute -bottom-3 -left-3 bg-slate-900/95 border border-amber-400/80 rounded-xl p-2 shadow-2xl flex items-center gap-2.5 backdrop-blur-md animate-bounce">
                                <img src="{{ asset('images/banners/earbuds.jpg') }}" alt="Free Gift" class="w-9 h-9 object-cover rounded-lg border border-amber-400">
                                <div class="text-left leading-tight">
                                    <span class="text-[9px] text-amber-300 font-bold uppercase block">FREE GIFT</span>
                                    <span class="text-[11px] text-white font-black">Gaming Buds &amp; Bag</span>
                                </div>
                            </div>
                            <!-- Discount Badge -->
                            <div class="absolute -top-3 -right-3 bg-gradient-to-tr from-red-600 to-amber-500 text-white rounded-full w-14 h-14 flex flex-col items-center justify-center shadow-2xl font-black text-[10px] leading-tight rotate-12 border-2 border-white">
                                <span>MEGA</span>
                                <span>OFFER</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ambient Glow -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-red-600/25 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-20 -top-20 w-60 h-60 bg-purple-600/20 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <!-- SLIDE 2: TECHLAND CUSTOM GAMING PC BUILD OFFER -->
            <div 
                x-show="activeSlide === 1"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-8"
                class="w-full h-full min-h-[340px] sm:min-h-[380px] md:min-h-[420px] bg-gradient-to-r from-[#02182b] via-[#072d4a] to-[#041a30] p-6 sm:p-8 md:p-10 flex flex-col justify-between relative overflow-hidden"
            >
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center h-full z-10">
                    <!-- Text Content (7 cols) -->
                    <div class="md:col-span-7 space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-cyan-500 to-blue-600 text-slate-950 text-[10px] sm:text-xs uppercase px-3 py-1 rounded-full font-black tracking-wider shadow-md">
                                <i class="fa-solid fa-microchip"></i> PC BUILD MEGA DEAL
                            </span>
                            <span class="bg-white/10 text-cyan-300 text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-white/10">
                                Intel Gen-14 &amp; Ryzen 7000
                            </span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight tracking-tight text-white">
                            বিল্ড করুন আপনার স্বপ্নের <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-sky-300 to-blue-300 font-extrabold">গেমিং ও এডিটিং পিসি</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-200">
                            GeForce RTX 4070 Ti, Gen4 NVMe SSD ও লিকুইড কুলিং সহ হাই-পারফরম্যান্স রিগ।
                        </p>
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20 inline-block shadow-lg">
                            <p class="text-xs sm:text-sm font-bold text-cyan-300 flex items-center gap-2">
                                <i class="fa-solid fa-keyboard text-cyan-400 text-base sm:text-lg"></i>
                                <span>ফ্রি প্রফেশনাল অ্যাসেম্বলি + RGB মেকানিক্যাল কিবোর্ড বান্ডেল!</span>
                            </p>
                        </div>
                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <a href="{{ route('shop.index', ['category' => 'desktop']) }}" class="bg-gradient-to-r from-cyan-400 to-cyan-500 hover:from-cyan-300 hover:to-cyan-400 text-slate-950 text-xs sm:text-sm font-black px-6 py-2.5 rounded-full inline-flex items-center gap-2 shadow-lg shadow-cyan-900/40 transition-transform hover:scale-105">
                                <span>পিসি কনফিগার করুন</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <span class="text-[11px] text-gray-300 font-medium">✓ ৩ বছরের অফিসিয়াল রিপ্লেসমেন্ট ওয়ারেন্টি</span>
                        </div>
                    </div>

                    <!-- Product Graphic Showcase (5 cols) -->
                    <div class="md:col-span-5 flex items-center justify-center relative mt-4 md:mt-0">
                        <div class="relative w-full max-w-[340px] flex items-center justify-center group">
                            <img 
                                src="{{ asset('images/banners/gaming_pc.jpg') }}" 
                                alt="RGB Gaming Desktop PC" 
                                class="w-full h-48 sm:h-56 md:h-60 object-cover rounded-2xl shadow-2xl border-2 border-cyan-400/40 transform rotate-1 group-hover:rotate-0 transition-transform duration-500"
                            />
                            <div class="absolute -top-3 -right-3 bg-gradient-to-br from-starBlue to-blue-700 text-white rounded-full w-14 h-14 flex flex-col items-center justify-center shadow-2xl font-black text-[10px] leading-tight rotate-12 border-2 border-white">
                                <span>INTEL</span>
                                <span>14TH</span>
                            </div>
                            <div class="absolute -bottom-3 -left-3 bg-slate-900/95 border border-cyan-400/80 rounded-xl p-2 shadow-2xl flex items-center gap-2 backdrop-blur-md">
                                <i class="fa-solid fa-shield-halved text-cyan-400 text-base"></i>
                                <span class="text-[11px] text-white font-bold">100% Genuine Components</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ambient Glow -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-cyan-500/25 rounded-full blur-3xl pointer-events-none"></div>
                <div class="absolute -left-20 -top-20 w-60 h-60 bg-blue-600/20 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <!-- SLIDE 3: APPLE MACBOOK PRO & AIR M3 SHOWCASE -->
            <div 
                x-show="activeSlide === 2"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-8"
                class="w-full h-full min-h-[340px] sm:min-h-[380px] md:min-h-[420px] bg-gradient-to-r from-[#061816] via-[#0d2723] to-[#081514] p-6 sm:p-8 md:p-10 flex flex-col justify-between relative overflow-hidden"
            >
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center h-full z-10">
                    <!-- Text Content (7 cols) -->
                    <div class="md:col-span-7 space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-emerald-600 to-teal-600 text-white text-[10px] sm:text-xs uppercase px-3 py-1 rounded-full font-black tracking-wider shadow-md">
                                <i class="fa-brands fa-apple text-white"></i> AUTHORIZED APPLE RESELLER
                            </span>
                            <span class="bg-white/10 text-emerald-300 text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-white/10">
                                M3 / M3 Max Chip
                            </span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight tracking-tight text-white">
                            Apple <span class="text-transparent bg-clip-text bg-gradient-to-r from-emerald-400 via-teal-300 to-white font-extrabold">MacBook Pro &amp; Air M3</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-200">
                            Liquid Retina XDR ডিসপ্লে ও অল-ডে ১৮ ঘণ্টার ব্যাটারি ব্যাকআপ।
                        </p>
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20 inline-block shadow-lg">
                            <p class="text-xs sm:text-sm font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-credit-card text-emerald-400 text-base sm:text-lg"></i>
                                <span>৩৬ মাস পর্যন্ত ০% EMI সুবিধা ও স্পেশাল ক্যাশ ভাউচার!</span>
                            </p>
                        </div>
                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <a href="{{ route('shop.index', ['category' => 'laptop', 'q' => 'apple']) }}" class="bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-400 hover:to-teal-400 text-slate-950 text-xs sm:text-sm font-black px-6 py-2.5 rounded-full inline-flex items-center gap-2 shadow-lg shadow-emerald-900/40 transition-transform hover:scale-105">
                                <span>ম্যাকবুক কালেকশন</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <span class="text-[11px] text-gray-300 font-medium">✓ ১ বছরের ইন্টারন্যাশনাল ওয়ারেন্টি</span>
                        </div>
                    </div>

                    <!-- Product Graphic Showcase (5 cols) -->
                    <div class="md:col-span-5 flex items-center justify-center relative mt-4 md:mt-0">
                        <div class="relative w-full max-w-[340px] flex items-center justify-center group">
                            <img 
                                src="{{ asset('images/banners/macbook.jpg') }}" 
                                alt="Apple MacBook Pro M3" 
                                class="w-full h-48 sm:h-56 md:h-60 object-cover rounded-2xl shadow-2xl border-2 border-emerald-500/40 transform -rotate-1 group-hover:rotate-0 transition-transform duration-500"
                            />
                            <div class="absolute -top-3 -right-3 bg-white text-slate-900 rounded-full w-14 h-14 flex flex-col items-center justify-center shadow-2xl font-black text-[10px] leading-tight rotate-12 border-2 border-emerald-400">
                                <span>M3</span>
                                <span>MAX</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ambient Glow -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-emerald-500/25 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <!-- SLIDE 4: 240Hz FAST CURVED GAMING MONITOR ARENA -->
            <div 
                x-show="activeSlide === 3"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-8"
                class="w-full h-full min-h-[340px] sm:min-h-[380px] md:min-h-[420px] bg-gradient-to-r from-[#2c0914] via-[#1a0815] to-[#250a04] p-6 sm:p-8 md:p-10 flex flex-col justify-between relative overflow-hidden"
            >
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center h-full z-10">
                    <!-- Text Content (7 cols) -->
                    <div class="md:col-span-7 space-y-3">
                        <div class="flex flex-wrap items-center gap-2">
                            <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-slate-950 text-[10px] sm:text-xs uppercase px-3 py-1 rounded-full font-black tracking-wider shadow-md">
                                <i class="fa-solid fa-display"></i> ESPORTS ARENA
                            </span>
                            <span class="bg-white/10 text-amber-300 text-[11px] font-bold px-2.5 py-0.5 rounded-full border border-white/10">
                                240Hz 1ms IPS / OLED
                            </span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight tracking-tight text-white">
                            240Hz <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-400 via-orange-400 to-rose-400 font-extrabold">Curved Gaming Monitors</span>
                        </h2>
                        <p class="text-xs sm:text-sm text-gray-200">
                            Samsung, ASUS ROG, MSI ও Gigabyte এর সেরা গেমিং মনিটরে বিশেষ ছাড়।
                        </p>
                        <div class="bg-white/10 backdrop-blur-md rounded-xl p-3 border border-white/20 inline-block shadow-lg">
                            <p class="text-xs sm:text-sm font-bold text-amber-300 flex items-center gap-2">
                                <i class="fa-solid fa-tags text-orange-400 text-base sm:text-lg"></i>
                                <span>আপ টু ১৫,০০০৳ ডিসকাউন্ট ও ফ্রি ডিসপ্লে পোর্ট ক্যাবল!</span>
                            </p>
                        </div>
                        <div class="pt-2 flex flex-wrap items-center gap-3">
                            <a href="{{ route('shop.index', ['category' => 'monitor']) }}" class="bg-gradient-to-r from-amber-500 to-orange-600 hover:from-orange-600 hover:to-amber-500 text-white text-xs sm:text-sm font-black px-6 py-2.5 rounded-full inline-flex items-center gap-2 shadow-lg shadow-orange-900/40 transition-transform hover:scale-105">
                                <span>মনিটর অফার দেখুন</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <span class="text-[11px] text-gray-300 font-medium">✓ ৩ বছরের অফিসিয়াল রিপ্লেসমেন্ট ওয়ারেন্টি</span>
                        </div>
                    </div>

                    <!-- Product Graphic Showcase (5 cols) -->
                    <div class="md:col-span-5 flex items-center justify-center relative mt-4 md:mt-0">
                        <div class="relative w-full max-w-[340px] flex items-center justify-center group">
                            <img 
                                src="{{ asset('images/banners/gaming_monitor.jpg') }}" 
                                alt="Curved Gaming Monitor" 
                                class="w-full h-48 sm:h-56 md:h-60 object-cover rounded-2xl shadow-2xl border-2 border-orange-500/40 transform rotate-1 group-hover:rotate-0 transition-transform duration-500"
                            />
                            <div class="absolute -top-3 -right-3 bg-gradient-to-tr from-amber-500 to-red-600 text-white rounded-full w-14 h-14 flex flex-col items-center justify-center shadow-2xl font-black text-[10px] leading-tight rotate-12 border-2 border-white">
                                <span>240Hz</span>
                                <span>1ms</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ambient Glow -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-orange-600/25 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <!-- Slider Controls: Previous & Next Arrows -->
            <button 
                type="button"
                @click="prevSlide()" 
                class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/50 hover:bg-starOrange text-white flex items-center justify-center backdrop-blur-md transition-all border border-white/20 shadow-xl z-20 cursor-pointer focus:outline-none"
                aria-label="Previous Slide"
            >
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button 
                type="button"
                @click="nextSlide()" 
                class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 rounded-full bg-black/50 hover:bg-starOrange text-white flex items-center justify-center backdrop-blur-md transition-all border border-white/20 shadow-xl z-20 cursor-pointer focus:outline-none"
                aria-label="Next Slide"
            >
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>

            <!-- Slider Navigation Dots Indicator -->
            <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-2 z-20 bg-black/40 backdrop-blur-md px-3.5 py-1.5 rounded-full border border-white/15 shadow-lg">
                <template x-for="i in slidesCount" :key="i">
                    <button 
                        type="button"
                        @click="activeSlide = i - 1" 
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="activeSlide === (i - 1) ? 'w-7 bg-starOrange shadow-sm' : 'w-2 bg-white/50 hover:bg-white'"
                        :aria-label="'Go to slide ' + i"
                    ></button>
                </template>
            </div>

        </div>

        <!-- Right Column Dual Side Banners (Col Span 1 - TechLand BD Signature Style) -->
        <div class="flex flex-col gap-4">
            
            <!-- Side Banner 1: Custom PC Builder -->
            <a 
                href="{{ route('shop.index', ['category' => 'desktop']) }}" 
                class="bg-gradient-to-br from-[#0c2e4e] via-[#08233d] to-[#041525] text-white p-5 rounded-2xl flex flex-col justify-between flex-1 border border-sky-500/30 shadow-lg relative overflow-hidden group hover:border-cyan-400 transition-all duration-300"
            >
                <div class="z-10">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] bg-cyan-500/20 text-cyan-300 font-extrabold px-2.5 py-0.5 rounded-full uppercase border border-cyan-500/30 tracking-wider">
                            Interactive Tool
                        </span>
                        <span class="flex items-center gap-1 text-[10px] text-cyan-300 font-bold">
                            <span class="w-2 h-2 rounded-full bg-cyan-400 animate-pulse"></span> LIVE
                        </span>
                    </div>
                    <h3 class="text-xl font-black mt-2.5 text-white group-hover:text-cyan-300 transition-colors">
                        Custom PC Builder
                    </h3>
                    <p class="text-xs text-gray-300 mt-1 leading-relaxed">
                        পছন্দের প্রসেসর, র‍্যাম ও জিপিইউ সিলেক্ট করে নিমেষেই তৈরি করুন আপনার পিসি।
                    </p>
                    <div class="flex flex-wrap gap-1.5 mt-2.5">
                        <span class="text-[10px] bg-white/10 text-cyan-200 px-2 py-0.5 rounded-md">✓ ফ্রি অ্যাসেম্বলি</span>
                        <span class="text-[10px] bg-white/10 text-cyan-200 px-2 py-0.5 rounded-md">✓ ৩ বছর ওয়ারেন্টি</span>
                    </div>
                </div>
                <div class="mt-4 z-10">
                    <span class="inline-flex items-center gap-2 bg-gradient-to-r from-cyan-400 to-cyan-500 group-hover:from-cyan-300 group-hover:to-cyan-400 text-slate-950 text-xs font-black px-4 py-2 rounded-full transition shadow-md">
                        <span>পিসি বিল্ড শুরু করুন</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
                <i class="fa-solid fa-microchip absolute -right-3 -bottom-3 text-7xl text-cyan-400/10 group-hover:scale-110 transition-transform"></i>
            </a>

            <!-- Side Banner 2: TechLand Mega Deals & Night Offers -->
            <a 
                href="{{ route('shop.index') }}" 
                class="bg-gradient-to-br from-[#c82333] via-[#9e1525] to-[#6f0d1a] text-white p-5 rounded-2xl flex flex-col justify-between flex-1 border border-red-500/30 shadow-lg relative overflow-hidden group hover:border-amber-400 transition-all duration-300"
            >
                <div class="z-10">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] bg-amber-400/20 text-amber-300 font-extrabold px-2.5 py-0.5 rounded-full uppercase border border-amber-400/30 tracking-wider">
                            Special Deals
                        </span>
                        <i class="fa-solid fa-fire text-amber-400 text-xs animate-bounce"></i>
                    </div>
                    <h3 class="text-xl font-black mt-2.5 leading-tight group-hover:text-amber-300 transition-colors">
                        TechLand Mega Offers
                    </h3>
                    <p class="text-xs text-gray-200 mt-1 leading-relaxed">
                        ল্যাপটপ, মনিটর ও অ্যাক্সেসরিজে ধামাকা ডিসকাউন্ট ও নিশ্চিত গিফট!
                    </p>
                    <div class="flex flex-wrap gap-1.5 mt-2.5">
                        <span class="text-[10px] bg-white/10 text-amber-200 px-2 py-0.5 rounded-md">✓ ০% EMI</span>
                        <span class="text-[10px] bg-white/10 text-amber-200 px-2 py-0.5 rounded-md">✓ ক্যাশ ভাউচার</span>
                    </div>
                </div>
                <div class="mt-4 z-10">
                    <span class="inline-flex items-center gap-2 bg-gradient-to-r from-amber-400 to-amber-500 group-hover:from-amber-300 group-hover:to-amber-400 text-slate-950 text-xs font-black px-4 py-2 rounded-full transition shadow-md">
                        <span>অফার দেখুন</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
                <i class="fa-solid fa-gift absolute -right-3 -bottom-3 text-7xl text-white/10 group-hover:scale-110 transition-transform"></i>
            </a>

        </div>
    </section>

    <!-- =========================================================================
         3. 4-PILLAR SERVICE / TRUST BAR (TECHLAND BD SIGNATURE STYLE)
         ========================================================================= -->
    <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3.5" data-purpose="service-pillars">
        <!-- 1. Express Delivery -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex items-center gap-3.5 hover:shadow-md transition-shadow group">
            <div class="w-12 h-12 rounded-xl bg-red-50 text-starOrange flex items-center justify-center text-xl shrink-0 group-hover:bg-starOrange group-hover:text-white transition-colors">
                <i class="fa-solid fa-truck-fast"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs sm:text-sm text-slate-800 group-hover:text-starOrange transition-colors">Fast Home Delivery</h4>
                <p class="text-[11px] text-gray-500">Dhaka in 2-4 Hours &amp; Nationwide</p>
            </div>
        </div>

        <!-- 2. 100% Genuine -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex items-center gap-3.5 hover:shadow-md transition-shadow group">
            <div class="w-12 h-12 rounded-xl bg-blue-50 text-starBlue flex items-center justify-center text-xl shrink-0 group-hover:bg-starBlue group-hover:text-white transition-colors">
                <i class="fa-solid fa-shield-check"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs sm:text-sm text-slate-800 group-hover:text-starBlue transition-colors">100% Genuine Tech</h4>
                <p class="text-[11px] text-gray-500">Official Brand Warranty</p>
            </div>
        </div>

        <!-- 3. 0% EMI Facility -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex items-center gap-3.5 hover:shadow-md transition-shadow group">
            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0 group-hover:bg-emerald-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-credit-card"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs sm:text-sm text-slate-800 group-hover:text-emerald-600 transition-colors">0% EMI Facility</h4>
                <p class="text-[11px] text-gray-500">Up to 36 Months with 20+ Banks</p>
            </div>
        </div>

        <!-- 4. Expert Care & Service -->
        <div class="bg-white p-4 rounded-xl shadow-sm border border-slate-100 flex items-center gap-3.5 hover:shadow-md transition-shadow group">
            <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0 group-hover:bg-amber-600 group-hover:text-white transition-colors">
                <i class="fa-solid fa-headset"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs sm:text-sm text-slate-800 group-hover:text-amber-600 transition-colors">24/7 Expert Support</h4>
                <p class="text-[11px] text-gray-500">Helpline: 16793 &amp; Live Chat</p>
            </div>
        </div>
    </section>

    <!-- =========================================================================
         4. FEATURED CATEGORY SECTION (16 ICON TILES)
         ========================================================================= -->
    <section class="space-y-4" data-purpose="featured-categories">
        <div class="text-center space-y-1">
            <h2 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">Featured Category</h2>
            <p class="text-xs md:text-sm text-gray-500">Get Your Desired Product from Featured Category!</p>
        </div>

        <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 gap-3">
            <!-- 1. AC -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'appliance', 'q' => 'ac']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-wind"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">AC</span>
            </a>

            <!-- 2. Portable Power Station -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'power']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-car-battery"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange leading-tight">Power Station</span>
            </a>

            <!-- 3. Air Fryer -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'appliance', 'q' => 'air fryer']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-fire-burner"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Air Fryer</span>
            </a>

            <!-- 4. Drone -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'camera', 'q' => 'drone']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-helicopter"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Drone</span>
            </a>

            <!-- 5. Gimbal -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'camera', 'q' => 'gimbal']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-video"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Gimbal</span>
            </a>

            <!-- 6. Table PC -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'tablet']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-tablet-screen-button"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Tablet PC</span>
            </a>

            <!-- 7. TV -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'tv']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-tv"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">TV</span>
            </a>

            <!-- 8. Fridge -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'appliance', 'q' => 'fridge']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-box-tissue"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Fridge</span>
            </a>

            <!-- 9. Mobile Phone -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'phone']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-mobile-screen-button"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Mobile Phone</span>
            </a>

            <!-- 10. Mobile Accessories -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'accessories']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-plug"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange leading-tight">Mobile Accessories</span>
            </a>

            <!-- 11. Health Monitor -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'gadget', 'q' => 'health']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-heart-pulse"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Health Monitor</span>
            </a>

            <!-- 12. WiFi Camera -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'security']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-camera-rotate"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">WiFi Camera</span>
            </a>

            <!-- 13. Trimmer -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'gadget', 'q' => 'trimmer']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-wand-magic-sparkles"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Trimmer</span>
            </a>

            <!-- 14. Smart Watch -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'gadget', 'q' => 'watch']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-stopwatch"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Smart Watch</span>
            </a>

            <!-- 15. Earbuds -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'gadget', 'q' => 'earbuds']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-headphones-simple"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Earbuds</span>
            </a>

            <!-- 16. Torch Light -->
            <a class="bg-white p-3 rounded-lg shadow-sm hover:shadow border border-slate-100 flex flex-col items-center justify-center text-center group transition" href="{{ route('shop.index', ['category' => 'gadget', 'q' => 'torch']) }}">
                <div class="w-10 h-10 flex items-center justify-center text-slate-600 group-hover:text-starOrange mb-1.5 text-2xl">
                    <i class="fa-solid fa-flashlight"></i>
                </div>
                <span class="text-[11px] font-semibold text-slate-700 group-hover:text-starOrange line-clamp-1">Torch Light</span>
            </a>
        </div>
    </section>

    <!-- =========================================================================
         5. MID-PAGE PROMOTIONAL CAMPAIGN BANNERS (TECHLAND BD SIGNATURE DUAL GRID)
         ========================================================================= -->
    <section class="grid grid-cols-1 md:grid-cols-2 gap-4" data-purpose="mid-campaign-banners">
        <!-- Mid Banner 1: Pro Gaming Gear Hub -->
        <a 
            href="{{ route('shop.index', ['category' => 'accessories']) }}" 
            class="bg-gradient-to-r from-[#18092d] via-[#260e3d] to-[#120724] rounded-2xl p-6 sm:p-7 text-white border border-purple-900/40 shadow-xl relative overflow-hidden group hover:border-purple-500/60 transition-all duration-300 flex flex-col justify-between min-h-[220px]"
        >
            <div class="grid grid-cols-12 gap-3 items-center z-10">
                <div class="col-span-7 sm:col-span-8 space-y-2">
                    <span class="inline-flex items-center gap-1.5 bg-purple-600/30 text-purple-300 text-[10px] sm:text-xs font-black px-2.5 py-0.5 rounded-full uppercase border border-purple-500/40 tracking-wider">
                        <i class="fa-solid fa-gamepad text-purple-300"></i> RGB GAMING HUB
                    </span>
                    <h3 class="text-lg sm:text-xl font-black text-white group-hover:text-purple-300 transition-colors leading-tight">
                        Pro Gaming Gear &amp; Peripherals
                    </h3>
                    <p class="text-xs text-purple-100/80 line-clamp-2">
                        মেকানিক্যাল কিবোর্ড, ওয়্যারলেস মাউস, ৭.১ হেডসেট ও গেমিং এক্সেসরিজ।
                    </p>
                    <div class="pt-2">
                        <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-purple-500 to-pink-500 group-hover:from-purple-400 group-hover:to-pink-400 text-white text-xs font-black px-4 py-2 rounded-full transition shadow-md">
                            <span>Explore Gear</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </div>
                </div>
                <div class="col-span-5 sm:col-span-4 flex justify-end">
                    <img 
                        src="{{ asset('images/banners/gaming_gear.jpg') }}" 
                        alt="Gaming Gear" 
                        class="w-28 h-28 sm:w-32 sm:h-32 object-cover rounded-xl shadow-2xl border-2 border-purple-500/40 group-hover:scale-105 group-hover:rotate-1 transition-transform duration-500"
                    />
                </div>
            </div>
            <!-- Glow Effect -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-purple-600/20 rounded-full blur-2xl pointer-events-none"></div>
        </a>

        <!-- Mid Banner 2: Supercharge Components & SSD Upgrade -->
        <a 
            href="{{ route('shop.index', ['category' => 'desktop']) }}" 
            class="bg-gradient-to-r from-[#031d30] via-[#072c4c] to-[#041624] rounded-2xl p-6 sm:p-7 text-white border border-cyan-900/40 shadow-xl relative overflow-hidden group hover:border-cyan-500/60 transition-all duration-300 flex flex-col justify-between min-h-[220px]"
        >
            <div class="grid grid-cols-12 gap-3 items-center z-10">
                <div class="col-span-7 sm:col-span-8 space-y-2">
                    <span class="inline-flex items-center gap-1.5 bg-cyan-600/30 text-cyan-300 text-[10px] sm:text-xs font-black px-2.5 py-0.5 rounded-full uppercase border border-cyan-500/40 tracking-wider">
                        <i class="fa-solid fa-bolt text-cyan-300"></i> HIGH SPEED UPGRADE
                    </span>
                    <h3 class="text-lg sm:text-xl font-black text-white group-hover:text-cyan-300 transition-colors leading-tight">
                        NVMe SSD &amp; DDR5 Memory
                    </h3>
                    <p class="text-xs text-cyan-100/80 line-clamp-2">
                        Gen4 আল্ট্রা-ফাস্ট M.2 এসএসডি, হাই-স্পিড র‍্যাম ও কুলিং সলিউশন।
                    </p>
                    <div class="pt-2">
                        <span class="inline-flex items-center gap-1.5 bg-gradient-to-r from-cyan-400 to-blue-500 group-hover:from-cyan-300 group-hover:to-blue-400 text-slate-950 text-xs font-black px-4 py-2 rounded-full transition shadow-md">
                            <span>Upgrade Rig</span>
                            <i class="fa-solid fa-arrow-right text-[10px]"></i>
                        </span>
                    </div>
                </div>
                <div class="col-span-5 sm:col-span-4 flex justify-end">
                    <img 
                        src="{{ asset('images/banners/components.jpg') }}" 
                        alt="PC Components" 
                        class="w-28 h-28 sm:w-32 sm:h-32 object-cover rounded-xl shadow-2xl border-2 border-cyan-500/40 group-hover:scale-105 group-hover:-rotate-1 transition-transform duration-500"
                    />
                </div>
            </div>
            <!-- Glow Effect -->
            <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-cyan-600/20 rounded-full blur-2xl pointer-events-none"></div>
        </a>
    </section>

    <!-- =========================================================================
         6. PHYSICAL STORES BANNER
         ========================================================================= -->
    <section class="bg-gradient-to-r from-[#0088cc] via-[#0297df] to-[#04689b] rounded-lg p-5 md:p-6 text-white shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-white/20 flex items-center justify-center text-2xl shrink-0">
                <i class="fa-solid fa-location-dot"></i>
            </div>
            <div>
                <h3 class="text-xl md:text-2xl font-bold leading-tight">20+ Physical Stores</h3>
                <p class="text-xs md:text-sm text-sky-100">Visit Our Store &amp; Get Your Desired IT Product!</p>
            </div>
        </div>
        <a class="bg-[#f59e0b] hover:bg-[#d97706] text-slate-900 font-bold px-6 py-2.5 rounded-full text-xs md:text-sm transition flex items-center gap-2 shrink-0 shadow" href="{{ route('shop.index') }}">
            <span>Find Our Store</span>
            <i class="fa-solid fa-magnifying-glass text-xs"></i>
        </a>
    </section>

    <!-- =========================================================================
         6. FEATURED PRODUCTS (20 OFFICIAL STAR TECH PRODUCTS GRID)
         ========================================================================= -->
    <section class="space-y-4" data-purpose="featured-products">
        <div class="text-center space-y-1">
            <h2 class="text-xl md:text-2xl font-bold text-slate-900 tracking-tight">Featured Products</h2>
            <p class="text-xs md:text-sm text-gray-500">Check &amp; Get Your Desired Product!</p>
        </div>

        <!-- 20 Product Grid (5 columns on desktop) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-md border border-slate-200 overflow-hidden flex flex-col justify-between hover:shadow-lg transition-shadow relative p-3 group">
                    
                    <!-- Dynamic Badge / Tag -->
                    @if($product->has_discount && ($product->price - $product->effective_price) > 0)
                        @php
                            $savingAmount = $product->price - $product->effective_price;
                        @endphp
                        <span class="absolute top-2 left-2 bg-[#6e42c1] text-white text-[10px] font-semibold px-2 py-0.5 rounded-xs z-10">
                            Save: {{ number_format($savingAmount) }}৳ (-{{ $product->discount_percentage }}%)
                        </span>
                    @elseif($product->effective_price > 80000)
                        <span class="absolute top-2 left-2 bg-[#082b49] text-white text-[10px] font-semibold px-2 py-0.5 rounded-xs z-10">
                            Earn Point: 450
                        </span>
                    @endif

                    <!-- Product Image Container -->
                    <a href="{{ route('product.show', $product->slug) }}" class="py-4 flex justify-center items-center h-44 block">
                        <img 
                            alt="{{ $product->name }}" 
                            class="max-h-36 max-w-full object-contain group-hover:scale-105 transition-transform duration-300" 
                            src="{{ $product->image }}"
                        />
                    </a>

                    <!-- Product Title & Price -->
                    <div class="border-t border-slate-100 pt-3 space-y-2">
                        <h3 class="text-xs font-semibold text-slate-800 group-hover:text-starOrange line-clamp-2 leading-relaxed">
                            <a href="{{ route('product.show', $product->slug) }}">
                                {{ $product->name }}
                            </a>
                        </h3>

                        <div class="flex items-center gap-2">
                            <span class="text-starOrange font-bold text-sm">{{ number_format($product->effective_price) }}৳</span>
                            @if($product->has_discount)
                                <span class="text-gray-400 line-through text-xs">{{ number_format($product->price) }}৳</span>
                            @endif
                        </div>

                        <!-- Quick Add to Cart Action -->
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="pt-1">
                            @csrf
                            <button type="submit" class="w-full py-1.5 bg-[#f2f4f8] hover:bg-starOrange hover:text-white text-slate-700 text-[11px] font-bold rounded transition flex items-center justify-center gap-1.5 cursor-pointer">
                                <i class="fa-solid fa-cart-plus text-[10px]"></i>
                                <span>Buy Now</span>
                            </button>
                        </form>
                    </div>

                </div>
            @endforeach
        </div>
    </section>

    <!-- =========================================================================
         7. BRAND NARRATIVE AND SEO ARTICLE
         ========================================================================= -->
    <article class="bg-white rounded-lg p-6 md:p-8 space-y-6 text-slate-600 text-xs md:text-[13px] leading-relaxed border border-slate-200/80 shadow-sm" data-purpose="seo-content">
        <div class="space-y-2">
            <h2 class="text-lg md:text-xl font-bold text-slate-900">Leading Computer, Laptop &amp; Gaming PC Retail &amp; Online Shop in Bangladesh</h2>
            <p>
                Technology has become an integral part of our daily lives, and we depend on tech products daily for work, study, and recreation. <a class="text-starOrange hover:underline font-semibold" href="#">SM Shop</a> is your premier destination for genuine tech gear in Bangladesh. We focus on giving the best customer service, adhering to our core principle: <strong>"Customer Comes First."</strong> This is why SM Shop is rapidly becoming one of the most <strong>trusted computer &amp; gadget shops in Bangladesh</strong>, providing official brand warranties, verified quality products, and express nationwide delivery.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">Best Laptop &amp; Desktop PC Shop in Bangladesh</h3>
            <p>
                SM Shop offers an extensive range of <a class="text-starOrange hover:underline font-semibold" href="{{ route('shop.index', ['category' => 'laptop']) }}">laptops</a> and <a class="text-starOrange hover:underline font-semibold" href="{{ route('shop.index', ['category' => 'desktop']) }}">desktop PCs</a>. Whether you are a student, programmer, creative professional, or gamer, we carry top brands including Asus, Lenovo, HP, Dell, MSI, Apple MacBook, Acer, and custom AMD Ryzen / Intel gaming rigs. Our experienced technical team helps you select the best components to fit your exact workload and budget.
            </p>
        </div>

        <div class="space-y-2">
            <h3 class="text-base font-bold text-slate-900">100% Genuine Components &amp; Fast Nationwide Delivery</h3>
            <p>
                At SM Shop, we guarantee 100% genuine products with official distributor warranties. We deliver to all 64 districts across Bangladesh with secure cash-on-delivery and digital payment options. For inquiries, advice, or order tracking, our support helpline and live chat team are always ready to assist you.
            </p>
        </div>
    </article>

</div>
@endsection