@props([
    'variant' => 'product', // product | glass | elevated | default
    'hover3d' => true,
    'image' => null,
    'imageAlt' => '',
    'imageHref' => null,
    'aspect' => 'square', // square | video | 4/3 | auto
])

@php
    $baseClasses = 'rounded-3xl transition-all duration-300 flex flex-col overflow-hidden';
    
    $tiltClass = $hover3d ? 'card-3d' : '';

    $variantClasses = [
        'product' => 'bg-white dark:bg-slate-900 border border-slate-200/90 dark:border-white/10 shadow-xs hover:shadow-2xl hover:border-indigo-400/60 dark:hover:border-indigo-500/50',
        'glass' => 'glass-card border border-white/60 dark:border-white/10 shadow-lg hover:shadow-2xl',
        'elevated' => 'bg-slate-50 dark:bg-slate-800/90 border border-slate-200 dark:border-slate-700 shadow-md hover:shadow-xl',
        'default' => 'bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-xs',
    ][$variant] ?? $variantClasses['product'];

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
        <div class="relative {{ $aspectClasses }} bg-slate-100 dark:bg-slate-800 overflow-hidden group">
            @if($imageHref)
                <a href="{{ $imageHref }}" class="block w-full h-full">
                    <img 
                        src="{{ $image }}" 
                        alt="{{ $imageAlt }}" 
                        class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
                    >
                </a>
            @else
                <img 
                    src="{{ $image }}" 
                    alt="{{ $imageAlt }}" 
                    class="w-full h-full object-cover group-hover:scale-108 transition-transform duration-500"
                >
            @endif

            @if(isset($badges))
                <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
                    {{ $badges }}
                </div>
            @endif
        </div>
    @endif

    <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
        {{ $slot }}

        @if(isset($footer))
            <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex flex-col gap-3">
                {{ $footer }}
            </div>
        @endif
    </div>
</div>
