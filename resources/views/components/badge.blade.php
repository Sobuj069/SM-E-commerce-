@props([
    'variant' => 'discount', // discount | featured | success | warning | danger | info | nano | neutral
    'size' => 'sm',          // sm | md
    'dot' => false,
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center font-black uppercase tracking-widest rounded-none shadow-none';

    $sizeClasses = [
        'sm' => 'text-[10px] py-1 px-2.5 gap-1.5',
        'md' => 'text-xs py-1.5 px-3.5 gap-2',
    ][$size] ?? 'text-[10px] py-1 px-2.5 gap-1.5';

    $variantClasses = [
        'discount' => 'bg-red-600 text-white',
        'featured' => 'bg-black text-white',
        'success' => 'bg-emerald-600 text-white',
        'warning' => 'bg-amber-500 text-black',
        'danger' => 'bg-red-600 text-white',
        'info' => 'bg-zinc-900 text-white',
        'nano' => 'bg-black text-white border border-white/20',
        'neutral' => 'bg-zinc-100 text-zinc-900 border border-zinc-300',
    ][$variant] ?? $variantClasses['featured'];

    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($icon)
        <i class="{{ $icon }} text-[10px]"></i>
    @endif
    <span>{{ $slot }}</span>
</span>