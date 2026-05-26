<?php

namespace App\Filament\Resources\TotalSimpanans\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Table;
use App\Filament\Support\MoneyFormatter;
use Filament\Tables\Columns\TextColumn;

class TotalSimpanansTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')
                    ->label('Anggota')
                    ->sortable()
                    ->searchable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('total_simpanan_pokok')
                )->label('Pokok')->sortable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('total_simpanan_wajib')
                )->label('Wajib')->sortable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('total_simpanan_sukarela')
                )->label('Sukarela')->sortable(),
                MoneyFormatter::rupiah(
                    TextColumn::make('total_simpanan')
                )->label('TOTAL KESELURUHAN')->badge()->sortable(),
                \Filament\Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Dihitung')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\ActionGroup::make([
                    \Filament\Actions\Action::make('riwayat_pokok')
                        ->label('Riwayat Pokok')
                        ->icon('heroicon-o-book-open')
                        ->color('info')
                        ->url(fn ($record) => \App\Filament\Resources\Simpanans\SimpananResource::getUrl('index', [
                            'tab' => 'Pokok',
                            'tableFilters' => ['user_id' => ['value' => $record->user_id]]
                        ])),
                    \Filament\Actions\Action::make('riwayat_wajib')
                        ->label('Riwayat Wajib')
                        ->icon('heroicon-o-book-open')
                        ->color('warning')
                        ->url(fn ($record) => \App\Filament\Resources\Simpanans\SimpananResource::getUrl('index', [
                            'tab' => 'Wajib',
                            'tableFilters' => ['user_id' => ['value' => $record->user_id]]
                        ])),
                    \Filament\Actions\Action::make('riwayat_sukarela')
                        ->label('Riwayat Sukarela')
                        ->icon('heroicon-o-book-open')
                        ->color('success')
                        ->url(fn ($record) => \App\Filament\Resources\Simpanans\SimpananResource::getUrl('index', [
                            'tab' => 'Sukarela',
                            'tableFilters' => ['user_id' => ['value' => $record->user_id]]
                        ])),
                ])->icon('heroicon-m-ellipsis-vertical')->tooltip('Riwayat Mutasi'),
            ])
            ->toolbarActions([]);
    }
}
