@extends('layouts.app')

@section('title', 'SM Shop - Tech, Gadgets & Fashion Apparel')

@section('content')

<!-- =========================================================================
     1. HIGH-IMPACT MULTI-SLIDE HERO BANNER (TECH & FASHION SLIDER)
     ========================================================================= -->
<section 
    x-data="{ 
        currentSlide: 0, 
        slidesCount: 3, 
        autoplayTimer: null,
        isPaused: false,
        init() {
            this.startAutoplay();
        },
        startAutoplay() {
            this.autoplayTimer = setInterval(() => {
                if (!this.isPaused) {
                    this.nextSlide();
                }
            }, 6000);
        },
        nextSlide() {
            this.currentSlide = (this.currentSlide + 1) % this.slidesCount;
        },
        prevSlide() {
            this.currentSlide = (this.currentSlide - 1 + this.slidesCount) % this.slidesCount;
        },
        goToSlide(index) {
            this.currentSlide = index;
        }
    }" 
    @mouseenter="isPaused = true" 
    @mouseleave="isPaused = false"
    class="relative min-h-[640px] sm:min-h-[720px] lg:min-h-[780px] flex items-center bg-zinc-950 overflow-hidden text-white select-none"
>

    <!-- SLIDE 0: ⚡ NEXT-GEN TECH & SMART GADGETS -->
    <div 
        x-show="currentSlide === 0"
        x-transition:enter="transition ease-out duration-700 transform"
        x-transition:enter-start="opacity-0 scale-105"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-500 transform absolute inset-0"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute inset-0 w-full h-full"
    >
        <img 
            src="https://images.unsplash.com/photo-1519389950473-47ba0277781c?w=1600&auto=format&fit=crop" 
            alt="Flagship Tech & Next-Gen Devices" 
            class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.80]"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/60 to-black/30 lg:bg-gradient-to-r lg:from-black/95 lg:via-black/65 lg:to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20 sm:py-28 w-full h-full flex items-center">
            <div class="max-w-2xl space-y-6 text-left">
                <div class="inline-flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-blue-600 text-white text-xs font-black rounded-full uppercase tracking-wider shadow-lg">
                        <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                        ⚡ 2026 FLAGSHIP TECH
                    </span>
                    <span class="hidden sm:inline-flex items-center px-3 py-1.5 bg-black/70 border border-blue-400/30 text-blue-200 text-xs font-bold rounded-full uppercase tracking-wider backdrop-blur-md">
                        Apple Silicon &bull; AI Powered &bull; 5G
                    </span>
                </div>
                
                <h1 class="text-3xl sm:text-5xl lg:text-7xl font-black tracking-tight leading-[1.05] text-white uppercase font-sans">
                    NEXT-GEN TECH &amp; SMART DEVICES
                </h1>
                
                <p class="text-sm sm:text-base text-zinc-300 font-normal leading-relaxed max-w-xl">
                    Experience extreme computing power. Titanium Apple iPhone 16 Pro, M3 Max MacBooks, Sony ANC Audio and rugged smartwatches built for next-level performance.
                </p>

                <div class="flex flex-wrap items-center gap-3 sm:gap-4 pt-2">
                    <a href="{{ route('shop.index', ['category' => 'smartphones']) }}" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-blue-600 hover:bg-blue-500 text-white text-xs font-black uppercase tracking-wider rounded-full transition shadow-xl hover:scale-105 cursor-pointer">
                        SHOP MOBILES &amp; TECH
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'laptops-pc']) }}" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-black/70 hover:bg-black text-white border border-white/40 text-xs font-black uppercase tracking-wider rounded-full transition backdrop-blur-md hover:scale-105 cursor-pointer">
                        EXPLORE LAPTOPS
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'audio-gadgets']) }}" class="px-6 py-3.5 sm:py-4 bg-transparent hover:text-white text-zinc-300 text-xs font-black uppercase tracking-wider transition underline underline-offset-4 cursor-pointer">
                        SMART AUDIO &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-4 sm:gap-6 pt-6 border-t border-white/20 max-w-lg text-left">
                    <div>
                        <div class="text-lg sm:text-2xl font-black text-white">M3 MAX</div>
                        <div class="text-[10px] sm:text-[11px] text-zinc-400 font-bold uppercase tracking-wider mt-0.5">Extreme Chip</div>
                    </div>
                    <div>
                        <div class="text-lg sm:text-2xl font-black text-white">200MP</div>
                        <div class="text-[10px] sm:text-[11px] text-zinc-400 font-bold uppercase tracking-wider mt-0.5">AI Telephoto</div>
                    </div>
                    <div>
                        <div class="text-lg sm:text-2xl font-black text-white">100%</div>
                        <div class="text-[10px] sm:text-[11px] text-zinc-400 font-bold uppercase tracking-wider mt-0.5">Brand Warranty</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SLIDE 1: 🔥 CONDITIONING & FASHION DROPS -->
    <div 
        x-show="currentSlide === 1"
        x-transition:enter="transition ease-out duration-700 transform"
        x-transition:enter-start="opacity-0 scale-105"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-500 transform absolute inset-0"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute inset-0 w-full h-full"
        style="display: none;"
    >
        <img 
            src="{{ asset('images/gymshark_hero_banner.jpg') }}" 
            alt="SM Shop Conditioning Apparel" 
            class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.82]"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/55 to-black/30 lg:bg-gradient-to-r lg:from-black/95 lg:via-black/60 lg:to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20 sm:py-28 w-full h-full flex items-center">
            <div class="max-w-2xl space-y-6 text-left">
                <div class="inline-flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-red-600 text-white text-xs font-black rounded-full uppercase tracking-wider shadow-lg">
                        <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                        🔥 FASHION &amp; ACTIVEWEAR
                    </span>
                    <span class="hidden sm:inline-flex items-center px-3 py-1.5 bg-black/70 border border-white/20 text-zinc-300 text-xs font-bold rounded-full uppercase tracking-wider backdrop-blur-md">
                        Engineered for Performance
                    </span>
                </div>
                
                <h1 class="text-3xl sm:text-5xl lg:text-7xl font-black tracking-tight leading-[1.05] text-white uppercase font-sans">
                    CONDITIONING IS EVERYTHING
                </h1>
                
                <p class="text-sm sm:text-base text-zinc-300 font-normal leading-relaxed max-w-xl">
                    Engineered seamless gymwear, heavyweight fleece pump covers, and squat-proof activewear designed for peak human performance.
                </p>

                <div class="flex flex-wrap items-center gap-3 sm:gap-4 pt-2">
                    <a href="{{ route('shop.index', ['category' => 'women']) }}" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-white hover:bg-zinc-200 text-black text-xs font-black uppercase tracking-wider rounded-full transition shadow-xl hover:scale-105 cursor-pointer">
                        SHOP WOMEN
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'men']) }}" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-black/70 hover:bg-black text-white border border-white/50 text-xs font-black uppercase tracking-wider rounded-full transition backdrop-blur-md hover:scale-105 cursor-pointer">
                        SHOP MEN
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'seamless']) }}" class="px-6 py-3.5 sm:py-4 bg-transparent hover:text-white text-zinc-300 text-xs font-black uppercase tracking-wider transition underline underline-offset-4 cursor-pointer">
                        EXPLORE SEAMLESS &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-4 sm:gap-6 pt-6 border-t border-white/20 max-w-lg text-left">
                    <div>
                        <div class="text-lg sm:text-2xl font-black text-white font-sans">100%</div>
                        <div class="text-[10px] sm:text-[11px] text-zinc-400 font-bold uppercase tracking-wider mt-0.5">Squat-Proof Knit</div>
                    </div>
                    <div>
                        <div class="text-lg sm:text-2xl font-black text-white font-sans">FREE</div>
                        <div class="text-[10px] sm:text-[11px] text-zinc-400 font-bold uppercase tracking-wider mt-0.5">Delivery Over $75</div>
                    </div>
                    <div>
                        <div class="text-lg sm:text-2xl font-black text-white font-sans">30-DAY</div>
                        <div class="text-[10px] sm:text-[11px] text-zinc-400 font-bold uppercase tracking-wider mt-0.5">Easy Returns</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SLIDE 2: 💻 PRO LAPTOPS & PC WORKSTATIONS -->
    <div 
        x-show="currentSlide === 2"
        x-transition:enter="transition ease-out duration-700 transform"
        x-transition:enter-start="opacity-0 scale-105"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-500 transform absolute inset-0"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute inset-0 w-full h-full"
        style="display: none;"
    >
        <img 
            src="https://images.unsplash.com/photo-1550745165-9bc0b252726f?w=1600&auto=format&fit=crop" 
            alt="Pro Laptops & Gaming Rigs" 
            class="absolute inset-0 w-full h-full object-cover object-center filter brightness-[0.78]"
        >
        <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/60 to-black/30 lg:bg-gradient-to-r lg:from-black/95 lg:via-black/65 lg:to-transparent"></div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20 sm:py-28 w-full h-full flex items-center">
            <div class="max-w-2xl space-y-6 text-left">
                <div class="inline-flex items-center gap-2">
                    <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 bg-indigo-600 text-white text-xs font-black rounded-full uppercase tracking-wider shadow-lg">
                        <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                        💻 ULTRA-FAST COMPUTING
                    </span>
                    <span class="hidden sm:inline-flex items-center px-3 py-1.5 bg-black/70 border border-indigo-400/30 text-indigo-200 text-xs font-bold rounded-full uppercase tracking-wider backdrop-blur-md">
                        2.5K OLED &bull; RTX 4080 &bull; Workstations
                    </span>
                </div>
                
                <h1 class="text-3xl sm:text-5xl lg:text-7xl font-black tracking-tight leading-[1.05] text-white uppercase font-sans">
                    PRO LAPTOPS &amp; WORKSTATIONS
                </h1>
                
                <p class="text-sm sm:text-base text-zinc-300 font-normal leading-relaxed max-w-xl">
                    Extreme computing and gaming firepower. Apple Silicon MacBooks, ASUS ROG Zephyrus G16, mechanical keyboards, and 4K creator setups.
                </p>

                <div class="flex flex-wrap items-center gap-3 sm:gap-4 pt-2">
                    <a href="{{ route('shop.index', ['category' => 'laptops-pc']) }}" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-indigo-600 hover:bg-indigo-500 text-white text-xs font-black uppercase tracking-wider rounded-full transition shadow-xl hover:scale-105 cursor-pointer">
                        EXPLORE PRO LAPTOPS
                    </a>
                    <a href="{{ route('shop.index', ['category' => 'tech-accessories']) }}" class="px-7 sm:px-8 py-3.5 sm:py-4 bg-black/70 hover:bg-black text-white border border-white/40 text-xs font-black uppercase tracking-wider rounded-full transition backdrop-blur-md hover:scale-105 cursor-pointer">
                        GAMING GEAR
                    </a>
                    <a href="{{ route('shop.index') }}" class="px-6 py-3.5 sm:py-4 bg-transparent hover:text-white text-zinc-300 text-xs font-black uppercase tracking-wider transition underline underline-offset-4 cursor-pointer">
                        ALL PRODUCTS &rarr;
                    </a>
                </div>

                <div class="grid grid-cols-3 gap-4 sm:gap-6 pt-6 border-t border-white/20 max-w-lg text-left">
                    <div>
                        <div class="text-lg sm:text-2xl font-black text-white">240Hz</div>
                        <div class="text-[10px] sm:text-[11px] text-zinc-400 font-bold uppercase tracking-wider mt-0.5">OLED Display</div>
                    </div>
                    <div>
                        <div class="text-lg sm:text-2xl font-black text-white">RTX 4080</div>
                        <div class="text-[10px] sm:text-[11px] text-zinc-400 font-bold uppercase tracking-wider mt-0.5">Ray Tracing</div>
                    </div>
                    <div>
                        <div class="text-lg sm:text-2xl font-black text-white">22 HRS</div>
                        <div class="text-[10px] sm:text-[11px] text-zinc-400 font-bold uppercase tracking-wider mt-0.5">Battery Life</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- PREV / NEXT ARROWS -->
    <button 
        type="button" 
        @click="prevSlide()" 
        class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 w-10 sm:w-12 h-10 sm:h-12 rounded-full bg-black/40 hover:bg-black/80 border border-white/20 text-white flex items-center justify-center backdrop-blur-md transition z-20 cursor-pointer shadow-xl"
        aria-label="Previous Slide"
    >
        <i class="fa-solid fa-chevron-left text-sm sm:text-base"></i>
    </button>
    <button 
        type="button" 
        @click="nextSlide()" 
        class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 w-10 sm:w-12 h-10 sm:h-12 rounded-full bg-black/40 hover:bg-black/80 border border-white/20 text-white flex items-center justify-center backdrop-blur-md transition z-20 cursor-pointer shadow-xl"
        aria-label="Next Slide"
    >
        <i class="fa-solid fa-chevron-right text-sm sm:text-base"></i>
    </button>

    <!-- BOTTOM INTERACTIVE SLIDE TABS -->
    <div class="absolute bottom-4 sm:bottom-6 inset-x-0 z-20 flex items-center justify-center px-4">
        <div class="inline-flex items-center gap-2 p-1.5 rounded-full bg-black/60 border border-white/15 backdrop-blur-md">
            
            <button 
                type="button" 
                @click="goToSlide(0)" 
                class="px-3 sm:px-4 py-1.5 rounded-full text-[10px] sm:text-xs font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer"
                :class="currentSlide === 0 ? 'bg-blue-600 text-white shadow-md' : 'text-zinc-400 hover:text-white'"
            >
                <i class="fa-solid fa-bolt text-[10px]"></i>
                <span>1. Next-Gen Tech</span>
            </button>

            <button 
                type="button" 
                @click="goToSlide(1)" 
                class="px-3 sm:px-4 py-1.5 rounded-full text-[10px] sm:text-xs font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer"
                :class="currentSlide === 1 ? 'bg-red-600 text-white shadow-md' : 'text-zinc-400 hover:text-white'"
            >
                <i class="fa-solid fa-fire text-[10px]"></i>
                <span>2. Fashion Drops</span>
            </button>

            <button 
                type="button" 
                @click="goToSlide(2)" 
                class="px-3 sm:px-4 py-1.5 rounded-full text-[10px] sm:text-xs font-black uppercase tracking-wider transition flex items-center gap-1.5 cursor-pointer"
                :class="currentSlide === 2 ? 'bg-indigo-600 text-white shadow-md' : 'text-zinc-400 hover:text-white'"
            >
                <i class="fa-solid fa-laptop text-[10px]"></i>
                <span>3. Pro Laptops</span>
            </button>

        </div>
    </div>

</section>

<!-- =========================================================================
     2. VALUE PERKS STRIP (TECH & APPAREL GUARANTEES)
     ========================================================================= -->
<section class="py-7 bg-white border-b border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            
            <div class="flex flex-col items-center justify-center p-2">
                <i class="fa-solid fa-award text-xl text-blue-600 mb-1.5" aria-hidden="true"></i>
                <p class="font-bold text-black text-sm">100% Genuine &amp; Warranty</p>
                <p class="text-xs text-zinc-500 mt-0.5">Original brand certified items</p>
            </div>

            <div class="flex flex-col items-center justify-center p-2">
                <i class="fa-solid fa-truck-fast text-xl text-black mb-1.5" aria-hidden="true"></i>
                <p class="font-bold text-black text-sm">Fast Insured Delivery</p>
                <p class="text-xs text-zinc-500 mt-0.5">Free shipping over $75</p>
            </div>

            <div class="flex flex-col items-center justify-center p-2">
                <i class="fa-solid fa-rotate-left text-xl text-emerald-600 mb-1.5" aria-hidden="true"></i>
                <p class="font-bold text-black text-sm">30-Day Easy Returns</p>
                <p class="text-xs text-zinc-500 mt-0.5">Fast hassle-free policy</p>
            </div>

            <div class="flex flex-col items-center justify-center p-2">
                <i class="fa-solid fa-shield-halved text-xl text-indigo-600 mb-1.5" aria-hidden="true"></i>
                <p class="font-bold text-black text-sm">Member Savings 20%</p>
                <p class="text-xs text-zinc-500 mt-0.5">Use code <span class="font-bold text-black">SM20</span></p>
            </div>

        </div>
    </div>
</section>

<!-- =========================================================================
     2.5. CONTINUOUS AUTO-SLIDING BRAND LOGOS (TECH & FASHION BRANDS)
     ========================================================================= -->
<section class="py-9 bg-white border-b border-zinc-200 overflow-hidden relative">
    <div class="pointer-events-none absolute inset-y-0 left-0 w-20 sm:w-40 bg-gradient-to-r from-white to-transparent z-10"></div>
    <div class="pointer-events-none absolute inset-y-0 right-0 w-20 sm:w-40 bg-gradient-to-l from-white to-transparent z-10"></div>

    <div class="brand-marquee-track flex items-center gap-14 sm:gap-20 py-2">
        
        <!-- Apple -->
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <i class="fa-brands fa-apple text-3xl sm:text-4xl text-black"></i>
            <span class="text-xl sm:text-2xl font-bold tracking-tight text-black">Apple</span>
        </div>

        <!-- Samsung -->
        <div class="flex items-center shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <span class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-[#1428a0]">SAMSUNG</span>
        </div>

        <!-- Sony -->
        <div class="flex items-center shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <span class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-black font-serif">SONY</span>
        </div>

        <!-- ASUS ROG -->
        <div class="flex items-center gap-1.5 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <i class="fa-solid fa-gamepad text-2xl text-[#d71921]"></i>
            <span class="text-xl sm:text-2xl font-black italic tracking-wider text-black">ASUS ROG</span>
        </div>

        <!-- Gymshark -->
        <div class="flex items-center gap-2.5 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <svg class="w-7 h-7 fill-current text-black" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            <span class="text-xl sm:text-2xl font-black tracking-wider uppercase text-black">GYMSHARK</span>
        </div>

        <!-- Nike -->
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <i class="fa-solid fa-check text-2xl text-[#FF5500]"></i>
            <span class="text-2xl sm:text-3xl font-black italic tracking-tight text-black">NIKE</span>
        </div>

        <!-- Beats by Dre -->
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <div class="w-7 h-7 rounded-full bg-[#E01F3D] text-white font-bold flex items-center justify-center text-xs shadow-xs">b</div>
            <span class="text-xl sm:text-2xl font-black tracking-tight text-[#E01F3D]">beats</span>
        </div>

        <!-- Garmin -->
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <i class="fa-solid fa-diamond text-lg text-[#007CC3]"></i>
            <span class="text-xl sm:text-2xl font-black tracking-widest uppercase text-[#007CC3]">GARMIN</span>
        </div>

        <!-- Duplicate Set for Seamless Loop -->
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <i class="fa-brands fa-apple text-3xl sm:text-4xl text-black"></i>
            <span class="text-xl sm:text-2xl font-bold tracking-tight text-black">Apple</span>
        </div>
        <div class="flex items-center shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <span class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-[#1428a0]">SAMSUNG</span>
        </div>
        <div class="flex items-center shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <span class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-black font-serif">SONY</span>
        </div>
        <div class="flex items-center gap-1.5 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <i class="fa-solid fa-gamepad text-2xl text-[#d71921]"></i>
            <span class="text-xl sm:text-2xl font-black italic tracking-wider text-black">ASUS ROG</span>
        </div>
        <div class="flex items-center gap-2.5 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <svg class="w-7 h-7 fill-current text-black" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            <span class="text-xl sm:text-2xl font-black tracking-wider uppercase text-black">GYMSHARK</span>
        </div>
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <i class="fa-solid fa-check text-2xl text-[#FF5500]"></i>
            <span class="text-2xl sm:text-3xl font-black italic tracking-tight text-black">NIKE</span>
        </div>

    </div>
</section>

<!-- =========================================================================
     3. SHOP BY DEPARTMENT & CATEGORIES GRID
     ========================================================================= -->
<section class="py-14 sm:py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-bold text-zinc-500 tracking-wider uppercase">Explore Departments</span>
                <h2 class="text-2xl sm:text-3xl font-black text-black tracking-tight mt-1 uppercase">Shop by Category</h2>
            </div>
            <a href="{{ route('shop.index') }}" class="text-xs font-black uppercase text-black hover:text-zinc-600 transition flex items-center gap-1.5">
                <span>View All</span>
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
            @foreach($categories as $category)
                <a 
                    href="{{ route('shop.index', ['category' => $category->slug]) }}" 
                    class="group relative rounded-2xl overflow-hidden bg-zinc-900 aspect-[4/5] flex flex-col justify-end p-4 sm:p-5 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 block"
                >
                    <img 
                        src="{{ $category->image }}" 
                        alt="{{ $category->name }}" 
                        class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-85"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                    
                    <div class="relative z-10 space-y-1">
                        <span class="text-[10px] font-bold text-zinc-300 uppercase tracking-wider block">
                            {{ $category->products_count ?? '' }} Products
                        </span>
                        <h3 class="text-sm sm:text-base font-black text-white leading-tight uppercase line-clamp-2">
                            {{ $category->name }}
                        </h3>
                        <span class="inline-flex items-center gap-1 text-[11px] font-black text-white pt-1 group-hover:translate-x-1 transition-transform uppercase">
                            Shop Now &rarr;
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</section>

<!-- =========================================================================
     4. ⚡ FLAGSHIP TECH & NEXT-GEN GADGETS SHOWCASE
     ========================================================================= -->
@if(isset($techProducts) && $techProducts->count() > 0)
<section class="py-16 bg-zinc-950 text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-blue-600/30 border border-blue-500/40 text-blue-300 text-[11px] font-black rounded-full uppercase tracking-wider mb-2">
                    <i class="fa-solid fa-bolt text-blue-400"></i> Next-Gen Hardware
                </div>
                <h2 class="text-2xl sm:text-4xl font-black tracking-tight uppercase">Flagship Tech &amp; Gadgets</h2>
                <p class="text-xs sm:text-sm text-zinc-400 mt-1">High-performance laptops, titanium 5G phones, and noise-cancelling audio.</p>
            </div>
            
            <a href="{{ route('shop.index', ['category' => 'smartphones']) }}" class="px-6 py-2.5 bg-white hover:bg-zinc-200 text-black text-xs font-black uppercase tracking-wider rounded-full transition self-start sm:self-auto shrink-0 shadow-md">
                All Tech Gear &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            @foreach($techProducts as $product)
                <div class="group bg-zinc-900 rounded-2xl border border-zinc-800 overflow-hidden flex flex-col justify-between shadow-lg hover:border-zinc-700 transition">
                    
                    <div class="relative aspect-square overflow-hidden bg-zinc-800">
                        <img 
                            src="{{ $product->image }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                        >
                        @if($product->has_discount)
                            <span class="absolute top-3 left-3 bg-red-600 text-white text-[10px] font-black px-2.5 py-1 rounded-full uppercase tracking-wider">
                                -{{ $product->discount_percent }}% OFF
                            </span>
                        @endif
                        <span class="absolute top-3 right-3 bg-black/60 backdrop-blur-xs text-zinc-300 text-[10px] font-bold px-2 py-0.5 rounded-md uppercase">
                            {{ $product->category->name ?? 'Tech' }}
                        </span>
                    </div>

                    <div class="p-4 sm:p-5 flex-1 flex flex-col justify-between space-y-3">
                        <div>
                            <h3 class="font-bold text-white text-xs sm:text-sm tracking-tight line-clamp-2 group-hover:text-blue-400 transition">
                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-[11px] text-zinc-400 line-clamp-1 mt-1 font-medium">
                                {{ $product->short_description }}
                            </p>
                        </div>

                        <div class="pt-3 border-t border-zinc-800 flex items-center justify-between">
                            <div>
                                @if($product->has_discount)
                                    <span class="text-xs text-zinc-500 line-through mr-1 font-semibold">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-sm sm:text-base font-black text-red-500">${{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="text-sm sm:text-base font-black text-white">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            <x-rating :value="$product->rating" size="xs" />
                        </div>

                        <a href="{{ route('product.show', $product->slug) }}" class="w-full py-2.5 bg-blue-600 hover:bg-blue-500 text-white text-center text-xs font-black uppercase tracking-wider rounded-xl transition block">
                            View Tech Specs &rarr;
                        </a>
                    </div>

                </div>
            @endforeach
        </div>

    </div>
</section>
@endif

<!-- =========================================================================
     5. 🔥 TRENDING FASHION & GYMWEAR DROPS
     ========================================================================= -->
<section class="py-16 bg-zinc-50 border-t border-b border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <div class="inline-flex items-center gap-1.5 px-3 py-1 bg-red-600/10 border border-red-500/20 text-red-600 text-[11px] font-black rounded-full uppercase tracking-wider mb-2">
                    <i class="fa-solid fa-fire text-red-600"></i> Athlete Approved
                </div>
                <h2 class="text-2xl sm:text-4xl font-black text-black tracking-tight uppercase">Trending Fashion &amp; Gymwear</h2>
                <p class="text-xs sm:text-sm text-zinc-600 mt-1">Squat-proof seamless sets, heavyweight pump covers, and activewear essentials.</p>
            </div>
            
            <a href="{{ route('shop.index', ['category' => 'women']) }}" class="px-6 py-2.5 bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-wider rounded-full transition self-start sm:self-auto shrink-0 shadow-md">
                All Fashion Drops &rarr;
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            @php
                $displayFashion = (isset($fashionProducts) && $fashionProducts->count() > 0) ? $fashionProducts : $featuredProducts->take(4);
            @endphp
            @foreach($displayFashion as $product)
                <x-card :image="$product->image" :imageAlt="$product->name" :imageHref="route('product.show', $product->slug)" :productId="$product->id">
                    <x-slot:badges>
                        @if($product->has_discount)
                            <x-badge variant="discount">-{{ $product->discount_percent }}% OFF</x-badge>
                        @endif
                        @if($product->is_featured)
                            <x-badge variant="featured">New Drop</x-badge>
                        @endif
                    </x-slot:badges>

                    <div>
                        <div class="text-xs font-bold text-zinc-500 uppercase tracking-wider">
                            {{ $product->category->name ?? 'Apparel' }}
                        </div>
                        <h3 class="font-black text-black text-sm tracking-tight mt-0.5 line-clamp-1 group-hover:underline">
                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-zinc-500 line-clamp-1 mt-0.5 font-medium">
                            {{ $product->short_description }}
                        </p>
                    </div>

                    <x-slot:footer>
                        <div class="flex items-center justify-between">
                            <div>
                                @if($product->has_discount)
                                    <span class="text-xs text-zinc-400 line-through mr-1 font-semibold">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-sm sm:text-base font-black text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="text-sm sm:text-base font-black text-black">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                            <x-rating :value="$product->rating" size="xs" />
                        </div>
                    </x-slot:footer>
                </x-card>
            @endforeach
        </div>

    </div>
</section>

<!-- =========================================================================
     6. INTERACTIVE LOOKBOOK & HOTSPOT SHOWCASE
     ========================================================================= -->
<section x-data="{ activeHotspot: null }" class="py-16 bg-zinc-950 text-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold text-zinc-400 tracking-wider uppercase">Engineered Lookbook</span>
                <h2 class="text-2xl sm:text-4xl font-black text-white tracking-tight mt-1 uppercase">Shop The Look</h2>
            </div>
            <p class="text-xs sm:text-sm text-zinc-400 max-w-md">
                Click on the interactive tags below to shop the exact conditioning outfits worn by our athletes.
            </p>
        </div>

        <div class="relative rounded-3xl overflow-hidden bg-zinc-900 border border-zinc-800 shadow-2xl min-h-[500px] lg:min-h-[600px] flex items-center">
            <img 
                src="{{ asset('images/gymshark_hero_banner.jpg') }}" 
                alt="Gymshark Athlete Lookbook" 
                class="absolute inset-0 w-full h-full object-cover object-center filter brightness-90"
            >
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/30"></div>

            <!-- HOTSPOT 1: Vital Seamless Leggings -->
            <div class="absolute top-[65%] left-[62%] z-20">
                <button 
                    type="button"
                    @click="activeHotspot = (activeHotspot === 1 ? null : 1)"
                    class="relative w-8 h-8 rounded-full bg-white text-black flex items-center justify-center shadow-2xl hover:scale-125 transition-transform duration-300 cursor-pointer"
                    aria-label="View Vital Seamless Leggings"
                >
                    <span class="absolute inset-0 rounded-full bg-white animate-ping opacity-75"></span>
                    <i class="fa-solid fa-plus text-xs font-bold"></i>
                </button>

                <div 
                    x-show="activeHotspot === 1" 
                    @click.away="activeHotspot = null"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="absolute bottom-10 -left-28 sm:-left-32 w-64 bg-white text-black rounded-2xl p-4 shadow-2xl border border-zinc-200 z-30 space-y-3"
                    style="display: none;"
                >
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/prod_vital_leggings.jpg') }}" alt="Leggings" class="w-14 h-14 object-cover rounded-xl bg-zinc-100 shrink-0">
                        <div class="min-w-0">
                            <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Women's Activewear</span>
                            <h4 class="font-black text-xs text-black truncate">Vital Seamless 2.0</h4>
                            <div class="text-xs font-black text-red-600 mt-0.5">$44.00 <span class="text-zinc-400 line-through text-[10px]">$54.00</span></div>
                        </div>
                    </div>
                    <a href="{{ route('shop.index', ['category' => 'women']) }}" class="w-full py-2 bg-black hover:bg-zinc-800 text-white text-[11px] font-black uppercase tracking-wider rounded-full transition block text-center">
                        Quick Add &rarr;
                    </a>
                </div>
            </div>

            <!-- HOTSPOT 2: Apex Workout Tee -->
            <div class="absolute top-[38%] left-[38%] z-20">
                <button 
                    type="button"
                    @click="activeHotspot = (activeHotspot === 2 ? null : 2)"
                    class="relative w-8 h-8 rounded-full bg-white text-black flex items-center justify-center shadow-2xl hover:scale-125 transition-transform duration-300 cursor-pointer"
                    aria-label="View Apex Workout T-Shirt"
                >
                    <span class="absolute inset-0 rounded-full bg-white animate-ping opacity-75"></span>
                    <i class="fa-solid fa-plus text-xs font-bold"></i>
                </button>

                <div 
                    x-show="activeHotspot === 2" 
                    @click.away="activeHotspot = null"
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95"
                    x-transition:enter-end="opacity-100 scale-100"
                    class="absolute bottom-10 -left-28 sm:-left-32 w-64 bg-white text-black rounded-2xl p-4 shadow-2xl border border-zinc-200 z-30 space-y-3"
                    style="display: none;"
                >
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/prod_apex_tee.jpg') }}" alt="T-Shirt" class="w-14 h-14 object-cover rounded-xl bg-zinc-100 shrink-0">
                        <div class="min-w-0">
                            <span class="text-[10px] font-bold text-zinc-500 uppercase tracking-wider">Men's Gymwear</span>
                            <h4 class="font-black text-xs text-black truncate">Apex Seamless Tee</h4>
                            <div class="text-xs font-black text-red-600 mt-0.5">$38.00 <span class="text-zinc-400 line-through text-[10px]">$48.00</span></div>
                        </div>
                    </div>
                    <a href="{{ route('shop.index', ['category' => 'men']) }}" class="w-full py-2 bg-black hover:bg-zinc-800 text-white text-[11px] font-black uppercase tracking-wider rounded-full transition block text-center">
                        Quick Add &rarr;
                    </a>
                </div>
            </div>

            <!-- Bottom Floating Banner Info -->
            <div class="absolute bottom-6 left-6 right-6 z-10 hidden sm:flex items-center justify-between p-4 bg-black/60 backdrop-blur-md rounded-2xl border border-white/10">
                <div class="flex items-center gap-3">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-xs font-bold text-white uppercase tracking-wider">Tap any '+' icon to inspect fabric details &amp; instant bag add</span>
                </div>
                <a href="{{ route('shop.index') }}" class="px-5 py-2 bg-white text-black text-xs font-black uppercase tracking-wider rounded-full hover:bg-zinc-200 transition">
                    Shop Full Look
                </a>
            </div>

        </div>

    </div>
</section>

<!-- =========================================================================
     7. VERIFIED CUSTOMER REVIEWS
     ========================================================================= -->
<section class="py-16 bg-white border-b border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold text-zinc-500 tracking-wider uppercase">Community Approved</span>
            <h2 class="text-2xl sm:text-3xl font-black text-black tracking-tight mt-1 uppercase">Customer Reviews</h2>
            <p class="text-xs sm:text-sm text-zinc-600 mt-2">Hear directly from customers testing our tech devices and athletic apparel.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @forelse($testimonials as $testimonial)
                <div class="bg-zinc-50 p-6 rounded-2xl border border-zinc-200 flex flex-col justify-between space-y-4">
                    <div class="space-y-3">
                        <div class="flex items-center gap-1 text-amber-400">
                            @for($i = 0; $i < $testimonial->rating; $i++)
                                <i class="fa-solid fa-star text-xs"></i>
                            @endfor
                        </div>
                        <h3 class="font-bold text-sm text-black">"{{ $testimonial->title }}"</h3>
                        <p class="text-xs text-zinc-600 leading-relaxed font-medium">{{ $testimonial->comment }}</p>
                    </div>
                    <div class="pt-4 border-t border-zinc-200 flex items-center justify-between">
                        <span class="text-xs font-bold text-black">{{ $testimonial->user_name }}</span>
                        <span class="text-[11px] text-emerald-600 font-bold flex items-center gap-1">
                            <i class="fa-solid fa-circle-check text-xs"></i> Verified Customer
                        </span>
                    </div>
                </div>
            @empty
                <div class="col-span-3 text-center py-8 text-zinc-400 text-xs">
                    No reviews yet. Be the first to review!
                </div>
            @endforelse
        </div>
    </div>
</section>

<!-- =========================================================================
     8. VIP CLUB & 20% DISCOUNT VOUCHER
     ========================================================================= -->
<section class="py-16 bg-zinc-950 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center space-y-6">
        <span class="text-xs font-black uppercase tracking-widest text-blue-400">⚡ VIP EXCLUSIVE VOUCHER</span>
        <h2 class="text-3xl sm:text-4xl font-black uppercase tracking-tight text-white">
            GET 20% OFF YOUR TECH &amp; FASHION ORDERS
        </h2>
        <p class="text-xs sm:text-sm text-zinc-300 max-w-lg mx-auto font-normal leading-relaxed">
            Use code <span class="font-black text-amber-300 bg-zinc-800 px-2 py-0.5 rounded border border-zinc-700">SM20</span> at checkout for 20% off all orders over $50. Use <span class="font-black text-blue-300 bg-zinc-800 px-2 py-0.5 rounded border border-zinc-700">TECH50</span> for $50 off flagships.
        </p>
        
        <div class="pt-4 flex flex-wrap justify-center gap-4">
            <a href="{{ route('shop.index', ['category' => 'smartphones']) }}" class="px-8 py-3.5 bg-blue-600 hover:bg-blue-500 text-white text-xs font-black uppercase tracking-wider rounded-full transition shadow-lg inline-block">
                SHOP TECH &amp; GADGETS
            </a>
            <a href="{{ route('shop.index', ['category' => 'women']) }}" class="px-8 py-3.5 bg-white hover:bg-zinc-200 text-black text-xs font-black uppercase tracking-wider rounded-full transition shadow-lg inline-block">
                SHOP FASHION
            </a>
        </div>
    </div>
</section>

@endsection