@extends('layouts.app')

@section('title', 'SM Shop 3D - Next-Gen 2026 E-Commerce Experience')

@section('content')
<!-- =========================================================================
     1. HERO SECTION: 3D THREE.JS WEBGL CANVAS + GSAP TYPOGRAPHY + 3D SHOWCASE
     ========================================================================= -->
<section class="relative bg-gradient-to-b from-slate-50 via-indigo-50/40 to-white text-slate-900 overflow-hidden py-16 lg:py-24 border-b border-slate-200/80 perspective-1000">
    
    <!-- Three.js 3D WebGL Particle & Mesh Canvas Background -->
    <div id="hero-3d-canvas" class="absolute inset-0 z-0 pointer-events-none opacity-40"></div>

    <!-- Glowing Ambient Soft Light Orbs -->
    <div class="absolute top-10 left-10 w-96 h-96 rounded-full bg-indigo-200/30 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[30rem] h-[30rem] rounded-full bg-violet-200/25 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left: Hero Headline & Micro-actions -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                
                <div class="gsap-hero-title inline-flex items-center gap-2">
                    <x-badge variant="info" :dot="true" size="md">
                        ⚡ 2026 Next-Gen Collection
                    </x-badge>
                </div>
                
                <h1 class="gsap-hero-title text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.12] text-slate-900">
                    Immersive 3D <br class="hidden sm:inline">
                    <span class="bg-gradient-to-r from-indigo-600 via-violet-600 to-purple-600 bg-clip-text text-transparent">Tech, Audio & Style</span>
                </h1>
                
                <p class="gsap-hero-title text-base sm:text-lg text-slate-600 max-w-xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    Step into the future of online shopping with real-time 3D product previews, instant checkout, and curated tech & luxury fashion.
                </p>

                <!-- Hero CTA Buttons -->
                <div class="gsap-hero-title flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <x-button variant="primary" size="lg" href="{{ route('shop.index') }}" icon="fa-solid fa-cube">
                        Explore 3D Catalog
                    </x-button>
                    <x-button variant="outline" size="lg" href="{{ route('shop.index', ['sort' => 'popular']) }}">
                        Trending Deals
                    </x-button>
                </div>

                <!-- Verified Stats Strip -->
                <div class="gsap-hero-title grid grid-cols-3 gap-6 pt-8 border-t border-slate-200/80">
                    <div>
                        <div class="text-3xl font-black text-slate-900">100%</div>
                        <div class="text-xs text-slate-500 mt-0.5">Authentic Gear</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-slate-900">24h</div>
                        <div class="text-xs text-slate-500 mt-0.5">Express Delivery</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-slate-900">4.9★</div>
                        <div class="text-xs text-slate-500 mt-0.5">Customer Rating</div>
                    </div>
                </div>

            </div>

            <!-- Right: Interactive 3D Showcase Card with Parallax -->
            <div class="lg:col-span-5 relative perspective-2000">
                <div class="hero-3d-card transform-style-3d relative mx-auto max-w-md rounded-3xl overflow-hidden bg-white/95 backdrop-blur-xl shadow-2xl border border-slate-200/80 transition-transform duration-200 cursor-pointer group">
                    <div class="aspect-4/3 w-full overflow-hidden bg-slate-50 relative">
                        <img 
                            src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80" 
                            alt="Pro Studio Audio ANC" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        <div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full border border-slate-200 text-indigo-600 text-xs font-bold flex items-center gap-1.5 shadow-sm">
                            <i class="fa-solid fa-cube text-indigo-600"></i> 3D Ready
                        </div>
                    </div>

                    <div class="p-6 relative translate-z-30 space-y-3 bg-white">
                        <div class="flex items-center justify-between">
                            <x-badge variant="featured" size="sm">
                                ⭐ Staff Pick of The Week
                            </x-badge>
                            <x-rating :value="4.9" :count="128" size="xs" />
                        </div>
                        
                        <h3 class="text-xl font-bold text-slate-900">Pro Wireless Studio ANC</h3>
                        <p class="text-xs text-slate-500 line-clamp-2 leading-relaxed">
                            Adaptive spatial audio, 40-hour battery stamina, titanium dynamic drivers, and memory-foam luxury.
                        </p>

                        <div class="flex items-center justify-between pt-2">
                            <div>
                                <span class="text-xs text-slate-400 line-through mr-1 font-semibold">$299.99</span>
                                <span class="text-2xl font-black text-indigo-600">$249.99</span>
                            </div>
                            <x-button variant="primary" size="sm" href="{{ route('product.show', 'pro-wireless-noise-cancelling-headphones') }}">
                                View 3D Model
                            </x-button>
                        </div>
                    </div>
                </div>

                <!-- Floating 3D Badge: Top Left -->
                <div class="hero-float-badge-1 absolute -top-4 -left-4 sm:-left-8 bg-white/95 backdrop-blur-xl px-4 py-2.5 rounded-2xl shadow-xl border border-slate-200 hidden sm:flex items-center gap-3 z-20">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-400 to-orange-500 flex items-center justify-center text-slate-950 font-bold shadow-xs">
                        <i class="fa-solid fa-bolt text-sm text-white"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-amber-600 uppercase">Flash Discount</div>
                        <div class="text-xs font-bold text-slate-900">Save Up To 50%</div>
                    </div>
                </div>

                <!-- Floating 3D Badge: Bottom Right -->
                <div class="hero-float-badge-2 absolute -bottom-6 -right-4 sm:-right-6 bg-white/95 backdrop-blur-xl px-4 py-2.5 rounded-2xl shadow-xl border border-slate-200 hidden sm:flex items-center gap-3 z-20">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-400 to-teal-500 flex items-center justify-center text-white font-bold shadow-xs">
                        <i class="fa-solid fa-shield-check text-sm"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-bold text-emerald-600 uppercase">100% Authentic</div>
                        <div class="text-xs font-bold text-slate-900">1 Year Warranty</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- =========================================================================
     2. VALUE PROPOSITIONS & FEATURE STRIP
     ========================================================================= -->
<section class="py-8 bg-slate-50/70 border-b border-slate-200/80 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="card-3d p-5 rounded-2xl bg-white border border-slate-200/80 hover:border-indigo-300 shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">Free Express Delivery</h4>
                    <p class="text-xs text-slate-500 mt-0.5">On all orders over $100</p>
                </div>
            </div>

            <div class="card-3d p-5 rounded-2xl bg-white border border-slate-200/80 hover:border-emerald-300 shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">100% Secure Checkout</h4>
                    <p class="text-xs text-slate-500 mt-0.5">256-Bit SSL Encryption</p>
                </div>
            </div>

            <div class="card-3d p-5 rounded-2xl bg-white border border-slate-200/80 hover:border-amber-300 shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-rotate-left"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">30-Day Free Return</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Zero hassle money-back</p>
                </div>
            </div>

            <div class="card-3d p-5 rounded-2xl bg-white border border-slate-200/80 hover:border-violet-300 shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-900 text-sm">24/7 VIP Support</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Dedicated live specialists</p>
                </div>
            </div>

        </div>
    </div>
<!-- =========================================================================
     3. BENTO-GRID CATEGORY SHOWCASE
     ========================================================================= -->
<section class="py-16 bg-white transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Modern Collections</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">Browse by Bento Category</h2>
            </div>
            <a href="{{ route('shop.index') }}" class="text-xs sm:text-sm font-bold text-indigo-600 hover:underline flex items-center gap-1.5">
                <span>View Full Catalog</span> 
                <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <!-- 2026 Bento Grid Layout -->
        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
            
            <!-- Bento Card 1: Large Featured (Span 2) -->
            <a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="md:col-span-2 lg:col-span-2 relative rounded-3xl overflow-hidden bg-slate-900 border border-line-subtle group min-h-[320px] flex flex-col justify-end p-8 card-3d">
                <img 
                    src="https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=800&q=80" 
                    alt="Electronics & Gadgets" 
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 opacity-60"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                <div class="relative z-10 space-y-2">
                    <x-badge variant="nano" size="sm">🔥 2026 Flagship Tech</x-badge>
                    <h3 class="text-2xl font-black text-white">Electronics & Smart Gadgets</h3>
                    <p class="text-xs text-slate-300 max-w-sm">Explore next-generation laptops, 4K displays, and smart accessories.</p>
                    <span class="inline-flex items-center gap-1 text-xs font-bold text-amber-300 pt-2 group-hover:translate-x-1 transition-transform">
                        Explore Category <i class="fa-solid fa-arrow-right ml-1"></i>
                    </span>
                </div>
            </a>

            <!-- Bento Card 2: Smart Watches -->
            <a href="{{ route('shop.index', ['category' => 'smart-watches-wearables']) }}" class="relative rounded-3xl overflow-hidden bg-slate-900 border border-line-subtle group min-h-[320px] flex flex-col justify-end p-6 card-3d">
                <img 
                    src="https://images.unsplash.com/photo-1523275335684-37898b6baf30?auto=format&fit=crop&w=600&q=80" 
                    alt="Smart Watches" 
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 opacity-60"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                <div class="relative z-10 space-y-1.5">
                    <x-badge variant="featured" size="sm">Wearables</x-badge>
                    <h3 class="text-lg font-black text-white">Smartwatches</h3>
                    <p class="text-xs text-slate-300">Biometrics & GPS track.</p>
                </div>
            </a>

            <!-- Bento Card 3: Audio & Studio -->
            <a href="{{ route('shop.index', ['category' => 'audio-headphones']) }}" class="relative rounded-3xl overflow-hidden bg-slate-900 border border-line-subtle group min-h-[320px] flex flex-col justify-end p-6 card-3d">
                <img 
                    src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=600&q=80" 
                    alt="Audio Gear" 
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 opacity-60"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                <div class="relative z-10 space-y-1.5">
                    <x-badge variant="discount" size="sm">Spatial Audio</x-badge>
                    <h3 class="text-lg font-black text-white">Audio & Studio</h3>
                    <p class="text-xs text-slate-300">Hi-Res ANC acoustics.</p>
                </div>
            </a>

            <!-- Bento Card 4: Fashion (Span 2) -->
            <a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="md:col-span-2 lg:col-span-2 relative rounded-3xl overflow-hidden bg-slate-900 border border-line-subtle group min-h-[260px] flex flex-col justify-end p-8 card-3d">
                <img 
                    src="https://images.unsplash.com/photo-1445205170230-053b83016050?auto=format&fit=crop&w=800&q=80" 
                    alt="Fashion & Apparel" 
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 opacity-60"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                <div class="relative z-10 space-y-2">
                    <x-badge variant="neutral" size="sm">Luxury Apparel</x-badge>
                    <h3 class="text-xl font-black text-white">Urban Techwear & Minimalist Styles</h3>
                    <p class="text-xs text-slate-300">Tailored comfort engineered with all-weather thermal fabrics.</p>
                </div>
            </a>

            <!-- Bento Card 5: Home & Living (Span 2) -->
            <a href="{{ route('shop.index', ['category' => 'home-living']) }}" class="md:col-span-2 lg:col-span-2 relative rounded-3xl overflow-hidden bg-slate-900 border border-line-subtle group min-h-[260px] flex flex-col justify-end p-8 card-3d">
                <img 
                    src="https://images.unsplash.com/photo-1513694203232-719a280e022f?auto=format&fit=crop&w=800&q=80" 
                    alt="Home & Living" 
                    class="absolute inset-0 w-full h-full object-cover group-hover:scale-108 transition-transform duration-700 opacity-60"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                <div class="relative z-10 space-y-2">
                    <x-badge variant="success" size="sm">Workspace & Living</x-badge>
                    <h3 class="text-xl font-black text-white">Modern Ergonomics & Minimal Living</h3>
                    <p class="text-xs text-slate-300">Elevate your workspace setup with premium minimalist design.</p>
                </div>
            </a>

        </div>
    </div>
</section>

<!-- =========================================================================
     4. TABBED FEATURED PRODUCTS SECTION (POWERED BY ALPINE.JS)
     ========================================================================= -->
<section x-data="{ activeTab: 'featured' }" class="py-16 bg-surface border-t border-line-subtle transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header & Interactive Tabs -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-10">
            <div>
                <span class="text-xs font-black text-brand-primary uppercase tracking-widest">Handpicked 2026 Collection</span>
                <h2 class="text-2xl sm:text-3xl font-black text-content-primary mt-1">Featured 3D Products</h2>
            </div>

            <!-- Alpine.js Dynamic Tab Pill Selectors -->
            <div class="inline-flex p-1.5 rounded-2xl bg-surface-elevated border border-line-subtle shadow-inner">
                <button 
                    type="button"
                    x-on:click="activeTab = 'featured'"
                    :class="activeTab === 'featured' ? 'bg-brand-primary text-white shadow-md' : 'text-content-secondary hover:text-content-primary'"
                    class="px-5 py-2 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer flex items-center gap-1.5"
                >
                    <i class="fa-solid fa-sparkles"></i> Featured Deals
                </button>
                <button 
                    type="button"
                    x-on:click="activeTab = 'bestsellers'"
                    :class="activeTab === 'bestsellers' ? 'bg-brand-primary text-white shadow-md' : 'text-content-secondary hover:text-content-primary'"
                    class="px-5 py-2 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer flex items-center gap-1.5"
                >
                    <i class="fa-solid fa-fire text-amber-300"></i> Best Sellers
                </button>
                <button 
                    type="button"
                    x-on:click="activeTab = 'latest'"
                    :class="activeTab === 'latest' ? 'bg-brand-primary text-white shadow-md' : 'text-content-secondary hover:text-content-primary'"
                    class="px-5 py-2 rounded-xl text-xs font-bold transition-all duration-200 cursor-pointer flex items-center gap-1.5"
                >
                    <i class="fa-solid fa-clock-rotate-left"></i> New Arrivals
                </button>
            </div>
        </div>

        <!-- Tab 1: Featured Deals -->
        <div x-show="activeTab === 'featured'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <x-card variant="product" :hover3d="true" :image="$product->image" :imageAlt="$product->name" :imageHref="route('product.show', $product->slug)">
                    <x-slot:badges>
                        @if($product->has_discount)
                            <x-badge variant="discount">-{{ $product->discount_percent }}% OFF</x-badge>
                        @endif
                        @if($product->is_featured)
                            <x-badge variant="featured">⚡ 3D Featured</x-badge>
                        @endif
                    </x-slot:badges>

                    <div>
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">
                            {{ $product->category->name ?? 'General' }}
                        </span>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mt-0.5 line-clamp-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1 leading-relaxed">
                            {{ $product->short_description }}
                        </p>
                    </div>

                    <x-slot:footer>
                        <div class="flex items-center justify-between">
                            <x-rating :value="$product->rating" :count="$product->reviews_count" size="xs" />
                            <div class="text-right">
                                @if($product->has_discount)
                                    <span class="text-xs text-slate-400 line-through mr-1 font-semibold">${{ number_format($product->price, 2) }}</span>
                                    <span class="text-lg font-extrabold text-rose-600 dark:text-rose-400">${{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="text-lg font-extrabold text-slate-900 dark:text-white">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </div>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <x-button variant="primary" size="sm" type="submit" :fullWidth="true" icon="fa-solid fa-cart-plus">
                                Add to Cart
                            </x-button>
                        </form>
                    </x-slot:footer>
                </x-card>
            @endforeach
        </div>

        <!-- Tab 2: Best Sellers -->
        <div x-show="activeTab === 'bestsellers'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" style="display: none;">
            @foreach($bestSellers as $product)
                <x-card variant="product" :hover3d="true" :image="$product->image" :imageAlt="$product->name" :imageHref="route('product.show', $product->slug)">
                    <x-slot:badges>
                        <x-badge variant="featured">🔥 Top Rated</x-badge>
                    </x-slot:badges>

                    <div>
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">
                            {{ $product->category->name ?? 'General' }}
                        </span>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mt-0.5 line-clamp-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1 leading-relaxed">
                            {{ $product->short_description }}
                        </p>
                    </div>

                    <x-slot:footer>
                        <div class="flex items-center justify-between">
                            <x-rating :value="$product->rating" :count="$product->reviews_count" size="xs" />
                            <span class="text-lg font-extrabold text-slate-900 dark:text-white">${{ number_format($product->effective_price, 2) }}</span>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <x-button variant="primary" size="sm" type="submit" :fullWidth="true" icon="fa-solid fa-cart-plus">
                                Add to Cart
                            </x-button>
                        </form>
                    </x-slot:footer>
                </x-card>
            @endforeach
        </div>

        <!-- Tab 3: New Arrivals -->
        <div x-show="activeTab === 'latest'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6" style="display: none;">
            @foreach($latestProducts as $product)
                <x-card variant="product" :hover3d="true" :image="$product->image" :imageAlt="$product->name" :imageHref="route('product.show', $product->slug)">
                    <x-slot:badges>
                        <x-badge variant="info">✨ New Drop</x-badge>
                    </x-slot:badges>

                    <div>
                        <span class="text-xs font-medium text-slate-500 dark:text-slate-400">
                            {{ $product->category->name ?? 'General' }}
                        </span>
                        <h3 class="font-bold text-slate-900 dark:text-white text-base mt-0.5 line-clamp-1 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
                            <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 line-clamp-2 mt-1 leading-relaxed">
                            {{ $product->short_description }}
                        </p>
                    </div>

                    <x-slot:footer>
                        <div class="flex items-center justify-between">
                            <x-rating :value="$product->rating" :count="$product->reviews_count" size="xs" />
                            <span class="text-lg font-extrabold text-slate-900 dark:text-white">${{ number_format($product->effective_price, 2) }}</span>
                        </div>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <x-button variant="primary" size="sm" type="submit" :fullWidth="true" icon="fa-solid fa-cart-plus">
                                Add to Cart
                            </x-button>
                        </form>
                    </x-slot:footer>
                </x-card>
            @endforeach
        </div>

        <div class="mt-14 text-center">
            <x-button variant="primary" size="lg" href="{{ route('shop.index') }}" icon="fa-solid fa-arrow-right" iconPosition="right">
                Explore All Products
            </x-button>
        </div>
    </div>
</section>

<!-- =========================================================================
     5. SWIPER.JS TESTIMONIALS SLIDER SECTION
     ========================================================================= -->
<section class="py-16 bg-white border-t border-slate-200/80 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <x-badge variant="info" size="sm">⭐ Verified Experience</x-badge>
            <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-2">Loved by Pioneers & Tech Enthusiasts</h2>
            <p class="text-xs sm:text-sm text-slate-600 mt-2">Discover what our community has to say about our 3D product previews and fast delivery.</p>
        </div>

        <!-- Swiper Carousel Container -->
        <div class="swiper testimonial-swiper pb-12">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide h-auto">
                        <div class="p-6 rounded-3xl h-full flex flex-col justify-between space-y-4 bg-slate-50/80 border border-slate-200/80 shadow-xs">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <x-rating :value="$testimonial->rating" size="sm" />
                                    <span class="text-[10px] text-slate-500 font-bold">Verified Buyer</span>
                                </div>
                                <h4 class="font-bold text-slate-900 text-sm">{{ $testimonial->title ?? 'Excellent Quality!' }}</h4>
                                <p class="text-xs text-slate-600 leading-relaxed italic">
                                    "{{ $testimonial->comment }}"
                                </p>
                            </div>

                            <div class="flex items-center gap-3 pt-3 border-t border-slate-200/80">
                                <div class="w-9 h-9 rounded-full bg-indigo-600 text-white font-bold flex items-center justify-center text-xs shadow-xs">
                                    {{ substr($testimonial->user_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-xs text-slate-900">{{ $testimonial->user_name }}</div>
                                    <div class="text-[10px] text-slate-500">Reviewed {{ $testimonial->product->name ?? 'SM Product' }}</div>
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
     6. VIP DISCOUNT & PROMOTION BANNER
     ========================================================================= -->
<section class="py-16 bg-slate-50 border-t border-slate-200/80 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="relative bg-gradient-to-r from-indigo-600 via-indigo-700 to-violet-800 rounded-3xl p-8 sm:p-12 lg:p-16 shadow-xl overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="max-w-2xl space-y-4 relative z-10">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/20 text-white font-bold text-xs">
                    ⚡ Member Exclusive Promo
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight text-white">
                    Get 20% Off With Coupon <span class="text-amber-300">SM20</span>
                </h2>
                <p class="text-white/90 text-sm sm:text-base leading-relaxed">
                    Enjoy member-only early 3D drops, automatic warranty registration, and expedited nationwide delivery.
                </p>
                <form action="#" onsubmit="event.preventDefault(); alert('Subscribed successfully! Use voucher code SM20 at checkout for 20% off.');" class="flex flex-col sm:flex-row gap-3 pt-4 max-w-md">
                    <input 
                        type="email" 
                        placeholder="Enter your email address" 
                        class="w-full px-4 py-3.5 rounded-2xl bg-white/15 border border-white/30 text-white placeholder-white/70 focus:outline-none focus:ring-2 focus:ring-amber-300 text-sm backdrop-blur-md"
                        required
                    >
                    <x-button variant="accent" size="md" type="submit">
                        Claim Voucher
                    </x-button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

