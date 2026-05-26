<?php

namespace App\Filament\Resources\Simpanans\Schemas;

use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SimpananInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Grid::make(['default' => 1, 'md' => 2])
                    ->columnSpan('full')
                    ->schema([
                        // LEFT SIDE - Data (50% width)
                        Group::make([
                            Section::make('Informasi Simpanan')
                                ->icon('heroicon-o-wallet')
                                ->schema([
                                    TextEntry::make('user.name')
                                        ->label('Anggota Penyetor')
                                        ->icon('heroicon-o-user'),
                                    TextEntry::make('jenis_simpanan')
                                        ->label('Jenis Simpanan')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
                                            'Wajib' => 'warning',
                                            'Sukarela' => 'success',
                                            'Pokok' => 'info',
                                            default => 'primary',
                                        }),
                                    TextEntry::make('nominal_simpanan')
                                        ->label('Nominal')
                                        ->money('IDR'),
                                    TextEntry::make('waktu_simpanan')
                                        ->label('Tanggal Simpanan')
                                        ->date('d F Y'),
                                    TextEntry::make('jenis_pembayaran')
                                        ->label('Jenis Pembayaran')
                                        ->default('-'),
                                    TextEntry::make('status')
                                        ->label('Status')
                                        ->badge()
                                        ->color(fn (string $state): string => match ($state) {
                                            'Menunggu' => 'gray',
                                            'Diterima' => 'success',
                                            'Revisi' => 'warning',
                                            'Ditolak' => 'danger',
                                            default => 'primary',
                                        }),
                                    TextEntry::make('catatan_penolakan')
                                        ->label('Catatan Admin')
                                        ->visible(fn ($record) => !empty($record->catatan_penolakan))
                                        ->columnSpanFull(),
                                    TextEntry::make('created_at')
                                        ->label('Diajukan Pada')
                                        ->dateTime('d F Y, H:i'),
                                ])
                                ->columns(2),
                        ]),

                        // RIGHT SIDE - Bukti Transfer (50% width)
                        Group::make([
                            Section::make('Bukti Transfer')
                                ->icon('heroicon-o-photo')
                                ->schema([
                                    ImageEntry::make('bukti_transfer')
                                        ->hiddenLabel()
                                        ->height(400)
                                        ->extraImgAttributes(['class' => 'rounded-lg w-full object-contain']),
                                ]),
                        ]),
                    ]),
            ]);
    }
}
