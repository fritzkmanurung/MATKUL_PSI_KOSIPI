@props([
    'label' => null,
])

<div {{ $attributes->merge(['class' => 'relative my-6']) }}>
    <div class="absolute inset-0 flex items-center" aria-hidden="true">
        <div class="w-full border-t border-gray-100 dark:border-gray-800"></div>
    </div>
    @if ($label)
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#706f6c] dark:text-[#A1A09A] font-medium">
                {{ $label }}
            </span>
        </div>
    @endif
</div>
