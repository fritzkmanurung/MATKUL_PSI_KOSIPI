@props([
    'label',
    'value',
    'icon' => null,
    'trend' => null,
    'trendColor' => 'success',
])

<x-ui.card padding="p-5">
    <div class="flex items-center gap-4">
        @if ($icon)
            <div class="p-3 rounded-lg bg-gray-50 dark:bg-gray-900 text-gray-500 dark:text-gray-400">
                {{ $icon }}
            </div>
        @endif
        
        <div class="flex-1">
            <p class="text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider mb-1">
                {{ $label }}
            </p>
            <div class="flex items-baseline gap-2">
                <h4 class="text-2xl font-black text-[#1b1b18] dark:text-[#EDEDEC]">
                    {{ $value }}
                </h4>
                @if ($trend)
                    <span @class([
                        'text-[10px] font-bold px-1.5 py-0.5 rounded-full',
                        'bg-emerald-50 text-emerald-600' => $trendColor === 'success',
                        'bg-rose-50 text-rose-600' => $trendColor === 'danger',
                        'bg-amber-50 text-amber-600' => $trendColor === 'warning',
                    ])>
                        {{ $trend }}
                    </span>
                @endif
            </div>
        </div>
    </div>
</x-ui.card>
