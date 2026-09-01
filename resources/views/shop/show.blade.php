@extends('layouts.app')

@section('title', $product->name . ' - SM Shop')

@section('content')
<!-- Breadcrumbs -->
<div class="bg-zinc-100 border-b border-zinc-200 py-3.5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-[11px] font-bold text-zinc-500 uppercase tracking-wider gap-2 items-center">
            <a href="{{ route('home') }}" class="hover:text-black">HOME</a>
            <span>/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-black">SHOP</a>
            @if($product->category)
                <span>/</span>
                <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-black">{{ $product->category->name }}</a>
            @endif
            <span>/</span>
            <span class="text-black line-clamp-1">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10" 
     x-data="{ 
         viewMode: 'image', // 'image' | '3d'
         quantity: 1,
         selectedVariantId: '{{ $product->variants->first()?->id ?? '' }}',
         activePrice: {{ $product->effective_price }},
         activeStock: {{ $product->stock }},
         activeSku: '{{ $product->sku ?? 'N/A' }}',
         variants: {{ $product->variants->toJson() }},
         selectVariant(id, price, stock, sku) {
             this.selectedVariantId = id;
             if (price) this.activePrice = parseFloat(price);
             if (stock !== undefined) this.activeStock = parseInt(stock);
             if (sku) this.activeSku = sku;
         }
     }"
>
    <!-- Main Product Presentation Card -->
    <div class="bg-white rounded-2xl border border-zinc-200 p-6 sm:p-10 shadow-xs">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Left: Interactive 3D Viewer & Gallery Container -->
            <div class="lg:col-span-6 space-y-4">
                
                <!-- View Mode Toggle -->
                <div class="flex items-center justify-between p-1 rounded-full bg-zinc-100 border border-zinc-200">
                    <button 
                        type="button" 
                        x-on:click="viewMode = 'image'"
                        :class="viewMode === 'image' ? 'bg-black text-white shadow-sm' : 'text-zinc-600 hover:text-black'"
                        class="flex-1 py-2 rounded-full text-xs font-black uppercase tracking-wider transition flex items-center justify-center gap-1.5 cursor-pointer"
                    >
                        <i class="fa-solid fa-image"></i> HD Photo Gallery
                    </button>
                    <button 
                        type="button" 
                        x-on:click="viewMode = '3d'"
                        :class="viewMode === '3d' ? 'bg-black text-white shadow-sm' : 'text-zinc-600 hover:text-black'"
                        class="flex-1 py-2 rounded-full text-xs font-black uppercase tracking-wider transition flex items-center justify-center gap-1.5 cursor-pointer"
                    >
                        <i class="fa-solid fa-cube text-amber-300"></i> Interactive 3D / 360°
                    </button>
                </div>

                <!-- Showcase Media Frame -->
                <div class="relative aspect-[3/4] rounded-2xl overflow-hidden bg-[#f4f4f5] border border-zinc-200 group">
                    
                    <!-- Mode 1: HD Image -->
                    <div x-show="viewMode === 'image'" class="w-full h-full relative flex items-center justify-center overflow-hidden">
                        <img 
                            src="{{ $product->image }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                        >
                        
                        <div class="absolute top-4 left-4 flex flex-col gap-1.5 z-10">
                            @if($product->has_discount)
                                <x-badge variant="discount" size="md">
                                    -{{ $product->discount_percent }}% OFF
                                </x-badge>
                            @endif
                            @if($product->is_featured)
                                <x-badge variant="featured" size="md">
                                    NEW RELEASE
                                </x-badge>
                            @endif
                        </div>
                    </div>

                    <!-- Mode 2: Interactive 3D Model Viewer -->
                    <div x-show="viewMode === '3d'" class="w-full h-full relative bg-zinc-950 flex flex-col items-center justify-center p-6 text-center" style="display: none;">
                        <model-viewer 
                            src="https://modelviewer.dev/shared-assets/models/Astronaut.glb"
                            alt="{{ $product->name }} 3D model"
                            auto-rotate
                            camera-controls
                            shadow-intensity="1.5"
                            touch-action="pan-y"
                            class="w-full h-full"
                            style="width: 100%; height: 100%; min-height: 420px;"
                        ></model-viewer>
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-black/80 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/20 text-white text-xs font-bold pointer-events-none shadow-lg">
                            <i class="fa-solid fa-arrows-rotate mr-1"></i> Drag to rotate 360° | Pinch to zoom
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right: Product Information & Interactive Options -->
            <div class="lg:col-span-6 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    
                    <div class="flex items-center justify-between">
                        <span class="text-[11px] font-bold text-zinc-500 uppercase tracking-widest">
                            {{ $product->category->name ?? 'GEAR' }}
                        </span>
                        <span class="text-[11px] text-zinc-400 font-mono font-bold" x-text="'SKU: ' + activeSku">SKU: {{ $product->sku ?? 'N/A' }}</span>
                    </div>

                    <h1 class="text-2xl sm:text-4xl font-black text-black uppercase tracking-tight leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Rating & Reviews -->
                    <div class="flex items-center gap-3">
                        <x-rating :value="$product->rating" :count="$product->reviews_count" size="sm" />
                        <button x-on:click="$dispatch('open-modal', 'review-modal')" class="text-xs font-black uppercase tracking-wider text-black hover:underline cursor-pointer">
                            WRITE A REVIEW
                        </button>
                    </div>

                    <!-- Price Block -->
                    <div class="flex items-baseline gap-3 pt-1">
                        <span class="text-3xl sm:text-4xl font-black text-black" x-text="'$' + activePrice.toFixed(2)">${{ number_format($product->effective_price, 2) }}</span>
                        @if($product->has_discount)
                            <span class="text-lg text-zinc-400 line-through font-semibold">${{ number_format($product->price, 2) }}</span>
                            <x-badge variant="discount" size="sm">Save ${{ number_format($product->price - $product->sale_price, 2) }}</x-badge>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <p class="text-xs sm:text-sm text-zinc-600 leading-relaxed font-medium">
                        {{ $product->short_description }}
                    </p>

                    <!-- Color Swatches & Variant Selectors -->
                    @if($product->variants->count() > 0)
                        <div class="pt-2 space-y-3">
                            <label class="text-xs font-black uppercase tracking-widest text-black block">
                                SELECT VARIANT / SIZE:
                            </label>
                            <div class="flex flex-wrap gap-2.5">
                                @foreach($product->variants as $var)
                                    <button 
                                        type="button" 
                                        x-on:click="selectVariant('{{ $var->id }}', {{ $var->price ?? $product->effective_price }}, {{ $var->stock }}, '{{ $var->sku }}')"
                                        :class="selectedVariantId == '{{ $var->id }}' ? 'border-black bg-black text-white' : 'border-zinc-300 text-black hover:border-black'"
                                        class="px-5 py-2.5 rounded-full border-2 text-xs font-black uppercase tracking-wider flex items-center gap-2 transition cursor-pointer"
                                    >
                                        @if($var->color)
                                            <span class="w-3 h-3 rounded-full border border-zinc-400" style="background-color: {{ $var->color }}"></span>
                                        @endif
                                        <span>{{ $var->name }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Stock Scarcity Notice -->
                    <div class="p-3.5 rounded-xl bg-zinc-100 border border-zinc-200 space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-black uppercase tracking-wider text-black flex items-center gap-1.5">
                                <i class="fa-solid fa-bolt text-amber-500"></i> HIGH DEMAND ITEM
                            </span>
                            <span class="font-bold text-zinc-600" x-text="activeStock + ' UNITS REMAINING'">{{ $product->stock }} UNITS REMAINING</span>
                        </div>
                    </div>

                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4 pt-4 border-t border-zinc-200">
                    @csrf
                    <input type="hidden" name="variant_id" x-model="selectedVariantId">

                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        
                        <!-- Quantity Picker -->
                        <div class="flex items-center border border-zinc-300 rounded-full bg-white p-1 w-full sm:w-auto justify-between">
                            <button type="button" x-on:click="if(quantity > 1) quantity--" class="w-9 h-9 flex items-center justify-center text-black hover:bg-zinc-100 rounded-full transition font-black cursor-pointer">-</button>
                            <input type="number" name="quantity" x-model="quantity" min="1" :max="activeStock" class="w-12 text-center bg-transparent border-0 font-black text-sm text-black focus:outline-none">
                            <button type="button" x-on:click="if(quantity < activeStock) quantity++" class="w-9 h-9 flex items-center justify-center text-black hover:bg-zinc-100 rounded-full transition font-black cursor-pointer">+</button>
                        </div>

                        <!-- Add to Cart CTA -->
                        <div class="flex-1 w-full">
                            <button 
                                type="submit" 
                                class="w-full bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-widest py-4 px-8 rounded-full transition shadow-lg flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <i class="fa-solid fa-bag-shopping"></i> ADD TO BAG
                            </button>
                        </div>

                    </div>
                </form>

                <!-- Value Props Strip -->
                <div class="grid grid-cols-3 gap-3 pt-4 border-t border-zinc-200 text-center">
                    <div class="p-3 bg-zinc-50 rounded-xl border border-zinc-200">
                        <i class="fa-solid fa-truck-fast text-black text-sm mb-1 block"></i>
                        <span class="text-[10px] font-black uppercase text-black">FREE OVER $75</span>
                    </div>
                    <div class="p-3 bg-zinc-50 rounded-xl border border-zinc-200">
                        <i class="fa-solid fa-shield-check text-black text-sm mb-1 block"></i>
                        <span class="text-[10px] font-black uppercase text-black">1 YEAR WARRANTY</span>
                    </div>
                    <div class="p-3 bg-zinc-50 rounded-xl border border-zinc-200">
                        <i class="fa-solid fa-rotate-left text-black text-sm mb-1 block"></i>
                        <span class="text-[10px] font-black uppercase text-black">30-DAY RETURNS</span>
                    </div>
                </div>

            </div>

        </div>

        <!-- Detailed Description Section -->
        <div class="mt-14 pt-10 border-t border-zinc-200">
            <h3 class="text-base font-black uppercase tracking-wider text-black mb-4 flex items-center gap-2">
                <i class="fa-solid fa-circle-info"></i> PRODUCT OVERVIEW & 3D TECH SPECS
            </h3>
            <div class="text-xs sm:text-sm text-zinc-600 leading-relaxed space-y-4 font-medium">
                <p>{{ $product->description ?? $product->short_description }}</p>
            </div>
        </div>

        <!-- Ratings & Verified Reviews Breakdown -->
        <div class="mt-14 pt-10 border-t border-zinc-200 space-y-8">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-black uppercase tracking-tight text-black flex items-center gap-2">
                        <i class="fa-solid fa-star text-amber-400"></i> VERIFIED COMMUNITY REVIEWS
                    </h3>
                    <p class="text-xs text-zinc-500 uppercase tracking-wider font-bold mt-1">Real feedback from athletes & tech pioneers worldwide.</p>
                </div>
                <button type="button" x-on:click="$dispatch('open-modal', 'review-modal')" class="bg-black hover:bg-zinc-800 text-white text-xs font-black uppercase tracking-widest py-3 px-6 rounded-full transition cursor-pointer">
                    WRITE A REVIEW
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center bg-zinc-50 p-6 rounded-2xl border border-zinc-200">
                <div class="md:col-span-4 text-center border-b md:border-b-0 md:border-r border-zinc-200 pb-6 md:pb-0 md:pr-6">
                    <div class="text-5xl font-black text-black">{{ number_format($product->rating, 1) }}</div>
                    <div class="my-2"><x-rating :value="$product->rating" size="md" /></div>
                    <div class="text-xs text-zinc-500 font-bold uppercase tracking-wider">BASED ON {{ $totalReviews }} VERIFIED REVIEWS</div>
                </div>

                <div class="md:col-span-8 space-y-2">
                    @foreach([5, 4, 3, 2, 1] as $star)
                        <div class="flex items-center gap-3 text-xs font-bold uppercase">
                            <span class="w-12 text-black">{{ $star }} Star</span>
                            <div class="flex-1 h-2 bg-zinc-200 rounded-full overflow-hidden">
                                <div class="h-full bg-black rounded-full" style="width: {{ $ratingDistribution[$star] ?? 0 }}%;"></div>
                            </div>
                            <span class="w-10 text-right text-zinc-500">{{ $ratingDistribution[$star] ?? 0 }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Review Items List -->
            @if($product->reviews->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @foreach($product->reviews as $review)
                        <div class="p-6 rounded-2xl bg-zinc-50 border border-zinc-200 space-y-3">
                            <div class="flex items-center justify-between">
                                <x-rating :value="$review->rating" size="xs" />
                                <span class="text-[10px] text-zinc-500 font-bold uppercase tracking-wider">{{ $review->created_at->format('M d, Y') }}</span>
                            </div>
                            <h4 class="font-black text-black text-sm uppercase">{{ $review->title ?? 'GREAT PRODUCT!' }}</h4>
                            <p class="text-xs text-zinc-600 leading-relaxed italic">
                                "{{ $review->comment }}"
                            </p>
                            <div class="text-[11px] font-bold text-black uppercase pt-2 border-t border-zinc-200">
                                {{ $review->user_name }} <span class="text-zinc-400 font-normal">| Verified Purchase</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>

    <!-- Related Products Swiper Section -->
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-16 pt-10 border-t border-zinc-200">
            <h2 class="text-2xl font-black text-black uppercase tracking-tight mb-8">YOU MIGHT ALSO LIKE</h2>
            <div class="swiper related-swiper">
                <div class="swiper-wrapper">
                    @foreach($relatedProducts as $rel)
                        <div class="swiper-slide h-auto">
                            <x-card :image="$rel->image" :imageAlt="$rel->name" :imageHref="route('product.show', $rel->slug)" :productId="$rel->id">
                                <div>
                                    <div class="text-[11px] font-bold text-zinc-500 uppercase tracking-wider">
                                        {{ $rel->category->name ?? 'GEAR' }}
                                    </div>
                                    <h3 class="font-bold text-black text-xs sm:text-sm uppercase tracking-tight mt-0.5 line-clamp-1 group-hover:underline">
                                        <a href="{{ route('product.show', $rel->slug) }}">{{ $rel->name }}</a>
                                    </h3>
                                </div>
                                <x-slot:footer>
                                    <div class="flex items-center justify-between">
                                        <span class="text-sm font-black text-black">${{ number_format($rel->effective_price, 2) }}</span>
                                        <x-rating :value="$rel->rating" size="xs" />
                                    </div>
                                </x-slot:footer>
                            </x-card>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>
@endsection