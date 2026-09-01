@extends('layouts.app')

@section('title', ($selectedCategory ? $selectedCategory->name . ' - ' : '') . 'Shop All Products - SM E-Commerce')

@section('content')
<div class="bg-white border-b border-slate-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <nav class="flex text-xs font-semibold text-slate-400 gap-2 mb-2">
                    <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
                    <span>/</span>
                    <a href="{{ route('shop.index') }}" class="hover:text-indigo-600">Shop</a>
                    @if($selectedCategory)
                        <span>/</span>
                        <span class="text-slate-800">{{ $selectedCategory->name }}</span>
                    @endif
                </nav>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900">
                    {{ $selectedCategory ? $selectedCategory->name : (request('q') ? 'Search Results for "' . request('q') . '"' : 'All Products') }}
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 mt-1">
                    Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} items
                </p>
            </div>

            <!-- Sorting Dropdown -->
            <form action="{{ route('shop.index') }}" method="GET" class="flex items-center gap-3">
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif

                <label for="sort" class="text-xs font-bold text-slate-600 whitespace-nowrap">Sort By:</label>
                <select 
                    name="sort" 
                    id="sort" 
                    onchange="this.form.submit()" 
                    class="bg-slate-50 border border-slate-200 text-xs font-semibold rounded-xl px-3 py-2 text-slate-700 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                >
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest Arrivals</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar Filters -->
        <div class="space-y-6">
            
            <!-- Category Filter Box -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center justify-between">
                    <span>Categories</span>
                    <i class="fa-solid fa-list-ul text-slate-400 text-xs"></i>
                </h3>
                <ul class="space-y-2">
                    <li>
                        <a 
                            href="{{ route('shop.index', request()->except('category', 'page')) }}" 
                            class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition {{ !request('category') ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}"
                        >
                            <span>All Categories</span>
                            <span class="text-[11px] opacity-70">{{ $categories->sum('products_count') }}</span>
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a 
                                href="{{ route('shop.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}" 
                                class="flex items-center justify-between px-3 py-2 rounded-xl text-xs font-semibold transition {{ request('category') == $cat->slug ? 'bg-indigo-50 text-indigo-700 font-bold' : 'text-slate-600 hover:bg-slate-50 hover:text-indigo-600' }}"
                            >
                                <span>{{ $cat->name }}</span>
                                <span class="text-[11px] opacity-70">{{ $cat->products_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Price Filter Box -->
            <div class="bg-white rounded-2xl border border-slate-200 p-6 shadow-xs">
                <h3 class="font-bold text-slate-900 text-sm uppercase tracking-wider mb-4 pb-2 border-b border-slate-100 flex items-center justify-between">
                    <span>Price Range</span>
                    <i class="fa-solid fa-sliders text-slate-400 text-xs"></i>
                </h3>
                <form action="{{ route('shop.index') }}" method="GET" class="space-y-4">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <label class="text-[11px] text-slate-500 font-semibold">Min ($)</label>
                            <input 
                                type="number" 
                                name="min_price" 
                                value="{{ request('min_price') }}" 
                                placeholder="0" 
                                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                        </div>
                        <div>
                            <label class="text-[11px] text-slate-500 font-semibold">Max ($)</label>
                            <input 
                                type="number" 
                                name="max_price" 
                                value="{{ request('max_price') }}" 
                                placeholder="1000" 
                                class="w-full px-3 py-2 text-xs border border-slate-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            >
                        </div>
                    </div>
                    <button type="submit" class="w-full py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-xs">
                        Filter Price
                    </button>
                    @if(request()->hasAny(['min_price', 'max_price', 'category', 'q', 'sort']))
                        <a href="{{ route('shop.index') }}" class="block text-center text-xs text-rose-600 hover:underline pt-1">
                            Clear all filters
                        </a>
                    @endif
                </form>
            </div>

        </div>

        <!-- Products Grid Area -->
        <div class="lg:col-span-3 space-y-6">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
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

                <!-- Pagination -->
                <div class="pt-6">
                    {{ $products->links() }}
                </div>
            @else
                <div class="bg-white rounded-2xl border border-slate-200 p-12 text-center">
                    <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center text-2xl mx-auto mb-4">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">No products found</h3>
                    <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">
                        We couldn't find any products matching your search criteria. Try modifying your filters or search keyword.
                    </p>
                    <a href="{{ route('shop.index') }}" class="inline-block mt-4 px-6 py-2.5 bg-indigo-600 text-white text-xs font-bold rounded-xl hover:bg-indigo-700 transition">
                        Reset Filters
                    </a>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection
