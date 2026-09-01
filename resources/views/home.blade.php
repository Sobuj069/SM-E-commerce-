@extends('layouts.app')

@section('title', 'SM Shop 3D - Engineered for Performance & Tech')

@section('content')
<!-- =========================================================================
     1. GYMSHARK HIGH-IMPACT HERO BANNER
     ========================================================================= -->
<section class="relative bg-zinc-100 overflow-hidden py-20 lg:py-32 border-b border-zinc-200">
    <!-- WebGL Particle Canvas (Soft Ambient) -->
    <div id="hero-3d-canvas" class="absolute inset-0 z-0 pointer-events-none opacity-30"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left: High-Impact Typography & Dual CTA Pills -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                
                <div class="inline-flex items-center gap-2">
                    <x-badge variant="featured" size="sm">
                        NEW COLLECTION 2026
                    </x-badge>
                </div>
                
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black tracking-tight leading-[1.05] text-black uppercase">
                    ENGINEERED <br class="hidden sm:inline">
                    FOR TECH & STYLE
                </h1>
                
                <p class="text-sm sm:text-base text-zinc-600 max-w-lg mx-auto lg:mx-0 uppercase tracking-wider font-semibold leading-relaxed">
                    Interactive 3D product previews. Next-generation electronics, spatial audio, and high-performance lifestyle essentials.
                </p>

                <!-- Dual Gymshark CTA Buttons -->
                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-3 pt-4">
                    <x-button variant="primary" size="lg" href="{{ route('shop.index') }}">
                        SHOP ALL PRODUCTS
                    </x-button>
                    <x-button variant="outline" size="lg" href="{{ route('shop.index', ['sort' => 'popular']) }}">
                        EXPLORE 3D DEALS
                    </x-button>
                </div>

                <!-- Minimalist Perks Strip -->
                <div class="grid grid-cols-3 gap-6 pt-10 border-t border-zinc-300 max-w-lg mx-auto lg:mx-0 text-left">
                    <div>
                        <div class="text-2xl font-black text-black uppercase">100%</div>
                        <div class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mt-0.5">AUTHENTIC GEAR</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-black uppercase">FREE</div>
                        <div class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mt-0.5">SHIPPING OVER $75</div>
                    </div>
                    <div>
                        <div class="text-2xl font-black text-black uppercase">30-DAY</div>
                        <div class="text-[10px] font-bold text-zinc-500 uppercase tracking-widest mt-0.5">EASY RETURNS</div>
                    </div>
                </div>

            </div>

            <!-- Right: High-Impact Featured 3D Showcase -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md rounded-2xl overflow-hidden bg-white shadow-xl border border-zinc-200 group">
                    <div class="aspect-[3/4] w-full overflow-hidden bg-[#f4f4f5] relative">
                        <img 
                            src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80" 
                            alt="Pro Studio Audio ANC" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                        >
                        <div class="absolute top-3 left-3">
                            <x-badge variant="discount" size="sm">-20% OFF</x-badge>
                        </div>
                        <div class="absolute top-3 right-3 bg-black text-white px-3 py-1 text-[10px] font-black uppercase tracking-widest">
                            <i class="fa-solid fa-cube mr-1"></i> 3D READY
                        </div>
                    </div>

                    <div class="p-6 space-y-3 bg-white border-t border-zinc-100">
                        <div class="text-[11px] font-bold uppercase tracking-wider text-zinc-500">STUDIO AUDIO | TITANIUM SERIES</div>
                        <h3 class="text-lg font-black text-black uppercase tracking-tight">PRO WIRELESS STUDIO ANC</h3>
                        
                        <div class="flex items-center justify-between pt-2">
                            <div>
                                <span class="text-xs text-zinc-400 line-through mr-1 font-semibold">$299.99</span>
                                <span class="text-xl font-black text-black">$249.99</span>
                            </div>
                            <x-button variant="primary" size="sm" href="{{ route('product.show', 'pro-wireless-noise-cancelling-headphones') }}">
                                VIEW IN 3D
                            </x-button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- =========================================================================
     2. GYMSHARK VALUE PERKS STRIP
     ========================================================================= -->
<section class="py-6 bg-white border-b border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
            
            <div class="flex flex-col items-center justify-center p-3">
                <i class="fa-solid fa-truck-fast text-xl text-black mb-2"></i>
                <h4 class="font-black text-black text-xs uppercase tracking-wider">FREE STANDARD DELIVERY</h4>
                <p class="text-[11px] text-zinc-500 uppercase mt-0.5">ON ALL ORDERS OVER $75</p>
            </div>

            <div class="flex flex-col items-center justify-center p-3">
                <i class="fa-solid fa-rotate-left text-xl text-black mb-2"></i>
                <h4 class="font-black text-black text-xs uppercase tracking-wider">30-DAY EASY RETURNS</h4>
                <p class="text-[11px] text-zinc-500 uppercase mt-0.5">FAST & HASSLE-FREE</p>
            </div>

            <div class="flex flex-col items-center justify-center p-3">
                <i class="fa-solid fa-shield-halved text-xl text-black mb-2"></i>
                <h4 class="font-black text-black text-xs uppercase tracking-wider">100% SECURE CHECKOUT</h4>
                <p class="text-[11px] text-zinc-500 uppercase mt-0.5">256-BIT ENCRYPTION</p>
            </div>

            <div class="flex flex-col items-center justify-center p-3">
                <i class="fa-solid fa-cube text-xl text-black mb-2"></i>
                <h4 class="font-black text-black text-xs uppercase tracking-wider">INTERACTIVE 3D PREVIEW</h4>
                <p class="text-[11px] text-zinc-500 uppercase mt-0.5">INSPECT BEFORE YOU BUY</p>
            </div>

        </div>
    </div>
</section>

<!-- =========================================================================
     3. GYMSHARK SHOP BY CATEGORY COLLECTION
     ========================================================================= -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black text-black uppercase tracking-tight">SHOP BY COLLECTION</h2>
            </div>
            <a href="{{ route('shop.index') }}" class="text-xs font-black text-black uppercase tracking-widest hover:underline flex items-center gap-1.5">
                <span>VIEW ALL</span> 
                <i class="fa-solid fa-arrow-right text-[10px]"></i>
            </a>
        </div>

        <!-- 4-Column Category Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Category 1: Tech & Gadgets -->
            <a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="group relative rounded-xl overflow-hidden bg-[#f4f4f5] aspect-[3/4] flex flex-col justify-end p-6">
                <img 
                    src="https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=800&q=80" 
                    alt="Electronics & Gadgets" 
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="relative z-10 space-y-1">
                    <span class="text-[10px] font-bold text-zinc-300 uppercase tracking-widest">FLAGSHIP TECH</span>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">TECH & GADGETS</h3>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-white uppercase tracking-wider pt-2 group-hover:translate-x-1 transition-transform">
                        SHOP NOW <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
            </a>

            <!-- Category 2: Smartwatches & Wearables -->
            <a href="{{ route('shop.index', ['category' => 'smart-watches-wearables']) }}" class="group relative rounded-xl overflow-hidden bg-[#f4f4f5] aspect-[3/4] flex flex-col justify-end p-6">
                <img 
                    src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80" 
                    alt="Smartwatches & Wearables" 
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="relative z-10 space-y-1">
                    <span class="text-[10px] font-bold text-zinc-300 uppercase tracking-widest">BIOMETRICS</span>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">SMART WEARABLES</h3>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-white uppercase tracking-wider pt-2 group-hover:translate-x-1 transition-transform">
                        SHOP NOW <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
            </a>

            <!-- Category 3: Audio & Headphones -->
            <a href="{{ route('shop.index', ['category' => 'audio-headphones']) }}" class="group relative rounded-xl overflow-hidden bg-[#f4f4f5] aspect-[3/4] flex flex-col justify-end p-6">
                <img 
                    src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80" 
                    alt="Audio & Headphones" 
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="relative z-10 space-y-1">
                    <span class="text-[10px] font-bold text-zinc-300 uppercase tracking-widest">SPATIAL ANC</span>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">AUDIO & STUDIO</h3>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-white uppercase tracking-wider pt-2 group-hover:translate-x-1 transition-transform">
                        SHOP NOW <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
            </a>

            <!-- Category 4: Fashion & Apparel -->
            <a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="group relative rounded-xl overflow-hidden bg-[#f4f4f5] aspect-[3/4] flex flex-col justify-end p-6">
                <img 
                    src="https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=800&q=80" 
                    alt="Fashion & Apparel" 
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-105 transition-transform duration-700"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                <div class="relative z-10 space-y-1">
                    <span class="text-[10px] font-bold text-zinc-300 uppercase tracking-widest">ACTIVE LUXURY</span>
                    <h3 class="text-xl font-black text-white uppercase tracking-tight">TECHWEAR & APPAREL</h3>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-white uppercase tracking-wider pt-2 group-hover:translate-x-1 transition-transform">
                        SHOP NOW <i class="fa-solid fa-arrow-right text-[10px]"></i>
                    </span>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- =========================================================================
     4. GYMSHARK PRODUCT GRID & TABS ("TRENDING NOW")
     ========================================================================= -->
<section x-data="{ activeTab: 'featured' }" class="py-16 bg-zinc-50 border-t border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Category Tab Filters -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <h2 class="text-2xl sm:text-3xl font-black text-black uppercase tracking-tight">TRENDING NOW</h2>
            </div>

            <!-- Tab Pills -->
            <div class="inline-flex p-1 rounded-full bg-zinc-200">
                <button 
                    type="button"
                    x-on:click="activeTab = 'featured'"
                    :class="activeTab === 'featured' ? 'bg-black text-white shadow-sm' : 'text-zinc-700 hover:text-black'"
                    class="px-5 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-200 cursor-pointer"
                >
                    FEATURED
                </button>
                <button 
                    type="button"
                    x-on:click="activeTab = 'bestsellers'"
                    :class="activeTab === 'bestsellers' ? 'bg-black text-white shadow-sm' : 'text-zinc-700 hover:text-black'"
                    class="px-5 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-200 cursor-pointer"
                >
                    BEST SELLERS
                </button>
                <button 
                    type="button"
                    x-on:click="activeTab = 'latest'"
                    :class="activeTab === 'latest' ? 'bg-black text-white shadow-sm' : 'text-zinc-700 hover:text-black'"
                    class="px-5 py-2 rounded-full text-xs font-black uppercase tracking-wider transition-all duration-200 cursor-pointer"
                >
                    NEW RELEASES
                </button>
            </div>
        </div>

        <!-- Tab 1: Featured Deals -->
        <div x-show="activeTab === 'featured'" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6">
            @foreach($featuredProducts as $product)
                <x-card :image="$product->image" :imageAlt="$product->name" :imageHref="route('product.show', $product->slug)" :productId="$product->id">
                    <x-slot:badges>
                        @if($product->has_discount)
                            <x-badge variant="discount">-{{ $product->discount_percent }}% OFF</x-badge>
                        @endif
                        @if($product->is_featured)
                            <x-badge variant="featured">NEW</x-badge>
                        @endif
                    </x-slot:badges>

                    <div>
                        <div class="text-[11px] font-bold text-zinc-500 uppercase tracking-wider">
                            {{ $product->category->name ?? 'GEAR' }}
                        </div>
                        <h3 class="font-bold text-black text-xs sm:text-sm uppercase tracking-tight mt-0.5 line-clamp-1 group-hover:underline">
                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-[11px] text-zinc-500 line-clamp-1 mt-0.5">
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
        <div x-show="activeTab === 'bestsellers'" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6" style="display: none;">
            @foreach($bestSellers as $product)
                <x-card :image="$product->image" :imageAlt="$product->name" :imageHref="route('product.show', $product->slug)" :productId="$product->id">
                    <x-slot:badges>
                        <x-badge variant="featured">BESTSELLER</x-badge>
                    </x-slot:badges>

                    <div>
                        <div class="text-[11px] font-bold text-zinc-500 uppercase tracking-wider">
                            {{ $product->category->name ?? 'GEAR' }}
                        </div>
                        <h3 class="font-bold text-black text-xs sm:text-sm uppercase tracking-tight mt-0.5 line-clamp-1 group-hover:underline">
                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-[11px] text-zinc-500 line-clamp-1 mt-0.5">
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
        <div x-show="activeTab === 'latest'" class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-4 gap-5 sm:gap-6" style="display: none;">
            @foreach($latestProducts as $product)
                <x-card :image="$product->image" :imageAlt="$product->name" :imageHref="route('product.show', $product->slug)" :productId="$product->id">
                    <x-slot:badges>
                        <x-badge variant="featured">JUST DROPPED</x-badge>
                    </x-slot:badges>

                    <div>
                        <div class="text-[11px] font-bold text-zinc-500 uppercase tracking-wider">
                            {{ $product->category->name ?? 'GEAR' }}
                        </div>
                        <h3 class="font-bold text-black text-xs sm:text-sm uppercase tracking-tight mt-0.5 line-clamp-1 group-hover:underline">
                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-[11px] text-zinc-500 line-clamp-1 mt-0.5">
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
            <x-button variant="primary" size="lg" href="{{ route('shop.index') }}">
                VIEW ALL PRODUCTS
            </x-button>
        </div>
    </div>
</section>

<!-- =========================================================================
     5. GYMSHARK COMMUNITY & TESTIMONIALS
     ========================================================================= -->
<section class="py-16 bg-white border-t border-zinc-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <h2 class="text-2xl sm:text-3xl font-black text-black uppercase tracking-tight">VERIFIED REVIEWS</h2>
            <p class="text-xs text-zinc-500 uppercase tracking-wider font-bold mt-1">SEE WHAT THE COMMUNITY IS SAYING</p>
        </div>

        <div class="swiper testimonial-swiper pb-10">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide h-auto">
                        <div class="p-6 rounded-2xl h-full flex flex-col justify-between space-y-4 bg-zinc-50 border border-zinc-200">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <x-rating :value="$testimonial->rating" size="xs" />
                                    <span class="text-[10px] text-zinc-500 font-bold uppercase tracking-wider">VERIFIED BUYER</span>
                                </div>
                                <h4 class="font-black text-black text-xs uppercase tracking-wider">{{ $testimonial->title ?? 'EXCELLENT QUALITY' }}</h4>
                                <p class="text-xs text-zinc-600 leading-relaxed italic">
                                    "{{ $testimonial->comment }}"
                                </p>
                            </div>

                            <div class="flex items-center gap-3 pt-3 border-t border-zinc-200">
                                <div class="w-8 h-8 rounded-full bg-black text-white font-black flex items-center justify-center text-xs">
                                    {{ substr($testimonial->user_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-xs text-black uppercase">{{ $testimonial->user_name }}</div>
                                    <div class="text-[10px] text-zinc-500 uppercase">{{ $testimonial->product->name ?? 'SM Product' }}</div>
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
     6. GYMSHARK HIGH-CONTRAST VIP MEMBER BANNER
     ========================================================================= -->
<section class="py-16 bg-black text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
        <div class="max-w-2xl mx-auto space-y-4">
            <span class="inline-flex items-center px-3 py-1 bg-zinc-800 text-white font-black text-[10px] uppercase tracking-widest">
                EXCLUSIVE COMMUNITY OFFER
            </span>
            <h2 class="text-3xl sm:text-5xl font-black uppercase tracking-tight text-white">
                GET 20% OFF YOUR FIRST ORDER
            </h2>
            <p class="text-zinc-400 text-xs sm:text-sm uppercase tracking-wider font-semibold leading-relaxed">
                Unlock exclusive early 3D drops, automatic 1-year product warranty, and free express nationwide shipping.
            </p>
            <div class="pt-4">
                <a href="{{ route('shop.index') }}" class="inline-flex items-center justify-center bg-white hover:bg-zinc-200 text-black text-xs font-black uppercase tracking-widest py-4 px-10 rounded-full transition">
                    USE CODE: SM20 AT CHECKOUT
                </a>
            </div>
        </div>
    </div>
</section>
@endsection