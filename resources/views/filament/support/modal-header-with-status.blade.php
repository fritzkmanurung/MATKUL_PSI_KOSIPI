@props([
    'title',
    'status',
])

<div class="flex items-center gap-3">
    <span class="text-lg font-bold text-[#1b1b18] dark:text-[#EDEDEC]">{{ $title }}</span>
    <x-koperasi.status-badge :status="$status" class="px-2 py-1" />
</div>
