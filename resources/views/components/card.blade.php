@props([
    'variant' => 'product',
    'hover3d' => false,
    'image' => null,
    'imageAlt' => '',
    'imageHref' => null,
    'aspect' => 'tall',
    'productId' => null,
])

@php
    $baseClasses = 'transition-all duration-300 flex flex-col group bg-white';
    
    $aspectClasses = [
        'tall' => 'aspect-[3/4]',
        'square' => 'aspect-square',
        'video' => 'aspect-video',
        '4/3' => 'aspect-4/3',
    ][$aspect] ?? 'aspect-[3/4]';
@endphp

<div {{ $attributes->merge(['class' => $baseClasses]) }}>
    @if($image)
        <div class="relative {{ $aspectClasses }} bg-[#f4f4f5] overflow-hidden rounded-xl">
            @if($imageHref)
                <a href="{{ $imageHref }}" class="block w-full h-full">
                    <img 
                        src="{{ $image }}" 
                        alt="{{ $imageAlt }}" 
                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                    >
                </a>
            @else
                <img 
                    src="{{ $image }}" 
                    alt="{{ $imageAlt }}" 
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                >
            @endif

            <!-- Top Left: Gymshark Badges -->
            @if(isset($badges))
                <div class="absolute top-2.5 left-2.5 flex flex-col gap-1 z-10">
                    {{ $badges }}
                </div>
            @endif

            <!-- Top Right: Wishlist Heart -->
            <button type="button" class="absolute top-2.5 right-2.5 w-8 h-8 rounded-full bg-white/90 backdrop-blur-xs flex items-center justify-center text-zinc-800 hover:text-red-600 hover:scale-110 transition shadow-xs z-10" title="Add to Wishlist">
                <i class="fa-regular fa-heart text-xs"></i>
            </button>

            <!-- Gymshark Size Selector Quick-Add Slide-up on Hover -->
            @if($productId)
                <div class="absolute inset-x-2.5 bottom-2.5 translate-y-16 group-hover:translate-y-0 transition-transform duration-300 z-20 hidden sm:block bg-white/95 backdrop-blur-md rounded-xl p-2 shadow-xl border border-zinc-200">
                    <div class="text-[9px] font-black uppercase tracking-wider text-zinc-500 mb-1.5 text-center">SELECT SIZE / QUICK ADD</div>
                    <form action="{{ route('cart.add', $productId) }}" method="POST" class="grid grid-cols-4 gap-1">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="py-1 text-[10px] font-black uppercase bg-zinc-100 hover:bg-black hover:text-white rounded transition text-zinc-800 cursor-pointer">S</button>
                        <button type="submit" class="py-1 text-[10px] font-black uppercase bg-zinc-100 hover:bg-black hover:text-white rounded transition text-zinc-800 cursor-pointer">M</button>
                        <button type="submit" class="py-1 text-[10px] font-black uppercase bg-zinc-100 hover:bg-black hover:text-white rounded transition text-zinc-800 cursor-pointer">L</button>
                        <button type="submit" class="py-1 text-[10px] font-black uppercase bg-zinc-100 hover:bg-black hover:text-white rounded transition text-zinc-800 cursor-pointer">XL</button>
                    </form>
                </div>
            @endif
        </div>
    @endif

    <!-- Card Content Details -->
    <div class="pt-3 pb-2 flex-1 flex flex-col justify-between space-y-1.5 bg-white">
        
        <!-- Gymshark Signature Color Swatch Dots -->
        <div class="flex items-center gap-1.5">
            <span class="w-2.5 h-2.5 rounded-full bg-black border border-zinc-300"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-zinc-600 border border-zinc-300"></span>
            <span class="w-2.5 h-2.5 rounded-full bg-zinc-300 border border-zinc-400"></span>
        </div>

        {{ $slot }}

        @if(isset($footer))
            <div class="pt-1.5 flex flex-col gap-1.5">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>