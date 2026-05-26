@props([
    'pokok',
    'denda' => 0,
    'hariTelat' => 0,
])

@php
    $total = $pokok + $denda;
@endphp

<div class="text-sm space-y-2 p-3 rounded-lg bg-gray-50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800">
    <div class="flex justify-between items-center">
        <span class="text-gray-500">Pokok:</span>
        <x-koperasi.money :value="$pokok" />
    </div>
    
    @if ($denda > 0)
        <div class="flex justify-between items-center text-rose-600 dark:text-rose-400 font-medium">
            <span>Denda ({{ $hariTelat }} Hari):</span>
            <x-koperasi.money :value="$denda" prefix="+ Rp" />
        </div>
    @endif

    <x-ui.divider class="my-1" />

    <div class="flex justify-between items-center font-black text-base text-[#1b1b18] dark:text-[#EDEDEC]">
        <span>Total Bayar:</span>
        <x-koperasi.money :value="$total" />
    </div>
</div>
