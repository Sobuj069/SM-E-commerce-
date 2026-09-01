@extends('layouts.app')

@section('title', ($selectedCategory ? $selectedCategory->name . ' - ' : '') . '3D Catalog & Shop - SM Shop')

@section('content')
<!-- Catalog Header Strip -->
<div class="bg-surface border-b border-line-subtle py-8 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <nav class="flex text-xs font-semibold text-content-muted gap-2 mb-2">
                    <a href="{{ route('home') }}" class="hover:text-brand-primary">Home</a>
                    <span>/</span>
                    <a href="{{ route('shop.index') }}" class="hover:text-brand-primary">Shop</a>
                    @if($selectedCategory)
                        <span>/</span>
                        <span class="text-content-primary font-bold">{{ $selectedCategory->name }}</span>
                    @endif
                </nav>
                <h1 class="text-2xl sm:text-3xl font-black text-content-primary">
                    {{ $selectedCategory ? $selectedCategory->name : (request('q') ? 'Search Results for "' . request('q') . '"' : 'Explore 3D Collection') }}
                </h1>
                <p class="text-xs sm:text-sm text-content-muted mt-1">
                    Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} items
                </p>
            </div>

            <!-- Sorting & View Controls -->
            <form action="{{ route('shop.index') }}" method="GET" class="flex items-center gap-3">
                @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
                @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
                @if(request('min_rating')) <input type="hidden" name="min_rating" value="{{ request('min_rating') }}"> @endif
                @if(request('in_stock')) <input type="hidden" name="in_stock" value="1"> @endif

                <label for="sort" class="text-xs font-bold text-content-secondary whitespace-nowrap">Sort By:</label>
                <select 
                    name="sort" 
                    id="sort" 
                    onchange="this.form.submit()" 
                    class="bg-surface-elevated border border-line-subtle text-xs font-bold rounded-2xl px-4 py-2.5 text-content-primary focus:outline-none focus:ring-2 focus:ring-brand-primary"
                >
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Newest Drops</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Highest Rated (5★)</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Popular</option>
                </select>
            </form>
        </div>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" x-data="{ isFiltering: false }">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        
        <!-- Sidebar Filters -->
        <div class="space-y-6">
            
            <!-- Category Filter Box -->
            <div class="bg-surface rounded-3xl border border-line-subtle p-6 shadow-xs transition-colors duration-200">
                <h3 class="font-black text-content-primary text-xs uppercase tracking-wider mb-4 pb-2 border-b border-line-subtle flex items-center justify-between">
                    <span>Category</span>
                    <i class="fa-solid fa-list-ul text-content-muted text-xs"></i>
                </h3>
                <ul class="space-y-1.5">
                    <li>
                        <a 
                            href="{{ route('shop.index', request()->except('category', 'page')) }}" 
                            class="flex items-center justify-between px-3.5 py-2 rounded-2xl text-xs font-bold transition {{ !request('category') ? 'bg-brand-primary text-white shadow-md' : 'text-content-secondary hover:bg-surface-elevated hover:text-content-primary' }}"
                        >
                            <span>All Categories</span>
                            <span class="text-[11px] opacity-80">{{ $categories->sum('products_count') }}</span>
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a 
                                href="{{ route('shop.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}" 
                                class="flex items-center justify-between px-3.5 py-2 rounded-2xl text-xs font-bold transition {{ request('category') == $cat->slug ? 'bg-brand-primary text-white shadow-md' : 'text-content-secondary hover:bg-surface-elevated hover:text-content-primary' }}"
                            >
                                <span>{{ $cat->name }}</span>
                                <span class="text-[11px] opacity-80">{{ $cat->products_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Multi-Attribute Filters Form -->
            <div class="bg-surface rounded-3xl border border-line-subtle p-6 shadow-xs space-y-6 transition-colors duration-200">
                <h3 class="font-black text-content-primary text-xs uppercase tracking-wider pb-2 border-b border-line-subtle flex items-center justify-between">
                    <span>Filters</span>
                    <i class="fa-solid fa-sliders text-content-muted text-xs"></i>
                </h3>

                <form action="{{ route('shop.index') }}" method="GET" class="space-y-6">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                    <!-- Price Range -->
                    <div>
                        <label class="text-xs font-black text-content-primary uppercase tracking-wider block mb-2">
                            Price Range ($)
                        </label>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <input 
                                    type="number" 
                                    name="min_price" 
                                    placeholder="Min" 
                                    value="{{ request('min_price') }}"
                                    class="w-full px-3 py-2 rounded-xl border border-line-subtle bg-surface-elevated text-xs font-bold text-content-primary focus:outline-none focus:ring-2 focus:ring-brand-primary"
                                >
                            </div>
                            <div>
                                <input 
                                    type="number" 
                                    name="max_price" 
                                    placeholder="Max" 
                                    value="{{ request('max_price') }}"
                                    class="w-full px-3 py-2 rounded-xl border border-line-subtle bg-surface-elevated text-xs font-bold text-content-primary focus:outline-none focus:ring-2 focus:ring-brand-primary"
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Minimum Star Rating -->
                    <div>
                        <label class="text-xs font-black text-content-primary uppercase tracking-wider block mb-2">
                            Minimum Rating
                        </label>
                        <div class="space-y-1.5">
                            <label class="flex items-center gap-2 text-xs font-bold text-content-secondary cursor-pointer">
                                <input type="radio" name="min_rating" value="" {{ !request('min_rating') ? 'checked' : '' }} class="text-brand-primary focus:ring-0">
                                <span>All Ratings</span>
                            </label>
                            <label class="flex items-center gap-2 text-xs font-bold text-content-secondary cursor-pointer">
                                <input type="radio" name="min_rating" value="4.5" {{ request('min_rating') == '4.5' ? 'checked' : '' }} class="text-brand-primary focus:ring-0">
                                <span class="text-amber-400">★★★★★</span>
                                <span>4.5 & Up</span>
                            </label>
                            <label class="flex items-center gap-2 text-xs font-bold text-content-secondary cursor-pointer">
                                <input type="radio" name="min_rating" value="4.0" {{ request('min_rating') == '4.0' ? 'checked' : '' }} class="text-brand-primary focus:ring-0">
                                <span class="text-amber-400">★★★★☆</span>
                                <span>4.0 & Up</span>
                            </label>
                        </div>
                    </div>

                    <!-- Stock Availability Toggle -->
                    <div class="pt-2 border-t border-line-subtle">
                        <label class="flex items-center gap-2.5 text-xs font-bold text-content-primary cursor-pointer">
                            <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }} class="rounded text-brand-primary focus:ring-0">
                            <span>In Stock Items Only</span>
                        </label>
                    </div>

                    <div class="pt-2 flex gap-2">
                        <x-button variant="primary" size="sm" type="submit" :fullWidth="true">
                            Apply Filters
                        </x-button>
                        <a href="{{ route('shop.index') }}" class="px-3 py-2 rounded-xl border border-line-subtle text-xs font-bold text-content-secondary hover:text-content-primary hover:bg-surface-elevated transition flex items-center justify-center">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Nano Voucher Callout -->
            <div class="p-6 rounded-3xl bg-gradient-to-br from-indigo-950 via-slate-900 to-violet-950 text-white border border-white/10 space-y-3">
                <x-badge variant="featured" size="sm">⚡ 20% Instant Code</x-badge>
                <h4 class="text-base font-black">Use Coupon "SM20"</h4>
                <p class="text-xs text-slate-300">Apply at checkout to claim instant 20% savings on orders over $50.</p>
            </div>

        </div>

        <!-- Product Grid Area -->
        <div class="lg:col-span-3">
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <x-card variant="product" :hover3d="true" :image="$product->image" :imageAlt="$product->name" :imageHref="route('product.show', $product->slug)">
                            <x-slot:badges>
                                @if($product->has_discount)
                                    <x-badge variant="discount">-{{ $product->discount_percent }}% OFF</x-badge>
                                @endif
                                @if($product->is_featured)
                                    <x-badge variant="featured">⚡ 3D Ready</x-badge>
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

                                <div class="grid grid-cols-2 gap-2">
                                    <x-button variant="outline" size="sm" href="{{ route('product.show', $product->slug) }}" icon="fa-solid fa-cube">
                                        3D View
                                    </x-button>
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" value="1">
                                        <x-button variant="primary" size="sm" type="submit" :fullWidth="true" icon="fa-solid fa-cart-plus">
                                            Cart
                                        </x-button>
                                    </form>
                                </div>
                            </x-slot:footer>
                        </x-card>
                    @endforeach
                </div>

                <!-- Modern Pagination Navigation -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-surface rounded-3xl border border-line-subtle p-8 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-surface-elevated text-content-muted flex items-center justify-center text-2xl mx-auto">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-xl font-black text-content-primary">No Products Found</h3>
                    <p class="text-xs text-content-secondary max-w-sm mx-auto">We couldn't find any products matching your current filters. Try changing or clearing your filter selections.</p>
                    <x-button variant="primary" size="md" href="{{ route('shop.index') }}">
                        Reset All Filters
                    </x-button>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection