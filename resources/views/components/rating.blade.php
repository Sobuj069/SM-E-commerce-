@props([
    'value' => 5.0,
    'count' => null,
    'size' => 'sm',
])

@php
$starSize = [
    'xs' => 'text-[10px]',
    'sm' => 'text-xs',
    'md' => 'text-sm',
    'lg' => 'text-base',
][$size] ?? 'text-xs';
@endphp

<div class="flex items-center gap-1.5">
    <div class="flex text-amber-400 {{ $starSize }}">
        @for($i = 1; $i <= 5; $i++)
            @if($value >= $i)
                <i class="fa-solid fa-star"></i>
            @elseif($value >= $i - 0.5)
                <i class="fa-solid fa-star-half-stroke"></i>
            @else
                <i class="fa-regular fa-star text-slate-300 dark:text-slate-600"></i>
            @endif
        @endfor
    </div>
    <span class="text-xs font-black text-slate-800 dark:text-slate-200">{{ number_format($value, 1) }}</span>
    @if($count !== null)
        <span class="text-[11px] font-semibold text-slate-400">({{ $count }})</span>
    @endif
</div>