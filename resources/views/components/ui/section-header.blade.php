@props([
    'title',
    'description' => null,
])

<div {{ $attributes->merge(['class' => 'mb-6']) }}>
    <h2 class="text-xl font-bold tracking-tight text-[#1b1b18] dark:text-[#EDEDEC]">
        {{ $title }}
    </h2>
    @if ($description)
        <p class="mt-1 text-sm text-[#706f6c] dark:text-[#A1A09A]">
            {{ $description }}
        </p>
    @endif
</div>
