@extends('layouts.app')

@section('title', 'SM Shop 3D - Next-Gen 2026 E-Commerce Experience')

@section('content')
<!-- =========================================================================
     1. HERO SECTION: 3D THREE.JS WEBGL CANVAS + GSAP TYPOGRAPHY + 3D SHOWCASE
     ========================================================================= -->
<section class="relative bg-gradient-to-b from-slate-950 via-indigo-950 to-slate-900 text-white overflow-hidden py-16 lg:py-28 perspective-1000">
    
    <!-- Three.js 3D WebGL Particle & Mesh Canvas Background -->
    <div id="hero-3d-canvas" class="absolute inset-0 z-0 pointer-events-none opacity-60"></div>

    <!-- Glowing Ambient Neon Light Orbs -->
    <div class="absolute top-10 left-10 w-96 h-96 rounded-full bg-indigo-600/25 blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[30rem] h-[30rem] rounded-full bg-violet-600/20 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left: Hero Headline & Micro-actions -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                
                <div class="gsap-hero-title inline-flex items-center gap-2">
                    <x-badge variant="nano" :dot="true" size="md">
                        2026 Next-Gen 3D Collection
                    </x-badge>
                </div>
                
                <h1 class="gsap-hero-title text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.12]">
                    Immersive 3D <br class="hidden sm:inline">
                    <span class="bg-gradient-to-r from-indigo-300 via-violet-300 to-amber-300 bg-clip-text text-transparent">Tech, Audio & Style</span>
                </h1>
                
                <p class="gsap-hero-title text-base sm:text-lg text-slate-300 max-w-xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    Step into the future of online shopping with real-time 3D product previews, instant checkout, and curated tech & luxury fashion.
                </p>

                <!-- Hero CTA Buttons -->
                <div class="gsap-hero-title flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <x-button variant="accent" size="lg" href="{{ route('shop.index') }}" icon="fa-solid fa-cube">
                        Explore 3D Catalog
                    </x-button>
                    <x-button variant="glass" size="lg" href="{{ route('shop.index', ['sort' => 'popular']) }}">
                        Trending Deals
                    </x-button>
                </div>

                <!-- Verified Stats Strip -->
                <div class="gsap-hero-title grid grid-cols-3 gap-6 pt-8 border-t border-white/10">
                    <div>
                        <div class="text-3xl font-black text-white bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">100%</div>
                        <div class="text-xs text-slate-400 mt-0.5">Authentic Gear</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-white bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">24h</div>
                        <div class="text-xs text-slate-400 mt-0.5">Express Delivery</div>
                    </div>
                    <div>
                        <div class="text-3xl font-black text-white bg-gradient-to-r from-white to-slate-300 bg-clip-text text-transparent">4.9★</div>
                        <div class="text-xs text-slate-400 mt-0.5">Customer Rating</div>
                    </div>
                </div>

            </div>

            <!-- Right: Interactive 3D Showcase Card with Parallax -->
            <div class="lg:col-span-5 relative perspective-2000">
                <div class="hero-3d-card transform-style-3d relative mx-auto max-w-md rounded-3xl overflow-hidden glass-dark shadow-2xl border border-white/20 transition-transform duration-200 cursor-pointer group">
                    <div class="aspect-4/3 w-full overflow-hidden bg-slate-900 relative">
                        <img 
                            src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80" 
                            alt="Pro Studio Audio ANC" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                        <div class="absolute top-4 right-4 bg-slate-950/80 backdrop-blur-md px-3 py-1.5 rounded-full border border-indigo-400/30 text-amber-300 text-xs font-black flex items-center gap-1.5 shadow-lg">
                            <i class="fa-solid fa-cube text-indigo-400"></i> 3D Ready
                        </div>
                    </div>

                    <div class="p-6 relative translate-z-30 space-y-3">
                        <div class="flex items-center justify-between">
                            <x-badge variant="featured" size="sm">
                                ⭐ Staff Pick of The Week
                            </x-badge>
                            <x-rating :value="4.9" :count="128" size="xs" />
                        </div>
                        
                        <h3 class="text-xl font-black text-white">Pro Wireless Studio ANC</h3>
                        <p class="text-xs text-slate-300 line-clamp-2 leading-relaxed">
                            Adaptive spatial audio, 40-hour battery stamina, titanium dynamic drivers, and memory-foam luxury.
                        </p>

                        <div class="flex items-center justify-between pt-2">
                            <div>
                                <span class="text-xs text-slate-400 line-through mr-1 font-semibold">$299.99</span>
                                <span class="text-2xl font-black text-amber-300">$249.99</span>
                            </div>
                            <x-button variant="primary" size="sm" href="{{ route('product.show', 'pro-wireless-noise-cancelling-headphones') }}">
                                View 3D Model
                            </x-button>
                        </div>
                    </div>
                </div>

                <!-- Floating 3D Badge: Top Left -->
                <div class="hero-float-badge-1 absolute -top-4 -left-4 sm:-left-8 glass-dark px-4 py-2.5 rounded-2xl shadow-xl border border-white/20 hidden sm:flex items-center gap-3 backdrop-blur-xl z-20">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-400 to-orange-500 flex items-center justify-center text-slate-950 font-bold shadow-md">
                        <i class="fa-solid fa-bolt text-sm"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-amber-300 uppercase">Flash Discount</div>
                        <div class="text-xs font-extrabold text-white">Save Up To 50%</div>
                    </div>
                </div>

                <!-- Floating 3D Badge: Bottom Right -->
                <div class="hero-float-badge-2 absolute -bottom-6 -right-4 sm:-right-6 glass-dark px-4 py-2.5 rounded-2xl shadow-xl border border-white/20 hidden sm:flex items-center gap-3 backdrop-blur-xl z-20">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-400 to-teal-500 flex items-center justify-center text-slate-950 font-bold shadow-md">
                        <i class="fa-solid fa-shield-check text-sm"></i>
                    </div>
                    <div>
                        <div class="text-[10px] font-black text-emerald-300 uppercase">100% Authentic</div>
                        <div class="text-xs font-extrabold text-white">1 Year Warranty</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- =========================================================================
     2. VALUE PROPOSITIONS & FEATURE STRIP (GLASSMORPHISM STYLE)
     ========================================================================= -->
<section class="py-8 bg-surface border-b border-line-subtle transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="card-3d p-5 rounded-2xl bg-surface-elevated border border-line-subtle hover:border-brand-primary shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white flex items-center justify-center text-xl shadow-md shadow-indigo-500/20 shrink-0">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-content-primary text-sm">Free Express Delivery</h4>
                    <p class="text-xs text-content-muted mt-0.5">On all orders over $100</p>
                </div>
            </div>

            <div class="card-3d p-5 rounded-2xl bg-surface-elevated border border-line-subtle hover:border-status-success shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white flex items-center justify-center text-xl shadow-md shadow-emerald-500/20 shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-content-primary text-sm">100% Secure Checkout</h4>
                    <p class="text-xs text-content-muted mt-0.5">256-Bit SSL Encryption</p>
                </div>
            </div>

            <div class="card-3d p-5 rounded-2xl bg-surface-elevated border border-line-subtle hover:border-brand-accent shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-500 text-white flex items-center justify-center text-xl shadow-md shadow-amber-500/20 shrink-0">
                    <i class="fa-solid fa-rotate-left"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-content-primary text-sm">30-Day Free Return</h4>
                    <p class="text-xs text-content-muted mt-0.5">Zero hassle money-back</p>
                </div>
            </div>

            <div class="card-3d p-5 rounded-2xl bg-surface-elevated border border-line-subtle hover:border-brand-secondary shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-tr from-violet-600 to-purple-600 text-white flex items-center justify-center text-xl shadow-md shadow-violet-500/20 shrink-0">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-content-primary text-sm">24/7 VIP Support</h4>
                    <p class="text-xs text-content-muted mt-0.5">Dedicated live specialists</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- =========================================================================
     3. 2026 BENTO-GRID CATEGORY SHOWCASE
     ========================================================================= -->
<section class="py-16 bg-app transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10">
            <div>
                <span class="text-xs font-black text-brand-primary uppercase tracking-widest">Modern Collections</span>
                <h2 class="text-2xl sm:text-3xl font-black text-content-primary mt-1">Browse by Bento Category</h2>
            </div>
            <a href="{{ route('shop.index') }}" class="text-xs sm:text-sm font-bold text-brand-primary hover:underline flex items-center gap-1.5">
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
     5. SWIPER.JS TESTIMONIALS SLIDER SECTION (GLASSMORPHISM STYLE)
     ========================================================================= -->
<section class="py-16 bg-app border-t border-line-subtle transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center max-w-2xl mx-auto mb-12">
            <x-badge variant="nano" size="sm">⭐ Verified Experience</x-badge>
            <h2 class="text-2xl sm:text-3xl font-black text-content-primary mt-2">Loved by Pioneers & Tech Enthusiasts</h2>
            <p class="text-xs sm:text-sm text-content-secondary mt-2">Discover what our community has to say about our 3D product previews and fast delivery.</p>
        </div>

        <!-- Swiper Carousel Container -->
        <div class="swiper testimonial-swiper pb-12">
            <div class="swiper-wrapper">
                @foreach($testimonials as $testimonial)
                    <div class="swiper-slide h-auto">
                        <div class="glass-card p-6 rounded-3xl h-full flex flex-col justify-between space-y-4 border border-line-subtle">
                            <div class="space-y-3">
                                <div class="flex items-center justify-between">
                                    <x-rating :value="$testimonial->rating" size="sm" />
                                    <span class="text-[10px] text-content-muted font-bold">Verified Buyer</span>
                                </div>
                                <h4 class="font-extrabold text-content-primary text-sm">{{ $testimonial->title ?? 'Excellent Quality!' }}</h4>
                                <p class="text-xs text-content-secondary leading-relaxed italic">
                                    "{{ $testimonial->comment }}"
                                </p>
                            </div>

                            <div class="flex items-center gap-3 pt-3 border-t border-line-subtle">
                                <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-indigo-500 to-violet-600 text-white font-bold flex items-center justify-center text-xs shadow-md">
                                    {{ substr($testimonial->user_name, 0, 1) }}
                                </div>
                                <div>
                                    <div class="font-bold text-xs text-content-primary">{{ $testimonial->user_name }}</div>
                                    <div class="text-[10px] text-content-muted">Reviewed {{ $testimonial->product->name ?? 'SM Product' }}</div>
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
     6. CYBER VIP DISCOUNT & PROMOTION BANNER
     ========================================================================= -->
<section class="py-16 bg-slate-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:20px_20px] opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="relative bg-gradient-to-r from-indigo-950 via-slate-900 to-violet-950 rounded-3xl p-8 sm:p-12 lg:p-16 border border-indigo-500/30 shadow-2xl overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="max-w-2xl space-y-4 relative z-10">
                <x-badge variant="featured" size="sm">
                    ⚡ Member Exclusive Promo
                </x-badge>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight">
                    Get 20% Off With Coupon <span class="bg-gradient-to-r from-amber-300 to-orange-400 bg-clip-text text-transparent">SM20</span>
                </h2>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Enjoy member-only early 3D drops, automatic warranty registration, and expedited nationwide delivery.
                </p>
                <form action="#" onsubmit="event.preventDefault(); alert('Subscribed successfully! Use voucher code SM20 at checkout for 20% off.');" class="flex flex-col sm:flex-row gap-3 pt-4 max-w-md">
                    <input 
                        type="email" 
                        placeholder="Enter your email address" 
                        class="w-full px-4 py-3.5 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm backdrop-blur-md"
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

