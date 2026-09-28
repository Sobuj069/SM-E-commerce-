@extends('layouts.app')

@section('title', ($selectedCategory ? $selectedCategory->name . ' - ' : '') . 'SM Shop Catalog - Computer, Laptop & Gadget Store')

@section('content')
<!-- Star Tech Catalog Breadcrumb Strip -->
<div class="bg-white border-b border-slate-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2">
            <nav class="flex text-xs font-medium text-slate-500 gap-2 items-center">
                <a href="{{ route('home') }}" class="hover:text-starOrange"><i class="fa-solid fa-house text-slate-400"></i></a>
                <span>/</span>
                <a href="{{ route('shop.index') }}" class="hover:text-starOrange">Shop</a>
                @if($selectedCategory)
                    <span>/</span>
                    <span class="text-slate-800 font-semibold">{{ $selectedCategory->name }}</span>
                @endif
            </nav>
            <div class="text-xs text-slate-500">
                Showing <strong class="text-slate-800">{{ $products->count() }}</strong> of <strong class="text-slate-800">{{ $products->total() }}</strong> items
            </div>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
    <!-- Header Title & Sort Bar -->
    <div class="bg-white rounded-lg border border-slate-200 p-4 mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 shadow-xs">
        <div>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-900">
                {{ $selectedCategory ? $selectedCategory->name : (request('q') ? 'Search Results: "' . request('q') . '"' : 'All Products') }}
            </h1>
            <p class="text-xs text-slate-500 mt-0.5">
                Official warranty, best price & genuine tech products in Bangladesh.
            </p>
        </div>

        <!-- Sorting & Filter Controls -->
        <form action="{{ route('shop.index') }}" method="GET" class="flex items-center gap-3">
            @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
            @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
            @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
            @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif

            <label for="sort" class="text-xs font-semibold text-slate-700 whitespace-nowrap">Sort By:</label>
            <select 
                name="sort" 
                id="sort" 
                onchange="this.form.submit()" 
                class="bg-slate-50 border border-slate-300 text-xs font-medium rounded-md px-3 py-2 text-slate-800 focus:outline-none focus:border-starBlue"
            >
                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Default / Newest</option>
                <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Top Rated</option>
                <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
            </select>
        </form>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
        
        <!-- Sidebar Filters -->
        <div class="space-y-5">
            
            <!-- Category Filter Box -->
            <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-xs">
                <h3 class="font-bold text-slate-900 text-sm mb-3 pb-2 border-b border-slate-100 flex items-center justify-between">
                    <span>Category</span>
                    <i class="fa-solid fa-layer-group text-slate-400 text-xs"></i>
                </h3>
                <ul class="space-y-1 max-h-80 overflow-y-auto pr-1">
                    <li>
                        <a 
                            href="{{ route('shop.index', request()->except('category', 'page')) }}" 
                            class="flex items-center justify-between px-2.5 py-1.5 rounded-md text-xs font-medium transition {{ !request('category') ? 'bg-starBlue text-white font-bold' : 'text-slate-700 hover:bg-slate-100 hover:text-starBlue' }}"
                        >
                            <span>All Categories</span>
                            <span class="text-[11px] opacity-80">{{ $categories->sum('products_count') }}</span>
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a 
                                href="{{ route('shop.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}" 
                                class="flex items-center justify-between px-2.5 py-1.5 rounded-md text-xs font-medium transition {{ request('category') == $cat->slug ? 'bg-starBlue text-white font-bold' : 'text-slate-700 hover:bg-slate-100 hover:text-starBlue' }}"
                            >
                                <span>{{ $cat->name }}</span>
                                <span class="text-[11px] opacity-80">{{ $cat->products_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Price Range Filter Form -->
            <div class="bg-white rounded-lg border border-slate-200 p-4 shadow-xs space-y-4">
                <h3 class="font-bold text-slate-900 text-sm pb-2 border-b border-slate-100 flex items-center justify-between">
                    <span>Price Range (৳)</span>
                    <i class="fa-solid fa-bangladeshi-taka-sign text-slate-400 text-xs"></i>
                </h3>

                <form action="{{ route('shop.index') }}" method="GET" class="space-y-4">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-[11px] text-slate-500 block mb-1">Min (৳)</label>
                            <input 
                                type="number" 
                                name="min_price" 
                                placeholder="0" 
                                value="{{ request('min_price') }}"
                                class="w-full px-2.5 py-1.5 rounded border border-slate-300 bg-white text-xs font-semibold text-slate-800 focus:outline-none focus:border-starBlue"
                            >
                        </div>
                        <div>
                            <label class="text-[11px] text-slate-500 block mb-1">Max (৳)</label>
                            <input 
                                type="number" 
                                name="max_price" 
                                placeholder="350000" 
                                value="{{ request('max_price') }}"
                                class="w-full px-2.5 py-1.5 rounded border border-slate-300 bg-white text-xs font-semibold text-slate-800 focus:outline-none focus:border-starBlue"
                            >
                        </div>
                    </div>

                    <div class="pt-1 flex gap-2">
                        <button type="submit" class="flex-1 bg-starBlue hover:bg-starBlueDark text-white text-xs font-bold py-2 rounded transition cursor-pointer">
                            Filter
                        </button>
                        <a href="{{ route('shop.index') }}" class="px-3 py-2 rounded border border-slate-300 text-xs font-medium text-slate-700 hover:bg-slate-100 transition flex items-center justify-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- SM Shop Promo Callout -->
            <div class="p-4 rounded-lg bg-gradient-to-br from-starNavy to-starNavyDark text-white space-y-2 border border-slate-800">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-starOrange animate-pulse"></span>
                    <span class="text-[11px] font-bold text-starOrange uppercase tracking-wider">SM Shop Promo</span>
                </div>
                <h4 class="text-sm font-bold">Use Coupon: STAR1000</h4>
                <p class="text-xs text-slate-300 leading-relaxed">Get 1,000৳ instant discount on computer & laptop orders over 15,000৳.</p>
            </div>

        </div>

        <!-- Product Grid Area -->
        <div class="lg:col-span-3">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($products as $product)
                        <div class="bg-white rounded-lg border border-slate-200 overflow-hidden hover:shadow-lg transition-all duration-300 flex flex-col justify-between p-4 relative group">
                            
                            <!-- Top Badges -->
                            <div class="absolute top-3 left-3 flex flex-col gap-1 z-10">
                                @if($product->has_discount)
                                    <span class="bg-starOrange text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-xs">
                                        Save {{ number_format($product->price - $product->sale_price) }}৳
                                    </span>
                                @endif
                                @if($product->is_featured)
                                    <span class="bg-starBlue text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-xs">
                                        Special
                                    </span>
                                @endif
                            </div>

                            <!-- Product Image -->
                            <div class="relative w-full h-44 flex items-center justify-center bg-white p-2 mb-3">
                                <a href="{{ route('product.show', $product->slug) }}" class="block w-full h-full flex items-center justify-center">
                                    <img 
                                        src="{{ $product->image }}" 
                                        alt="{{ $product->name }}" 
                                        class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                                        loading="lazy"
                                    >
                                </a>
                            </div>

                            <!-- Product Content -->
                            <div class="flex-1 flex flex-col justify-between">
                                <div>
                                    <div class="text-[11px] text-slate-400 font-medium mb-1">
                                        {{ $product->category->name ?? 'Tech Component' }}
                                    </div>
                                    <h3 class="font-bold text-slate-800 text-sm hover:text-starOrange transition line-clamp-2 leading-snug mb-2">
                                        <a href="{{ route('product.show', $product->slug) }}">{{ $product->name }}</a>
                                    </h3>

                                    <!-- Key Features Bullets -->
                                    <div class="space-y-1 text-xs text-slate-600 mb-3 bg-slate-50 p-2.5 rounded border border-slate-100">
                                        <div class="line-clamp-2 text-[11px] text-slate-600 leading-relaxed">
                                            {{ $product->short_description }}
                                        </div>
                                        <div class="flex items-center gap-1.5 text-[11px] text-emerald-600 font-semibold pt-1">
                                            <i class="fa-solid fa-check-circle text-[10px]"></i> In Stock • Official Warranty
                                        </div>
                                    </div>
                                </div>

                                <!-- Price & Action Footer -->
                                <div class="pt-2 border-t border-slate-100 flex flex-col gap-2">
                                    <div class="flex items-baseline justify-between">
                                        <div class="flex items-baseline gap-2">
                                            <span class="text-base font-bold text-starOrange">
                                                {{ number_format($product->effective_price) }}৳
                                            </span>
                                            @if($product->has_discount)
                                                <span class="text-xs text-slate-400 line-through">
                                                    {{ number_format($product->price) }}৳
                                                </span>
                                            @endif
                                        </div>
                                        <div class="text-[11px] text-amber-500 font-bold flex items-center gap-1">
                                            <i class="fa-solid fa-star text-[10px]"></i> {{ number_format($product->rating ?? 5.0, 1) }}
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="grid grid-cols-2 gap-2 mt-1">
                                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="quantity" value="1">
                                            <button type="submit" class="w-full bg-[#eef2ff] hover:bg-starBlue hover:text-white text-starBlue font-semibold text-xs py-2 px-2 rounded transition flex items-center justify-center gap-1.5 cursor-pointer">
                                                <i class="fa-solid fa-cart-shopping text-[11px]"></i> Add to Cart
                                            </button>
                                        </form>
                                        <a href="{{ route('product.show', $product->slug) }}" class="w-full bg-slate-100 hover:bg-slate-200 text-slate-800 font-semibold text-xs py-2 px-2 rounded transition flex items-center justify-center gap-1.5">
                                            <i class="fa-solid fa-eye text-[11px]"></i> View Details
                                        </a>
                                    </div>
                                </div>

                            </div>

                        </div>
                    @endforeach
                </div>

                <!-- Pagination Navigation -->
                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-lg border border-slate-200 p-8 space-y-4">
                    <div class="w-14 h-14 rounded-full bg-slate-100 text-slate-400 flex items-center justify-center text-2xl mx-auto">
                        <i class="fa-solid fa-laptop-slash"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">No Tech Products Found</h3>
                    <p class="text-xs text-slate-500 max-w-sm mx-auto">Try clearing your search query or filters to explore our full product catalog.</p>
                    <a href="{{ route('shop.index') }}" class="inline-block bg-starBlue hover:bg-starBlueDark text-white text-xs font-bold py-2.5 px-6 rounded-md transition">
                        Reset Filters
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection