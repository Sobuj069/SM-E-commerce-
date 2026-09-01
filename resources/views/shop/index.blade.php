@extends('layouts.app')

@section('title', ($selectedCategory ? $selectedCategory->name . ' - ' : '') . 'Catalog - SM Shop')

@section('content')
<!-- Catalog Header Strip -->
<div class="bg-zinc-100 border-b border-zinc-200 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <nav class="flex text-[11px] font-bold text-zinc-500 uppercase tracking-wider gap-2 mb-2">
                    <a href="{{ route('home') }}" class="hover:text-black">HOME</a>
                    <span>/</span>
                    <a href="{{ route('shop.index') }}" class="hover:text-black">SHOP</a>
                    @if($selectedCategory)
                        <span>/</span>
                        <span class="text-black">{{ $selectedCategory->name }}</span>
                    @endif
                </nav>
                <h1 class="text-2xl sm:text-4xl font-black text-black uppercase tracking-tight">
                    {{ $selectedCategory ? $selectedCategory->name : (request('q') ? 'SEARCH: "' . request('q') . '"' : 'ALL PRODUCTS') }}
                </h1>
                <p class="text-xs text-zinc-500 uppercase tracking-wider font-semibold mt-1">
                    {{ $products->total() }} PRODUCTS AVAILABLE
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

                <label for="sort" class="text-xs font-black uppercase tracking-wider text-black whitespace-nowrap">SORT BY:</label>
                <select 
                    name="sort" 
                    id="sort" 
                    onchange="this.form.submit()" 
                    class="bg-white border border-zinc-300 text-xs font-bold uppercase rounded-full px-4 py-2 text-black focus:outline-none focus:border-black"
                >
                    <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>NEWEST</option>
                    <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>PRICE: LOW TO HIGH</option>
                    <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>PRICE: HIGH TO LOW</option>
                    <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>TOP RATED</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>MOST POPULAR</option>
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
            <div class="bg-white rounded-2xl border border-zinc-200 p-6 shadow-xs">
                <h3 class="font-black text-black text-xs uppercase tracking-widest mb-4 pb-2 border-b border-zinc-200 flex items-center justify-between">
                    <span>COLLECTION</span>
                    <i class="fa-solid fa-list-ul text-zinc-400 text-xs"></i>
                </h3>
                <ul class="space-y-1.5">
                    <li>
                        <a 
                            href="{{ route('shop.index', request()->except('category', 'page')) }}" 
                            class="flex items-center justify-between px-3.5 py-2 rounded-full text-xs font-bold uppercase transition {{ !request('category') ? 'bg-black text-white' : 'text-zinc-700 hover:bg-zinc-100 hover:text-black' }}"
                        >
                            <span>ALL PRODUCTS</span>
                            <span class="text-[11px] opacity-80">{{ $categories->sum('products_count') }}</span>
                        </a>
                    </li>
                    @foreach($categories as $cat)
                        <li>
                            <a 
                                href="{{ route('shop.index', array_merge(request()->except('page'), ['category' => $cat->slug])) }}" 
                                class="flex items-center justify-between px-3.5 py-2 rounded-full text-xs font-bold uppercase transition {{ request('category') == $cat->slug ? 'bg-black text-white' : 'text-zinc-700 hover:bg-zinc-100 hover:text-black' }}"
                            >
                                <span>{{ $cat->name }}</span>
                                <span class="text-[11px] opacity-80">{{ $cat->products_count }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Multi-Attribute Filters Form -->
            <div class="bg-white rounded-2xl border border-zinc-200 p-6 shadow-xs space-y-6">
                <h3 class="font-black text-black text-xs uppercase tracking-widest pb-2 border-b border-zinc-200 flex items-center justify-between">
                    <span>FILTERS</span>
                    <i class="fa-solid fa-sliders text-zinc-400 text-xs"></i>
                </h3>

                <form action="{{ route('shop.index') }}" method="GET" class="space-y-6">
                    @if(request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif
                    @if(request('q')) <input type="hidden" name="q" value="{{ request('q') }}"> @endif
                    @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif

                    <!-- Price Range -->
                    <div>
                        <label class="text-xs font-black text-black uppercase tracking-wider block mb-2">
                            PRICE RANGE ($)
                        </label>
                        <div class="grid grid-cols-2 gap-2">
                            <div>
                                <input 
                                    type="number" 
                                    name="min_price" 
                                    placeholder="MIN" 
                                    value="{{ request('min_price') }}"
                                    class="w-full px-3 py-2 rounded-xl border border-zinc-300 bg-white text-xs font-bold text-black uppercase focus:outline-none focus:border-black"
                                >
                            </div>
                            <div>
                                <input 
                                    type="number" 
                                    name="max_price" 
                                    placeholder="MAX" 
                                    value="{{ request('max_price') }}"
                                    class="w-full px-3 py-2 rounded-xl border border-zinc-300 bg-white text-xs font-bold text-black uppercase focus:outline-none focus:border-black"
                                >
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 flex gap-2">
                        <button type="submit" class="flex-1 bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-widest py-2.5 rounded-full transition cursor-pointer">
                            APPLY
                        </button>
                        <a href="{{ route('shop.index') }}" class="px-4 py-2.5 rounded-full border border-zinc-300 text-xs font-black uppercase text-black hover:bg-zinc-100 transition flex items-center justify-center">
                            RESET
                        </a>
                    </div>
                </form>
            </div>

            <!-- Gymshark Voucher Callout -->
            <div class="p-6 rounded-2xl bg-black text-white space-y-2">
                <span class="text-[10px] font-black uppercase tracking-widest text-amber-300">⚡ MEMBER VOUCHER</span>
                <h4 class="text-base font-black uppercase tracking-tight">USE CODE: SM20</h4>
                <p class="text-xs text-zinc-400 leading-relaxed uppercase font-semibold">GET 20% OFF AT CHECKOUT ON ORDERS OVER $50.</p>
            </div>

        </div>

        <!-- Product Grid Area -->
        <div class="lg:col-span-3">
            @if($products->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-2 lg:grid-cols-3 gap-5 sm:gap-6">
                    @foreach($products as $product)
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

                <!-- Modern Pagination Navigation -->
                <div class="mt-12">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-20 bg-white rounded-2xl border border-zinc-200 p-8 space-y-4">
                    <div class="w-16 h-16 rounded-full bg-zinc-100 text-zinc-600 flex items-center justify-center text-2xl mx-auto">
                        <i class="fa-solid fa-box-open"></i>
                    </div>
                    <h3 class="text-xl font-black text-black uppercase">NO PRODUCTS FOUND</h3>
                    <p class="text-xs text-zinc-500 uppercase font-semibold max-w-sm mx-auto">Try clearing your filters to explore our full range.</p>
                    <x-button variant="primary" size="md" href="{{ route('shop.index') }}">
                        RESET FILTERS
                    </x-button>
                </div>
            @endif
        </div>

    </div>
</div>
@endsection