@extends('layouts.app')

@section('title', $product->name . ' - SM Shop')

@section('content')
<!-- Star Tech Breadcrumb Strip -->
<div class="bg-white border-b border-slate-200 py-3">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex text-xs font-medium text-slate-500 gap-2 items-center flex-wrap">
            <a href="{{ route('home') }}" class="hover:text-starOrange"><i class="fa-solid fa-house text-slate-400"></i></a>
            <span>/</span>
            <a href="{{ route('shop.index') }}" class="hover:text-starOrange">Shop</a>
            @if($product->category)
                <span>/</span>
                <a href="{{ route('shop.index', ['category' => $product->category->slug]) }}" class="hover:text-starOrange">{{ $product->category->name }}</a>
            @endif
            <span>/</span>
            <span class="text-slate-800 font-semibold line-clamp-1">{{ $product->name }}</span>
        </nav>
    </div>
</div>

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8" 
     x-data="{ 
         activeImage: '{{ $product->image }}',
         quantity: 1,
         activePrice: {{ $product->effective_price }},
         activeStock: {{ $product->stock }}
     }"
>
    <!-- Product Detail Container -->
    <div class="bg-white rounded-lg border border-slate-200 p-6 sm:p-8 shadow-xs mb-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12">
            
            <!-- Left: Product Image Gallery -->
            <div class="lg:col-span-5 space-y-4">
                <div class="relative w-full aspect-square bg-white border border-slate-200 rounded-lg p-6 flex items-center justify-center overflow-hidden group">
                    <img 
                        :src="activeImage" 
                        alt="{{ $product->name }}" 
                        class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform duration-300"
                    >
                    @if($product->has_discount)
                        <div class="absolute top-3 left-3 bg-starOrange text-white text-xs font-bold px-2.5 py-1 rounded shadow-xs">
                            Save {{ number_format($product->price - $product->sale_price) }}৳
                        </div>
                    @endif
                </div>

                @php
                    $allImages = $product->all_images;
                @endphp
                @if(count($allImages) > 1)
                    <div class="flex items-center gap-2 overflow-x-auto pb-1">
                        @foreach($allImages as $idx => $img)
                            <button 
                                type="button" 
                                @click="activeImage = '{{ $img }}'" 
                                class="w-16 h-16 rounded border-2 transition p-1 bg-white shrink-0 cursor-pointer"
                                :class="activeImage === '{{ $img }}' ? 'border-starOrange ring-1 ring-starOrange' : 'border-slate-200 hover:border-slate-400 opacity-80 hover:opacity-100'"
                            >
                                <img src="{{ $img }}" alt="{{ $product->name }} Angle {{ $idx + 1 }}" class="w-full h-full object-contain">
                            </button>
                        @endforeach
                    </div>
                @endif

                <!-- Trust Badges -->
                <div class="grid grid-cols-3 gap-2 pt-2 text-center">
                    <div class="p-2.5 bg-slate-50 rounded border border-slate-100">
                        <i class="fa-solid fa-shield-check text-starBlue text-base mb-1 block"></i>
                        <span class="text-[11px] font-semibold text-slate-700 block">100% Genuine</span>
                    </div>
                    <div class="p-2.5 bg-slate-50 rounded border border-slate-100">
                        <i class="fa-solid fa-truck-fast text-starOrange text-base mb-1 block"></i>
                        <span class="text-[11px] font-semibold text-slate-700 block">Fast Delivery</span>
                    </div>
                    <div class="p-2.5 bg-slate-50 rounded border border-slate-100">
                        <i class="fa-solid fa-rotate-left text-emerald-600 text-base mb-1 block"></i>
                        <span class="text-[11px] font-semibold text-slate-700 block">Easy Returns</span>
                    </div>
                </div>
            </div>

            <!-- Right: Product Information & Purchase Options -->
            <div class="lg:col-span-7 flex flex-col justify-between space-y-6">
                <div>
                    <!-- Product Title -->
                    <h1 class="text-xl sm:text-2xl font-bold text-slate-900 leading-snug mb-3">
                        {{ $product->name }}
                    </h1>

                    <!-- Key Metadata Strip -->
                    <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-xs text-slate-600 bg-slate-50 p-3 rounded-md border border-slate-100 mb-4">
                        <div>
                            <span class="text-slate-400">Price:</span> 
                            <strong class="text-starOrange text-sm font-bold">{{ number_format($product->effective_price) }}৳</strong>
                        </div>
                        @if($product->has_discount)
                            <div class="border-l border-slate-200 pl-4">
                                <span class="text-slate-400">Regular Price:</span> 
                                <span class="line-through text-slate-500 font-semibold">{{ number_format($product->price) }}৳</span>
                            </div>
                        @endif
                        <div class="border-l border-slate-200 pl-4">
                            <span class="text-slate-400">Status:</span> 
                            <strong class="text-emerald-600 font-bold"><i class="fa-solid fa-circle-check text-[10px]"></i> In Stock</strong>
                        </div>
                        <div class="border-l border-slate-200 pl-4">
                            <span class="text-slate-400">Product Code:</span> 
                            <span class="font-mono font-bold text-slate-700">{{ $product->sku ?? 'ST-PROD-' . $product->id }}</span>
                        </div>
                    </div>

                    <!-- Key Features -->
                    <div class="space-y-2 mb-6">
                        <h3 class="text-xs font-bold text-slate-800 uppercase tracking-wider">Key Features</h3>
                        <div class="text-xs text-slate-700 leading-relaxed space-y-1.5 pl-3 border-l-2 border-starBlue">
                            <p>{{ $product->short_description }}</p>
                            <p><i class="fa-solid fa-check text-emerald-600 text-[10px] mr-1"></i> Official Manufacturer Warranty</p>
                            <p><i class="fa-solid fa-check text-emerald-600 text-[10px] mr-1"></i> 100% Brand New Sealed Box</p>
                        </div>
                    </div>

                    <!-- EMI & Cash Discount Notice -->
                    <div class="p-3.5 bg-[#f0f9ff] border border-sky-200 rounded-md text-xs text-sky-900 space-y-1 mb-6">
                        <div class="flex items-center gap-1.5 font-bold">
                            <i class="fa-solid fa-credit-card text-starBlue"></i> 0% EMI Facility Available
                        </div>
                        <p class="text-sky-700 text-[11px]">
                            Monthly EMI starts from {{ number_format(round($product->effective_price / 12)) }}৳/month on selected credit cards (Up to 36 Months).
                        </p>
                    </div>

                    <!-- Star Tech Purchase Actions Form -->
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="space-y-4">
                        @csrf
                        
                        <div class="flex flex-col sm:flex-row items-center gap-3">
                            <!-- Quantity Selector -->
                            <div class="flex items-center border border-slate-300 rounded bg-white p-1 w-full sm:w-auto justify-between">
                                <button type="button" x-on:click="if(quantity > 1) quantity--" class="w-8 h-8 flex items-center justify-center text-slate-700 hover:bg-slate-100 rounded transition font-bold cursor-pointer">-</button>
                                <input type="number" name="quantity" x-model="quantity" min="1" :max="activeStock" class="w-12 text-center bg-transparent border-0 font-bold text-sm text-slate-900 focus:outline-none">
                                <button type="button" x-on:click="if(quantity < activeStock) quantity++" class="w-8 h-8 flex items-center justify-center text-slate-700 hover:bg-slate-100 rounded transition font-bold cursor-pointer">+</button>
                            </div>

                            <!-- Buy Now CTA (Star Tech Orange) -->
                            <button 
                                type="submit" 
                                class="flex-1 w-full bg-starOrange hover:bg-starOrangeHover text-white text-xs font-bold uppercase tracking-wider py-3.5 px-6 rounded transition shadow-md flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <i class="fa-solid fa-bolt"></i> Buy Now
                            </button>

                            <!-- Add to Cart CTA (Star Tech Blue) -->
                            <button 
                                type="submit" 
                                class="flex-1 w-full bg-starBlue hover:bg-starBlueDark text-white text-xs font-bold uppercase tracking-wider py-3.5 px-6 rounded transition shadow-md flex items-center justify-center gap-2 cursor-pointer"
                            >
                                <i class="fa-solid fa-cart-shopping"></i> Add to Cart
                            </button>
                        </div>
                    </form>

                </div>

                <!-- Call Helpline Strip -->
                <div class="pt-4 border-t border-slate-100 flex items-center justify-between text-xs text-slate-500">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-headset text-starBlue text-sm"></i>
                        <span>Need Help? Call <strong class="text-slate-800">16793</strong> or <strong class="text-slate-800">09678002003</strong></span>
                    </div>
                    <div class="font-semibold text-emerald-600">
                        10:00 AM - 08:00 PM
                    </div>
                </div>

            </div>

        </div>
    </div>

    <!-- Product Full Specifications & Reviews Section -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Left: Specifications & Description -->
        <div class="lg:col-span-8 space-y-6">
            
            <!-- Specifications Table -->
            <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-xs">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-200 pb-3 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-list-check text-starBlue"></i> Specification
                </h3>
                
                <div class="overflow-x-auto">
                    <table class="w-full text-xs text-left">
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50">
                                <td class="py-2.5 px-3 font-bold text-slate-700 w-1/3 bg-slate-50/50">Product Model</td>
                                <td class="py-2.5 px-3 text-slate-800">{{ $product->name }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-2.5 px-3 font-bold text-slate-700 bg-slate-50/50">Category</td>
                                <td class="py-2.5 px-3 text-slate-800">{{ $product->category->name ?? 'Computer Hardware' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-2.5 px-3 font-bold text-slate-700 bg-slate-50/50">SKU Code</td>
                                <td class="py-2.5 px-3 font-mono font-bold text-slate-800">{{ $product->sku ?? 'N/A' }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-2.5 px-3 font-bold text-slate-700 bg-slate-50/50">Key Overview</td>
                                <td class="py-2.5 px-3 text-slate-800">{{ $product->short_description }}</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="py-2.5 px-3 font-bold text-slate-700 bg-slate-50/50">Warranty Support</td>
                                <td class="py-2.5 px-3 text-slate-800">Official SM Shop Brand Authorized Warranty</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Description -->
            <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-xs">
                <h3 class="text-base font-bold text-slate-900 border-b border-slate-200 pb-3 mb-4 flex items-center gap-2">
                    <i class="fa-solid fa-circle-info text-starOrange"></i> Description
                </h3>
                <div class="text-xs sm:text-sm text-slate-700 leading-relaxed space-y-3">
                    <p>{{ $product->description ?? $product->short_description }}</p>
                    <p>SM Shop offers the best price for {{ $product->name }} in Bangladesh. Order online to get genuine gadgets and components with official warranty support.</p>
                </div>
            </div>

            <!-- Customer Reviews -->
            <div class="bg-white rounded-lg border border-slate-200 p-6 shadow-xs space-y-6">
                <div class="flex items-center justify-between border-b border-slate-200 pb-3">
                    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
                        <i class="fa-solid fa-star text-amber-400"></i> Reviews & Ratings ({{ $product->reviews_count ?? $product->reviews->count() }})
                    </h3>
                </div>

                <!-- Review Form -->
                <div class="bg-slate-50 p-4 rounded-lg border border-slate-200">
                    <h4 class="font-bold text-xs text-slate-800 uppercase tracking-wider mb-2">Write a Review for this product</h4>
                    <form action="{{ route('review.store', $product->id) }}" method="POST" class="space-y-3">
                        @csrf
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <input type="text" name="user_name" placeholder="Your Name *" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-xs text-slate-800 focus:outline-none focus:border-starBlue">
                            <input type="email" name="user_email" placeholder="Your Email *" required class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-xs text-slate-800 focus:outline-none focus:border-starBlue">
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <input type="text" name="title" placeholder="Review Title (e.g. Excellent Laptop)" class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-xs text-slate-800 focus:outline-none focus:border-starBlue">
                            <select name="rating" class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-xs text-slate-800 focus:outline-none focus:border-starBlue">
                                <option value="5">★★★★★ (5 Star - Best)</option>
                                <option value="4">★★★★☆ (4 Star - Good)</option>
                                <option value="3">★★★☆☆ (3 Star - Average)</option>
                                <option value="2">★★☆☆☆ (2 Star - Poor)</option>
                                <option value="1">★☆☆☆☆ (1 Star - Terrible)</option>
                            </select>
                        </div>
                        <textarea name="comment" rows="3" placeholder="Share your experience with this tech product..." required class="w-full px-3 py-2 bg-white border border-slate-300 rounded text-xs text-slate-800 focus:outline-none focus:border-starBlue"></textarea>
                        <button type="submit" class="bg-starBlue hover:bg-starBlueDark text-white text-xs font-bold py-2 px-6 rounded transition cursor-pointer">
                            Submit Review
                        </button>
                    </form>
                </div>

                <!-- Existing Reviews List -->
                <div class="space-y-4 divide-y divide-slate-100">
                    @forelse($product->reviews as $rev)
                        <div class="pt-4 first:pt-0 space-y-1.5">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <div class="w-7 h-7 rounded-full bg-starNavy text-white flex items-center justify-center font-bold text-xs">
                                        {{ substr($rev->user_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <span class="font-bold text-xs text-slate-800">{{ $rev->user_name }}</span>
                                        <span class="text-[10px] text-emerald-600 font-semibold ml-1.5"><i class="fa-solid fa-circle-check"></i> Verified Buyer</span>
                                    </div>
                                </div>
                                <div class="text-amber-400 text-xs">
                                    @for($i=1; $i<=5; $i++)
                                        <i class="fa-{{ $i <= $rev->rating ? 'solid' : 'regular' }} fa-star"></i>
                                    @endfor
                                </div>
                            </div>
                            @if($rev->title)
                                <h5 class="font-bold text-xs text-slate-900">{{ $rev->title }}</h5>
                            @endif
                            <p class="text-xs text-slate-600 leading-relaxed">{{ $rev->comment }}</p>
                            <span class="text-[10px] text-slate-400 block">{{ $rev->created_at ? $rev->created_at->diffForHumans() : 'Recently' }}</span>
                        </div>
                    @empty
                        <p class="text-xs text-slate-500 italic text-center py-4">No reviews yet. Be the first to review this product!</p>
                    @endforelse
                </div>
            </div>

        </div>

        <!-- Right: Related Products Sidebar -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-xs">
                <h3 class="font-bold text-slate-900 text-sm mb-4 pb-2 border-b border-slate-100 flex items-center justify-between">
                    <span>Related Products</span>
                    <i class="fa-solid fa-tags text-starOrange text-xs"></i>
                </h3>
                <div class="space-y-4">
                    @php
                        $related = \App\Models\Product::where('category_id', $product->category_id)->where('id', '!=', $product->id)->take(4)->get();
                    @endphp
                    @foreach($related as $rel)
                        <div class="flex items-center gap-3 group">
                            <a href="{{ route('product.show', $rel->slug) }}" class="w-16 h-16 bg-white border border-slate-100 rounded p-1 flex items-center justify-center shrink-0">
                                <img src="{{ $rel->image }}" alt="{{ $rel->name }}" class="max-h-full max-w-full object-contain group-hover:scale-105 transition-transform">
                            </a>
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-xs text-slate-800 hover:text-starOrange line-clamp-2 leading-snug">
                                    <a href="{{ route('product.show', $rel->slug) }}">{{ $rel->name }}</a>
                                </h4>
                                <div class="text-xs font-bold text-starOrange mt-1">
                                    {{ number_format($rel->effective_price) }}৳
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- SM Shop Outlets & Delivery Info Box -->
            <div class="bg-white rounded-lg border border-slate-200 p-5 shadow-xs text-slate-700 space-y-3">
                <h3 class="font-bold text-slate-900 text-sm flex items-center gap-2">
                    <i class="fa-solid fa-location-dot text-starOrange"></i> SM Shop Outlets &amp; Delivery
                </h3>
                <p class="text-xs text-slate-600">Fast delivery available across all 64 districts in Bangladesh or collect directly from our pickup hubs.</p>
                <div class="text-[11px] text-starBlue font-semibold flex items-center gap-1">
                    <i class="fa-solid fa-truck-fast"></i> 64 Districts Express Nationwide Shipping
                </div>
            </div>
        </div>

    </div>
</div>
@endsection