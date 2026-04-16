<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('nip')
                    ->default(null),
                TextInput::make('nik')
                    ->default(null),
                TextInput::make('name')
                    ->required(),
                TextInput::make('email')
                    ->label('Email address')
                    ->email()
                    ->required(),
                Select::make('jenis_kelamin')
                    ->options(['L' => 'L', 'P' => 'P'])
                    ->default(null),
                TextInput::make('tempat_lahir')
                    ->default(null),
                DatePicker::make('tanggal_lahir'),
                Textarea::make('alamat')
                    ->default(null)
                    ->columnSpanFull(),
                TextInput::make('no_hp')
                    ->default(null),
                DateTimePicker::make('email_verified_at'),
                TextInput::make('password')
                    ->password()
                    ->required()
                    ->hiddenOn('edit'),
                Select::make('agama_id')
                    ->relationship('agama', 'nama')
                    ->searchable()
                    ->preload(),
                Select::make('unit_kerja_id')
                    ->relationship('unitKerja', 'nama')
                    ->searchable()
                    ->preload(),
                Select::make('instansi_id')
                    ->relationship('instansi', 'nama')
                    ->searchable()
                    ->preload(),
                Select::make('status_id')
                    ->relationship('status', 'nama')
                    ->searchable()
                    ->preload(),
                Select::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->searchable()
                    ->label('Hak Akses (Roles)'),
                
                // --- Fields Data Diri ---
                TextInput::make('pekerjaan')
                    ->label('Pekerjaan')
                    ->default(null),
                Select::make('status_pegawai')
                    ->label('Status Pegawai')
                    ->options([
                        'PNS' => 'PNS',
                        'PPPK' => 'PPPK',
                        'Honorer' => 'Honorer',
                        'Swasta' => 'Swasta',
                        'Wiraswasta' => 'Wiraswasta',
                        'Lainnya' => 'Lainnya',
                    ])
                    ->default(null),
                TextInput::make('masa_kontrak')
                    ->label('Masa Kontrak (Bulan)')
                    ->numeric()
                    ->default(null),
                Select::make('status_perkawinan')
                    ->label('Status Perkawinan')
                    ->options([
                        'Belum Kawin' => 'Belum Kawin',
                        'Kawin' => 'Kawin',
                        'Cerai Hidup' => 'Cerai Hidup',
                        'Cerai Mati' => 'Cerai Mati',
                    ])
                    ->default(null),
                TextInput::make('nama_suami_istri')
                    ->label('Nama Suami/Istri')
                    ->default(null),

                // --- Input Simpanan Pokok (Hanya saat Create) ---
                TextInput::make('simpanan_pokok')
                    ->label('Simpanan Pokok Awal')
                    ->numeric()
                    ->prefix('Rp')
                    ->dehydrated(true)
                    ->hiddenOn('edit')
                    ->helperText('Otomatis membuat record Simpanan Pokok (Diterima)'),

            ])->columns(3);
    }
}
