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
        class="grid grid-cols-1 lg:grid-cols-4 gap-3.5 lg:gap-4" 
        data-purpose="hero-promotions"
        x-data="{
            activeSlide: 0,
            slidesCount: 6,
            timer: null,
            touchStartX: 0,
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
        @touchstart="touchStartX = $event.changedTouches[0].screenX"
        @touchend="if ($event.changedTouches[0].screenX < touchStartX - 30) nextSlide(); if ($event.changedTouches[0].screenX > touchStartX + 30) prevSlide();"
    >
        <!-- Main Promotional Slider Area (Col Span 3) -->
        <div class="lg:col-span-3 relative rounded-xl sm:rounded-2xl overflow-hidden shadow-sm sm:shadow-md aspect-[16/9] bg-white border border-slate-200/80 group">
            
            <!-- SLIDE 1: PURE PRODUCT SHOWCASE - GAMING LAPTOP -->
            <a 
                href="{{ route('shop.index', ['category' => 'laptop']) }}"
                x-show="activeSlide === 0"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8 scale-98"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-x-8 scale-98"
                class="w-full h-full block relative overflow-hidden group cursor-pointer"
            >
                <img 
                    src="{{ asset('images/banners/clean_banner_laptop.jpg') }}" 
                    alt="SM Shop - Gaming Laptops" 
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.02]"
                />
            </a>

            <!-- SLIDE 2: PURE PRODUCT SHOWCASE - CUSTOM GAMING PC RIG -->
            <a 
                href="{{ route('shop.index', ['category' => 'desktop']) }}"
                x-show="activeSlide === 1"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8 scale-98"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-x-8 scale-98"
                class="w-full h-full block relative overflow-hidden group cursor-pointer"
            >
                <img 
                    src="{{ asset('images/banners/clean_banner_pc.jpg') }}" 
                    alt="SM Shop - Custom Gaming Desktop PC" 
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.02]"
                />
            </a>

            <!-- SLIDE 3: PURE PRODUCT SHOWCASE - APPLE MACBOOK PRO & WORKSPACE -->
            <a 
                href="{{ route('shop.index', ['category' => 'laptop', 'q' => 'apple']) }}"
                x-show="activeSlide === 2"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8 scale-98"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-x-8 scale-98"
                class="w-full h-full block relative overflow-hidden group cursor-pointer"
            >
                <img 
                    src="{{ asset('images/banners/clean_banner_macbook.jpg') }}" 
                    alt="SM Shop - Apple MacBook Pro & Workspace" 
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.02]"
                />
            </a>

            <!-- SLIDE 4: PURE PRODUCT SHOWCASE - CURVED ULTRAWIDE GAMING MONITOR -->
            <a 
                href="{{ route('shop.index', ['category' => 'monitor']) }}"
                x-show="activeSlide === 3"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8 scale-98"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-x-8 scale-98"
                class="w-full h-full block relative overflow-hidden group cursor-pointer"
            >
                <img 
                    src="{{ asset('images/banners/clean_banner_monitor.jpg') }}" 
                    alt="SM Shop - Curved Ultrawide Gaming Monitor" 
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.02]"
                />
            </a>

            <!-- SLIDE 5: PURE PRODUCT SHOWCASE - SMART GADGETS & AUDIO -->
            <a 
                href="{{ route('shop.index', ['category' => 'accessories']) }}"
                x-show="activeSlide === 4"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8 scale-98"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-x-8 scale-98"
                class="w-full h-full block relative overflow-hidden group cursor-pointer"
            >
                <img 
                    src="{{ asset('images/banners/clean_banner_gadgets.jpg') }}" 
                    alt="SM Shop - Smartwatch, Headphones & Audio" 
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.02]"
                />
            </a>

            <!-- SLIDE 6: PURE PRODUCT SHOWCASE - PC HARDWARE & COMPONENTS -->
            <a 
                href="{{ route('shop.index', ['category' => 'desktop']) }}"
                x-show="activeSlide === 5"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8 scale-98"
                x-transition:enter-end="opacity-100 translate-x-0 scale-100"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0 scale-100"
                x-transition:leave-end="opacity-0 -translate-x-8 scale-98"
                class="w-full h-full block relative overflow-hidden group cursor-pointer"
            >
                <img 
                    src="{{ asset('images/banners/clean_banner_hardware.jpg') }}" 
                    alt="SM Shop - PC Components & Hardware" 
                    class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.02]"
                />
            </a>

            <!-- Slider Controls: Previous & Next Arrows -->
            <button 
                type="button"
                @click="prevSlide()" 
                class="absolute left-2 sm:left-3 top-1/2 -translate-y-1/2 w-7 h-7 sm:w-9 sm:h-9 lg:w-10 lg:h-10 rounded-full bg-black/40 hover:bg-starOrange text-white flex items-center justify-center backdrop-blur-md transition-all border border-white/40 shadow-md z-20 cursor-pointer focus:outline-none text-xs sm:text-sm"
                aria-label="Previous Slide"
            >
                <i class="fa-solid fa-chevron-left"></i>
            </button>
            <button 
                type="button"
                @click="nextSlide()" 
                class="absolute right-2 sm:right-3 top-1/2 -translate-y-1/2 w-7 h-7 sm:w-9 sm:h-9 lg:w-10 lg:h-10 rounded-full bg-black/40 hover:bg-starOrange text-white flex items-center justify-center backdrop-blur-md transition-all border border-white/40 shadow-md z-20 cursor-pointer focus:outline-none text-xs sm:text-sm"
                aria-label="Next Slide"
            >
                <i class="fa-solid fa-chevron-right"></i>
            </button>

            <!-- Slider Navigation Dots Indicator -->
            <div class="absolute bottom-2.5 sm:bottom-3.5 lg:bottom-4 left-1/2 -translate-x-1/2 flex items-center gap-1.5 lg:gap-2 z-20 bg-black/40 backdrop-blur-md px-2.5 py-1 lg:px-3.5 lg:py-1.5 rounded-full border border-white/30 shadow-md">
                <template x-for="i in slidesCount" :key="i">
                    <button 
                        type="button"
                        @click="activeSlide = i - 1" 
                        class="h-1.5 sm:h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="activeSlide === (i - 1) ? 'w-5 sm:w-7 bg-starOrange shadow-sm' : 'w-1.5 sm:w-2 bg-white/60 hover:bg-white'"
                        :aria-label="'Go to slide ' + i"
                    ></button>
                </template>
            </div>

        </div>

        <!-- Right Column Dual Side Banners (Col Span 1 - Compact 2-column on mobile, vertical stack on desktop) -->
        <div class="grid grid-cols-2 lg:flex lg:flex-col gap-3 lg:gap-4">
            
            <!-- Side Banner 1: Custom PC Rig Showcase -->
            <a 
                href="{{ route('shop.index', ['category' => 'desktop']) }}" 
                class="rounded-xl sm:rounded-2xl overflow-hidden shadow-sm sm:shadow-md border border-slate-200/80 relative group hover:border-starOrange transition-all duration-300 block aspect-[16/9] lg:aspect-auto lg:flex-1 bg-white"
            >
                <img 
                    src="{{ asset('images/banners/clean_banner_pc.jpg') }}" 
                    alt="SM Shop Custom PC Rig Showcase" 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
            </a>

            <!-- Side Banner 2: Smart Gadgets & Audio Showcase -->
            <a 
                href="{{ route('shop.index', ['category' => 'accessories']) }}" 
                class="rounded-xl sm:rounded-2xl overflow-hidden shadow-sm sm:shadow-md border border-slate-200/80 relative group hover:border-starOrange transition-all duration-300 block aspect-[16/9] lg:aspect-auto lg:flex-1 bg-white"
            >
                <img 
                    src="{{ asset('images/banners/clean_banner_gadgets.jpg') }}" 
                    alt="SM Shop Smart Gadgets Showcase" 
                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                />
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
         5. MID-PAGE PROMOTIONAL CAMPAIGN BANNERS (CLEAN FULL-SIZE PRODUCT BANNERS)
         ========================================================================= -->
    <section class="grid grid-cols-2 gap-3 md:gap-4" data-purpose="mid-campaign-banners">
        <!-- Mid Banner 1: Pure Product Showcase - Pro Gaming Peripherals & Gear -->
        <a 
            href="{{ route('shop.index', ['category' => 'accessories']) }}" 
            class="rounded-xl md:rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-200/80 relative block group aspect-[16/8] sm:aspect-[16/7] md:aspect-[16/6] bg-white transition-all duration-300"
        >
            <img 
                src="{{ asset('images/banners/clean_mid_gaming_peripherals.jpg') }}" 
                alt="SM Shop - Pro Gaming Gear & Peripherals" 
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.03]"
            />
        </a>

        <!-- Mid Banner 2: Pure Product Showcase - High-Speed PC Hardware & Components Upgrade -->
        <a 
            href="{{ route('shop.index', ['category' => 'desktop']) }}" 
            class="rounded-xl md:rounded-2xl overflow-hidden shadow-sm hover:shadow-xl border border-slate-200/80 relative block group aspect-[16/8] sm:aspect-[16/7] md:aspect-[16/6] bg-white transition-all duration-300"
        >
            <img 
                src="{{ asset('images/banners/clean_mid_hardware_upgrade.jpg') }}" 
                alt="SM Shop - PC Components & Hardware Upgrade" 
                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-[1.03]"
            />
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
         6. BEST DEALS & MEGA OFFERS SECTION
         ========================================================================= -->
    @if($bestDeals->isNotEmpty())
    <section class="space-y-4" data-purpose="best-deals">
        <div class="bg-gradient-to-r from-rose-600 via-rose-500 to-amber-500 rounded-xl p-4 sm:p-5 text-white shadow-sm flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-lg bg-white/20 backdrop-blur-md flex items-center justify-center text-xl shrink-0 text-amber-200 shadow-inner">
                    <i class="fa-solid fa-bolt-lightning animate-pulse"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="text-lg md:text-xl font-black tracking-tight text-white uppercase">Best Deals &amp; Mega Offers</h2>
                        <span class="bg-amber-400 text-slate-900 text-[10px] font-black px-2 py-0.5 rounded-full uppercase tracking-wider">HOT</span>
                    </div>
                    <p class="text-xs text-rose-100">সেরা মূল্যে সীমিত সময়ের বিশেষ অফার ও সুপার ডিসকাউন্ট!</p>
                </div>
            </div>

            <!-- Countdown Timer Aspirational Badge & View All -->
            <div class="flex items-center gap-3 w-full md:w-auto justify-between md:justify-end">
                <div class="flex items-center gap-1.5 text-xs font-bold bg-black/25 px-3 py-1.5 rounded-lg border border-white/20">
                    <i class="fa-regular fa-clock text-amber-300"></i>
                    <span>Flash Ends In:</span>
                    <span class="bg-white text-rose-600 px-1.5 py-0.5 rounded text-[11px] font-mono font-black">24H</span>
                </div>
                <a href="{{ route('shop.index') }}" class="bg-white hover:bg-rose-50 text-rose-600 font-bold px-4 py-2 rounded-lg text-xs transition flex items-center gap-1.5 shrink-0 shadow-sm">
                    <span>View All Deals</span>
                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                </a>
            </div>
        </div>

        <!-- Best Deals Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($bestDeals as $product)
                @include('partials.product-card', ['product' => $product, 'badgeText' => 'BEST DEAL', 'badgeClass' => 'bg-rose-600 text-white'])
            @endforeach
        </div>
    </section>
    @endif

    <!-- =========================================================================
         7. TRENDING PRODUCTS (HOT PICKS)
         ========================================================================= -->
    @if($trendingProducts->isNotEmpty())
    <section class="space-y-4" data-purpose="trending-products">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200/80 pb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center text-sm font-bold border border-amber-200">
                    <i class="fa-solid fa-fire-flame-curved"></i>
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <span>Trending Products</span>
                        <span class="text-[11px] font-semibold text-amber-600 bg-amber-50 px-2 py-0.5 rounded-full border border-amber-200">Popular</span>
                    </h2>
                    <p class="text-xs text-gray-500">বর্তমানে সবচেয়ে জনপ্রিয় ও ট্রেন্ডিং আইটেমস!</p>
                </div>
            </div>
            <a href="{{ route('shop.index') }}" class="text-xs font-bold text-starOrange hover:text-starOrangeHover transition flex items-center gap-1.5 self-start sm:self-auto group">
                <span>See All Trending</span>
                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <!-- Trending Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($trendingProducts as $product)
                @include('partials.product-card', ['product' => $product, 'badgeText' => 'TRENDING', 'badgeClass' => 'bg-amber-500 text-white'])
            @endforeach
        </div>
    </section>
    @endif

    <!-- =========================================================================
         8. NEW ARRIVALS (FRESH DROPS)
         ========================================================================= -->
    @if($newArrivals->isNotEmpty())
    <section class="space-y-4" data-purpose="new-arrivals">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200/80 pb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm font-bold border border-emerald-200">
                    <i class="fa-solid fa-sparkles"></i>
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <span>New Arrivals</span>
                        <span class="text-[11px] font-semibold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full border border-emerald-200">Just In</span>
                    </h2>
                    <p class="text-xs text-gray-500">নতুন যুক্ত হওয়া লেটেস্ট প্রোডাক্ট ও কালেকশন!</p>
                </div>
            </div>
            <a href="{{ route('shop.index') }}" class="text-xs font-bold text-starOrange hover:text-starOrangeHover transition flex items-center gap-1.5 self-start sm:self-auto group">
                <span>View All New Drops</span>
                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <!-- New Arrivals Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($newArrivals as $product)
                @include('partials.product-card', ['product' => $product, 'badgeText' => 'NEW ARRIVAL', 'badgeClass' => 'bg-emerald-600 text-white'])
            @endforeach
        </div>
    </section>
    @endif

    <!-- =========================================================================
         9. FEATURED PRODUCTS (HANDPICKED STORE SELECTIONS)
         ========================================================================= -->
    @if($featuredProducts->isNotEmpty())
    <section class="space-y-4" data-purpose="featured-products">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200/80 pb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-blue-50 text-starBlue flex items-center justify-center text-sm font-bold border border-blue-200">
                    <i class="fa-solid fa-star"></i>
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <span>Featured Products</span>
                        <span class="text-[11px] font-semibold text-blue-700 bg-blue-50 px-2 py-0.5 rounded-full border border-blue-200">Top Picks</span>
                    </h2>
                    <p class="text-xs text-gray-500">Check &amp; Get Your Desired Product from SM Shop!</p>
                </div>
            </div>
            <a href="{{ route('shop.index') }}" class="text-xs font-bold text-starOrange hover:text-starOrangeHover transition flex items-center gap-1.5 self-start sm:self-auto group">
                <span>Browse Catalog</span>
                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <!-- Featured Product Grid (5 columns on desktop) -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($featuredProducts as $product)
                @include('partials.product-card', ['product' => $product, 'badgeText' => 'FEATURED', 'badgeClass' => 'bg-[#1b84ff] text-white'])
            @endforeach
        </div>
    </section>
    @endif

    <!-- =========================================================================
         10. TOP RATED / CUSTOMER FAVORITES
         ========================================================================= -->
    @if($topRatedProducts->isNotEmpty())
    <section class="space-y-4" data-purpose="top-rated-products">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2 border-b border-slate-200/80 pb-3">
            <div class="flex items-center gap-2.5">
                <div class="w-8 h-8 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center text-sm font-bold border border-purple-200">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <div>
                    <h2 class="text-lg md:text-xl font-bold text-slate-900 tracking-tight flex items-center gap-2">
                        <span>Top Rated Products</span>
                        <span class="text-[11px] font-semibold text-purple-700 bg-purple-50 px-2 py-0.5 rounded-full border border-purple-200">★ 4.8+</span>
                    </h2>
                    <p class="text-xs text-gray-500">গ্রাহকদের সর্বোচ্চ রেটিং ও রিভিউ প্রাপ্ত সেরা কালেকশন!</p>
                </div>
            </div>
            <a href="{{ route('shop.index') }}" class="text-xs font-bold text-starOrange hover:text-starOrangeHover transition flex items-center gap-1.5 self-start sm:self-auto group">
                <span>See All Reviews</span>
                <i class="fa-solid fa-arrow-right text-[10px] group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <!-- Top Rated Product Grid -->
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-3">
            @foreach($topRatedProducts as $product)
                @include('partials.product-card', ['product' => $product, 'badgeText' => 'TOP RATED', 'badgeClass' => 'bg-purple-600 text-white'])
            @endforeach
        </div>
    </section>
    @endif

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