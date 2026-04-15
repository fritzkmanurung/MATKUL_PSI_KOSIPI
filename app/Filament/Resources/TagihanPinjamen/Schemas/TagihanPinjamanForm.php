<?php

namespace App\Filament\Resources\TagihanPinjamen\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;

class TagihanPinjamanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('pinjaman_id')
                    ->relationship('pinjaman', 'kode_pinjaman')
                    ->required()
                    ->disabled(), // Relasi tidak boleh diubah manual
                Forms\Components\TextInput::make('kode_tagihan')
                    ->required()
                    ->readonly(),
                Forms\Components\TextInput::make('tagihan_ke')
                    ->numeric()
                    ->readonly(),
                Forms\Components\DatePicker::make('jatuh_tempo')
                    ->required()
                    ->readonly(),
                Forms\Components\TextInput::make('total_tagihan')
                    ->numeric()
                    ->readonly(),
                Forms\Components\Select::make('status')
                    ->options([
                        'Belum Dibayar' => 'Belum Dibayar',
                        'Menunggu Verifikasi' => 'Menunggu Verifikasi (Transfer)',
                        'Lunas' => 'Lunas Pajak',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->required(),
                Forms\Components\FileUpload::make('bukti_bayar_transfer')
                    ->image()
                    ->directory('bukti-tagihan')
                    ->columnSpanFull(),
                Forms\Components\DatePicker::make('tanggal_bayar'),
                Forms\Components\Textarea::make('catatan_penolakan')
                    ->columnSpanFull(),
            ]);
    }
}
