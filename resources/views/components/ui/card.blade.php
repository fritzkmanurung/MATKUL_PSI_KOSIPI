@props([
    'title' => null,
    'description' => null,
    'padding' => 'p-6',
])

<div {{ $attributes->merge(['class' => 'bg-white dark:bg-[#161615] shadow-[inset_0px_0px_0px_1px_rgba(26,26,0,0.16)] dark:shadow-[inset_0px_0px_0px_1px_#fffaed2d] rounded-lg overflow-hidden']) }}>
    @if ($title || $description)
        <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-800">
            @if ($title)
                <h3 class="font-semibold text-base text-[#1b1b18] dark:text-[#EDEDEC]">{{ $title }}</h3>
            @endif
            @if ($description)
                <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-0.5">{{ $description }}</p>
            @endif
        </div>
    @endif

    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>
