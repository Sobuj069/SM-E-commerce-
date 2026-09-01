@props([
    'variant' => 'product', // product | glass | elevated | default
    'hover3d' => false,
    'image' => null,
    'imageAlt' => '',
    'imageHref' => null,
    'aspect' => 'tall', // tall | square | video | 4/3
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

            <!-- Top Left: Badges -->
            @if(isset($badges))
                <div class="absolute top-2.5 left-2.5 flex flex-col gap-1 z-10">
                    {{ $badges }}
                </div>
            @endif

            <!-- Top Right: Wishlist Heart -->
            <button type="button" class="absolute top-2.5 right-2.5 w-8 h-8 rounded-full bg-white/90 backdrop-blur-xs flex items-center justify-center text-zinc-800 hover:text-red-600 hover:scale-110 transition shadow-xs z-10" title="Add to Wishlist">
                <i class="fa-regular fa-heart text-xs"></i>
            </button>

            <!-- Quick Add Bar Slide-up on Hover -->
            @if($productId)
                <div class="absolute inset-x-3 bottom-3 translate-y-14 group-hover:translate-y-0 transition-transform duration-300 z-20 hidden sm:block">
                    <form action="{{ route('cart.add', $productId) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="w-full bg-white/95 hover:bg-black hover:text-white text-black text-[11px] font-black uppercase tracking-widest py-3 rounded-full shadow-lg transition-colors flex items-center justify-center gap-1.5 cursor-pointer">
                            <i class="fa-solid fa-plus text-[10px]"></i> Quick Add
                        </button>
                    </form>
                </div>
            @endif
        </div>
    @endif

    <!-- Card Content Details -->
    <div class="pt-3 pb-2 flex-1 flex flex-col justify-between space-y-2 bg-white">
        {{ $slot }}

        @if(isset($footer))
            <div class="pt-2 flex flex-col gap-2">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>