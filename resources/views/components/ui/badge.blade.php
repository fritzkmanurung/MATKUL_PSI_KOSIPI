@props([
    'variant' => 'neutral',
])

@php
    $baseClasses = 'inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold uppercase tracking-wider leading-tight';
    
    $variants = [
        'neutral' => 'bg-gray-100 dark:bg-[#3E3E3A] text-gray-700 dark:text-[#A1A09A]',
        'success' => 'bg-emerald-50 dark:bg-emerald-900/30 text-emerald-700 dark:text-emerald-400',
        'warning' => 'bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400',
        'danger' => 'bg-rose-50 dark:bg-rose-900/30 text-rose-700 dark:text-rose-400',
        'info' => 'bg-sky-50 dark:bg-sky-900/30 text-sky-700 dark:text-sky-400',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['neutral']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
