@props([
    'variant' => 'discount', // discount | featured | success | warning | danger | info | nano | neutral
    'size' => 'sm',          // sm | md
    'dot' => false,
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center font-semibold rounded-full tracking-normal';

    $sizeClasses = [
        'sm' => 'text-[11px] py-0.5 px-2.5 gap-1.5',
        'md' => 'text-xs py-1 px-3 gap-2',
    ][$size] ?? 'text-[11px] py-0.5 px-2.5 gap-1.5';

    $variantClasses = [
        'discount' => 'bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200/80 dark:border-rose-800/60 shadow-xs',
        'featured' => 'bg-slate-900 text-white dark:bg-white dark:text-slate-900 shadow-xs',
        'success' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/60 dark:text-emerald-300 border border-emerald-200/80 dark:border-emerald-800/60',
        'warning' => 'bg-amber-50 text-amber-800 dark:bg-amber-950/60 dark:text-amber-300 border border-amber-200/80 dark:border-amber-800/60',
        'danger' => 'bg-rose-50 text-rose-700 dark:bg-rose-950/60 dark:text-rose-300 border border-rose-200/80 dark:border-rose-800/60',
        'info' => 'bg-indigo-50 text-indigo-700 dark:bg-indigo-950/60 dark:text-indigo-300 border border-indigo-200/80 dark:border-indigo-800/60',
        'nano' => 'bg-indigo-600 text-white shadow-xs',
        'neutral' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border border-slate-200 dark:border-slate-700',
    ][$variant] ?? $variantClasses['discount'];

    $dotColors = [
        'discount' => 'bg-rose-500',
        'featured' => 'bg-indigo-400',
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-rose-500',
        'info' => 'bg-indigo-500',
        'nano' => 'bg-emerald-400',
        'neutral' => 'bg-slate-400',
    ][$variant] ?? 'bg-indigo-500';

    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColors }}"></span>
    @endif
    @if($icon)
        <i class="{{ $icon }} text-[10px]"></i>
    @endif
    <span>{{ $slot }}</span>
</span>