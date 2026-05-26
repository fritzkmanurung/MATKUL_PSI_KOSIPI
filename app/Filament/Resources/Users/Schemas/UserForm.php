<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\FileUpload;
use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Kategori Form')
                    ->tabs([
                        Tabs\Tab::make('Akun & Akses')
                            ->icon('heroicon-o-lock-closed')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('name')
                                        ->label('Nama Lengkap')
                                        ->required(),
                                    TextInput::make('email')
                                        ->label('Email Address')
                                        ->email()
                                        ->required(),
                                    TextInput::make('password')
                                        ->label('Password')
                                        ->password()
                                        ->required()
                                        ->hiddenOn('edit'),
                                    DateTimePicker::make('email_verified_at')
                                        ->label('Waktu Verifikasi Email')
                                        ->default(now()),
                                    Select::make('roles')
                                        ->relationship('roles', 'name')
                                        ->multiple()
                                        ->preload()
                                        ->searchable()
                                        ->label('Pilih Hak Akses (Roles)')
                                        ->columnSpanFull(),
                                ])
                            ]),

                        Tabs\Tab::make('Profil Keanggotaan')
                            ->icon('heroicon-o-identification')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('member.nba')
                                        ->label('Nomor Baku Anggota (NBA)')
                                        ->placeholder('Otomatis jika kosong')
                                        ->unique('members', 'nba', ignoreRecord: true),
                                    DatePicker::make('member.tanggal_bergabung')
                                        ->label('Tanggal Bergabung')
                                        ->default(now()),
                                    FileUpload::make('member.foto_profil')
                                        ->label('Foto Profil')
                                        ->image()
                                        ->directory('member-photos')
                                        ->columnSpanFull(),
                                    TextInput::make('member.nik')
                                        ->label('NIK KTP')
                                        ->numeric()
                                        ->default(null),
                                    TextInput::make('member.no_hp')
                                        ->label('Nomor Handphone')
                                        ->tel()
                                        ->default(null),
                                    TextInput::make('member.tempat_lahir')
                                        ->label('Tempat Lahir')
                                        ->default(null),
                                    DatePicker::make('member.tanggal_lahir')
                                        ->label('Tanggal Lahir'),
                                    Select::make('member.jenis_kelamin')
                                        ->label('Jenis Kelamin')
                                        ->options(['L' => 'Laki-Laki', 'P' => 'Perempuan'])
                                        ->default(null),
                                    Select::make('member.agama_id')
                                        ->label('Agama')
                                        ->relationship('member.agama', 'nama')
                                        ->searchable()
                                        ->preload(),
                                    Select::make('member.status_perkawinan')
                                        ->label('Status Perkawinan')
                                        ->options([
                                            'Belum Kawin' => 'Belum Kawin',
                                            'Kawin' => 'Kawin',
                                            'Cerai Hidup' => 'Cerai Hidup',
                                            'Cerai Mati' => 'Cerai Mati',
                                        ])
                                        ->default(null),
                                    TextInput::make('member.nama_suami_istri')
                                        ->label('Nama Suami / Istri')
                                        ->default(null),
                                    Textarea::make('member.alamat')
                                        ->label('Alamat Lengkap (Domisili)')
                                        ->default(null)
                                        ->columnSpanFull(),
                                ])
                            ]),

                        Tabs\Tab::make('Pekerjaan')
                            ->icon('heroicon-o-briefcase')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('member.nip')
                                        ->label('NIP Pegawai')
                                        ->default(null),
                                    Select::make('member.instansi_id')
                                        ->label('Instansi Induk')
                                        ->relationship('member.instansi', 'nama')
                                        ->searchable()
                                        ->preload(),
                                    Select::make('member.unit_kerja_id')
                                        ->label('Unit Kerja')
                                        ->relationship('member.unitKerja', 'nama')
                                        ->searchable()
                                        ->preload(),
                                    Select::make('member.status_id')
                                        ->label('Status Kepegawaian')
                                        ->relationship('member.status', 'nama')
                                        ->searchable()
                                        ->preload(),
                                ]),
                            ]),

                        Tabs\Tab::make('Ahli Waris')
                            ->icon('heroicon-o-heart')
                            ->schema([
                                Grid::make(2)->schema([
                                    TextInput::make('member.nama_ahli_waris')
                                        ->label('Nama Ahli Waris'),
                                    TextInput::make('member.hubungan_ahli_waris')
                                        ->label('Hubungan Ahli Waris')
                                        ->placeholder('Contoh: Istri, Anak, Ibu'),
                                ]),
                            ]),

                        Tabs\Tab::make('Simpanan Awal')
                            ->icon('heroicon-o-banknotes')
                            ->schema([
                                \Filament\Forms\Components\Placeholder::make('simpanan_pokok')
                                    ->label('Simpanan Pokok')
                                    ->content('Nilai Simpanan Pokok akan otomatis diambil dari konfigurasi "Besaran Simpanan" yang aktif dan ditambahkan sebagai tagihan dengan status "Menunggu" saat anggota baru didaftarkan.'),
                            ])
                            ->hiddenOn('edit'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
