@props([
    'status' => 'Pending',
])

@php
    $statusMap = [
        'Aktif' => 'success',
        'Lunas' => 'success',
        'Disetujui' => 'success',
        'Disetujui Admin' => 'success',
        'Selesai' => 'success',
        'Diterima' => 'success',
        
        'Menunggu' => 'warning',
        'Menunggu Dokumen' => 'warning',
        'Proses' => 'warning',
        'Pending' => 'warning',
        'Revisi' => 'warning',
        
        'Ditolak' => 'danger',
        'Ditolak Dokumen' => 'danger',
        'Batal' => 'danger',
        'Non-aktif' => 'danger',
        'Non-Aktif' => 'danger',
        'Jatuh Tempo' => 'danger',
        
        'Kontrak' => 'info',
        'Tetap' => 'info',
        'Anggota' => 'neutral',
    ];

    $variant = $statusMap[$status] ?? 'neutral';
@endphp

<x-ui.badge :variant="$variant" {{ $attributes }}>
    {{ $status }}
</x-ui.badge>
