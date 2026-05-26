<x-filament-widgets::widget>
    <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 shadow-sm overflow-hidden">
        {{-- Header --}}
        <div class="flex items-center justify-between px-5 py-3 border-b border-gray-100 dark:border-gray-800">
            <div>
                <h3 class="text-sm font-semibold text-gray-900 dark:text-white">5 Transaksi Terakhir</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400">Ringkasan aktivitas terbaru Anda</p>
            </div>
            <a href="{{ url('/member/buku-transaksi') }}" 
               class="inline-flex items-center gap-1 text-xs font-medium text-emerald-600 dark:text-emerald-400 hover:underline">
                Lihat Semua
                <x-heroicon-m-arrow-right class="w-3.5 h-3.5" />
            </a>
        </div>

        {{-- Table --}}
        @if($transactions->isEmpty())
            <div class="px-5 py-8 text-center text-sm text-gray-400 dark:text-gray-500">
                Belum ada transaksi.
            </div>
        @else
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/50 text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                        <th class="px-5 py-2 text-left font-medium">Tanggal</th>
                        <th class="px-5 py-2 text-left font-medium">Jenis</th>
                        <th class="px-5 py-2 text-right font-medium">Nominal</th>
                        <th class="px-5 py-2 text-center font-medium">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                    @foreach($transactions as $trx)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition-colors">
                            <td class="px-5 py-2.5 text-gray-600 dark:text-gray-300">
                                {{ \Carbon\Carbon::parse($trx->tanggal)->translatedFormat('d M Y') }}
                            </td>
                            <td class="px-5 py-2.5">
                                @php
                                    $jenisColor = match($trx->jenis) {
                                        'Simpanan' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
                                        'Penarikan' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400',
                                        'Pinjaman' => 'bg-sky-100 text-sky-700 dark:bg-sky-500/20 dark:text-sky-400',
                                        default => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300',
                                    };
                                @endphp
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $jenisColor }}">
                                    {{ $trx->jenis }}
                                </span>
                            </td>
                            <td class="px-5 py-2.5 text-right font-semibold {{ $trx->jenis === 'Penarikan' ? 'text-rose-600 dark:text-rose-400' : 'text-gray-900 dark:text-white' }}">
                                <x-koperasi.money :value="$trx->nominal" />
                            </td>
                            <td class="px-5 py-2.5 text-center">
                                @php
                                    $statusColor = match($trx->status) {
                                        'Diterima', 'Disetujui', 'Lunas' => 'bg-emerald-100 text-emerald-700 dark:bg-emerald-500/20 dark:text-emerald-400',
                                        'Menunggu', 'Menunggu Verifikasi' => 'bg-amber-100 text-amber-700 dark:bg-amber-500/20 dark:text-amber-400',
                                        'Ditolak' => 'bg-rose-100 text-rose-700 dark:bg-rose-500/20 dark:text-rose-400',
                                        default => 'bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-300',
                                    };
                                @endphp
                                <span class="inline-flex px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColor }}">
                                    {{ $trx->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-filament-widgets::widget>
