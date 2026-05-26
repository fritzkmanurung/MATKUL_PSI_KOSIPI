<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class PenarikanAnggotasTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                \Filament\Tables\Columns\TextColumn::make('nominal_penarikan')
                    ->label('Nominal')
                    ->money('IDR')
                    ->sortable(),
                \Filament\Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Menunggu' => 'gray',
                        'Disetujui' => 'success',
                        'Revisi' => 'warning',
                        'Ditolak' => 'danger',
                        default => 'primary',
                    }),
                \Filament\Tables\Columns\ImageColumn::make('bukti_penarikan')
                    ->label('Bukti')
                    ->circular(),
                \Filament\Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->label('Tanggal')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                \Filament\Actions\ActionGroup::make([
                    \Filament\Actions\ViewAction::make()
                        ->modalWidth('md')
                        ->modalHeading('Detail Penarikan'),
                    \Filament\Actions\EditAction::make()
                        ->label(fn ($record) => $record->status === 'Revisi' ? 'Perbaiki' : 'Ubah')
                        ->modalWidth('md')
                        ->modalHeading('Ubah Penarikan')
                        ->visible(fn ($record) => in_array($record->status, ['Menunggu', 'Revisi']))
                        ->mutateFormDataUsing(function (array $data): array {
                            $data['status'] = 'Menunggu';
                            return $data;
                        }),
                    \Filament\Actions\DeleteAction::make()
                        ->authorize(fn ($record) => $record->user_id === auth()->id())
                        ->visible(fn ($record) => $record->status === 'Menunggu'),
                ]),
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
