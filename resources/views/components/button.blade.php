@props([
    'variant' => 'primary', // primary | secondary | outline | accent | glass | danger | ghost
    'size' => 'md',       // sm | md | lg
    'href' => null,
    'type' => 'button',
    'icon' => null,
    'iconPosition' => 'left',
    'fullWidth' => false,
    'disabled' => false,
])

@php
    $baseClasses = 'inline-flex items-center justify-center font-black uppercase tracking-wider transition-all duration-200 active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none cursor-pointer rounded-full';

    $sizeClasses = [
        'sm' => 'text-[11px] py-2.5 px-5 gap-1.5',
        'md' => 'text-xs py-3.5 px-7 gap-2',
        'lg' => 'text-sm py-4 px-9 gap-2.5',
    ][$size] ?? 'text-xs py-3.5 px-7 gap-2';

    $variantClasses = [
        'primary' => 'bg-black hover:bg-zinc-800 text-white shadow-sm',
        'secondary' => 'bg-zinc-900 hover:bg-black text-white shadow-sm',
        'outline' => 'bg-transparent hover:bg-black text-black hover:text-white border-2 border-black',
        'accent' => 'bg-white hover:bg-zinc-100 text-black border border-zinc-200 shadow-md',
        'glass' => 'bg-white/90 hover:bg-white text-black backdrop-blur-md shadow-md',
        'danger' => 'bg-red-600 hover:bg-red-700 text-white',
        'ghost' => 'bg-transparent hover:bg-zinc-100 text-zinc-900',
    ][$variant] ?? $variantClasses['primary'];

    $widthClass = $fullWidth ? 'w-full' : '';
    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses} {$widthClass}";
@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')
            <i class="{{ $icon }}"></i>
        @endif
        <span>{{ $slot }}</span>
        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }}"></i>
        @endif
    </a>
@else
    <button type="{{ $type }}" {{ $disabled ? 'disabled' : '' }} {{ $attributes->merge(['class' => $classes]) }}>
        @if($icon && $iconPosition === 'left')
            <i class="{{ $icon }}"></i>
        @endif
        <span>{{ $slot }}</span>
        @if($icon && $iconPosition === 'right')
            <i class="{{ $icon }}"></i>
        @endif
    </button>
@endif