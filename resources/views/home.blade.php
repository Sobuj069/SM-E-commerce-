@extends('layouts.app')

@section('title', 'SM E-Commerce - 3D Next-Gen Shopping Experience')

@section('content')
<!-- 3D Animated Hero Section -->
<section class="relative bg-gradient-to-b from-slate-950 via-indigo-950 to-slate-900 text-white overflow-hidden py-16 lg:py-28 perspective-1000">
    
    <!-- Animated Glowing Background Ambient Light Orbs (Anime.js controlled) -->
    <div class="absolute top-10 left-10 w-96 h-96 rounded-full bg-indigo-600/25 blur-3xl animate-orb-1 pointer-events-none"></div>
    <div class="absolute bottom-10 right-10 w-[30rem] h-[30rem] rounded-full bg-violet-600/20 blur-3xl animate-orb-2 pointer-events-none"></div>
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-80 h-80 rounded-full bg-amber-500/10 blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <!-- Left Hero Content with Stagger Entrance -->
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                
                <div class="hero-stagger inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-white/15 text-indigo-200 text-xs font-bold uppercase tracking-wider shadow-lg">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    <span>3D Interactive Collection 2026</span>
                </div>
                
                <h1 class="hero-stagger text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-[1.12]">
                    Next-Generation <br class="hidden sm:inline">
                    <span class="bg-gradient-to-r from-indigo-300 via-violet-300 to-amber-300 bg-clip-text text-transparent">Tech, Audio & Style</span>
                </h1>
                
                <p class="hero-stagger text-base sm:text-lg text-slate-300 max-w-xl mx-auto lg:mx-0 leading-relaxed font-normal">
                    Experience seamless high-performance shopping. Powered by ultra-fast checkout, adaptive 3D product previews, and verified customer satisfaction.
                </p>

                <!-- CTA Buttons -->
                <div class="hero-stagger flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('shop.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-sm font-extrabold text-slate-950 bg-gradient-to-r from-amber-300 via-amber-200 to-amber-400 hover:from-amber-200 hover:to-amber-300 rounded-2xl shadow-xl shadow-amber-500/20 transition-all duration-300 transform hover:-translate-y-1 active:scale-95">
                        <i class="fa-solid fa-sparkles mr-2 text-indigo-900"></i> Explore 3D Catalog
                    </a>
                    <a href="{{ route('shop.index', ['sort' => 'popular']) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-sm font-bold text-white bg-white/10 hover:bg-white/20 border border-white/20 rounded-2xl backdrop-blur-md transition-all duration-300 transform hover:-translate-y-1">
                        Trending Deals
                    </a>
                </div>

                <!-- Live Metrics -->
                <div class="hero-stagger grid grid-cols-3 gap-6 pt-8 border-t border-white/10">
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

            <!-- Right: Interactive 3D Floating Showcase Card -->
            <div class="lg:col-span-5 relative perspective-2000">
                
                <!-- Main 3D Tilted Card -->
                <div class="hero-3d-card transform-style-3d relative mx-auto max-w-md rounded-3xl overflow-hidden glass-dark shadow-2xl border border-white/20 transition-transform duration-200 cursor-pointer group">
                    <div class="aspect-4/3 w-full overflow-hidden bg-slate-900 relative">
                        <img 
                            src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80" 
                            alt="Pro Studio Audio ANC" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-slate-950/40 to-transparent"></div>
                    </div>

                    <div class="p-6 relative translate-z-30 space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="px-2.5 py-1 rounded-full bg-indigo-500/30 text-indigo-300 text-[10px] font-bold uppercase tracking-wider border border-indigo-400/30">
                                ⭐ Top Pick of The Week
                            </span>
                            <span class="text-xs font-bold text-amber-400 flex items-center gap-1">
                                <i class="fa-solid fa-star text-[11px]"></i> 4.9 (128 Reviews)
                            </span>
                        </div>
                        
                        <h3 class="text-xl font-black text-white">Pro Wireless Studio ANC</h3>
                        <p class="text-xs text-slate-300 line-clamp-2 leading-relaxed">
                            Adaptive spatial audio, 40-hour battery stamina, titanium dynamic drivers, and memory-foam luxury.
                        </p>

                        <div class="flex items-center justify-between pt-2">
                            <div>
                                <span class="text-xs text-slate-400 line-through mr-1">$299.99</span>
                                <span class="text-2xl font-black text-amber-300">$249.99</span>
                            </div>
                            <a href="{{ route('product.show', 'pro-wireless-noise-cancelling-headphones') }}" class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-violet-600 hover:from-indigo-600 hover:to-violet-700 text-white text-xs font-bold rounded-xl shadow-lg shadow-indigo-500/30 transition active:scale-95">
                                View 3D Details
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Floating 3D Badge 1: Top Left -->
                <div class="hero-float-badge-1 absolute -top-4 -left-4 sm:-left-8 glass-dark px-4 py-2.5 rounded-2xl shadow-xl border border-white/20 hidden sm:flex items-center gap-3 backdrop-blur-xl z-20">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-amber-400 to-orange-500 flex items-center justify-center text-slate-950 font-bold shadow-md">
                        <i class="fa-solid fa-bolt text-sm"></i>
                    </div>
                    <div>
                        <div class="text-[11px] font-black text-amber-300 uppercase">Flash Discount</div>
                        <div class="text-xs font-extrabold text-white">Save Up To 50%</div>
                    </div>
                </div>

                <!-- Floating 3D Badge 2: Bottom Right -->
                <div class="hero-float-badge-2 absolute -bottom-6 -right-4 sm:-right-6 glass-dark px-4 py-2.5 rounded-2xl shadow-xl border border-white/20 hidden sm:flex items-center gap-3 backdrop-blur-xl z-20">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-emerald-400 to-teal-500 flex items-center justify-center text-slate-950 font-bold shadow-md">
                        <i class="fa-solid fa-shield-check text-sm"></i>
                    </div>
                    <div>
                        <div class="text-[11px] font-black text-emerald-300 uppercase">100% Authentic</div>
                        <div class="text-xs font-extrabold text-white">1 Year Warranty</div>
                    </div>
                </div>

            </div>

        </div>
    </div>
</section>

<!-- 3D Interactive Feature Strips -->
<section class="py-10 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger-grid">
            
            <div class="card-3d p-5 rounded-2xl bg-gradient-to-br from-indigo-50/50 to-white border border-slate-200/80 hover:border-indigo-500/50 shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-13 h-13 rounded-2xl bg-gradient-to-tr from-indigo-600 to-violet-500 text-white flex items-center justify-center text-xl shadow-md shadow-indigo-500/20 shrink-0">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-slate-900 text-sm">Free Express Delivery</h4>
                    <p class="text-xs text-slate-500 mt-0.5">On all orders above $100</p>
                </div>
            </div>

            <div class="card-3d p-5 rounded-2xl bg-gradient-to-br from-emerald-50/50 to-white border border-slate-200/80 hover:border-emerald-500/50 shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-13 h-13 rounded-2xl bg-gradient-to-tr from-emerald-500 to-teal-600 text-white flex items-center justify-center text-xl shadow-md shadow-emerald-500/20 shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-slate-900 text-sm">Secure Payment</h4>
                    <p class="text-xs text-slate-500 mt-0.5">256-Bit SSL Encryption</p>
                </div>
            </div>

            <div class="card-3d p-5 rounded-2xl bg-gradient-to-br from-amber-50/50 to-white border border-slate-200/80 hover:border-amber-500/50 shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-13 h-13 rounded-2xl bg-gradient-to-tr from-amber-500 to-orange-500 text-white flex items-center justify-center text-xl shadow-md shadow-amber-500/20 shrink-0">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-slate-900 text-sm">30-Day Free Return</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Zero hassle money-back</p>
                </div>
            </div>

            <div class="card-3d p-5 rounded-2xl bg-gradient-to-br from-violet-50/50 to-white border border-slate-200/80 hover:border-violet-500/50 shadow-xs flex items-center gap-4 cursor-pointer">
                <div class="w-13 h-13 rounded-2xl bg-gradient-to-tr from-violet-600 to-purple-600 text-white flex items-center justify-center text-xl shadow-md shadow-violet-500/20 shrink-0">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h4 class="font-extrabold text-slate-900 text-sm">24/7 VIP Support</h4>
                    <p class="text-xs text-slate-500 mt-0.5">Always here for you</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- 3D Category Showcase -->
<section class="py-16 bg-slate-50/60">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-10 scroll-reveal">
            <div>
                <span class="text-xs font-black text-indigo-600 uppercase tracking-widest">Collections</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">Browse by Category</h2>
            </div>
            <a href="{{ route('shop.index') }}" class="text-xs sm:text-sm font-bold text-indigo-600 hover:text-indigo-800 flex items-center gap-1.5 transition group">
                <span>View Full Catalog</span> 
                <i class="fa-solid fa-arrow-right text-xs group-hover:translate-x-1 transition-transform"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-5 stagger-grid">
            @foreach($categories as $cat)
                <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" class="category-card-3d group block relative rounded-2xl overflow-hidden bg-white border border-slate-200/90 hover:border-indigo-500/60 shadow-xs hover:shadow-xl transition-all duration-300">
                    <div class="aspect-square w-full overflow-hidden bg-slate-100 relative">
                        <img 
                            src="{{ $cat->image ?? 'https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=400&q=80' }}" 
                            alt="{{ $cat->name }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        >
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/70 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex items-end justify-center p-3">
                            <span class="text-[11px] font-bold text-white bg-indigo-600 px-3 py-1 rounded-full shadow-md">
                                Explore <i class="fa-solid fa-arrow-right ml-1 text-[9px]"></i>
                            </span>
                        </div>
                    </div>
                    <div class="p-4 text-center bg-white">
                        <h3 class="font-extrabold text-slate-800 text-sm group-hover:text-indigo-600 transition">{{ $cat->name }}</h3>
                        <p class="text-[11px] font-semibold text-slate-400 mt-0.5">{{ $cat->products_count }} {{ Str::plural('Product', $cat->products_count) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section with 3D Cards & Micro-interactions -->
<section class="py-16 bg-white border-t border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10 scroll-reveal">
            <div>
                <span class="text-xs font-black text-indigo-600 uppercase tracking-widest">Handpicked Tech & Fashion</span>
                <h2 class="text-2xl sm:text-3xl font-black text-slate-900 mt-1">Featured 3D Showcase</h2>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('shop.index') }}" class="px-4 py-2 text-xs font-bold bg-slate-900 text-white rounded-xl shadow-xs transition">All</a>
                <a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="px-4 py-2 text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition">Electronics</a>
                <a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="px-4 py-2 text-xs font-bold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-xl transition">Fashion</a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 stagger-grid">
            @foreach($featuredProducts as $product)
                <div class="card-3d bg-white rounded-3xl border border-slate-200/90 hover:border-indigo-400/60 shadow-xs hover:shadow-2xl transition-all duration-300 flex flex-col overflow-hidden group">
                    
                    <!-- Product Image & Badges -->
                    <div class="relative aspect-square bg-slate-100 overflow-hidden">
                        <a href="{{ route('product.show', $product->slug) }}">
                            <img 
                                src="{{ $product->image }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
                            >
                        </a>
                        
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
                            @if($product->has_discount)
                                <span class="bg-gradient-to-r from-rose-500 to-pink-600 text-white text-[11px] font-black px-2.5 py-1 rounded-full shadow-md">
                                    -{{ $product->discount_percent }}% OFF
                                </span>
                            @endif
                            @if($product->is_featured)
                                <span class="bg-gradient-to-r from-amber-400 to-orange-500 text-slate-950 text-[10px] font-black px-2.5 py-0.5 rounded-full shadow-md uppercase tracking-wider">
                                    ⚡ Featured
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Details Area -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <span class="text-[11px] font-black text-indigo-600 uppercase tracking-widest">
                                {{ $product->category->name ?? 'General' }}
                            </span>
                            <h3 class="font-extrabold text-slate-900 text-base mt-1 line-clamp-1 group-hover:text-indigo-600 transition">
                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 mt-1.5 leading-relaxed">
                                {{ $product->short_description }}
                            </p>
                        </div>

                        <!-- Rating & Price & Add to Cart -->
                        <div class="pt-3 border-t border-slate-100 flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1.5">
                                    <div class="flex text-amber-400 text-xs">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <span class="text-xs font-black text-slate-800">{{ number_format($product->rating, 1) }}</span>
                                    <span class="text-[11px] text-slate-400">({{ $product->reviews_count }})</span>
                                </div>
                                <div class="text-right">
                                    @if($product->has_discount)
                                        <span class="text-xs text-slate-400 line-through mr-1 font-semibold">${{ number_format($product->price, 2) }}</span>
                                        <span class="text-lg font-black text-rose-600">${{ number_format($product->sale_price, 2) }}</span>
                                    @else
                                        <span class="text-lg font-black text-slate-900">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>

                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="btn-add-cart w-full flex items-center justify-center gap-2 py-3 px-4 bg-slate-950 hover:bg-indigo-600 text-white text-xs font-extrabold rounded-2xl transition-all duration-200 shadow-md shadow-black/10 active:scale-95">
                                    <i class="fa-solid fa-cart-plus"></i> Add To Cart
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-14 text-center scroll-reveal">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-9 py-4 text-sm font-extrabold text-white bg-gradient-to-r from-indigo-600 via-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 rounded-2xl shadow-xl shadow-indigo-500/25 transition-all duration-300 transform hover:-translate-y-1">
                Explore All Products <i class="fa-solid fa-arrow-right ml-1"></i>
            </a>
        </div>
    </div>
</section>

<!-- Cyber Nano Promotional Banner Section -->
<section class="py-16 bg-slate-950 text-white relative overflow-hidden">
    <div class="absolute inset-0 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:20px_20px] opacity-20"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 scroll-reveal">
        <div class="relative bg-gradient-to-r from-indigo-950 via-slate-900 to-violet-950 rounded-3xl p-8 sm:p-12 lg:p-16 border border-indigo-500/30 shadow-2xl overflow-hidden">
            <div class="absolute -right-10 -bottom-10 w-96 h-96 bg-indigo-500/20 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="max-w-2xl space-y-4 relative z-10">
                <span class="px-3.5 py-1.5 rounded-full bg-gradient-to-r from-amber-400 to-orange-500 text-slate-950 text-xs font-black uppercase tracking-wider shadow-lg shadow-amber-400/20">
                    ⚡ Member Exclusive
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight">
                    Get 20% Off With Voucher <span class="bg-gradient-to-r from-amber-300 to-orange-400 bg-clip-text text-transparent">SM20</span>
                </h2>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Subscribe to receive instant discounts, exclusive member-only early drops, and automated delivery updates.
                </p>
                <form action="#" onsubmit="event.preventDefault(); alert('Subscribed successfully! Use coupon SM20 at checkout.');" class="flex flex-col sm:flex-row gap-3 pt-4 max-w-md">
                    <input 
                        type="email" 
                        placeholder="Enter your email address" 
                        class="w-full px-4 py-3.5 rounded-2xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm backdrop-blur-md"
                        required
                    >
                    <button type="submit" class="px-7 py-3.5 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-400 text-slate-950 font-black rounded-2xl text-sm transition-all duration-200 shrink-0 shadow-lg shadow-amber-400/20 active:scale-95">
                        Claim Voucher
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection

