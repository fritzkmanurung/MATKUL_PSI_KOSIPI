<x-filament-panels::page>
    <style>
        .buku-card {
            padding: 1.25rem;
            border-radius: 1rem;
            background-color: #ffffff;
            border: 1px solid rgba(0,0,0,0.04);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.03), 0 2px 4px -1px rgba(0, 0, 0, 0.02);
            transition: transform 0.2s ease, box-shadow 0.2s ease, border-color 0.2s ease;
        }
        .buku-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 20px -3px rgba(0, 0, 0, 0.08), 0 4px 6px -2px rgba(0, 0, 0, 0.04);
            border-color: rgba(0,0,0,0.08);
        }
        .dark .buku-card {
            background-color: #1f2937; /* gray-800 */
            border-color: rgba(255,255,255,0.05);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.2);
        }
        .dark .buku-card:hover {
            border-color: rgba(255,255,255,0.1);
            box-shadow: 0 12px 20px -3px rgba(0, 0, 0, 0.3);
        }

        .trx-row {
            border-bottom: 1px solid rgba(107,114,128,0.08);
            transition: background-color 0.15s ease;
        }
        .trx-row:hover {
            background-color: #f9fafb; /* gray-50 */
        }
        .dark .trx-row {
            border-color: rgba(255,255,255,0.05);
        }
        .dark .trx-row:hover {
            background-color: rgba(255,255,255,0.02);
        }
    </style>

    {{-- Ringkasan Saldo --}}
    <div class="fi-section rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10 p-6 mb-6" style="border: none; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);">
        <div class="flex items-center gap-2 mb-5">
            <div style="background: rgba(99,102,241,0.1); padding: 0.5rem; border-radius: 0.5rem;">
                <x-heroicon-o-wallet class="h-5 w-5" style="color: var(--primary-500);" />
            </div>
            <h3 class="text-lg font-bold text-gray-950 dark:text-white">Ringkasan Saldo</h3>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem;">
            {{-- Pokok --}}
            <div class="buku-card" style="border-left: 4px solid #6b7280;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                    <p style="font-size: 0.875rem; color: #6b7280; font-weight: 500;">Simpanan Pokok</p>
                    <x-heroicon-o-shield-check style="width: 1.25rem; height: 1.25rem; color: #9ca3af;" />
                </div>
                <p style="font-size: 1.5rem; font-weight: 800; color: var(--gray-800);" class="dark:text-gray-100">
                    <x-koperasi.money :value="$totalSimpanan?->total_simpanan_pokok ?? 0" />
                </p>
            </div>
            
            {{-- Wajib --}}
            <div class="buku-card" style="border-left: 4px solid #3b82f6;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                    <p style="font-size: 0.875rem; color: #3b82f6; font-weight: 500;">Simpanan Wajib</p>
                    <x-heroicon-o-calendar-days style="width: 1.25rem; height: 1.25rem; color: #93c5fd;" />
                </div>
                <p style="font-size: 1.5rem; font-weight: 800; color: var(--gray-800);" class="dark:text-gray-100">
                    <x-koperasi.money :value="$totalSimpanan?->total_simpanan_wajib ?? 0" />
                </p>
            </div>
            
            {{-- Sukarela --}}
            <div class="buku-card" style="border-left: 4px solid #22c55e;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                    <p style="font-size: 0.875rem; color: #22c55e; font-weight: 500;">Simpanan Sukarela</p>
                    <x-heroicon-o-sparkles style="width: 1.25rem; height: 1.25rem; color: #86efac;" />
                </div>
                <p style="font-size: 1.5rem; font-weight: 800; color: var(--gray-800);" class="dark:text-gray-100">
                    <x-koperasi.money :value="$totalSimpanan?->total_simpanan_sukarela ?? 0" />
                </p>
            </div>
            
            {{-- Total --}}
            <div class="buku-card" style="border-left: 4px solid var(--primary-500); background-color: rgba(99,102,241,0.03);">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 0.5rem;">
                    <p style="font-size: 0.875rem; color: var(--primary-600); font-weight: 600;">Total Saldo Bersih</p>
                    <x-heroicon-o-banknotes style="width: 1.25rem; height: 1.25rem; color: var(--primary-400);" />
                </div>
                <p style="font-size: 1.75rem; font-weight: 900; color: var(--primary-600);">
                    <x-koperasi.money :value="$totalSimpanan?->total_simpanan ?? 0" />
                </p>
            </div>
        </div>
    </div>

    {{-- Arus Kas --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        {{-- Dana Masuk --}}
        <div class="buku-card" style="display: flex; align-items: center; gap: 1.25rem; padding: 1.5rem;">
            <div style="width: 3.5rem; height: 3.5rem; border-radius: 1rem; background: rgba(34,197,94,0.1); display: flex; align-items: center; justify-content: center; box-shadow: inset 0 0 0 1px rgba(34,197,94,0.2);">
                <x-heroicon-o-arrow-down-circle style="width: 2rem; height: 2rem; color: #22c55e;" />
            </div>
            <div>
                <p style="font-size: 0.875rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Total Dana Masuk</p>
                <p style="font-size: 1.5rem; font-weight: 800; color: #16a34a; margin-top: 0.25rem;">
                    <x-koperasi.money :value="$totalMasuk" />
                </p>
            </div>
        </div>
        
        {{-- Dana Keluar --}}
        <div class="buku-card" style="display: flex; align-items: center; gap: 1.25rem; padding: 1.5rem;">
            <div style="width: 3.5rem; height: 3.5rem; border-radius: 1rem; background: rgba(239,68,68,0.1); display: flex; align-items: center; justify-content: center; box-shadow: inset 0 0 0 1px rgba(239,68,68,0.2);">
                <x-heroicon-o-arrow-up-circle style="width: 2rem; height: 2rem; color: #ef4444;" />
            </div>
            <div>
                <p style="font-size: 0.875rem; color: #6b7280; font-weight: 600; text-transform: uppercase; letter-spacing: 0.05em;">Total Dana Keluar</p>
                <p style="font-size: 1.5rem; font-weight: 800; color: #dc2626; margin-top: 0.25rem;">
                    <x-koperasi.money :value="$totalKeluar" />
                </p>
            </div>
        </div>
    </div>

    {{-- Tabel Riwayat --}}
    <div class="fi-section rounded-2xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10" style="overflow: hidden; box-shadow: 0 10px 15px -3px rgba(0,0,0,0.05);">
        <div style="padding: 1.5rem; border-bottom: 1px solid rgba(107,114,128,0.1); background-color: #fafafa;" class="dark:bg-gray-800/50">
            <div style="display: flex; align-items: center; gap: 0.75rem;">
                <div style="background: var(--primary-500); padding: 0.5rem; border-radius: 0.5rem; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
                    <x-heroicon-o-clipboard-document-list style="width: 1.25rem; height: 1.25rem; color: #ffffff;" />
                </div>
                <div>
                    <h3 style="font-size: 1.125rem; font-weight: 700;" class="text-gray-950 dark:text-white">Buku Transaksi Anggota</h3>
                    <p style="margin-top: 0.125rem; font-size: 0.875rem; color: #6b7280;">Rekam jejak seluruh mutasi finansial yang telah diverifikasi.</p>
                </div>
            </div>
        </div>

        @if($transaksi->count() > 0)
            <div style="overflow-x: auto;">
                <table style="width: 100%; font-size: 0.875rem; border-collapse: collapse;">
                    <thead>
                        <tr style="border-bottom: 2px solid rgba(107,114,128,0.1); background: #ffffff;" class="dark:bg-gray-900">
                            <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280;">Tanggal</th>
                            <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280;">Keterangan</th>
                            <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #6b7280;">Kategori</th>
                            <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #16a34a;">Masuk (Rp)</th>
                            <th style="padding: 1rem 1.5rem; text-align: right; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #dc2626;">Keluar (Rp)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksi as $trx)
                            @php
                                $colors = [
                                    'success' => ['bg' => '#dcfce7', 'text' => '#15803d', 'ring' => '#bbf7d0'],
                                    'danger'  => ['bg' => '#fee2e2', 'text' => '#b91c1c', 'ring' => '#fecaca'],
                                    'info'    => ['bg' => '#dbeafe', 'text' => '#1d4ed8', 'ring' => '#bfdbfe'],
                                    'warning' => ['bg' => '#fef3c7', 'text' => '#b45309', 'ring' => '#fde68a'],
                                ];
                                $c = $colors[$trx['color']] ?? $colors['info'];
                            @endphp
                            <tr class="trx-row">
                                <td style="padding: 1rem 1.5rem; white-space: nowrap; color: #4b5563; font-weight: 500;" class="dark:text-gray-300">
                                    {{ \Carbon\Carbon::parse($trx['tanggal'])->translatedFormat('d M Y') }}
                                </td>
                                <td style="padding: 1rem 1.5rem;">
                                    <div style="display: flex; align-items: center; gap: 0.75rem;">
                                        <div style="width: 2.25rem; height: 2.25rem; border-radius: 50%; background: {{ $c['bg'] }}; display: flex; align-items: center; justify-content: center; flex-shrink: 0; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                                            @if($trx['icon'] === 'arrow-down-circle')
                                                <x-heroicon-s-arrow-down-circle style="width: 1.25rem; height: 1.25rem; color: {{ $c['text'] }};" />
                                            @elseif($trx['icon'] === 'arrow-up-circle')
                                                <x-heroicon-s-arrow-up-circle style="width: 1.25rem; height: 1.25rem; color: {{ $c['text'] }};" />
                                            @elseif($trx['icon'] === 'banknotes')
                                                <x-heroicon-s-banknotes style="width: 1.25rem; height: 1.25rem; color: {{ $c['text'] }};" />
                                            @endif
                                        </div>
                                        <div>
                                            <span style="font-weight: 600; display: block;" class="text-gray-900 dark:text-gray-100">{{ $trx['keterangan'] }}</span>
                                            <span style="font-size: 0.75rem; color: #9ca3af; display: block; margin-top: 0.125rem;">ID: {{ strtoupper(substr(md5($trx['tanggal'].$trx['keterangan']), 0, 8)) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: center; white-space: nowrap;">
                                    <span style="display: inline-flex; align-items: center; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 600; background: {{ $c['bg'] }}; color: {{ $c['text'] }}; box-shadow: inset 0 0 0 1px {{ $c['ring'] }};">
                                        {{ $trx['jenis'] }}
                                    </span>
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right; white-space: nowrap; font-weight: 700; color: #16a34a;">
                                    @if($trx['masuk'] > 0)
                                        + {{ number_format($trx['masuk'], 0, ',', '.') }}
                                    @else
                                        <span style="color: #e5e7eb;">-</span>
                                    @endif
                                </td>
                                <td style="padding: 1rem 1.5rem; text-align: right; white-space: nowrap; font-weight: 700; color: #dc2626;">
                                    @if($trx['keluar'] > 0)
                                        - {{ number_format($trx['keluar'], 0, ',', '.') }}
                                    @else
                                        <span style="color: #e5e7eb;">-</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div style="display: flex; flex-direction: column; align-items: center; justify-content: center; padding: 5rem 1rem; text-align: center; background-color: #f8fafc;" class="dark:bg-gray-800/20">
                <div style="width: 4rem; height: 4rem; border-radius: 50%; background-color: #f1f5f9; display: flex; align-items: center; justify-content: center; margin-bottom: 1rem; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);" class="dark:bg-gray-800">
                    <x-heroicon-o-document-text style="width: 2rem; height: 2rem; color: #94a3b8;" />
                </div>
                <p style="font-size: 1rem; font-weight: 600; color: #475569;" class="dark:text-gray-300">Belum ada mutasi keuangan</p>
                <p style="font-size: 0.875rem; color: #94a3b8; margin-top: 0.25rem; max-width: 300px;">Setiap transaksi yang telah diverifikasi oleh admin akan otomatis tercatat di sini.</p>
            </div>
        @endif
    </div>
</x-filament-panels::page>
