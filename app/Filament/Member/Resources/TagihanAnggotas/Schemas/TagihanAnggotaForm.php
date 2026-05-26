<?php

namespace App\Filament\Member\Resources\TagihanAnggotas\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class TagihanAnggotaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Rincian Tagihan')
                    ->schema([
                        Forms\Components\TextInput::make('kode_tagihan')
                            ->label('Nomor Tagihan')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('total_tagihan')
                            ->label('Total yang Harus Dibayar')
                            ->disabled()
                            ->dehydrated()
                            ->prefix('Rp'),
                        Forms\Components\DatePicker::make('jatuh_tempo')
                            ->label('Batas Waktu Pembayaran')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('status')
                            ->label('Status Saat Ini')
                            ->disabled()
                            ->dehydrated(),
                    ])->columns(['sm' => 1, 'md' => 2]),

                Section::make('Catatan Penolakan')
                    ->schema([
                        Forms\Components\Placeholder::make('catatan_penolakan_display')
                            ->label('Alasan Ditolak oleh Admin')
                            ->content(fn (?\Illuminate\Database\Eloquent\Model $record) => $record?->catatan_penolakan ?? '-'),
                    ])
                    ->visible(fn (?\Illuminate\Database\Eloquent\Model $record) => $record && $record->status === 'Ditolak')
                    ->columnSpanFull(),

                Section::make('Konfirmasi Pembayaran')
                    ->schema([
                        Forms\Components\FileUpload::make('bukti_bayar_transfer')
                            ->image()
                            ->directory('bukti-tagihan')
                            ->label('Unggah Bukti Transfer Bank')
                            ->required()
                            ->maxSize(2048),
                        Forms\Components\DatePicker::make('tanggal_bayar')
                            ->label('Tanggal Pembayaran')
                            ->default(now())
                            ->required()
                            ->live(),
                        Forms\Components\Placeholder::make('info_denda')
                            ->label('Informasi Tagihan')
                            ->content(function ($record, $get) {
                                if (!$record) return '-';
                                
                                // Set temporary date for calculation
                                $record->tanggal_bayar = $get('tanggal_bayar');
                                
                                $pokokBunga = (float) $record->total_tagihan;
                                $denda = (float) $record->hitung_denda;
                                $total = $pokokBunga + $denda;

                                if ($denda > 0) {
                                    return new \Illuminate\Support\HtmlString("
                                        <div class='text-sm space-y-1'>
                                            <div class='flex justify-between'><span>Cicilan (Pokok + Bunga):</span><span class='font-medium'>Rp" . number_format($pokokBunga, 0, ',', '.') . "</span></div>
                                            <div class='flex justify-between text-danger-600'><span>Denda ({$record->jumlah_hari_telat} Hari):</span><span class='font-medium'>+ Rp" . number_format($denda, 0, ',', '.') . "</span></div>
                                            <div class='flex justify-between pt-1 border-t font-bold'><span>Total Bayar:</span><span>Rp" . number_format($total, 0, ',', '.') . "</span></div>
                                        </div>
                                    ");
                                }
                                return "Total yang harus dibayar: Rp" . number_format($pokokBunga, 0, ',', '.');
                            }),
                    ])
                    ->visible(fn (?\Illuminate\Database\Eloquent\Model $record) => $record && in_array($record->status, ['Belum Dibayar', 'Ditolak'])),
            ]);
    }
}
