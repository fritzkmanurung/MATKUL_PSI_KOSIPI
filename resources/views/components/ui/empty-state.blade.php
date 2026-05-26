@props([
    'title' => 'Tidak ada data',
    'description' => 'Maaf, sepertinya belum ada data yang tersedia saat ini.',
    'icon' => null,
])

<div {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center p-12 text-center']) }}>
    <div class="mb-4 text-gray-300 dark:text-gray-700">
        @if ($icon)
            {{ $icon }}
        @else
            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
            </svg>
        @endif
    </div>
    <h3 class="text-lg font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $title }}</h3>
    <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A] max-w-xs mx-auto">
        {{ $description }}
    </p>
    
    @if ($slot->isNotEmpty())
        <div class="mt-6">
            {{ $slot }}
        </div>
    @endif
</div>
