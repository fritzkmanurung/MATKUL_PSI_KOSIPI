<?php

namespace App\Filament\Resources\Simpanans\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;

class SimpananForm
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
                    ->label('Anggota Penyetor'),
                Forms\Components\Select::make('jenis_simpanan')
                    ->options([
                        'Wajib' => 'Simpanan Wajib',
                        'Sukarela' => 'Simpanan Sukarela',
                        'Pokok' => 'Simpanan Pokok',
                    ])
                    ->required(),
                Forms\Components\TextInput::make('nominal_simpanan')
                    ->required()
                    ->numeric()
                    ->prefix('Rp')
                    ->maxValue(9999999999),
                Forms\Components\DatePicker::make('waktu_simpanan')
                    ->default(now())
                    ->required(),
                Forms\Components\Select::make('status')
                    ->options([
                        'Menunggu' => 'Menunggu Verifikasi',
                        'Diterima' => 'Diterima',
                        'Ditolak' => 'Ditolak',
                    ])
                    ->default('Menunggu')
                    ->required(),
                Forms\Components\TextInput::make('jenis_pembayaran')
                    ->maxLength(50),
                Forms\Components\FileUpload::make('bukti_transfer')
                    ->image()
                    ->directory('bukti-simpanan')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('catatan_penolakan')
                    ->label('Catatan Penolakan (Jika ditolak)')
                    ->columnSpanFull(),
            ]);
    }
}
