@extends('layouts.app')

@section('title', $product->name . ' - SM E-Commerce')

@section('content')
<div class="bg-white border-b border-slate-200 py-4">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs font-semibold text-slate-400 gap-2">
            <a href="{{ route('home') }}" class="hover:text-indigo-600">Home</a>
            <span>/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-indigo-600">Shop</a>
            @if($product->category)
                <span>/</span>
                <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-indigo-600">{{ $product->category->name }}</a>
            @endif
            <span>/</span>
            <span class="text-slate-800 line-clamp-1">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="bg-white rounded-3xl border border-slate-200 p-6 sm:p-10 shadow-xs">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Product Image Showcase -->
            <div class="lg:col-span-6 space-y-4">
                <div class="relative aspect-square rounded-2xl overflow-hidden bg-slate-100 border border-slate-200 group">
                    <img 
                        src="{{ $product->image }}" 
                        alt="{{ $product->name }}" 
                        class="w-full h-full object-cover group-hover:scale-105 transition duration-500"
                    >
                    <div class="absolute top-4 left-4 flex flex-col gap-2">
                        @if($product->has_discount)
                            <span class="bg-rose-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                                -{{ $product->discount_percent }}% OFF
                            </span>
                        @endif
                        @if($product->is_featured)
                            <span class="bg-amber-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-md">
                                Featured
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Product Info & Purchase Form -->
            <div class="lg:col-span-6 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-indigo-600 uppercase tracking-wider bg-indigo-50 px-3 py-1 rounded-full">
                            {{ $product->category->name ?? 'General' }}
                        </span>
                        <span class="text-xs text-slate-400 font-mono">SKU: {{ $product->sku ?? 'N/A' }}</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Rating & Reviews -->
                    <div class="flex items-center gap-3">
                        <div class="flex text-amber-400 text-sm">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star-half-stroke"></i>
                        </div>
                        <span class="text-xs font-bold text-slate-700">{{ number_format($product->rating, 2) }}</span>
                        <span class="text-xs text-slate-400">({{ $product->reviews_count }} verified ratings)</span>
                    </div>

                    <!-- Price Block -->
                    <div class="p-4 rounded-2xl bg-slate-50 border border-slate-100 flex items-baseline gap-3">
                        @if($product->has_discount)
                            <span class="text-3xl font-black text-rose-600">${{ number_format($product->sale_price, 2) }}</span>
                            <span class="text-base text-slate-400 line-through">${{ number_format($product->price, 2) }}</span>
                            <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded">
                                Save ${{ number_format($product->price - $product->sale_price, 2) }}
                            </span>
                        @else
                            <span class="text-3xl font-black text-slate-900">${{ number_format($product->price, 2) }}</span>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <p class="text-sm text-slate-600 leading-relaxed">
                        {{ $product->short_description }}
                    </p>

                    <!-- Stock Status -->
                    <div class="flex items-center gap-2">
                        @if($product->in_stock)
                            <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                            <span class="text-xs font-bold text-emerald-700">In Stock ({{ $product->stock }} available)</span>
                        @else
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                            <span class="text-xs font-bold text-rose-700">Out of Stock</span>
                        @endif
                    </div>

                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4 pt-4 border-t border-slate-100">
                    @csrf
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        
                        <!-- Quantity Picker -->
                        <div class="flex items-center border border-slate-200 rounded-xl bg-slate-50 p-1 w-full sm:w-auto justify-between">
                            <button type="button" onclick="const q = document.getElementById('qty'); if(q.value > 1) q.value--;" class="w-9 h-9 flex items-center justify-center text-slate-600 hover:bg-white rounded-lg transition font-bold">-</button>
                            <input type="number" id="qty" name="quantity" value="1" min="1" max="{{ $product->stock > 0 ? $product->stock : 1 }}" class="w-12 text-center bg-transparent border-0 font-bold text-sm text-slate-800 focus:outline-none">
                            <button type="button" onclick="const q = document.getElementById('qty'); q.value++;" class="w-9 h-9 flex items-center justify-center text-slate-600 hover:bg-white rounded-lg transition font-bold">+</button>
                        </div>

                        <!-- Add to Cart CTA -->
                        <button 
                            type="submit" 
                            {{ !$product->in_stock ? 'disabled' : '' }}
                            class="flex-1 w-full py-3.5 px-6 bg-indigo-600 hover:bg-indigo-700 text-white font-bold rounded-xl transition flex items-center justify-center gap-2 shadow-md shadow-indigo-200 disabled:opacity-50 disabled:cursor-not-allowed active:scale-98"
                        >
                            <i class="fa-solid fa-cart-plus"></i> Add To Shopping Cart
                        </button>

                    </div>
                </form>

                <!-- Value Props -->
                <div class="grid grid-cols-3 gap-3 pt-4 border-t border-slate-100 text-center">
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <i class="fa-solid fa-truck text-indigo-600 text-sm mb-1 block"></i>
                        <span class="text-[11px] font-semibold text-slate-700">Fast Shipping</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <i class="fa-solid fa-shield text-emerald-600 text-sm mb-1 block"></i>
                        <span class="text-[11px] font-semibold text-slate-700">1 Year Warranty</span>
                    </div>
                    <div class="p-3 bg-slate-50 rounded-xl">
                        <i class="fa-solid fa-rotate-left text-amber-600 text-sm mb-1 block"></i>
                        <span class="text-[11px] font-semibold text-slate-700">30-Day Return</span>
                    </div>
                </div>

            </div>

        </div>

        <!-- Detailed Description Section -->
        <div class="mt-14 pt-10 border-t border-slate-200">
            <h3 class="text-lg font-bold text-slate-900 mb-4 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-indigo-600"></i> Product Overview & Details
            </h3>
            <div class="prose prose-slate max-w-none text-sm text-slate-600 leading-relaxed">
                <p>{{ $product->description ?? $product->short_description }}</p>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl sm:text-2xl font-extrabold text-slate-900">Related Products</h2>
                <a href="{{ route('shop.index', ['category' => $product->category->slug ?? '']) }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-800">
                    View More <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts as $rel)
                    <div class="bg-white rounded-2xl border border-slate-200 hover:border-slate-300 shadow-xs hover:shadow-lg transition duration-300 flex flex-col overflow-hidden group">
                        <div class="aspect-square bg-slate-100 overflow-hidden relative">
                            <a href="{{ route('product.show', $rel->slug) }}">
                                <img src="{{ $rel->image }}" alt="{{ $rel->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                            </a>
                        </div>
                        <div class="p-4 flex-1 flex flex-col justify-between">
                            <div>
                                <h4 class="font-bold text-sm text-slate-900 line-clamp-1 group-hover:text-indigo-600 transition">
                                    <a href="{{ route('product.show', $rel->slug) }}">{{ $rel->name }}</a>
                                </h4>
                                <span class="text-sm font-black text-slate-900 mt-1 block">
                                    ${{ number_format($rel->effective_price, 2) }}
                                </span>
                            </div>
                            <form action="{{ route('cart.add', $rel->id) }}" method="POST" class="mt-3">
                                @csrf
                                <input type="hidden" name="quantity" value="1">
                                <button type="submit" class="w-full py-2 bg-slate-900 hover:bg-indigo-600 text-white text-xs font-bold rounded-xl transition">
                                    Add To Cart
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection
