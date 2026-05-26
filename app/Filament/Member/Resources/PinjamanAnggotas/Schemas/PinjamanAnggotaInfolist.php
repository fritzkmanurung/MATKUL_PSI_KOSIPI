<?php

namespace App\Filament\Member\Resources\PinjamanAnggotas\Schemas;

use Filament\Schemas\Schema;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class PinjamanAnggotaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                                    'Menunggu' => 'gray',
                                    'Menunggu Dokumen', 'Menunggu Verifikasi Dokumen' => 'info',
                                    'Disetujui', 'Lunas' => 'success',
                                    'Revisi', 'Ditolak Dokumen' => 'warning',
                                    'Ditolak' => 'danger',
                                    default => 'gray',
                                }),
                            TextEntry::make('tanggal_pinjaman')->label('Tanggal Pencairan')
                                ->date('d F Y')
                                ->placeholder('Belum dicairkan'),
                            TextEntry::make('alasan')->label('Alasan/Tujuan Meminjam')->columnSpanFull(),
                            TextEntry::make('catatan_penolakan')
                                ->label('Catatan dari Admin')
                                ->color('danger')
                                ->visible(fn ($record) => !is_null($record->catatan_penolakan))
                                ->columnSpanFull(),
                        ])
                    ]),

                Section::make('Dokumen & Bukti Pendukung')
                    ->icon('heroicon-o-document')
                    ->schema([
                        ImageEntry::make('dokumen_persetujuan_1')->label('Berkas Persetujuan 1')
                            ->columnSpan(1),
                        ImageEntry::make('dokumen_persetujuan_2')->label('Berkas Persetujuan 2')
                            ->columnSpan(1),
                        ImageEntry::make('bukti_transfer_admin')->label('Bukti Pencairan Dana')
                            ->columnSpan(1),
                    ])->columns(3),
            ]);
    }
}
