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
                    ->disabled(fn (?\Illuminate\Database\Eloquent\Model $record) => $record !== null)
                    ->dehydrated()
                    ->label('Anggota yang Menarik Saldo'),
                Forms\Components\TextInput::make('nominal_penarikan')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled(fn (?\Illuminate\Database\Eloquent\Model $record) => $record !== null)
                    ->dehydrated()
                    ->maxValue(9999999999),
                Forms\Components\DatePicker::make('tanggal_penarikan')
                    ->default(now())
                    ->disabled(fn (?\Illuminate\Database\Eloquent\Model $record) => $record !== null)
                    ->dehydrated()
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'Menunggu' => 'Menunggu Verifikasi',
                        'Disetujui' => 'Disetujui',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->default('Menunggu')
                    ->required()
                    ->live(),
                Forms\Components\FileUpload::make('bukti_penarikan')
                    ->image()
                    ->directory('bukti-penarikan')
                    ->disabled(fn (?\Illuminate\Database\Eloquent\Model $record) => $record !== null)
                    ->dehydrated()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('catatan_penolakan')
                    ->label('Catatan Penolakan (Wajib diisi saat menolak)')
                    ->visible(fn ($get) => $get('status') === 'Ditolak')
                    ->columnSpanFull(),
            ]);
    }
}
