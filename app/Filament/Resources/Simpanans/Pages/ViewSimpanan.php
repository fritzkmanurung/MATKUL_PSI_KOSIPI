<?php

namespace App\Filament\Resources\Simpanans\Pages;

use App\Filament\Resources\Simpanans\SimpananResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewSimpanan extends ViewRecord
{
    protected static string $resource = SimpananResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('verifikasi')
                ->label('Verifikasi')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Verifikasi')
                ->modalDescription('Apakah Anda yakin dokumen dan transaksi ini sudah sesuai? Tindakan ini tidak dapat dibatalkan.')
                ->modalSubmitActionLabel('Ya, Terima sekarang')
                ->action(function () {
                    $this->record->update(['status' => 'Diterima']);
                    $this->refreshFormData(['status']);
                })
                ->visible(fn () => in_array($this->record->status, ['Menunggu', 'Revisi'])),

            Action::make('revisi')
                ->label('Revisi')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->form([
                    \Filament\Forms\Components\Textarea::make('catatan_penolakan')
                        ->label('Catatan Revisi')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'Revisi',
                        'catatan_penolakan' => $data['catatan_penolakan'],
                    ]);
                    $this->refreshFormData(['status', 'catatan_penolakan']);
                })
                ->visible(fn () => $this->record->status === 'Menunggu'),

            Action::make('tolak')
                ->label('Tolak')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->form([
                    \Filament\Forms\Components\Textarea::make('catatan_penolakan')
                        ->label('Alasan Penolakan')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'Ditolak',
                        'catatan_penolakan' => $data['catatan_penolakan'],
                    ]);
                    $this->refreshFormData(['status', 'catatan_penolakan']);
                })
                ->visible(fn () => in_array($this->record->status, ['Menunggu', 'Revisi'])),
        ];
    }
}
