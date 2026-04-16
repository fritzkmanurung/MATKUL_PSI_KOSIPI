<?php

namespace App\Filament\Resources\Pinjamen\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;

class PinjamanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Syarat Pengajuan Kredit')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Anggota Peminjam'),
                        Forms\Components\TextInput::make('kode_pinjaman')
                            ->default(fn () => 'PNJ-' . date('Ymd') . '-' . rand(1000, 9999))
                            ->readonly()
                            ->required(),
                        Forms\Components\TextInput::make('jumlah_pinjaman')
                            ->required()
                            ->numeric()
                            ->prefix('Rp'),
                        Forms\Components\Select::make('bunga_persen')
                            ->label('Pilih Bunga')
                            ->options(\Modules\Sistem\Models\Bunga::pluck('nama', 'nilai_persen')->mapWithKeys(function ($item, $key) {
                                return [$key => $item . ' (' . $key . '%)'];
                            }))
                            ->required(),
                        Forms\Components\TextInput::make('tenor_bulan')
                            ->required()
                            ->numeric()
                            ->suffix('Bulan'),
                        Forms\Components\TextInput::make('alasan')
                            ->required()
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Profil Kreditur')
                    ->schema([
                        Forms\Components\Select::make('status_pegawai')
                            ->options(['Kontrak' => 'Kontrak', 'Tetap' => 'Tetap'])
                            ->required(),
                        Forms\Components\TextInput::make('masa_kontrak')
                            ->numeric()
                            ->suffix('Bulan'),
                        Forms\Components\Select::make('status_perkawinan')
                            ->options(['Belum Kawin' => 'Belum Kawin', 'Sudah Kawin' => 'Sudah Kawin'])
                            ->required(),
                        Forms\Components\TextInput::make('nama_suami_istri'),
                        Forms\Components\TextInput::make('pekerjaan')
                            ->required(),
                    ])->columns(2),

                Section::make('Persetujuan Admin')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'Menunggu' => 'Menunggu Verifikasi',
                                'Disetujui' => 'Disetujui (Berjalan)',
                                'Ditolak' => 'Ditolak',
                                'Lunas' => 'Lunas',
                            ])
                            ->default('Menunggu')
                            ->required(),
                        Forms\Components\Textarea::make('catatan_penolakan')
                            ->columnSpanFull(),
                    ])->columns(1),
            ]);
    }
}
