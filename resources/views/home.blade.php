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
         2. HERO PROMO BANNERS (INTERACTIVE SLIDER + DUAL TEASERS)
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
                }, 5000);
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
        <div class="lg:col-span-3 relative rounded-xl overflow-hidden shadow-md min-h-[320px] sm:min-h-[350px] md:min-h-[380px] bg-slate-950 flex flex-col justify-between border border-slate-800 group">
            
            <!-- SLIDE 1: Lenovo AMD Ryzen Laptop Campaign with Real Products -->
            <div 
                x-show="activeSlide === 0"
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-8"
                class="w-full h-full min-h-[320px] sm:min-h-[350px] md:min-h-[380px] bg-gradient-to-r from-[#1c072b] via-[#0d1629] to-[#2c080d] p-6 sm:p-8 md:p-10 flex flex-col justify-between relative overflow-hidden"
            >
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center h-full z-10">
                    <!-- Text Content (7 cols) -->
                    <div class="md:col-span-7 space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-block bg-red-600 text-white text-[10px] sm:text-xs uppercase px-3 py-1 rounded-full font-extrabold tracking-wider shadow">SPECIAL CAMPAIGN</span>
                            <span class="text-xs text-amber-400 font-bold flex items-center gap-1">
                                <i class="fa-solid fa-fire animate-pulse"></i> মেগা ডিল
                            </span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight tracking-tight text-white">
                            লেনোভো -এর <span class="text-red-500 font-extrabold">AMD Ryzen™ ল্যাপটপ</span><br/>
                            কিনলেই পাচ্ছেন নিশ্চিত উপহার
                        </h2>
                        <div class="bg-white/10 backdrop-blur-md rounded-lg p-3 border border-white/20 inline-block">
                            <p class="text-sm sm:text-base font-bold text-amber-300 flex items-center gap-2">
                                <i class="fa-solid fa-gift text-red-400 text-lg"></i>
                                স্মার্টওয়াচ অথবা প্রিমিয়াম এয়ারবাডস ফ্রি!
                            </p>
                        </div>
                        <div class="pt-2 flex items-center gap-3">
                            <a href="{{ route('shop.index', ['category' => 'laptop', 'q' => 'lenovo']) }}" class="bg-starOrange hover:bg-starOrangeHover text-white text-xs sm:text-sm font-bold px-6 py-2.5 rounded-full inline-flex items-center gap-2 shadow-lg transition-transform hover:scale-105">
                                <span>অফারটি লুফে নিন</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <span class="text-[11px] text-gray-300">*শর্ত প্রযোজ্য</span>
                        </div>
                    </div>

                    <!-- Product Graphic Showcase (5 cols) -->
                    <div class="md:col-span-5 flex items-center justify-center relative mt-4 md:mt-0">
                        <div class="relative w-full max-w-[340px] flex items-center justify-center">
                            <!-- Laptop Image -->
                            <img 
                                src="{{ asset('images/banners/laptop_gaming.jpg') }}" 
                                alt="Lenovo Gaming Laptop" 
                                class="w-full h-44 sm:h-52 md:h-56 object-cover rounded-xl shadow-2xl border-2 border-red-500/40 transform -rotate-1 hover:rotate-0 transition-transform duration-300"
                            />
                            <!-- Floating Free Gifts Badge -->
                            <div class="absolute -bottom-3 -left-3 bg-slate-900/95 border border-amber-400/80 rounded-lg p-2 shadow-xl flex items-center gap-2.5 backdrop-blur-md animate-bounce">
                                <img src="{{ asset('images/banners/smartwatch.jpg') }}" alt="Free Smartwatch" class="w-9 h-9 object-cover rounded-md border border-amber-400">
                                <div class="text-left leading-tight">
                                    <span class="text-[9px] text-amber-300 font-bold uppercase block">FREE GIFT</span>
                                    <span class="text-[11px] text-white font-black">Smartwatch &amp; Buds</span>
                                </div>
                            </div>
                            <!-- Discount Badge -->
                            <div class="absolute -top-3 -right-3 bg-red-600 text-white rounded-full w-14 h-14 flex flex-col items-center justify-center shadow-lg font-black text-[10px] leading-tight rotate-12 border-2 border-white">
                                <span>ধামাকা</span>
                                <span>অফার</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ambient Glow -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-red-600/20 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <!-- SLIDE 2: Custom Gaming PC Builder Mega Deal -->
            <div 
                x-show="activeSlide === 1"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-8"
                class="w-full h-full min-h-[320px] sm:min-h-[350px] md:min-h-[380px] bg-gradient-to-r from-[#031527] via-[#082b49] to-[#041d33] p-6 sm:p-8 md:p-10 flex flex-col justify-between relative overflow-hidden"
            >
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center h-full z-10">
                    <!-- Text Content (7 cols) -->
                    <div class="md:col-span-7 space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-block bg-starBlue text-white text-[10px] sm:text-xs uppercase px-3 py-1 rounded-full font-extrabold tracking-wider shadow">CUSTOM PC BUILDER</span>
                            <span class="text-xs text-cyan-300 font-bold flex items-center gap-1">
                                <i class="fa-solid fa-microchip"></i> RTX 40-Series
                            </span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight tracking-tight text-white">
                            বিল্ড করুন আপনার স্বপ্নের <span class="text-cyan-400 font-extrabold">গেমিং ও এডিটিং পিসি</span><br/>
                            সেরা দামে ও ০% EMI সুবিধায়
                        </h2>
                        <div class="bg-white/10 backdrop-blur-md rounded-lg p-3 border border-white/20 inline-block">
                            <p class="text-sm sm:text-base font-bold text-cyan-300 flex items-center gap-2">
                                <i class="fa-solid fa-keyboard text-cyan-400 text-lg"></i>
                                ফ্রি RGB মেকানিক্যাল কিবোর্ড ও মাউস বান্ডেল!
                            </p>
                        </div>
                        <div class="pt-2 flex items-center gap-3">
                            <a href="{{ route('shop.index', ['category' => 'desktop']) }}" class="bg-cyan-500 hover:bg-cyan-400 text-slate-950 text-xs sm:text-sm font-black px-6 py-2.5 rounded-full inline-flex items-center gap-2 shadow-lg transition-transform hover:scale-105">
                                <span>PC Builder শুরু করুন</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <span class="text-[11px] text-gray-300">৩ বছরের অফিসিয়াল রিপ্লেসমেন্ট ওয়ারেন্টি</span>
                        </div>
                    </div>

                    <!-- Product Graphic Showcase (5 cols) -->
                    <div class="md:col-span-5 flex items-center justify-center relative mt-4 md:mt-0">
                        <div class="relative w-full max-w-[340px] flex items-center justify-center">
                            <img 
                                src="{{ asset('images/banners/gaming_pc.jpg') }}" 
                                alt="RGB Gaming Desktop PC" 
                                class="w-full h-44 sm:h-52 md:h-56 object-cover rounded-xl shadow-2xl border-2 border-cyan-400/40 transform rotate-1 hover:rotate-0 transition-transform duration-300"
                            />
                            <div class="absolute -top-3 -right-3 bg-starBlue text-white rounded-full w-14 h-14 flex flex-col items-center justify-center shadow-lg font-black text-[10px] leading-tight rotate-12 border-2 border-white">
                                <span>INTEL</span>
                                <span>GEN-14</span>
                            </div>
                            <div class="absolute -bottom-3 -left-3 bg-slate-900/95 border border-cyan-400/80 rounded-lg p-2 shadow-xl flex items-center gap-2 backdrop-blur-md">
                                <i class="fa-solid fa-shield-halved text-cyan-400 text-lg"></i>
                                <span class="text-[11px] text-white font-bold">100% Genuine Components</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ambient Glow -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-cyan-500/20 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <!-- SLIDE 3: Apple MacBook M3 Official Deal -->
            <div 
                x-show="activeSlide === 2"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-8"
                class="w-full h-full min-h-[320px] sm:min-h-[350px] md:min-h-[380px] bg-gradient-to-r from-[#0a1816] via-[#102422] to-[#081315] p-6 sm:p-8 md:p-10 flex flex-col justify-between relative overflow-hidden"
            >
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center h-full z-10">
                    <!-- Text Content (7 cols) -->
                    <div class="md:col-span-7 space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-block bg-emerald-600 text-white text-[10px] sm:text-xs uppercase px-3 py-1 rounded-full font-extrabold tracking-wider shadow">OFFICIAL APPLE FEST</span>
                            <span class="text-xs text-emerald-400 font-bold flex items-center gap-1">
                                <i class="fa-brands fa-apple"></i> Apple M3 Series
                            </span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight tracking-tight text-white">
                            Apple <span class="text-emerald-400 font-extrabold">MacBook Pro &amp; Air M3</span><br/>
                            অফিশিয়াল ওয়ারেন্টি ও এক্সক্লুসিভ ক্যাশব্যাক
                        </h2>
                        <div class="bg-white/10 backdrop-blur-md rounded-lg p-3 border border-white/20 inline-block">
                            <p class="text-sm sm:text-base font-bold text-white flex items-center gap-2">
                                <i class="fa-solid fa-credit-card text-emerald-400 text-lg"></i>
                                ৩৬ মাস পর্যন্ত ০% EMI ও ক্যাশ ডিসকাউন্ট!
                            </p>
                        </div>
                        <div class="pt-2 flex items-center gap-3">
                            <a href="{{ route('shop.index', ['category' => 'laptop', 'q' => 'apple']) }}" class="bg-emerald-500 hover:bg-emerald-400 text-slate-900 text-xs sm:text-sm font-black px-6 py-2.5 rounded-full inline-flex items-center gap-2 shadow-lg transition-transform hover:scale-105">
                                <span>ম্যাকবুক কালেকশন দেখুন</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <span class="text-[11px] text-gray-300">১ বছরের ইন্টারন্যাশনাল ওয়ারেন্টি</span>
                        </div>
                    </div>

                    <!-- Product Graphic Showcase (5 cols) -->
                    <div class="md:col-span-5 flex items-center justify-center relative mt-4 md:mt-0">
                        <div class="relative w-full max-w-[340px] flex items-center justify-center">
                            <img 
                                src="{{ asset('images/banners/macbook.jpg') }}" 
                                alt="Apple MacBook Pro M3" 
                                class="w-full h-44 sm:h-52 md:h-56 object-cover rounded-xl shadow-2xl border-2 border-emerald-500/40 transform -rotate-1 hover:rotate-0 transition-transform duration-300"
                            />
                            <div class="absolute -top-3 -right-3 bg-white text-slate-900 rounded-full w-14 h-14 flex flex-col items-center justify-center shadow-lg font-black text-[10px] leading-tight rotate-12 border-2 border-emerald-400">
                                <span>M3</span>
                                <span>CHIP</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ambient Glow -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-emerald-500/20 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <!-- SLIDE 4: Curved Gaming Monitor Mega Deal -->
            <div 
                x-show="activeSlide === 3"
                x-cloak
                x-transition:enter="transition ease-out duration-500"
                x-transition:enter-start="opacity-0 translate-x-8"
                x-transition:enter-end="opacity-100 translate-x-0"
                x-transition:leave="transition ease-in duration-300 absolute inset-0"
                x-transition:leave-start="opacity-100 translate-x-0"
                x-transition:leave-end="opacity-0 -translate-x-8"
                class="w-full h-full min-h-[320px] sm:min-h-[350px] md:min-h-[380px] bg-gradient-to-r from-[#290a13] via-[#1a0815] to-[#28080d] p-6 sm:p-8 md:p-10 flex flex-col justify-between relative overflow-hidden"
            >
                <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center h-full z-10">
                    <!-- Text Content (7 cols) -->
                    <div class="md:col-span-7 space-y-3">
                        <div class="flex items-center gap-2">
                            <span class="inline-block bg-starOrange text-white text-[10px] sm:text-xs uppercase px-3 py-1 rounded-full font-extrabold tracking-wider shadow">HOT DEAL 2026</span>
                            <span class="text-xs text-amber-400 font-bold flex items-center gap-1">
                                <i class="fa-solid fa-display"></i> 240Hz Gaming
                            </span>
                        </div>
                        <h2 class="text-2xl sm:text-3xl md:text-4xl font-black leading-tight tracking-tight text-white">
                            240Hz <span class="text-starOrange font-extrabold">Curved Gaming Monitor</span><br/>
                            নির্বাচিত মডেলে আকর্ষণীয় ক্যাশ ডিসকাউন্ট
                        </h2>
                        <div class="bg-white/10 backdrop-blur-md rounded-lg p-3 border border-white/20 inline-block">
                            <p class="text-sm sm:text-base font-bold text-amber-300 flex items-center gap-2">
                                <i class="fa-solid fa-tags text-starOrange text-lg"></i>
                                আপ টু ১৫,০০০৳ ডিসকাউন্ট ও ফ্রি ডেলিভারি!
                            </p>
                        </div>
                        <div class="pt-2 flex items-center gap-3">
                            <a href="{{ route('shop.index', ['category' => 'monitor']) }}" class="bg-starOrange hover:bg-starOrangeHover text-white text-xs sm:text-sm font-bold px-6 py-2.5 rounded-full inline-flex items-center gap-2 shadow-lg transition-transform hover:scale-105">
                                <span>মনিটর কালেকশন দেখুন</span>
                                <i class="fa-solid fa-arrow-right text-xs"></i>
                            </a>
                            <span class="text-[11px] text-gray-300">ASUS • MSI • Gigabyte • Samsung</span>
                        </div>
                    </div>

                    <!-- Product Graphic Showcase (5 cols) -->
                    <div class="md:col-span-5 flex items-center justify-center relative mt-4 md:mt-0">
                        <div class="relative w-full max-w-[340px] flex items-center justify-center">
                            <img 
                                src="{{ asset('images/banners/gaming_monitor.jpg') }}" 
                                alt="Curved Gaming Monitor" 
                                class="w-full h-44 sm:h-52 md:h-56 object-cover rounded-xl shadow-2xl border-2 border-starOrange/40 transform rotate-1 hover:rotate-0 transition-transform duration-300"
                            />
                            <div class="absolute -top-3 -right-3 bg-starOrange text-white rounded-full w-14 h-14 flex flex-col items-center justify-center shadow-lg font-black text-[10px] leading-tight rotate-12 border-2 border-white">
                                <span>240Hz</span>
                                <span>1ms</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Ambient Glow -->
                <div class="absolute -right-20 -bottom-20 w-80 h-80 bg-starOrange/20 rounded-full blur-3xl pointer-events-none"></div>
            </div>

            <!-- Slider Controls: Previous & Next Arrows -->
            <button 
                type="button"
                @click="prevSlide()" 
                class="absolute left-3 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-black/40 hover:bg-starOrange text-white flex items-center justify-center backdrop-blur-sm transition border border-white/10 shadow-lg z-20 cursor-pointer focus:outline-none"
                aria-label="Previous Slide"
            >
                <i class="fa-solid fa-chevron-left text-sm"></i>
            </button>
            <button 
                type="button"
                @click="nextSlide()" 
                class="absolute right-3 top-1/2 -translate-y-1/2 w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-black/40 hover:bg-starOrange text-white flex items-center justify-center backdrop-blur-sm transition border border-white/10 shadow-lg z-20 cursor-pointer focus:outline-none"
                aria-label="Next Slide"
            >
                <i class="fa-solid fa-chevron-right text-sm"></i>
            </button>

            <!-- Slider Navigation Dots Indicator -->
            <div class="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-2 z-20 bg-black/30 backdrop-blur-sm px-3 py-1.5 rounded-full border border-white/10">
                <template x-for="i in slidesCount" :key="i">
                    <button 
                        type="button"
                        @click="activeSlide = i - 1" 
                        class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                        :class="activeSlide === (i - 1) ? 'w-6 bg-starOrange' : 'w-2 bg-white/50 hover:bg-white'"
                        :aria-label="'Go to slide ' + i"
                    ></button>
                </template>
            </div>

        </div>

        <!-- Right Column Dual Teasers (Col Span 1) -->
        <div class="flex flex-col gap-4">
            
            <!-- Teaser 1: Custom PC Builder -->
            <a 
                href="{{ route('shop.index', ['category' => 'desktop']) }}" 
                class="bg-gradient-to-br from-[#0c2e4e] via-[#08233d] to-[#041525] text-white p-5 rounded-xl flex flex-col justify-between flex-1 border border-sky-900/50 shadow-sm relative overflow-hidden group hover:border-starBlue transition-all"
            >
                <div class="z-10">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] bg-cyan-500/20 text-cyan-300 font-bold px-2 py-0.5 rounded uppercase border border-cyan-500/30">Interactive Tool</span>
                        <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    </div>
                    <h3 class="text-xl font-black mt-2 text-white group-hover:text-cyan-300 transition-colors">
                        PC Builder
                    </h3>
                    <p class="text-xs text-gray-300 mt-1 leading-relaxed">
                        পছন্দের প্রসেসর, র‍্যাম ও জিপিইউ দিয়ে তৈরি করুন কাস্টম রিগ।
                    </p>
                </div>
                <div class="mt-4 z-10">
                    <span class="inline-flex items-center gap-2 bg-cyan-500 group-hover:bg-cyan-400 text-slate-950 text-xs font-bold px-4 py-2 rounded-full transition shadow">
                        <span>পিসি বিল্ড করুন</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
                <i class="fa-solid fa-microchip absolute -right-3 -bottom-3 text-7xl text-cyan-400/10 group-hover:scale-110 transition-transform"></i>
            </a>

            <!-- Teaser 2: Store Locator & Warranty Support -->
            <a 
                href="{{ route('shop.index') }}" 
                class="bg-gradient-to-br from-[#bf2e1b] via-[#991b1b] to-[#7f1d1d] text-white p-5 rounded-xl flex flex-col justify-between flex-1 border border-red-800/50 shadow-sm relative overflow-hidden group hover:border-starOrange transition-all"
            >
                <div class="z-10">
                    <div class="flex items-center justify-between">
                        <span class="text-[10px] bg-white/20 text-white font-bold px-2 py-0.5 rounded uppercase">20+ Outlets</span>
                        <i class="fa-solid fa-store text-amber-300 text-xs"></i>
                    </div>
                    <h3 class="text-xl font-black mt-2 leading-tight group-hover:text-amber-300 transition-colors">
                        Store Locator &amp;<br/>Official Warranty
                    </h3>
                    <p class="text-xs text-gray-200 mt-1 leading-relaxed">
                        সারাদেশে ফাস্ট হোম ডেলিভারি ও ১০০% জেনুইন টেক পণ্য।
                    </p>
                </div>
                <div class="mt-4 z-10">
                    <span class="inline-flex items-center gap-2 bg-amber-400 group-hover:bg-amber-300 text-slate-950 text-xs font-bold px-4 py-2 rounded-full transition shadow">
                        <span>আউটলেট দেখুন</span>
                        <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
                <i class="fa-solid fa-shield-check absolute -right-3 -bottom-3 text-7xl text-white/10 group-hover:scale-110 transition-transform"></i>
            </a>

        </div>
    </section>

    <!-- =========================================================================
         3. QUICK FEATURE TOOLS (4 CARDS)
         ========================================================================= -->
    <section class="grid grid-cols-2 md:grid-cols-4 gap-3.5" data-purpose="quick-tools">
        <!-- Laptop Finder -->
        <a class="bg-white p-3.5 rounded-lg shadow-sm hover:shadow transition-shadow flex items-center gap-3.5 border border-slate-100 group" href="{{ route('shop.index', ['category' => 'laptop']) }}">
            <div class="w-11 h-11 rounded-full bg-red-100 text-starOrange flex items-center justify-center text-lg shrink-0 group-hover:bg-starOrange group-hover:text-white transition-colors">
                <i class="fa-solid fa-laptop"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs md:text-sm text-slate-800">Laptop Finder</h4>
                <p class="text-[11px] text-gray-500">Find Your Laptop Easily</p>
            </div>
        </a>

        <!-- Raise a Complain -->
        <a class="bg-white p-3.5 rounded-lg shadow-sm hover:shadow transition-shadow flex items-center gap-3.5 border border-slate-100 group" href="{{ route('shop.index') }}">
            <div class="w-11 h-11 rounded-full bg-red-100 text-starOrange flex items-center justify-center text-lg shrink-0 group-hover:bg-starOrange group-hover:text-white transition-colors">
                <i class="fa-regular fa-comment-dots"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs md:text-sm text-slate-800">Raise a Complain</h4>
                <p class="text-[11px] text-gray-500">Share your experience</p>
            </div>
        </a>

        <!-- AC Ton Calculator -->
        <a class="bg-white p-3.5 rounded-lg shadow-sm hover:shadow transition-shadow flex items-center gap-3.5 border border-slate-100 group" href="{{ route('shop.index', ['category' => 'appliance']) }}">
            <div class="w-11 h-11 rounded-full bg-red-100 text-starOrange flex items-center justify-center text-lg shrink-0 group-hover:bg-starOrange group-hover:text-white transition-colors">
                <i class="fa-solid fa-snowflake"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs md:text-sm text-slate-800">AC Ton Calculator</h4>
                <p class="text-[11px] text-gray-500">Find Perfect AC</p>
            </div>
        </a>

        <!-- Servicing Center -->
        <a class="bg-white p-3.5 rounded-lg shadow-sm hover:shadow transition-shadow flex items-center gap-3.5 border border-slate-100 group" href="{{ route('shop.index') }}">
            <div class="w-11 h-11 rounded-full bg-red-100 text-starOrange flex items-center justify-center text-lg shrink-0 group-hover:bg-starOrange group-hover:text-white transition-colors">
                <i class="fa-solid fa-screwdriver-wrench"></i>
            </div>
            <div>
                <h4 class="font-bold text-xs md:text-sm text-slate-800">Servicing Center</h4>
                <p class="text-[11px] text-gray-500">Repair Your Device</p>
            </div>
        </a>
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
         5. PHYSICAL STORES BANNER
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