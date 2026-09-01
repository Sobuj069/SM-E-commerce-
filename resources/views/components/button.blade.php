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
    $baseClasses = 'inline-flex items-center justify-center font-semibold transition-all duration-200 active:scale-[0.98] disabled:opacity-50 disabled:pointer-events-none cursor-pointer';

    $sizeClasses = [
        'sm' => 'text-xs py-2 px-3.5 gap-1.5 rounded-xl',
        'md' => 'text-sm py-2.5 px-5 gap-2 rounded-xl',
        'lg' => 'text-base py-3 px-7 gap-2.5 rounded-xl',
    ][$size] ?? 'text-sm py-2.5 px-5 gap-2 rounded-xl';

    $variantClasses = [
        'primary' => 'bg-indigo-600 hover:bg-indigo-700 text-white shadow-sm hover:shadow-md transition-colors',
        'secondary' => 'bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white shadow-xs transition-colors',
        'outline' => 'bg-transparent hover:bg-slate-50 dark:hover:bg-slate-800/60 text-slate-800 dark:text-slate-200 border border-slate-300 dark:border-slate-700 transition-colors',
        'accent' => 'bg-amber-400 hover:bg-amber-300 text-slate-950 font-bold shadow-sm transition-colors',
        'glass' => 'bg-white/10 hover:bg-white/20 text-white backdrop-blur-md border border-white/20 shadow-sm transition-colors',
        'danger' => 'bg-rose-600 hover:bg-rose-700 text-white shadow-sm transition-colors',
        'ghost' => 'bg-transparent hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 transition-colors',
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