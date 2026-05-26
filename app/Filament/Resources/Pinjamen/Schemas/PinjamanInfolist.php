<?php

namespace App\Filament\Resources\Pinjamen\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class PinjamanInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Anggota Peminjam')
                    ->icon('heroicon-o-user')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('user.name')->label('Nama Lengkap'),
                            TextEntry::make('user.email')->label('Email'),
                            TextEntry::make('user.no_hp')->label('Nomor HP'),
                            
                            TextEntry::make('user.nik')->label('NIK KTP'),
                            TextEntry::make('user.nip')->label('NIP Pegawai'),
                            TextEntry::make('user.jenis_kelamin')->label('Jenis Kelamin')
                                ->formatStateUsing(fn ($state) => $state === 'L' ? 'Laki-Laki' : 'Perempuan'),
                            
                            TextEntry::make('user.instansi.nama')->label('Instansi'),
                            TextEntry::make('user.unitKerja.nama')->label('Unit Kerja'),
                            TextEntry::make('user.status.nama')->label('Status User'),

                            TextEntry::make('user.tempat_lahir')
                                ->label('Tempat Lahir')
                                ->formatStateUsing(fn ($state, $record) => $state . ', ' . ($record->user->tanggal_lahir ? \Carbon\Carbon::parse($record->user->tanggal_lahir)->translatedFormat('d F Y') : '-')),
                            
                            TextEntry::make('user.status_perkawinan')->label('Status Perkawinan'),
                            TextEntry::make('user.nama_suami_istri')->label('Nama Suami/Istri'),
                            
                            TextEntry::make('user.alamat')->label('Alamat Lengkap')->columnSpanFull(),
                        ])
                    ]),

                Section::make('Informasi Pengajuan Pinjaman')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        Grid::make(3)->schema([
                            TextEntry::make('kode_pinjaman')->label('Kode Pinjaman'),
                            TextEntry::make('jumlah_pinjaman')->label('Nominal Pinjaman')
                                ->money('IDR', locale: 'id'),
                            TextEntry::make('bunga_persen')->label('Bunga (%)')
                                ->suffix('%'),
                            TextEntry::make('tenor_bulan')->label('Lama Angsuran')
                                ->suffix(' Bulan'),
                            TextEntry::make('status_pegawai')->label('Status Pegawai Saat Pengajuan'),
                            TextEntry::make('masa_kontrak')->label('Masa Kontrak')
                                ->suffix(' Bulan')
                                ->default('-'),
                            TextEntry::make('pekerjaan')->label('Pekerjaan/Profesi'),
                            TextEntry::make('status')->label('Status Pengajuan')
                                ->badge()
                                ->color(fn (string $state): string => match ($state) {
                                    'Menunggu' => 'warning',
                                    'Ditolak' => 'danger',
                                    'Disetujui' => 'success',
                                    default => 'gray',
                                }),
                            TextEntry::make('alasan')->label('Alasan/Tujuan Meminjam')->columnSpanFull(),
                        ])
                    ]),

                Section::make('Dokumen & Bukti Pendukung')
                    ->icon('heroicon-o-document')
                    ->schema([
                        ImageEntry::make('dokumen_persetujuan_1')->label('Dokumen Persetujuan 1')
                            ->columnSpan(1),
                        ImageEntry::make('dokumen_persetujuan_2')->label('Dokumen Persetujuan 2')
                            ->columnSpan(1),
                        ImageEntry::make('bukti_transfer_admin')->label('Bukti Pencairan')
                            ->columnSpan(1),
                    ])->columns(3),
            ]);
    }
}
