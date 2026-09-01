@extends('layouts.app')

@section('title', $product->name . ' - 3D Preview | SM Shop')

@section('content')
<!-- Breadcrumbs -->
<div class="bg-surface border-b border-line-subtle py-3.5 transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs font-semibold text-content-muted gap-2 items-center">
            <a href="{{ route('home') }}" class="hover:text-brand-primary">Home</a>
            <span>/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-brand-primary">Shop</a>
            @if($product->category)
                <span>/</span>
                <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-brand-primary">{{ $product->category->name }}</a>
            @endif
            <span>/</span>
            <span class="text-content-primary line-clamp-1 font-bold">{{ $product->name }}</span>
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
    <div class="bg-surface rounded-3xl border border-line-subtle p-6 sm:p-10 shadow-xs transition-colors duration-200">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Left: Interactive 3D Viewer & Gallery Container -->
            <div class="lg:col-span-6 space-y-4">
                
                <!-- View Mode Toggle: High-Res Photo vs 3D Interactive Model -->
                <div class="flex items-center justify-between p-1.5 rounded-2xl bg-surface-elevated border border-line-subtle">
                    <button 
                        type="button" 
                        x-on:click="viewMode = 'image'"
                        :class="viewMode === 'image' ? 'bg-brand-primary text-white shadow-md' : 'text-content-secondary hover:text-content-primary'"
                        class="flex-1 py-2 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 cursor-pointer"
                    >
                        <i class="fa-solid fa-image"></i> HD Photo Gallery
                    </button>
                    <button 
                        type="button" 
                        x-on:click="viewMode = '3d'"
                        :class="viewMode === '3d' ? 'bg-brand-primary text-white shadow-md' : 'text-content-secondary hover:text-content-primary'"
                        class="flex-1 py-2 rounded-xl text-xs font-bold transition flex items-center justify-center gap-1.5 cursor-pointer"
                    >
                        <i class="fa-solid fa-cube text-amber-300"></i> Interactive 3D / 360°
                    </button>
                </div>

                <!-- Showcase Media Frame -->
                <div class="relative aspect-square rounded-3xl overflow-hidden bg-slate-900 border border-line-subtle group shadow-inner">
                    
                    <!-- Mode 1: HD Image with Zoom Lens Hover -->
                    <div x-show="viewMode === 'image'" class="w-full h-full relative flex items-center justify-center overflow-hidden">
                        <img 
                            src="{{ $product->image }}" 
                            alt="{{ $product->name }}" 
                            class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                        >
                        
                        <div class="absolute top-4 left-4 flex flex-col gap-2 z-10">
                            @if($product->has_discount)
                                <x-badge variant="discount" size="md">
                                    -{{ $product->discount_percent }}% OFF
                                </x-badge>
                            @endif
                            @if($product->is_featured)
                                <x-badge variant="featured" size="md">
                                    ⚡ 3D Verified
                                </x-badge>
                            @endif
                        </div>
                    </div>

                    <!-- Mode 2: Interactive 3D / 360 Turntable Viewer (Three.js / Model Viewer) -->
                    <div x-show="viewMode === '3d'" class="w-full h-full relative bg-slate-950 flex flex-col items-center justify-center p-6 text-center" style="display: none;">
                        <model-viewer 
                            src="https://modelviewer.dev/shared-assets/models/Astronaut.glb"
                            alt="{{ $product->name }} 3D model"
                            auto-rotate
                            camera-controls
                            shadow-intensity="1.5"
                            touch-action="pan-y"
                            class="w-full h-full"
                            style="width: 100%; height: 100%; min-height: 380px;"
                        ></model-viewer>
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 bg-slate-900/80 backdrop-blur-md px-4 py-1.5 rounded-full border border-white/20 text-amber-300 text-xs font-bold pointer-events-none shadow-lg">
                            <i class="fa-solid fa-arrows-rotate mr-1"></i> Drag to rotate 360° | Pinch to zoom
                        </div>
                    </div>

                </div>
            </div>

            <!-- Right: Product Information & Interactive Options -->
            <div class="lg:col-span-6 flex flex-col justify-between space-y-6">
                <div class="space-y-4">
                    
                    <div class="flex items-center justify-between">
                        <x-badge variant="nano" size="sm">
                            {{ $product->category->name ?? 'General' }}
                        </x-badge>
                        <span class="text-xs text-content-muted font-mono" x-text="'SKU: ' + activeSku">SKU: {{ $product->sku ?? 'N/A' }}</span>
                    </div>

                    <h1 class="text-2xl sm:text-3xl font-black text-content-primary leading-tight">
                        {{ $product->name }}
                    </h1>

                    <!-- Rating & Reviews -->
                    <div class="flex items-center gap-3">
                        <x-rating :value="$product->rating" :count="$product->reviews_count" size="sm" />
                        <button x-on:click="$dispatch('open-modal', 'review-modal')" class="text-xs font-bold text-brand-primary hover:underline cursor-pointer">
                            Write a Review
                        </button>
                    </div>

                    <!-- Live Dynamic Price Block -->
                    <div class="p-4 rounded-2xl bg-surface-elevated border border-line-subtle flex items-baseline gap-3">
                        <span class="text-3xl font-black text-brand-primary" x-text="'$' + activePrice.toFixed(2)">${{ number_format($product->effective_price, 2) }}</span>
                        @if($product->has_discount)
                            <span class="text-base text-content-muted line-through font-semibold">${{ number_format($product->price, 2) }}</span>
                            <x-badge variant="discount" size="sm">Save ${{ number_format($product->price - $product->sale_price, 2) }}</x-badge>
                        @endif
                    </div>

                    <!-- Short Description -->
                    <p class="text-sm text-content-secondary leading-relaxed">
                        {{ $product->short_description }}
                    </p>

                    <!-- Interactive Live Variants (Color Swatches / Size Options) -->
                    @if($product->variants->count() > 0)
                        <div class="pt-2 space-y-3">
                            <label class="text-xs font-black uppercase tracking-wider text-content-primary block">
                                Choose Variant:
                            </label>
                            <div class="flex flex-wrap gap-2.5">
                                @foreach($product->variants as $var)
                                    <button 
                                        type="button" 
                                        x-on:click="selectVariant('{{ $var->id }}', {{ $var->price ?? $product->effective_price }}, {{ $var->stock }}, '{{ $var->sku }}')"
                                        :class="selectedVariantId == '{{ $var->id }}' ? 'border-brand-primary bg-brand-primary/10 text-brand-primary ring-2 ring-brand-primary/30' : 'border-line-subtle text-content-primary hover:border-brand-primary'"
                                        class="px-4 py-2.5 rounded-2xl border text-xs font-extrabold flex items-center gap-2 transition cursor-pointer"
                                    >
                                        @if($var->color)
                                            <span class="w-3.5 h-3.5 rounded-full border border-black/20" style="background-color: {{ $var->color }}"></span>
                                        @endif
                                        <span>{{ $var->name }}</span>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Stock Scarcity Counter Meter -->
                    <div class="p-3.5 rounded-2xl bg-amber-50 dark:bg-amber-950/40 border border-amber-200 dark:border-amber-800/50 space-y-1.5">
                        <div class="flex items-center justify-between text-xs">
                            <span class="font-bold text-amber-800 dark:text-amber-300 flex items-center gap-1.5">
                                <i class="fa-solid fa-fire text-amber-500 animate-pulse"></i> High Demand Item
                            </span>
                            <span class="font-black text-amber-900 dark:text-amber-200" x-text="activeStock + ' Units Left in Stock'">{{ $product->stock }} Units Left</span>
                        </div>
                        <div class="w-full h-2 bg-amber-200/60 dark:bg-amber-900/60 rounded-full overflow-hidden">
                            <div class="h-full bg-gradient-to-r from-amber-500 to-orange-500 rounded-full" style="width: 45%;"></div>
                        </div>
                    </div>

                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4 pt-4 border-t border-line-subtle">
                    @csrf
                    <input type="hidden" name="variant_id" x-model="selectedVariantId">

                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        
                        <!-- Quantity Picker -->
                        <div class="flex items-center border border-line-subtle rounded-2xl bg-surface-elevated p-1 w-full sm:w-auto justify-between">
                            <button type="button" x-on:click="if(quantity > 1) quantity--" class="w-9 h-9 flex items-center justify-center text-content-primary hover:bg-surface rounded-xl transition font-black cursor-pointer">-</button>
                            <input type="number" name="quantity" x-model="quantity" min="1" :max="activeStock" class="w-12 text-center bg-transparent border-0 font-black text-sm text-content-primary focus:outline-none">
                            <button type="button" x-on:click="if(quantity < activeStock) quantity++" class="w-9 h-9 flex items-center justify-center text-content-primary hover:bg-surface rounded-xl transition font-black cursor-pointer">+</button>
                        </div>

                        <!-- Add to Cart CTA -->
                        <div class="flex-1 w-full">
                            <x-button 
                                variant="primary" 
                                size="lg" 
                                type="submit" 
                                :fullWidth="true" 
                                icon="fa-solid fa-cart-plus"
                            >
                                Add To Shopping Cart
                            </x-button>
                        </div>

                    </div>
                </form>

                <!-- Value Props -->
                <div class="grid grid-cols-3 gap-3 pt-4 border-t border-line-subtle text-center">
                    <div class="p-3 bg-surface-elevated rounded-2xl border border-line-subtle">
                        <i class="fa-solid fa-truck text-brand-primary text-sm mb-1 block"></i>
                        <span class="text-[11px] font-bold text-content-primary">Fast Delivery</span>
                    </div>
                    <div class="p-3 bg-surface-elevated rounded-2xl border border-line-subtle">
                        <i class="fa-solid fa-shield text-status-success text-sm mb-1 block"></i>
                        <span class="text-[11px] font-bold text-content-primary">1 Year Warranty</span>
                    </div>
                    <div class="p-3 bg-surface-elevated rounded-2xl border border-line-subtle">
                        <i class="fa-solid fa-rotate-left text-brand-accent text-sm mb-1 block"></i>
                        <span class="text-[11px] font-bold text-content-primary">30-Day Return</span>
                    </div>
                </div>

            </div>

        </div>

        <!-- Detailed Description Section -->
        <div class="mt-14 pt-10 border-t border-line-subtle">
            <h3 class="text-lg font-black text-content-primary mb-4 flex items-center gap-2">
                <i class="fa-solid fa-circle-info text-brand-primary"></i> Product Overview & Engineering Details
            </h3>
            <div class="text-sm text-content-secondary leading-relaxed space-y-4">
                <p>{{ $product->description ?? $product->short_description }}</p>
            </div>
        </div>

        <!-- Ratings & Verified Reviews Breakdown -->
        <div class="mt-14 pt-10 border-t border-line-subtle space-y-8">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-6">
                <div>
                    <h3 class="text-xl font-black text-content-primary flex items-center gap-2">
                        <i class="fa-solid fa-star text-amber-400"></i> Customer Reviews & Rating Breakdown
                    </h3>
                    <p class="text-xs text-content-secondary mt-1">Real feedback from verified buyers worldwide.</p>
                </div>
                <x-button variant="accent" size="sm" type="button" x-on:click="$dispatch('open-modal', 'review-modal')" icon="fa-solid fa-pen">
                    Leave a Review
                </x-button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center bg-surface-elevated p-6 rounded-3xl border border-line-subtle">
                <div class="md:col-span-4 text-center border-b md:border-b-0 md:border-r border-line-subtle pb-6 md:pb-0 md:pr-6">
                    <div class="text-5xl font-black text-content-primary">{{ number_format($product->rating, 1) }}</div>
                    <div class="my-2"><x-rating :value="$product->rating" size="md" /></div>
                    <div class="text-xs text-content-muted font-bold">Based on {{ $totalReviews }} verified ratings</div>
                </div>

                <div class="md:col-span-8 space-y-2">
                    @foreach([5, 4, 3, 2, 1] as $star)
                        <div class="flex items-center gap-3 text-xs">
                            <span class="w-12 font-bold text-content-primary">{{ $star }} Star</span>
                            <div class="flex-1 h-2.5 bg-slate-200 dark:bg-slate-800 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-amber-400 to-orange-500 rounded-full" style="width: {{ $ratingDistribution[$star] ?? 0 }}%;"></div>
                            </div>
                            <span class="w-10 text-right text-content-muted font-bold">{{ $ratingDistribution[$star] ?? 0 }}%</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Customer Reviews List -->
            <div class="space-y-4">
                @forelse($product->approvedReviews as $rev)
                    <div class="p-5 rounded-2xl bg-surface border border-line-subtle space-y-2">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-600 to-violet-600 text-white font-bold flex items-center justify-center text-xs">
                                    {{ substr($rev->user_name, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-xs text-content-primary">{{ $rev->user_name }}</h4>
                                    <span class="text-[10px] text-content-muted">{{ $rev->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <x-rating :value="$rev->rating" size="xs" />
                        </div>
                        @if($rev->title)
                            <h5 class="font-bold text-sm text-content-primary">{{ $rev->title }}</h5>
                        @endif
                        <p class="text-xs text-content-secondary leading-relaxed">
                            {{ $rev->comment }}
                        </p>
                    </div>
                @empty
                    <p class="text-xs text-content-muted italic">No reviews yet. Be the first to leave a verified review!</p>
                @endforelse
            </div>
        </div>

    </div>

    <!-- Related Products Carousel -->
    @if($relatedProducts->count() > 0)
        <div class="mt-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl sm:text-2xl font-black text-content-primary">Recommended Products</h2>
                <a href="{{ route('shop.index', ['category' => $product->category->slug ?? '']) }}" class="text-xs font-bold text-brand-primary hover:underline">
                    View More in Category <i class="fa-solid fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($relatedProducts->take(4) as $rel)
                    <x-card variant="product" :hover3d="true" :image="$rel->image" :imageAlt="$rel->name" :imageHref="route('product.show', $rel->slug)">
                        <div>
                            <span class="text-[11px] font-black text-brand-primary uppercase tracking-widest">{{ $rel->category->name ?? 'General' }}</span>
                            <h4 class="font-bold text-sm text-content-primary line-clamp-1 mt-1 hover:text-brand-primary">
                                <a href="{{ route('product.show', $rel->slug) }}">{{ $rel->name }}</a>
                            </h4>
                        </div>
                        <x-slot:footer>
                            <div class="flex justify-between items-center">
                                <span class="font-black text-content-primary">${{ number_format($rel->effective_price, 2) }}</span>
                                <x-button variant="secondary" size="sm" href="{{ route('product.show', $rel->slug) }}">
                                    View
                                </x-button>
                            </div>
                        </x-slot:footer>
                    </x-card>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Mobile Sticky Bottom Add-To-Cart Bar -->
    <div class="fixed bottom-0 left-0 right-0 z-40 bg-surface/95 backdrop-blur-xl border-t border-line-subtle p-3.5 shadow-2xl flex items-center justify-between gap-4 md:hidden">
        <div>
            <div class="text-[10px] text-content-muted uppercase font-bold">Total Price</div>
            <div class="text-lg font-black text-brand-primary" x-text="'$' + (activePrice * quantity).toFixed(2)">${{ number_format($product->effective_price, 2) }}</div>
        </div>

        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="flex items-center gap-2">
            @csrf
            <input type="hidden" name="variant_id" x-model="selectedVariantId">
            <input type="hidden" name="quantity" x-model="quantity">
            <x-button variant="primary" size="md" type="submit" icon="fa-solid fa-cart-plus">
                Add To Cart
            </x-button>
        </form>
    </div>
</div>

<!-- Customer Review Submission Modal -->
<x-modal name="review-modal" title="Write a Verified Customer Review">
    <form action="{{ route('product.review', $product->id) }}" method="POST" class="space-y-4">
        @csrf
        <div>
            <label class="block text-xs font-bold text-content-primary mb-1">Your Rating</label>
            <select name="rating" class="w-full px-4 py-2.5 rounded-xl border border-line-subtle bg-surface-elevated text-content-primary text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary">
                <option value="5">⭐⭐⭐⭐⭐ (5 - Outstanding)</option>
                <option value="4">⭐⭐⭐⭐ (4 - Very Good)</option>
                <option value="3">⭐⭐⭐ (3 - Average)</option>
                <option value="2">⭐⭐ (2 - Below Expectation)</option>
                <option value="1">⭐ (1 - Disappointed)</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-bold text-content-primary mb-1">Your Full Name</label>
            <input type="text" name="user_name" placeholder="John Doe" class="w-full px-4 py-2.5 rounded-xl border border-line-subtle bg-surface-elevated text-content-primary text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary" required>
        </div>

        <div>
            <label class="block text-xs font-bold text-content-primary mb-1">Email Address (Optional)</label>
            <input type="email" name="user_email" placeholder="john&#64;example.com" class="w-full px-4 py-2.5 rounded-xl border border-line-subtle bg-surface-elevated text-content-primary text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary">
        </div>

        <div>
            <label class="block text-xs font-bold text-content-primary mb-1">Review Headline</label>
            <input type="text" name="title" placeholder="e.g. Stunning 3D clarity and finish" class="w-full px-4 py-2.5 rounded-xl border border-line-subtle bg-surface-elevated text-content-primary text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary">
        </div>

        <div>
            <label class="block text-xs font-bold text-content-primary mb-1">Your Review Details</label>
            <textarea name="comment" rows="4" placeholder="Tell us about the build quality, sound, materials, or delivery speed..." class="w-full px-4 py-2.5 rounded-xl border border-line-subtle bg-surface-elevated text-content-primary text-sm focus:outline-none focus:ring-2 focus:ring-brand-primary" required></textarea>
        </div>

        <div class="pt-2 flex justify-end gap-3">
            <x-button variant="outline" size="sm" type="button" x-on:click="$dispatch('close-modal', 'review-modal')">
                Cancel
            </x-button>
            <x-button variant="primary" size="sm" type="submit">
                Submit Review
            </x-button>
        </div>
    </form>
</x-modal>
@endsection

