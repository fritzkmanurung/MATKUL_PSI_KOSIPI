<?php

namespace App\Filament\Resources\Penarikans\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;

class PenarikanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->label('Anggota yang Menarik Saldo'),
                Forms\Components\TextInput::make('nominal_penarikan')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->maxValue(9999999999),
                Forms\Components\DatePicker::make('tanggal_penarikan')
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'Menunggu' => 'Menunggu Verifikasi',
                        'Disetujui' => 'Disetujui',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->default('Menunggu')
                    ->required(),
                Forms\Components\FileUpload::make('bukti_penarikan')
                    ->image()
                    ->directory('bukti-penarikan')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('catatan_penolakan')
                    ->label('Catatan Penolakan (Jika ditolak)')
                    ->columnSpanFull(),
            ]);
    }
}
