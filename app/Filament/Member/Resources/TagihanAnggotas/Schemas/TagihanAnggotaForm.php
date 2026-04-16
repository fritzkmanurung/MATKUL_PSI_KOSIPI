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
                            ->disabled(),
                        Forms\Components\TextInput::make('total_tagihan')
                            ->label('Total yang harus dibayar')
                            ->disabled()
                            ->prefix('Rp'),
                        Forms\Components\DatePicker::make('jatuh_tempo')
                            ->label('Batas Waktu Pembayaran')
                            ->disabled(),
                    ])->columns(['sm' => 1, 'md' => 3]),

                Section::make('Konfirmasi Pembayaran')
                    ->schema([
                        Forms\Components\FileUpload::make('bukti_bayar_transfer')
                            ->image()
                            ->directory('bukti-tagihan')
                            ->label('Unggah Bukti Transfer Bank')
                            ->required(),
                    ]),
            ]);
    }
}
