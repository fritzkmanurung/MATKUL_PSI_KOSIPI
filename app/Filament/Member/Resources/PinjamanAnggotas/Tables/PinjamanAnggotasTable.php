<?php

namespace App\Filament\Member\Resources\PinjamanAnggotas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PinjamanAnggotasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('kode_pinjaman')
                    ->label('Kode Pinjaman')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),
                \Filament\Tables\Columns\TextColumn::make('jumlah_pinjaman')
                    ->label('Nominal Pinjaman')
                    ->money('IDR', locale: 'id')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('tenor_bulan')
                    ->label('Lama Cicilan')
                    ->suffix(' Bulan')
                    ->alignCenter()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('bunga_persen')
                    ->label('Bunga')
                    ->suffix('%')
                    ->alignCenter()
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->label('Status Pengajuan')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu' => 'gray',
                        'Menunggu Dokumen', 'Menunggu Verifikasi Dokumen' => 'info',
                        'Disetujui', 'Lunas' => 'success',
                        'Revisi', 'Ditolak Dokumen' => 'warning',
                        'Ditolak' => 'danger',
                        default => 'gray',
                    }),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ]);
    }
}
