@extends('layouts.app')

@section('title', 'SM Shark - Conditioning & Performance Gymwear')

@section('content')
@php
    $heroBanner = $banners->first();
    $campaignBanner = $banners->skip(1)->first();
@endphp

<!-- =========================================================================
     1. HERO BANNER (Authentic Gymshark Conditioning Apparel)
     ========================================================================= -->
<section class="relative min-h-[580px] lg:min-h-[720px] flex items-center bg-zinc-950 overflow-hidden text-white">
    <img 
        src="{{ $heroBanner->image ?? asset('images/gymshark_hero_banner.jpg') }}" 
        alt="Gymshark Apparel Hero Banner" 
        class="absolute inset-0 w-full h-full object-cover object-center opacity-85"
    >
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent lg:bg-gradient-to-r lg:from-black/90 lg:via-black/50 lg:to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20 w-full">
        <div class="max-w-xl space-y-6 text-left">
            
            <div class="inline-flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 bg-white text-black text-xs font-bold rounded-full uppercase tracking-wider">
                    {{ $heroBanner->badge ?? 'NEW 2026 DROP' }}
                </span>
            </div>
            
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight leading-[1.05] text-white uppercase">
                {{ $heroBanner->title ?? 'Conditioning is Everything' }}
            </h1>
            
            <p class="text-sm sm:text-base text-zinc-300 font-normal leading-relaxed">
                {{ $heroBanner->subtitle ?? 'Engineered seamless gymwear, heavyweight fleece pump covers, and squat-proof activewear designed for peak human performance.' }}
            </p>

            <!-- Dual Action Buttons: Women & Men -->
            <div class="flex flex-wrap gap-4 pt-2">
                <a href="{{ route('shop.index', ['category' => 'women']) }}" class="px-8 py-3.5 bg-white hover:bg-zinc-200 text-black text-xs font-black uppercase tracking-wider rounded-full transition shadow-lg cursor-pointer">
                    SHOP WOMEN
                </a>
                <a href="{{ route('shop.index', ['category' => 'men']) }}" class="px-8 py-3.5 bg-black/60 hover:bg-black text-white border border-white/60 text-xs font-black uppercase tracking-wider rounded-full transition backdrop-blur-md cursor-pointer">
                    SHOP MEN
                </a>
            </div>

            <!-- Perks Summary -->
            <div class="grid grid-cols-3 gap-6 pt-8 border-t border-white/20 max-w-lg text-left">
                <div>
                    <div class="text-xl font-bold text-white">100%</div>
                    <div class="text-xs text-zinc-400 font-medium mt-0.5">Squat-Proof Knit</div>
                </div>
                <div>
                    <div class="text-xl font-bold text-white">Free</div>
                    <div class="text-xs text-zinc-400 font-medium mt-0.5">Delivery Over $75</div>
                </div>
                <div>
                    <div class="text-xl font-bold text-white">30-Day</div>
                    <div class="text-xs text-zinc-400 font-medium mt-0.5">Easy Returns</div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- =========================================================================
     2. VALUE PERKS STRIP (Gymshark Guarantees)
     ========================================================================= -->
<section class="py-8 bg-white border-b border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            
            <div class="flex flex-col items-center justify-center p-3">
                <i class="fa-solid fa-truck-fast text-xl text-black mb-2" aria-hidden="true"></i>
                <p class="font-bold text-black text-sm">Free Standard Delivery</p>
                <p class="text-xs text-zinc-500 mt-0.5">On all orders over $75</p>
            </div>

            <div class="flex flex-col items-center justify-center p-3">
                <i class="fa-solid fa-rotate-left text-xl text-black mb-2" aria-hidden="true"></i>
                <p class="font-bold text-black text-sm">30-Day Easy Returns</p>
                <p class="text-xs text-zinc-500 mt-0.5">Fast & hassle-free</p>
            </div>

            <div class="flex flex-col items-center justify-center p-3">
                <i class="fa-solid fa-shield-halved text-xl text-black mb-2" aria-hidden="true"></i>
                <p class="font-bold text-black text-sm">Squat-Proof Guarantee</p>
                <p class="text-xs text-zinc-500 mt-0.5">Premium seamless knitwear</p>
            </div>

            <div class="flex flex-col items-center justify-center p-3">
                <i class="fa-solid fa-graduation-cap text-xl text-black mb-2" aria-hidden="true"></i>
                <p class="font-bold text-black text-sm">Student Discount 10%</p>
                <p class="text-xs text-zinc-500 mt-0.5">Instant online verification</p>
            </div>

        </div>
    </div>
</section>

<!-- =========================================================================
     2.5. CONTINUOUS AUTO-SLIDING PURE BRAND LOGOS (ONLY ORIGINAL LOGOS)
     ========================================================================= -->
<section class="py-10 bg-white border-b border-zinc-200 overflow-hidden relative">
    <!-- Left & Right Gradient Fade Masks -->
    <div class="pointer-events-none absolute inset-y-0 left-0 w-20 sm:w-40 bg-gradient-to-r from-white to-transparent z-10"></div>
    <div class="pointer-events-none absolute inset-y-0 right-0 w-20 sm:w-40 bg-gradient-to-l from-white to-transparent z-10"></div>

    <!-- Infinite Auto-Slider Track with Pure Original Brand Logos -->
    <div class="brand-marquee-track flex items-center gap-16 sm:gap-24 py-2">
        
        <!-- Set 1 -->
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

        <!-- Under Armour -->
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <span class="text-xl sm:text-2xl font-black tracking-widest text-[#C41230]">UNDER ARMOUR</span>
        </div>

        <!-- Apple -->
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <i class="fa-brands fa-apple text-3xl sm:text-4xl text-black"></i>
            <span class="text-xl sm:text-2xl font-bold tracking-tight text-black">Apple</span>
        </div>

        <!-- Sony -->
        <div class="flex items-center shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <span class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-black font-serif">SONY</span>
        </div>

        <!-- Beats by Dre -->
        <div class="flex items-center gap-2.5 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <div class="w-8 h-8 rounded-full bg-[#E01F3D] text-white font-bold flex items-center justify-center text-sm shadow-xs">b</div>
            <span class="text-xl sm:text-2xl font-black tracking-tight text-[#E01F3D]">beats</span>
        </div>

        <!-- Garmin -->
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <i class="fa-solid fa-diamond text-lg text-[#007CC3]"></i>
            <span class="text-xl sm:text-2xl font-black tracking-widest uppercase text-[#007CC3]">GARMIN</span>
        </div>

        <!-- Set 2 (Seamless Infinite Marquee Loop) -->
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

        <!-- Under Armour -->
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <span class="text-xl sm:text-2xl font-black tracking-widest text-[#C41230]">UNDER ARMOUR</span>
        </div>

        <!-- Apple -->
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <i class="fa-brands fa-apple text-3xl sm:text-4xl text-black"></i>
            <span class="text-xl sm:text-2xl font-bold tracking-tight text-black">Apple</span>
        </div>

        <!-- Sony -->
        <div class="flex items-center shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <span class="text-2xl sm:text-3xl font-black tracking-widest uppercase text-black font-serif">SONY</span>
        </div>

        <!-- Beats by Dre -->
        <div class="flex items-center gap-2.5 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <div class="w-8 h-8 rounded-full bg-[#E01F3D] text-white font-bold flex items-center justify-center text-sm shadow-xs">b</div>
            <span class="text-xl sm:text-2xl font-black tracking-tight text-[#E01F3D]">beats</span>
        </div>

        <!-- Garmin -->
        <div class="flex items-center gap-2 shrink-0 hover:scale-110 transition-transform duration-300 cursor-pointer">
            <i class="fa-solid fa-diamond text-lg text-[#007CC3]"></i>
            <span class="text-xl sm:text-2xl font-black tracking-widest uppercase text-[#007CC3]">GARMIN</span>
        </div>

    </div>
</section>

<!-- =========================================================================
     3. SHOP BY COLLECTION (Gymshark Apparel Drops)
     ========================================================================= -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-bold text-zinc-500 tracking-wider uppercase">Discover Drops</span>
                <h2 class="text-2xl sm:text-3xl font-black text-black tracking-tight mt-1 uppercase">Shop by Collection</h2>
            </div>
            <div class="flex items-center gap-3">
                <button type="button" class="collection-prev w-10 h-10 rounded-full border border-zinc-300 flex items-center justify-center text-black hover:bg-black hover:text-white transition cursor-pointer" title="Previous Slide">
                    <i class="fa-solid fa-arrow-left text-xs"></i>
                </button>
                <button type="button" class="collection-next w-10 h-10 rounded-full border border-zinc-300 flex items-center justify-center text-black hover:bg-black hover:text-white transition cursor-pointer" title="Next Slide">
                    <i class="fa-solid fa-arrow-right text-xs"></i>
                </button>
            </div>
        </div>

        <!-- Dynamic Swiper Collection Slider -->
        <div class="swiper collection-swiper overflow-hidden w-full">
            <div class="swiper-wrapper">
                @foreach($categories as $category)
                    <div class="swiper-slide h-auto">
                        <a href="{{ route('shop.index', ['category' => $category->slug]) }}" class="group relative rounded-2xl overflow-hidden bg-zinc-900 aspect-[3/4] flex flex-col justify-end p-6 shadow-sm block">
                            <img 
                                src="{{ $category->image }}" 
                                alt="{{ $category->name }}" 
                                class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 opacity-90"
                            >
                            <!-- High Contrast Scrim -->
                            <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/55 to-transparent"></div>
                            
                            <!-- Consistent Baseline Box -->
                            <div class="relative z-10 space-y-1 min-h-[4.5rem] flex flex-col justify-end">
                                <span class="text-xs font-semibold text-zinc-300">{{ Str::limit($category->description, 28) }}</span>
                                <h3 class="text-lg font-black text-white leading-tight uppercase">{{ $category->name }}</h3>
                                <span class="inline-flex items-center gap-1 text-xs font-black text-white pt-1 group-hover:translate-x-1 transition-transform uppercase tracking-wider">
                                    Shop Now <i class="fa-solid fa-arrow-right text-xs"></i>
                                </span>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
     4. TRENDING NOW TABS (Gymshark Apparel Drops)
     ========================================================================= -->
<section x-data="{ activeTab: 'featured' }" class="py-16 bg-zinc-50 border-t border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Category Tab Filters -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <span class="text-xs font-bold text-zinc-500 tracking-wider uppercase">Community Favourites</span>
                <h2 class="text-2xl sm:text-3xl font-black text-black tracking-tight mt-1 uppercase">Trending Now</h2>
            </div>

            <!-- Tab Pills -->
            <div role="tablist" aria-label="Product categories" class="inline-flex p-1 rounded-full bg-zinc-200">
                <button 
                    type="button"
                    role="tab"
                    :aria-selected="activeTab === 'featured'"
                    x-on:click="activeTab = 'featured'"
                    :class="activeTab === 'featured' ? 'bg-black text-white shadow-sm' : 'text-zinc-800 hover:text-black'"
                    class="px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-wider transition cursor-pointer focus-visible:ring-2 focus-visible:ring-black"
                >
                    Featured
                </button>
                <button 
                    type="button"
                    role="tab"
                    :aria-selected="activeTab === 'bestsellers'"
                    x-on:click="activeTab = 'bestsellers'"
                    :class="activeTab === 'bestsellers' ? 'bg-black text-white shadow-sm' : 'text-zinc-800 hover:text-black'"
                    class="px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-wider transition cursor-pointer focus-visible:ring-2 focus-visible:ring-black"
                >
                    Best Sellers
                </button>
                <button 
                    type="button"
                    role="tab"
                    :aria-selected="activeTab === 'latest'"
                    x-on:click="activeTab = 'latest'"
                    :class="activeTab === 'latest' ? 'bg-black text-white shadow-sm' : 'text-zinc-800 hover:text-black'"
                    class="px-5 py-2.5 rounded-full text-xs font-black uppercase tracking-wider transition cursor-pointer focus-visible:ring-2 focus-visible:ring-black"
                >
                    New Drops
                </button>
            </div>
        </div>

        <!-- Tab 1: Featured Deals -->
        <div x-show="activeTab === 'featured'" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
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

        <!-- Tab 2: Best Sellers -->
        <div x-show="activeTab === 'bestsellers'" x-cloak class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($bestSellers as $product)
                <x-card :image="$product->image" :imageAlt="$product->name" :imageHref="route('product.show', $product->slug)" :productId="$product->id">
                    <x-slot:badges>
                        <x-badge variant="featured">Bestseller</x-badge>
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
                            <span class="text-sm sm:text-base font-black text-black">${{ number_format($product->effective_price, 2) }}</span>
                            <x-rating :value="$product->rating" size="xs" />
                        </div>
                    </x-slot:footer>
                </x-card>
            @endforeach
        </div>

        <!-- Tab 3: New Arrivals -->
        <div x-show="activeTab === 'latest'" x-cloak class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($latestProducts as $product)
                <x-card :image="$product->image" :imageAlt="$product->name" :imageHref="route('product.show', $product->slug)" :productId="$product->id">
                    <x-slot:badges>
                        <x-badge variant="featured">New Release</x-badge>
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
                            <span class="text-sm sm:text-base font-black text-black">${{ number_format($product->effective_price, 2) }}</span>
                            <x-rating :value="$product->rating" size="xs" />
                        </div>
                    </x-slot:footer>
                </x-card>
            @endforeach
        </div>

        <div class="mt-14 text-center">
            <a href="{{ route('shop.index') }}" class="px-8 py-3.5 bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-wider rounded-full transition inline-block">
                View All Apparel
            </a>
        </div>
    </div>
</section>

<!-- =========================================================================
     5. CAMPAIGN SPOTLIGHT BANNER (Seamless Knit Technology)
     ========================================================================= -->
<section class="relative min-h-[480px] lg:min-h-[540px] flex items-center bg-zinc-950 text-white overflow-hidden my-12">
    <img 
        src="{{ $campaignBanner->image ?? asset('images/gymshark_campaign_banner.jpg') }}" 
        alt="Gymshark Seamless Fabric Innovation" 
        class="absolute inset-0 w-full h-full object-cover object-center opacity-80"
    >
    <div class="absolute inset-0 bg-gradient-to-t from-black/95 via-black/60 to-transparent lg:bg-gradient-to-r lg:from-black/95 lg:via-black/60 lg:to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-16 w-full">
        <div class="max-w-xl space-y-5 text-left">
            <span class="inline-flex items-center px-3 py-1 bg-white text-black text-xs font-bold rounded-full uppercase tracking-wider">
                {{ $campaignBanner->badge ?? 'FABRIC TECHNOLOGY' }}
            </span>
            <h2 class="text-3xl sm:text-5xl font-black tracking-tight leading-tight text-white uppercase">
                {{ $campaignBanner->title ?? 'SEAMLESS 2.0 INNOVATION' }}
            </h2>
            <p class="text-sm sm:text-base text-zinc-300 font-normal leading-relaxed">
                {{ $campaignBanner->subtitle ?? 'Precision jacquard knitwear with sweat-wicking DRY technology, zero-chafing ergonomic construction, and body-sculpting contour shading.' }}
            </p>
            <div class="pt-2">
                <a href="{{ $campaignBanner->link ?? route('shop.index', ['category' => 'seamless']) }}" class="inline-flex items-center gap-2 px-8 py-3.5 bg-white hover:bg-zinc-200 text-black text-xs font-black uppercase tracking-wider rounded-full transition shadow-lg cursor-pointer">
                    {{ $campaignBanner->button_text ?? 'EXPLORE SEAMLESS' }} <i class="fa-solid fa-arrow-right text-xs"></i>
                </a>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
     6. VERIFIED ATHLETE REVIEWS
     ========================================================================= -->
<section class="py-16 bg-white border-b border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <span class="text-xs font-bold text-zinc-500 tracking-wider uppercase">Community Approved</span>
            <h2 class="text-2xl sm:text-3xl font-black text-black tracking-tight mt-1 uppercase">Conditioning Athlete Reviews</h2>
            <p class="text-xs sm:text-sm text-zinc-600 mt-2">Hear directly from athletes and fitness enthusiasts testing our apparel in daily training.</p>
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
                            <i class="fa-solid fa-circle-check text-xs"></i> Verified Athlete
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
     7. VIP ATHLETE CLUB & 20% DISCOUNT
     ========================================================================= -->
<section class="py-16 bg-zinc-950 text-white">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 text-center space-y-6">
        <span class="text-xs font-black uppercase tracking-widest text-zinc-400">JOIN THE VISIONARY CLUB</span>
        <h2 class="text-3xl sm:text-4xl font-black uppercase tracking-tight text-white">
            GET 20% OFF YOUR FIRST DROP
        </h2>
        <p class="text-xs sm:text-sm text-zinc-300 max-w-lg mx-auto font-normal leading-relaxed">
            Use code <span class="font-black text-white bg-zinc-800 px-2 py-0.5 rounded border border-zinc-700">SM20</span> at checkout for 20% off all seamless leggings, workout tees, and heavyweight hoodies.
        </p>
        
        <div class="pt-4">
            <a href="{{ route('shop.index') }}" class="px-8 py-3.5 bg-white hover:bg-zinc-200 text-black text-xs font-black uppercase tracking-wider rounded-full transition shadow-lg inline-block">
                SHOP THE COLLECTION
            </a>
        </div>
    </div>
</section>

@endsection