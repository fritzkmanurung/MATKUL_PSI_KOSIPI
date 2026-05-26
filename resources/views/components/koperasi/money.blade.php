@props([
    'value' => 0,
    'prefix' => 'Rp',
    'suffix' => '',
])

@php
    $formattedValue = number_format((float) $value, 0, ',', '.');
@endphp

<span {{ $attributes->merge(['class' => 'font-medium tabular-nums']) }}>
    {{ $prefix ? $prefix . ' ' : '' }}{{ $formattedValue }}{{ $suffix ? ' ' . $suffix : '' }}
</span>
