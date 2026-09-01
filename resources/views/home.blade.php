@extends('layouts.app')

@section('title', 'SM Shop 3D - Engineered for Performance & Tech')

@section('content')
@php
    $heroBanner = $banners->first();
    $campaignBanner = $banners->skip(1)->first();
@endphp

<!-- =========================================================================
     1. HERO BANNER (Standardized Typography & WCAG Contrast)
     ========================================================================= -->
<section class="relative min-h-[550px] lg:min-h-[680px] flex items-center bg-zinc-950 overflow-hidden text-white">
    <img 
        src="{{ $heroBanner->image ?? asset('images/gymshark_hero_banner.jpg') }}" 
        alt="Hero Banner" 
        class="absolute inset-0 w-full h-full object-cover object-center opacity-85"
    >
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent lg:bg-gradient-to-r lg:from-black/90 lg:via-black/50 lg:to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-20 w-full">
        <div class="max-w-xl space-y-6 text-left">
            
            <div class="inline-flex items-center gap-2">
                <span class="inline-flex items-center px-3 py-1 bg-white text-black text-xs font-bold rounded-full">
                    {{ $heroBanner->badge ?? 'New 2026 Collection' }}
                </span>
            </div>
            
            <h1 class="text-4xl sm:text-6xl font-black tracking-tight leading-[1.05] text-white">
                Engineered for Progress
            </h1>
            
            <p class="text-sm sm:text-base text-zinc-300 font-normal leading-relaxed">
                Next-gen 3D tech, spatial audio, and high-performance activewear with interactive 3D preview and express checkout.
            </p>

            <!-- Dual Standardized Action Buttons -->
            <div class="flex flex-wrap gap-4 pt-2">
                <a href="{{ $heroBanner->link ?? route('shop.index') }}" class="px-8 py-3.5 bg-white hover:bg-zinc-200 text-black text-xs font-bold rounded-full transition shadow-lg cursor-pointer">
                    {{ $heroBanner->button_text ?? 'Shop All Tech' }}
                </a>
                <a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="px-8 py-3.5 bg-black/60 hover:bg-black text-white border border-white/60 text-xs font-bold rounded-full transition backdrop-blur-md cursor-pointer">
                    Shop Apparel
                </a>
            </div>

            <!-- Perks Summary -->
            <div class="grid grid-cols-3 gap-6 pt-8 border-t border-white/20 max-w-lg text-left">
                <div>
                    <div class="text-xl font-bold text-white">100%</div>
                    <div class="text-xs text-zinc-400 font-medium mt-0.5">Authentic Gear</div>
                </div>
                <div>
                    <div class="text-xl font-bold text-white">Free</div>
                    <div class="text-xs text-zinc-400 font-medium mt-0.5">Shipping Over $75</div>
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
     2. VALUE PERKS STRIP (Fixed Heading Levels & Semantics)
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
                <p class="font-bold text-black text-sm">100% Secure Checkout</p>
                <p class="text-xs text-zinc-500 mt-0.5">256-Bit SSL encryption</p>
            </div>

            <div class="flex flex-col items-center justify-center p-3">
                <i class="fa-solid fa-cube text-xl text-black mb-2" aria-hidden="true"></i>
                <p class="font-bold text-black text-sm">Interactive 3D Preview</p>
                <p class="text-xs text-zinc-500 mt-0.5">Inspect before you buy</p>
            </div>

        </div>
    </div>
</section>

<!-- =========================================================================
     3. SHOP BY COLLECTION (Aligned Baselines & Deep Gradient Scrim)
     ========================================================================= -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-bold text-zinc-500 tracking-wider">Discover Drops</span>
                <h2 class="text-2xl sm:text-3xl font-black text-black tracking-tight mt-1">Shop by Collection</h2>
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
                                <h3 class="text-lg font-bold text-white leading-tight">{{ $category->name }}</h3>
                                <span class="inline-flex items-center gap-1 text-xs font-bold text-white pt-1 group-hover:translate-x-1 transition-transform">
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
     4. TRENDING NOW TABS (Fixed Void, Cloak & Responsive Grid)
     ========================================================================= -->
<section x-data="{ activeTab: 'featured' }" class="py-16 bg-zinc-50 border-t border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Category Tab Filters -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <span class="text-xs font-bold text-zinc-500 tracking-wider">Community Picks</span>
                <h2 class="text-2xl sm:text-3xl font-black text-black tracking-tight mt-1">Trending Now</h2>
            </div>

            <!-- Tab Pills (WCAG 2.2 Tablist & Accessible Contrast) -->
            <div role="tablist" aria-label="Product categories" class="inline-flex p-1 rounded-full bg-zinc-200">
                <button 
                    type="button"
                    role="tab"
                    :aria-selected="activeTab === 'featured'"
                    x-on:click="activeTab = 'featured'"
                    :class="activeTab === 'featured' ? 'bg-black text-white shadow-sm' : 'text-zinc-800 hover:text-black'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition cursor-pointer focus-visible:ring-2 focus-visible:ring-black"
                >
                    Featured
                </button>
                <button 
                    type="button"
                    role="tab"
                    :aria-selected="activeTab === 'bestsellers'"
                    x-on:click="activeTab = 'bestsellers'"
                    :class="activeTab === 'bestsellers' ? 'bg-black text-white shadow-sm' : 'text-zinc-800 hover:text-black'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition cursor-pointer focus-visible:ring-2 focus-visible:ring-black"
                >
                    Best Sellers
                </button>
                <button 
                    type="button"
                    role="tab"
                    :aria-selected="activeTab === 'latest'"
                    x-on:click="activeTab = 'latest'"
                    :class="activeTab === 'latest' ? 'bg-black text-white shadow-sm' : 'text-zinc-800 hover:text-black'"
                    class="px-5 py-2.5 rounded-full text-xs font-bold transition cursor-pointer focus-visible:ring-2 focus-visible:ring-black"
                >
                    New Releases
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
                            <x-badge variant="featured">New</x-badge>
                        @endif
                    </x-slot:badges>

                    <div>
                        <div class="text-xs font-semibold text-zinc-500">
                            {{ $product->category->name ?? 'Gear' }}
                        </div>
                        <h3 class="font-bold text-black text-sm tracking-tight mt-0.5 line-clamp-1 group-hover:underline">
                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-zinc-500 line-clamp-1 mt-0.5">
                            {{ $product->short_description }}
                        </p>
                    </div>

                    <x-slot:footer>
                        <div class="flex items-center justify-between">
                            <div>
                                @if($product->has_discount)
                                    <span class="text-xs text-zinc-400 line-through mr-1 font-semibold">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-sm sm:text-base font-bold text-red-600">${{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="text-sm sm:text-base font-bold text-black">${{ number_format($product->price, 2) }}</span>
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
                        <div class="text-xs font-semibold text-zinc-500">
                            {{ $product->category->name ?? 'Gear' }}
                        </div>
                        <h3 class="font-bold text-black text-sm tracking-tight mt-0.5 line-clamp-1 group-hover:underline">
                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-zinc-500 line-clamp-1 mt-0.5">
                            {{ $product->short_description }}
                        </p>
                    </div>

                    <x-slot:footer>
                        <div class="flex items-center justify-between">
                            <span class="text-sm sm:text-base font-bold text-black">${{ number_format($product->effective_price, 2) }}</span>
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
                        <div class="text-xs font-semibold text-zinc-500">
                            {{ $product->category->name ?? 'Gear' }}
                        </div>
                        <h3 class="font-bold text-black text-sm tracking-tight mt-0.5 line-clamp-1 group-hover:underline">
                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-zinc-500 line-clamp-1 mt-0.5">
                            {{ $product->short_description }}
                        </p>
                    </div>

                    <x-slot:footer>
                        <div class="flex items-center justify-between">
                            <span class="text-sm sm:text-base font-bold text-black">${{ number_format($product->effective_price, 2) }}</span>
                            <x-rating :value="$product->rating" size="xs" />
                        </div>
                    </x-slot:footer>
                </x-card>
            @endforeach
        </div>

        <div class="mt-14 text-center">
            <a href="{{ route('shop.index') }}" class="px-8 py-3.5 bg-black hover:bg-zinc-800 text-white text-xs font-bold rounded-full transition inline-block">
                View All Products
            </a>
        </div>
    </div>
</section>

<!-- =========================================================================
     5. CAMPAIGN SPOTLIGHT BANNER (Consistent Left-Alignment & Badge Token)
     ========================================================================= -->
<section class="relative min-h-[480px] lg:min-h-[520px] flex items-center bg-zinc-950 text-white overflow-hidden my-12">
    <img 
        src="{{ $campaignBanner->image ?? asset('images/gymshark_campaign_banner.jpg') }}" 
        alt="Campaign Banner" 
        class="absolute inset-0 w-full h-full object-cover object-center opacity-80"
    >
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent lg:bg-gradient-to-r lg:from-black/90 lg:via-black/50 lg:to-transparent"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 py-16 w-full">
        <div class="max-w-xl space-y-4 text-left">
            <span class="inline-flex items-center px-3.5 py-1 bg-white/15 backdrop-blur-md text-white border border-white/20 text-xs font-bold rounded-full tracking-wider">
                {{ $campaignBanner->badge ?? 'Seamless Fit & Precision Tech' }}
            </span>
            <h2 class="text-3xl sm:text-5xl font-black text-white leading-tight">
                {{ $campaignBanner->title ?? 'Active Techwear & Wearables' }}
            </h2>
            <p class="text-sm text-zinc-300 font-normal leading-relaxed">
                {{ $campaignBanner->subtitle ?? 'Engineered with breathable thermal fabrics, biometric performance tracking, and lightweight ergonomic form.' }}
            </p>
            <div class="pt-2">
                <a href="{{ $campaignBanner->link ?? route('shop.index', ['category' => 'fashion-apparel']) }}" class="px-8 py-3.5 bg-white hover:bg-zinc-200 text-black text-xs font-bold rounded-full transition shadow-lg inline-block cursor-pointer">
                    {{ $campaignBanner->button_text ?? 'Explore Collection' }}
                </a>
            </div>
        </div>
    </div>
</section>

<!-- =========================================================================
     6. VERIFIED REVIEWS SECTION (Unified Grouping & Strict Heading Hierarchy)
     ========================================================================= -->
<section class="py-16 bg-white border-t border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 mb-10 pb-6 border-b border-zinc-200">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black text-black tracking-tight">Verified Reviews</h2>
                <p class="text-xs text-zinc-500 font-medium mt-1">Real feedback from verified purchasers worldwide.</p>
            </div>
            <div class="flex items-center gap-2 bg-zinc-100 px-4 py-2 rounded-full text-xs font-bold text-black">
                <i class="fa-solid fa-star text-amber-400"></i> 4.9 out of 5 Rating Average
            </div>
        </div>

        <div class="swiper testimonial-swiper overflow-hidden w-full pb-10">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide h-auto">
                        <div class="p-6 rounded-2xl h-full flex flex-col justify-between space-y-4 bg-zinc-50 border border-zinc-200">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <x-rating :value="$testimonial->rating" size="xs" />
                                    <span class="text-xs text-zinc-500 font-semibold">Verified Buyer</span>
                                </div>
                                <h3 class="font-bold text-black text-sm">{{ $testimonial->title ?? 'Excellent Quality' }}</h3>
                                <p class="text-xs text-zinc-600 leading-relaxed italic">
                                    "{{ $testimonial->comment }}"
                                </p>
                            </div>

                            <div class="flex items-center gap-3 pt-3 border-t border-zinc-200">
                                <div class="w-8 h-8 rounded-full bg-black text-white font-bold flex items-center justify-center text-xs">
                                    {{ substr($testimonial->user_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-xs text-black">{{ $testimonial->user_name }}</div>
                                    <div class="text-xs text-zinc-500">{{ $testimonial->product->name ?? 'SM Product' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>

<!-- =========================================================================
     7. CONSOLIDATED VIP CLUB & INTERACTIVE PROMO (Clipboard Copy Action)
     ========================================================================= -->
<section class="py-16 bg-black text-white text-center">
    <div class="max-w-2xl mx-auto px-4 space-y-4">
        <span class="inline-flex items-center px-3.5 py-1 bg-zinc-800 text-white text-xs font-bold rounded-full">
            Exclusive Community Offer
        </span>
        <h2 class="text-3xl sm:text-4xl font-black text-white">
            Get 20% Off Your Order
        </h2>
        <p class="text-xs sm:text-sm text-zinc-400 font-medium leading-relaxed">
            Unlock exclusive early 3D drops, 1-year product warranty, and free express nationwide shipping.
        </p>
        
        <!-- Copy to Clipboard Button -->
        <div x-data="{ copied: false }" class="pt-4">
            <button 
                type="button" 
                @click="navigator.clipboard.writeText('SM20'); copied = true; setTimeout(() => copied = false, 2500)"
                class="inline-flex items-center gap-2 bg-white hover:bg-zinc-100 text-black text-xs font-bold py-3.5 px-8 rounded-full transition cursor-pointer shadow-lg"
            >
                <i :class="copied ? 'fa-solid fa-check text-emerald-600' : 'fa-regular fa-copy'"></i>
                <span x-text="copied ? 'Copied to Clipboard: SM20' : 'Copy Code: SM20 (20% Off)'"></span>
            </button>
        </div>
    </div>
</section>
@endsection