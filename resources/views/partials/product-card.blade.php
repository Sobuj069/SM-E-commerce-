@props([
    'product',
    'badgeText' => null,
    'badgeClass' => null,
    'delay' => 0
])

<div 
    data-aos="fade-up" 
    data-aos-delay="{{ $delay }}"
    data-aos-duration="650"
    class="product-card-motion bg-white rounded-md border border-slate-200 overflow-hidden flex flex-col justify-between hover:shadow-2xl hover:-translate-y-2 hover:border-starOrange transition-all duration-300 relative p-3 group will-change-transform"
>
    
    <!-- Dynamic Badges -->
    <div class="absolute top-2 left-2 flex flex-col gap-1 z-10">
        @if($badgeText)
            <span class="{{ $badgeClass ?? 'bg-starOrange text-white' }} shimmer-badge text-[10px] font-bold px-2 py-0.5 rounded-xs tracking-wide uppercase shadow-sm flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-white animate-pulse"></span>
                <span>{{ $badgeText }}</span>
            </span>
        @elseif($product->has_discount && ($product->price - $product->effective_price) > 0)
            @php
                $savingAmount = $product->price - $product->effective_price;
            @endphp
            <span class="bg-[#6e42c1] shimmer-badge text-white text-[10px] font-semibold px-2 py-0.5 rounded-xs shadow-sm flex items-center gap-1">
                <span>Save: {{ number_format($savingAmount) }}৳ (-{{ $product->discount_percentage }}%)</span>
            </span>
        @elseif($product->is_new_arrival)
            <span class="bg-emerald-600 shimmer-badge text-white text-[10px] font-bold px-2 py-0.5 rounded-xs shadow-sm uppercase flex items-center gap-1">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-200 animate-ping"></span>
                <span>New</span>
            </span>
        @elseif($product->is_trending)
            <span class="bg-amber-500 shimmer-badge text-white text-[10px] font-bold px-2 py-0.5 rounded-xs shadow-sm uppercase flex items-center gap-1">
                <i class="fa-solid fa-fire text-[9px] text-amber-200"></i>
                <span>Trending</span>
            </span>
        @elseif($product->effective_price > 80000)
            <span class="bg-[#082b49] text-white text-[10px] font-semibold px-2 py-0.5 rounded-xs shadow-xs">
                Earn Point: 450
            </span>
        @endif
    </div>

    <!-- Product Image Container with Zoom Animation -->
    <a href="{{ route('product.show', $product->slug) }}" class="py-4 flex justify-center items-center h-44 block relative overflow-hidden">
        <img 
            alt="{{ $product->name }}" 
            class="max-h-36 max-w-full object-contain group-hover:scale-110 group-hover:rotate-1 transition-transform duration-500 ease-out" 
            src="{{ $product->image }}"
            loading="lazy"
        />
    </a>

    <!-- Product Title & Price -->
    <div class="border-t border-slate-100 pt-3 space-y-2">
        <h3 class="text-xs font-semibold text-slate-800 group-hover:text-starOrange line-clamp-2 leading-relaxed h-8 transition-colors">
            <a href="{{ route('product.show', $product->slug) }}" title="{{ $product->name }}">
                {{ $product->name }}
            </a>
        </h3>

        <div class="flex items-center gap-2">
            <span class="text-starOrange font-bold text-sm">{{ number_format($product->effective_price) }}৳</span>
            @if($product->has_discount)
                <span class="text-gray-400 line-through text-xs">{{ number_format($product->price) }}৳</span>
            @endif
        </div>

        <!-- Rating snippet if available -->
        @if($product->rating > 0)
            <div class="flex items-center gap-1 text-[11px] text-amber-500">
                <i class="fa-solid fa-star text-[10px]"></i>
                <span class="font-bold text-slate-700">{{ number_format($product->rating, 1) }}</span>
                <span class="text-gray-400 text-[10px]">({{ $product->reviews_count ?? 0 }})</span>
            </div>
        @endif

        <!-- Quick Add to Cart Action with Hover Transition -->
        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="pt-1">
            @csrf
            <button type="submit" class="w-full py-1.5 bg-[#f2f4f8] group-hover:bg-starOrange group-hover:text-white text-slate-700 text-[11px] font-bold rounded transition-all duration-300 flex items-center justify-center gap-1.5 cursor-pointer shadow-xs active:scale-95">
                <i class="fa-solid fa-cart-plus text-[10px] group-hover:animate-bounce"></i>
                <span>Buy Now</span>
            </button>
        </form>
    </div>

</div>
