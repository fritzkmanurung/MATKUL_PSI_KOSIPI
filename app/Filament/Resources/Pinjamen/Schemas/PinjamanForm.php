<?php

namespace App\Filament\Resources\Pinjamen\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Modules\Sistem\Models\Bunga;

class PinjamanForm
{
    public static function configure(Schema $schema): Schema
    {
        $bungaAktif = Bunga::getAktif();

        return $schema
            ->components([
                Section::make('Syarat Pengajuan Kredit')
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(fn (?\Illuminate\Database\Eloquent\Model $record) => $record !== null)
                            ->dehydrated()
                            ->label('Anggota Peminjam'),
                        Forms\Components\TextInput::make('kode_pinjaman')
                            ->default(fn () => 'PNJ-' . date('Ymd') . '-' . rand(1000, 9999))
                            ->readonly()
                            ->required()
                            ->dehydrated(),
                        Forms\Components\TextInput::make('jumlah_pinjaman')
                            ->required()
                            ->numeric()
                            ->disabled(fn (?\Illuminate\Database\Eloquent\Model $record) => $record !== null)
                            ->dehydrated()
                            ->prefix('Rp'),
                        Forms\Components\Placeholder::make('bunga_info')
                            ->label('Bunga yang Berlaku')
                            ->content(fn (?\Illuminate\Database\Eloquent\Model $record) => $record
                                ? $record->bunga_persen . '%'
                                : ($bungaAktif
                                    ? $bungaAktif->nama . ' (' . $bungaAktif->nilai_persen . '%)'
                                    : 'Belum ada bunga aktif. Atur di menu Bunga.')),
                        Forms\Components\Hidden::make('bunga_persen')
                            ->default($bungaAktif?->nilai_persen)
                            ->dehydrated(),
                        Forms\Components\TextInput::make('alasan')
                            ->required()
                            ->disabled(fn (?\Illuminate\Database\Eloquent\Model $record) => $record !== null)
                            ->dehydrated()
                            ->columnSpanFull(),
                    ])->columns(2),

                Section::make('Profil Kreditur')
                    ->schema([
                        Forms\Components\Select::make('status_pegawai')
                            ->options(['Kontrak' => 'Kontrak', 'Tetap' => 'Tetap'])
                            ->required()
                            ->disabled(fn (?\Illuminate\Database\Eloquent\Model $record) => $record !== null)
                            ->dehydrated()
                            ->live(),
                        Forms\Components\TextInput::make('masa_kontrak')
                            ->numeric()
                            ->label('Masa Kontrak (Bulan)')
                            ->required(fn ($get) => $get('status_pegawai') === 'Kontrak')
                            ->visible(fn ($get) => $get('status_pegawai') === 'Kontrak')
                            ->disabled(fn (?\Illuminate\Database\Eloquent\Model $record) => $record !== null)
                            ->dehydrated()
                            ->minValue(2)
                            ->suffix('Bulan')
                            ->live(),
                        Forms\Components\TextInput::make('tenor_bulan')
                            ->required()
                            ->numeric()
                            ->disabled(fn (?\Illuminate\Database\Eloquent\Model $record) => $record !== null)
                            ->dehydrated()
                            ->suffix('Bulan')
                            ->label('Lama Angsuran')
                            ->minValue(1)
                            ->maxValue(function ($get) {
                                $status = $get('status_pegawai');
                                $masaKontrak = (int) $get('masa_kontrak');

                                if ($status === 'Tetap') {
                                    return 24;
                                }

                                if ($status === 'Kontrak' && $masaKontrak > 0) {
                                    return min($masaKontrak - 1, 24);
                                }

                                return 24;
                            })
                            ->helperText(function ($get) {
                                $status = $get('status_pegawai');
                                $masaKontrak = (int) $get('masa_kontrak');

                                if ($status === 'Tetap') {
                                    return 'Pegawai Tetap: maksimal 24 bulan.';
                                }

                                if ($status === 'Kontrak' && $masaKontrak > 0) {
                                    $max = min($masaKontrak - 1, 24);
                                    return "Pegawai Kontrak ({$masaKontrak} bulan): maksimal {$max} bulan.";
                                }

                                return 'Pilih status pegawai terlebih dahulu.';
                            })
                            ->live(),
                        Forms\Components\TextInput::make('pekerjaan')
                            ->required()
                            ->disabled(fn (?\Illuminate\Database\Eloquent\Model $record) => $record !== null)
                            ->dehydrated(),
                    ])->columns(2),

                Section::make('Dokumen Persetujuan Anggota')
                    ->schema([
                        Forms\Components\FileUpload::make('dokumen_persetujuan_1')
                            ->label('Dokumen Persetujuan 1')
                            ->directory('dokumen-pinjaman')
                            ->disabled()
                            ->dehydrated(),
                        Forms\Components\FileUpload::make('dokumen_persetujuan_2')
                            ->label('Dokumen Persetujuan 2')
                            ->directory('dokumen-pinjaman')
                            ->disabled()
                            ->dehydrated(),
                    ])->columns(2),

                Section::make('Persetujuan & Verifikasi Admin')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'Menunggu' => 'Menunggu Verifikasi',
                                'Menunggu Dokumen' => 'Menunggu Dokumen (Disetujui Awal)',
                                'Menunggu Verifikasi Dokumen' => 'Menunggu Verifikasi Dokumen',
                                'Ditolak' => 'Ditolak',
                                'Ditolak Dokumen' => 'Ditolak Dokumen (Perbaiki)',
                                'Disetujui' => 'Disetujui (Dana Dicairkan)',
                                'Lunas' => 'Lunas',
                            ])
                            ->default('Menunggu')
                            ->required()
                            ->live(),
                        Forms\Components\DatePicker::make('tanggal_pinjaman')
                            ->label('Tanggal Pencairan')
                            ->visible(fn ($get) => in_array($get('status'), ['Disetujui', 'Lunas'])),
                        Forms\Components\FileUpload::make('bukti_transfer_admin')
                            ->label('Bukti Transfer Pencairan Dana')
                            ->image()
                            ->directory('bukti-pencairan-pinjaman')
                            ->visible(fn ($get) => in_array($get('status'), ['Disetujui', 'Lunas'])),
                        Forms\Components\Textarea::make('catatan_penolakan')
                            ->label('Keterangan Penolakan')
                            ->visible(fn ($get) => in_array($get('status'), ['Ditolak', 'Ditolak Dokumen']))
                            ->columnSpanFull(),
                    ])->columns(2),
            ]);
    }
}
