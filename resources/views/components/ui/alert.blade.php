@props([
    'variant' => 'info',
    'title' => null,
])

@php
    $variants = [
        'info' => [
            'bg' => 'bg-sky-50 dark:bg-sky-900/20',
            'border' => 'border-sky-200 dark:border-sky-800/30',
            'text' => 'text-sky-800 dark:text-sky-300',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        ],
        'success' => [
            'bg' => 'bg-emerald-50 dark:bg-emerald-900/20',
            'border' => 'border-emerald-200 dark:border-emerald-800/30',
            'text' => 'text-emerald-800 dark:text-emerald-300',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        ],
        'warning' => [
            'bg' => 'bg-amber-50 dark:bg-amber-900/20',
            'border' => 'border-amber-200 dark:border-amber-800/30',
            'text' => 'text-amber-800 dark:text-amber-300',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
        ],
        'danger' => [
            'bg' => 'bg-rose-50 dark:bg-rose-900/20',
            'border' => 'border-rose-200 dark:border-rose-800/30',
            'text' => 'text-rose-800 dark:text-rose-300',
            'icon' => '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>',
        ],
    ];

    $v = $variants[$variant] ?? $variants['info'];
@endphp

<div {{ $attributes->merge(['class' => "p-4 rounded-lg border {$v['bg']} {$v['border']} {$v['text']}"]) }}>
    <div class="flex">
        <div class="shrink-0">
            {!! $v['icon'] !!}
        </div>
        <div class="ml-3">
            @if ($title)
                <h3 class="text-sm font-bold">{{ $title }}</h3>
            @endif
            <div class="text-sm {{ $title ? 'mt-1' : '' }}">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
