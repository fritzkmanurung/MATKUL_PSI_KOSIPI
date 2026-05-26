<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                \Filament\Schemas\Components\Grid::make(['default' => 1, 'lg' => 3])
                    ->schema([
                        // KOLOM 1: IDENTITAS & FOTO
                        \Filament\Schemas\Components\Section::make('Identitas Anggota')
                            ->icon('heroicon-o-user')
                            ->columnSpan(1)
                            ->schema([
                                ImageEntry::make('member.foto_profil')
                                    ->label('Foto Profil')
                                    ->circular(),
                                TextEntry::make('member.nba')
                                    ->label('No. Baku Anggota (NBA)')
                                    ->weight('bold')
                                    ->color('primary'),
                                TextEntry::make('name')
                                    ->label('Nama Lengkap'),
                                TextEntry::make('email')
                                    ->icon('heroicon-m-envelope'),
                                TextEntry::make('member.no_hp')
                                    ->label('No. Handphone')
                                    ->icon('heroicon-m-phone'),
                                TextEntry::make('member.tanggal_bergabung')
                                    ->label('Tanggal Bergabung')
                                    ->date('d M Y'),
                            ]),

                        // KOLOM 2: PEKERJAAN & STATUS
                        \Filament\Schemas\Components\Section::make('Pekerjaan & Relasi')
                            ->icon('heroicon-o-briefcase')
                            ->columnSpan(1)
                            ->schema([
                                TextEntry::make('member.nip')
                                    ->label('NIP Pegawai'),
                                TextEntry::make('member.unitKerja.nama')
                                    ->label('Unit Kerja'),
                                TextEntry::make('member.instansi.nama')
                                    ->label('Instansi'),
                                TextEntry::make('member.status.nama')
                                    ->label('Status Kepegawaian')
                                    ->badge()
                                    ->color('warning'),
                                TextEntry::make('member.jenis_kelamin')
                                    ->label('Jenis Kelamin')
                                    ->formatStateUsing(fn ($state) => $state === 'L' ? 'Laki-Laki' : 'Perempuan')
                                    ->badge(),
                                TextEntry::make('member.agama.nama')
                                    ->label('Agama'),
                            ]),

                        // KOLOM 3: BIODATA & AHLI WARIS
                        \Filament\Schemas\Components\Section::make('Biodata & Ahli Waris')
                            ->icon('heroicon-o-heart')
                            ->columnSpan(1)
                            ->schema([
                                TextEntry::make('member.nik')
                                    ->label('NIK KTP'),
                                TextEntry::make('member.status_perkawinan')
                                    ->label('Status Perkawinan'),
                                TextEntry::make('member.tempat_lahir')
                                    ->label('Tempat, Tgl Lahir')
                                    ->state(fn ($record) => ($record->member?->tempat_lahir ?? '-') . ', ' . ($record->member?->tanggal_lahir?->format('d M Y') ?? '-')),
                                TextEntry::make('member.alamat')
                                    ->label('Alamat Lengkap')
                                    ->markdown(),
                                \Filament\Infolists\Components\Grid::make(1)
                                    ->schema([
                                        TextEntry::make('member.nama_ahli_waris')
                                            ->label('Nama Ahli Waris')
                                            ->weight('bold'),
                                        TextEntry::make('member.hubungan_ahli_waris')
                                            ->label('Hubungan'),
                                    ])->visible(fn ($record) => !empty($record->member?->nama_ahli_waris)),
                            ]),
                    ]),
            ]);
    }
}
