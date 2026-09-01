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
    $baseClasses = 'inline-flex items-center justify-center font-bold tracking-tight transition-all duration-200 active:scale-95 disabled:opacity-50 disabled:pointer-events-none cursor-pointer';

    $sizeClasses = [
        'sm' => 'text-xs py-2 px-3.5 gap-1.5 rounded-xl',
        'md' => 'text-sm py-2.5 px-5 gap-2 rounded-xl',
        'lg' => 'text-base py-3.5 px-8 gap-2.5 rounded-2xl',
    ][$size] ?? 'text-sm py-2.5 px-5 gap-2 rounded-xl';

    $variantClasses = [
        'primary' => 'bg-gradient-to-r from-indigo-600 via-indigo-600 to-violet-600 hover:from-indigo-700 hover:to-violet-700 text-white shadow-md shadow-indigo-500/25 hover:shadow-lg hover:shadow-indigo-500/35 border border-indigo-400/20',
        'secondary' => 'bg-slate-900 dark:bg-slate-800 hover:bg-slate-800 dark:hover:bg-slate-700 text-white shadow-md shadow-black/10 border border-slate-700/50',
        'outline' => 'bg-transparent hover:bg-indigo-50 dark:hover:bg-indigo-950/40 text-slate-800 dark:text-slate-200 hover:text-indigo-600 dark:hover:text-indigo-400 border border-slate-300 dark:border-slate-700 hover:border-indigo-400',
        'accent' => 'bg-gradient-to-r from-amber-400 via-amber-300 to-amber-400 hover:from-amber-300 hover:to-amber-400 text-slate-950 shadow-md shadow-amber-500/20 hover:shadow-lg hover:shadow-amber-500/30 border border-amber-300/40',
        'glass' => 'glass-card hover:bg-white/90 dark:hover:bg-slate-800/90 text-slate-900 dark:text-white border border-white/60 dark:border-white/10 shadow-sm',
        'danger' => 'bg-gradient-to-r from-rose-500 to-pink-600 hover:from-rose-600 hover:to-pink-700 text-white shadow-md shadow-rose-500/25 border border-rose-400/20',
        'ghost' => 'bg-transparent hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 hover:text-indigo-600 dark:hover:text-indigo-400',
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
