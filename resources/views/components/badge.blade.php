@props([
    'variant' => 'discount', // discount | featured | success | warning | danger | info | nano | neutral
    'size' => 'sm',          // sm | md
    'dot' => false,
    'icon' => null,
])

@php
    $baseClasses = 'inline-flex items-center font-extrabold uppercase tracking-wider rounded-full shadow-xs';

    $sizeClasses = [
        'sm' => 'text-[10px] py-0.5 px-2.5 gap-1.5',
        'md' => 'text-xs py-1 px-3 gap-2',
    ][$size] ?? 'text-[10px] py-0.5 px-2.5 gap-1.5';

    $variantClasses = [
        'discount' => 'bg-gradient-to-r from-rose-500 to-pink-600 text-white shadow-rose-500/25',
        'featured' => 'bg-gradient-to-r from-amber-400 to-orange-500 text-slate-950 shadow-amber-500/25',
        'success' => 'bg-emerald-50 text-emerald-700 dark:bg-emerald-950/50 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60',
        'warning' => 'bg-amber-50 text-amber-800 dark:bg-amber-950/50 dark:text-amber-300 border border-amber-200 dark:border-amber-800/60',
        'danger' => 'bg-rose-50 text-rose-700 dark:bg-rose-950/50 dark:text-rose-300 border border-rose-200 dark:border-rose-800/60',
        'info' => 'bg-sky-50 text-sky-700 dark:bg-sky-950/50 dark:text-sky-300 border border-sky-200 dark:border-sky-800/60',
        'nano' => 'bg-gradient-to-r from-indigo-500 to-violet-600 text-white shadow-indigo-500/40 border border-indigo-400/30',
        'neutral' => 'bg-slate-100 text-slate-700 dark:bg-slate-800 dark:text-slate-300 border border-slate-200 dark:border-slate-700',
    ][$variant] ?? $variantClasses['discount'];

    $dotColors = [
        'discount' => 'bg-white',
        'featured' => 'bg-slate-950',
        'success' => 'bg-emerald-500',
        'warning' => 'bg-amber-500',
        'danger' => 'bg-rose-500',
        'info' => 'bg-sky-500',
        'nano' => 'bg-emerald-400',
        'neutral' => 'bg-slate-400',
    ][$variant] ?? 'bg-white';

    $classes = "{$baseClasses} {$sizeClasses} {$variantClasses}";
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    @if($dot)
        <span class="w-1.5 h-1.5 rounded-full {{ $dotColors }} animate-ping"></span>
    @endif
    @if($icon)
        <i class="{{ $icon }} text-[10px]"></i>
    @endif
    <span>{{ $slot }}</span>
</span>
