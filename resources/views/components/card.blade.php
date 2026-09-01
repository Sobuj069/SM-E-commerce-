@props([
    'variant' => 'product', // product | glass | elevated | default
    'hover3d' => true,
    'image' => null,
    'imageAlt' => '',
    'imageHref' => null,
    'aspect' => 'square', // square | video | 4/3 | auto
])

@php
    $baseClasses = 'rounded-2xl transition-all duration-300 flex flex-col overflow-hidden bg-white border border-slate-200/90 shadow-xs hover:shadow-xl hover:border-indigo-200 hover:-translate-y-1';
    
    $tiltClass = $hover3d ? 'card-3d' : '';

    $variantClasses = [
        'product' => 'bg-white',
        'glass' => 'bg-white/95 backdrop-blur-md border border-slate-200 shadow-md',
        'elevated' => 'bg-slate-50 border border-slate-200 shadow-sm',
        'default' => 'bg-white',
    ][$variant] ?? 'bg-white';

    $aspectClasses = [
        'square' => 'aspect-square',
        'video' => 'aspect-video',
        '4/3' => 'aspect-4/3',
        'auto' => 'aspect-auto',
    ][$aspect] ?? 'aspect-square';

    $classes = "{$baseClasses} {$tiltClass} {$variantClasses}";
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($image)
        <div class="relative {{ $aspectClasses }} bg-slate-50 overflow-hidden group">
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

            @if(isset($badges))
                <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 z-10">
                    {{ $badges }}
                </div>
            @endif
        </div>
    @endif

    <div class="p-5 flex-1 flex flex-col justify-between space-y-4 bg-white text-slate-900">
        {{ $slot }}

        @if(isset($footer))
            <div class="pt-3 border-t border-slate-100 flex flex-col gap-3">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>