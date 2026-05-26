<?php

namespace App\Filament\Member\Resources\PinjamanAnggotas\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Grid;
use Modules\Sistem\Models\Bunga;

class PinjamanAnggotaForm
{
    public static function configure(Schema $schema): Schema
    {
        $bungaAktif = Bunga::getAktif();
        $config = config('koperasi.pinjaman');

        return $schema
            ->components([
                Section::make('Catatan Admin')
                    ->schema([
                        Forms\Components\Placeholder::make('catatan_penolakan_display')
                            ->label('Pesan dari Admin')
                            ->content(fn (?\Illuminate\Database\Eloquent\Model $record) => $record?->catatan_penolakan ?? '-'),
                    ])
                    ->visible(fn (?\Illuminate\Database\Eloquent\Model $record) => $record && !empty($record->catatan_penolakan) && in_array($record->status, ['Ditolak', 'Ditolak Dokumen', 'Revisi']))
                    ->columnSpanFull(),

                Grid::make(['default' => 1, 'md' => 2])
                    ->columnSpanFull()
                    ->schema([
                        Section::make('Data Anggota (Informasi)')
                            ->id('kolom-kiri')
                            ->schema([
                                        Forms\Components\TextInput::make('user_name')
                                            ->label('Nama Lengkap')
                                            ->formatStateUsing(fn () => auth()->user()?->name)
                                            ->disabled()
                                            ->dehydrated(false),
                                        Forms\Components\TextInput::make('user_nip')
                                            ->label('NIP')
                                            ->formatStateUsing(fn () => auth()->user()?->member?->nip)
                                            ->disabled()
                                            ->dehydrated(false),
                                        Forms\Components\TextInput::make('user_nik')
                                            ->label('NIK')
                                            ->formatStateUsing(fn () => auth()->user()?->member?->nik)
                                            ->disabled()
                                            ->dehydrated(false),
                                        Forms\Components\TextInput::make('user_jk')
                                            ->label('Jenis Kelamin')
                                            ->formatStateUsing(fn () => auth()->user()?->member?->jenis_kelamin === 'L' ? 'Laki-Laki' : (auth()->user()?->member?->jenis_kelamin === 'P' ? 'Perempuan' : '-'))
                                            ->disabled()
                                            ->dehydrated(false),
                                        Forms\Components\TextInput::make('user_ttl')
                                            ->label('Tempat, Tanggal Lahir')
                                            ->formatStateUsing(function () {
                                                $member = auth()->user()?->member;
                                                $tempat = $member?->tempat_lahir ?? '-';
                                                $tanggal = $member?->tanggal_lahir ? \Carbon\Carbon::parse($member->tanggal_lahir)->translatedFormat('d F Y') : '-';
                                                return $tempat . ', ' . $tanggal;
                                            })
                                            ->disabled()
                                            ->dehydrated(false),
                                        Forms\Components\TextInput::make('user_hp')
                                            ->label('No. HP / WA')
                                            ->formatStateUsing(fn () => auth()->user()?->member?->no_hp)
                                            ->disabled()
                                            ->dehydrated(false),
                                        Forms\Components\TextInput::make('user_instansi')
                                            ->label('Instansi Induk')
                                            ->formatStateUsing(fn () => auth()->user()?->member?->instansi?->nama ?? '-')
                                            ->disabled()
                                            ->dehydrated(false),
                                        Forms\Components\TextInput::make('user_unit_kerja')
                                            ->label('Unit Kerja')
                                            ->formatStateUsing(fn () => auth()->user()?->member?->unitKerja?->nama ?? '-')
                                            ->disabled()
                                            ->dehydrated(false),
                                        Forms\Components\Textarea::make('user_alamat')
                                            ->label('Alamat Lengkap')
                                            ->formatStateUsing(fn () => auth()->user()?->member?->alamat)
                                            ->disabled()
                                            ->dehydrated(false)
                                            ->rows(5)
                                            ->columnSpanFull(),
                                    ])
                                    ->columns(2)
                                    ->columnSpan(['default' => 1, 'md' => 1])
                                    ->extraAttributes(['class' => 'h-full']),

                        Grid::make(1)
                            ->schema([
                                Section::make('Informasi Limit Pinjaman')
                                    ->schema([
                                        Forms\Components\ViewField::make('limit_info')
                                            ->label('')
                                            ->view('filament.member.loan-limit-info')
                                            ->viewData(function () {
                                                $userId = auth()->id();
                                                $limit = \Modules\Pinjaman\Models\Pinjaman::getLimitPinjaman($userId);
                                                $tunggakan = \Modules\Pinjaman\Models\Pinjaman::hasTunggakan($userId);

                                                return [
                                                    'saldo' => $limit['saldo_pribadi'],
                                                    'limitPribadi' => $limit['limit_pribadi'],
                                                    'limitLikuiditas' => $limit['limit_likuiditas'],
                                                    'limitFinal' => $limit['limit_final'],
                                                    'tunggakan' => $tunggakan,
                                                ];
                                            }),
                                    ])
                                    ->collapsible(),

                                Section::make('Syarat Pengajuan Kredit')
                                    ->schema([
                                        Grid::make(1)
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        Forms\Components\TextInput::make('kode_pinjaman')
                                                            ->default(fn () => 'PNJ-' . date('Ymd') . '-' . rand(1000, 9999))
                                                            ->readonly()
                                                            ->required()
                                                            ->dehydrated(),
                                                        Forms\Components\TextInput::make('jumlah_pinjaman')
                                                            ->required()
                                                            ->numeric()
                                                            ->prefix('Rp')
                                                            ->label('Nominal Pinjaman (Rp)')
                                            ->maxValue(function () {
                                                $limit = \Modules\Pinjaman\Models\Pinjaman::getLimitPinjaman(auth()->id());
                                                return $limit['limit_final'];
                                            })
                                            ->minValue(1)
                                                            ->helperText(function () use ($bungaAktif) {
                                                                $limit = \Modules\Pinjaman\Models\Pinjaman::getLimitPinjaman(auth()->id());
                                                                $maxFormatted = \App\Filament\Support\MoneyFormatter::format($limit['limit_final']);
                                                                $bungaText = $bungaAktif
                                                                    ? '✅ Bunga: ' . $bungaAktif->nilai_persen . '% '
                                                                    : '<span class="text-danger-500">Belum ada bunga aktif.</span> ';
                                                                return new \Illuminate\Support\HtmlString('<span class="text-xs italic text-gray-400">' . $bungaText . '| Maks: ' . $maxFormatted . '</span>');
                                                            }),
                                                    ]),
                                                Forms\Components\Hidden::make('bunga_persen')
                                                    ->default($bungaAktif?->nilai_persen)
                                                    ->dehydrated(),
                                                Forms\Components\Textarea::make('alasan')
                                                    ->required()
                                                    ->label('Alasan/Tujuan Meminjam')
                                                    ->rows(2),
                                            ]),
                                    ])->columns(1),
                                    
                                Section::make('Profil Kreditur (Data Diri)')
                                    ->schema([
                                        Forms\Components\TextInput::make('pekerjaan')
                                            ->required()
                                            ->maxLength(100),
                                        Forms\Components\Select::make('status_pegawai')
                                            ->options(['Kontrak' => 'Kontrak', 'Tetap' => 'Tetap'])
                                            ->required()
                                            ->live(),
                                        Forms\Components\TextInput::make('masa_kontrak')
                                            ->numeric()
                                            ->label('Masa Kontrak (Bulan)')
                                            ->required(fn ($get) => $get('status_pegawai') === 'Kontrak')
                                            ->visible(fn ($get) => $get('status_pegawai') === 'Kontrak')
                                            ->minValue($config['min_masa_kontrak'])
                                            ->live(),
                                        Forms\Components\TextInput::make('tenor_bulan')
                                            ->required()
                                            ->numeric()
                                            ->suffix('Bulan')
                                            ->label('Lama Angsuran (Bulan)')
                                            ->minValue(1)
                                            ->maxValue(function ($get) use ($config) {
                                                $status = $get('status_pegawai');
                                                $masaKontrak = (int) $get('masa_kontrak');
                                                $maxTenor = $config['max_tenor_tetap'];

                                                if ($status === 'Tetap') {
                                                    return $maxTenor;
                                                }

                                                if ($status === 'Kontrak' && $masaKontrak > 0) {
                                                    return min($masaKontrak - 1, $maxTenor);
                                                }

                                                return $maxTenor;
                                            })
                                            ->helperText(function ($get) use ($config) {
                                                $status = $get('status_pegawai');
                                                $masaKontrak = (int) $get('masa_kontrak');
                                                $maxTenor = $config['max_tenor_tetap'];
                                                $msg = '';

                                                if ($status === 'Tetap') {
                                                    $msg = "Pegawai Tetap: maksimal {$maxTenor} bulan.";
                                                } elseif ($status === 'Kontrak' && $masaKontrak > 0) {
                                                    $max = min($masaKontrak - 1, $maxTenor);
                                                    $msg = "Pegawai Kontrak ({$masaKontrak} bulan): maksimal {$max} bulan.";
                                                } else {
                                                    $msg = '*Pilih status pegawai terlebih dahulu.';
                                                }
                                                
                                                return new \Illuminate\Support\HtmlString('<span class="text-[0.7rem] text-gray-500 max-w-full leading-tight block mt-1 italic">' . $msg . '</span>');
                                            })
                                            ->live(),
                                    ])->columns(2),
                            ])->columnSpan(['default' => 1, 'md' => 1]),
                    ]),

                Section::make('Dokumen Persetujuan')
                    ->description('Silakan lengkapi dan upload dokumen persetujuan setelah pengajuan tahap awal disetujui oleh admin.')
                    ->schema([
                        Forms\Components\FileUpload::make('dokumen_persetujuan_1')
                            ->label('Upload Dokumen Persetujuan 1')
                            ->directory('dokumen-pinjaman')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(2048),
                        Forms\Components\FileUpload::make('dokumen_persetujuan_2')
                            ->label('Upload Dokumen Persetujuan 2')
                            ->directory('dokumen-pinjaman')
                            ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png'])
                            ->maxSize(2048),
                    ])
                    ->visible(fn (?string $operation, ?\Illuminate\Database\Eloquent\Model $record) => $operation === 'edit' && $record && in_array($record->status, ['Menunggu Dokumen', 'Ditolak Dokumen']))
                    ->columnSpanFull(),
            ]);
    }
}
