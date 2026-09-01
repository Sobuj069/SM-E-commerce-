@extends('layouts.app')

@section('title', 'SM E-Commerce - Discover the Future of Shopping')

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-indigo-900 via-indigo-800 to-slate-900 text-white overflow-hidden py-16 lg:py-24">
    <div class="absolute inset-0 bg-[radial-gradient(#4338ca_1px,transparent_1px)] [background-size:16px_16px] opacity-25"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
            
            <div class="lg:col-span-7 space-y-6 text-center lg:text-left">
                <div class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-indigo-500/20 border border-indigo-400/30 text-indigo-200 text-xs font-semibold uppercase tracking-wider">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    New Spring / Summer Collection
                </div>
                
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight">
                    Upgrade Your Lifestyle With <span class="bg-gradient-to-r from-indigo-200 via-violet-300 to-amber-200 bg-clip-text text-transparent">Next-Gen Tech & Style</span>
                </h1>
                
                <p class="text-base sm:text-lg text-indigo-100/80 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                    Explore curated tech gadgets, premium audio, stylish wearables, and modern fashion designed to elevate your everyday routine.
                </p>

                <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                    <a href="{{ route('shop.index') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 text-base font-bold text-indigo-900 bg-white hover:bg-slate-100 rounded-xl shadow-lg shadow-black/10 transition transform active:scale-95">
                        Shop Now <i class="fa-solid fa-arrow-right ml-2 text-sm"></i>
                    </a>
                    <a href="{{ route('shop.index', ['sort' => 'popular']) }}" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3.5 text-base font-semibold text-white bg-indigo-700/60 hover:bg-indigo-700 border border-indigo-500/30 rounded-xl transition">
                        Explore Best Sellers
                    </a>
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-6 pt-6 border-t border-indigo-800/80">
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-white">5k+</div>
                        <div class="text-xs text-indigo-200">Products Available</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-white">99%</div>
                        <div class="text-xs text-indigo-200">Customer Satisfaction</div>
                    </div>
                    <div>
                        <div class="text-2xl sm:text-3xl font-extrabold text-white">24/7</div>
                        <div class="text-xs text-indigo-200">Expert Support</div>
                    </div>
                </div>
            </div>

            <!-- Hero Image Banner Card -->
            <div class="lg:col-span-5 relative">
                <div class="relative mx-auto max-w-md rounded-2xl overflow-hidden shadow-2xl border border-white/10 group">
                    <img 
                        src="https://images.unsplash.com/photo-1505740420928-5e560c06d30e?auto=format&fit=crop&w=800&q=80" 
                        alt="Hero Product" 
                        class="w-full h-[400px] object-cover group-hover:scale-105 transition duration-500"
                    >
                    <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-transparent to-transparent flex flex-col justify-end p-6">
                        <span class="text-xs font-semibold text-indigo-300 uppercase tracking-wider">Trending Device</span>
                        <h3 class="text-xl font-bold text-white">Pro Studio Audio ANC</h3>
                        <div class="flex items-center justify-between mt-2">
                            <span class="text-2xl font-black text-amber-400">$249.99</span>
                            <a href="{{ route('shop.index', ['category' => 'audio-headphones']) }}" class="text-xs font-semibold bg-white/20 hover:bg-white text-white hover:text-slate-900 px-3 py-1.5 rounded-lg transition backdrop-blur-xs">
                                View Deal
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Features Row -->
<section class="py-8 bg-white border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-slate-50 transition">
                <div class="w-12 h-12 rounded-xl bg-indigo-100 text-indigo-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-truck-fast"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">Free Delivery</h4>
                    <p class="text-xs text-slate-500">On all orders over $100</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-slate-50 transition">
                <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-shield-halved"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">100% Secure Payment</h4>
                    <p class="text-xs text-slate-500">Encrypted checkout</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-slate-50 transition">
                <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">30-Day Free Return</h4>
                    <p class="text-xs text-slate-500">Hassle-free guarantee</p>
                </div>
            </div>

            <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-slate-50 transition">
                <div class="w-12 h-12 rounded-xl bg-purple-100 text-purple-600 flex items-center justify-center text-xl shrink-0">
                    <i class="fa-solid fa-headset"></i>
                </div>
                <div>
                    <h4 class="font-bold text-slate-800 text-sm">24/7 Dedicated Support</h4>
                    <p class="text-xs text-slate-500">Always here to help you</p>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-end justify-between mb-8">
            <div>
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Top Collections</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Browse by Category</h2>
            </div>
            <a href="{{ route('shop.index') }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 flex items-center gap-1">
                View All <i class="fa-solid fa-arrow-right text-xs"></i>
            </a>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4 sm:gap-6">
            @foreach($categories as $cat)
                <a href="{{ route('shop.index', ['category' => $cat->slug]) }}" class="group block relative rounded-2xl overflow-hidden bg-white border border-slate-200 hover:border-indigo-500/50 shadow-xs hover:shadow-lg transition duration-300">
                    <div class="aspect-square w-full overflow-hidden bg-slate-100">
                        <img 
                            src="{{ $cat->image ?? 'https://images.unsplash.com/photo-1498049794561-7780e7231661?auto=format&fit=crop&w=400&q=80' }}" 
                            alt="{{ $cat->name }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-500"
                        >
                    </div>
                    <div class="p-4 text-center">
                        <h3 class="font-bold text-slate-800 text-sm group-hover:text-indigo-600 transition">{{ $cat->name }}</h3>
                        <p class="text-xs text-slate-500 mt-0.5">{{ $cat->products_count }} {{ Str::plural('Product', $cat->products_count) }}</p>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
</section>

<!-- Featured Products Section -->
<section class="py-16 bg-white border-t border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div>
                <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider">Handpicked For You</span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-slate-900 mt-1">Featured Products</h2>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('shop.index') }}" class="px-4 py-2 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition">All</a>
                <a href="{{ route('shop.index', ['category' => 'electronics-gadgets']) }}" class="px-4 py-2 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition">Electronics</a>
                <a href="{{ route('shop.index', ['category' => 'fashion-apparel']) }}" class="px-4 py-2 text-xs font-semibold bg-slate-100 hover:bg-slate-200 text-slate-700 rounded-lg transition">Fashion</a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
                <div class="bg-white rounded-2xl border border-slate-200 hover:border-slate-300 shadow-xs hover:shadow-xl transition duration-300 flex flex-col overflow-hidden group">
                    
                    <!-- Product Image & Badges -->
                    <div class="relative aspect-square bg-slate-100 overflow-hidden">
                        <a href="{{ route('product.show', $product->slug) }}">
                            <img 
                                src="{{ $product->image }}" 
                                alt="{{ $product->name }}" 
                                class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                            >
                        </a>
                        
                        <div class="absolute top-3 left-3 flex flex-col gap-1.5">
                            @if($product->has_discount)
                                <span class="bg-rose-500 text-white text-[11px] font-bold px-2.5 py-1 rounded-full shadow-xs">
                                    -{{ $product->discount_percent }}% OFF
                                </span>
                            @endif
                            @if($product->is_featured)
                                <span class="bg-amber-500 text-white text-[11px] font-bold px-2.5 py-1 rounded-full shadow-xs">
                                    Featured
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Details -->
                    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                        <div>
                            <span class="text-xs font-semibold text-indigo-600 uppercase tracking-wider">
                                {{ $product->category->name ?? 'General' }}
                            </span>
                            <h3 class="font-bold text-slate-900 text-base mt-1 line-clamp-1 group-hover:text-indigo-600 transition">
                                <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                            </h3>
                            <p class="text-xs text-slate-500 line-clamp-2 mt-1.5 leading-relaxed">
                                {{ $product->short_description }}
                            </p>
                        </div>

                        <!-- Rating & Price & Add to Cart -->
                        <div class="pt-2 border-t border-slate-100 flex flex-col gap-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1.5">
                                    <div class="flex text-amber-400 text-xs">
                                        <i class="fa-solid fa-star"></i>
                                    </div>
                                    <span class="text-xs font-bold text-slate-700">{{ number_format($product->rating, 1) }}</span>
                                    <span class="text-xs text-slate-400">({{ $product->reviews_count }})</span>
                                </div>
                                <div class="text-right">
                                    @if($product->has_discount)
                                        <span class="text-xs text-slate-400 line-through mr-1">${{ number_format($product->price, 2) }}</span>
                                        <span class="text-lg font-black text-rose-600">${{ number_format($product->sale_price, 2) }}</span>
                                    @else
                                        <span class="text-lg font-black text-slate-900">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>
                            </div>

                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 bg-slate-900 hover:bg-indigo-600 text-white text-xs font-bold rounded-xl transition duration-200 shadow-xs">
                                    <i class="fa-solid fa-cart-plus"></i> Add To Cart
                                </button>
                            </form>
                        </div>

                    </div>

                </div>
            @endforeach
        </div>

        <div class="mt-12 text-center">
            <a href="{{ route('shop.index') }}" class="inline-flex items-center gap-2 px-8 py-3.5 text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-md shadow-indigo-200 transition">
                View All Products <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

<!-- Promotional Banner Section -->
<section class="py-16 bg-slate-900 text-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="bg-gradient-to-r from-indigo-900/90 to-violet-900/90 rounded-3xl p-8 sm:p-12 lg:p-16 border border-white/10 shadow-2xl">
            <div class="max-w-2xl space-y-4">
                <span class="px-3 py-1 rounded-full bg-amber-400 text-slate-950 text-xs font-black uppercase tracking-wider">
                    Limited Time Offer
                </span>
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-black leading-tight">
                    Get 20% Off Your First Order
                </h2>
                <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                    Join our newsletter and enjoy premium discounts, early access to new tech gadgets, and member-exclusive flash sales.
                </p>
                <form action="#" onsubmit="event.preventDefault(); alert('Subscribed successfully!');" class="flex flex-col sm:flex-row gap-3 pt-4 max-w-md">
                    <input 
                        type="email" 
                        placeholder="Enter your email address" 
                        class="w-full px-4 py-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-400 text-sm"
                        required
                    >
                    <button type="submit" class="px-6 py-3 bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold rounded-xl text-sm transition shrink-0">
                        Subscribe
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
