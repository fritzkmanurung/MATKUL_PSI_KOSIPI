@props([
    'saldo',
    'limitPribadi',
    'limitLikuiditas',
    'limitFinal',
    'tunggakan' => null,
])

<div class="space-y-4 text-sm">
    <div class="grid grid-cols-1 gap-2">
        <div class="flex justify-between items-center p-2 rounded-lg bg-gray-50 dark:bg-gray-900/50">
            <span class="text-gray-500 dark:text-gray-400">Total Saldo Simpanan:</span>
            <x-koperasi.money :value="$saldo" class="text-base" />
        </div>
        
        <div class="flex justify-between items-center p-2">
            <span class="text-gray-500 dark:text-gray-400">Limit Pribadi (Saldo × 3):</span>
            <x-koperasi.money :value="$limitPribadi" />
        </div>
        
        <div class="flex justify-between items-center p-2">
            <span class="text-gray-500 dark:text-gray-400">Limit Likuiditas Koperasi (20%):</span>
            <x-koperasi.money :value="$limitLikuiditas" />
        </div>
    </div>

    <x-ui.divider />

    <div class="flex justify-between items-center p-4 rounded-lg bg-primary-50 dark:bg-primary-900/20 border border-primary-100 dark:border-primary-800/30">
        <span class="font-bold text-primary-700 dark:text-primary-400 text-base">Limit Final Anda:</span>
        <x-koperasi.money :value="$limitFinal" class="text-xl font-black text-primary-700 dark:text-primary-400" />
    </div>

    @if ($tunggakan && $tunggakan['ada_tunggakan'])
        <x-ui.alert variant="danger" title="Anda memiliki tunggakan">
            <ul class="list-disc list-inside mt-1 space-y-1">
                @if ($tunggakan['jumlah_tagihan_belum_bayar'] > 0)
                    <li>{{ $tunggakan['jumlah_tagihan_belum_bayar'] }} tagihan wajib belum dibayar</li>
                @endif
                @if ($tunggakan['total_denda'] > 0)
                    <li>Total denda: <x-koperasi.money :value="$tunggakan['total_denda']" /></li>
                @endif
            </ul>
            <p class="mt-2 font-semibold italic text-xs">Silakan lunasi tunggakan sebelum mengajukan pinjaman.</p>
        </x-ui.alert>
    @endif
</div>
