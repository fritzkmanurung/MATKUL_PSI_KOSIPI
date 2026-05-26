<?php

namespace App\Filament\Resources\TagihanPinjamen\Pages;

use App\Filament\Resources\TagihanPinjamen\TagihanPinjamanResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewTagihanPinjaman extends ViewRecord
{
    protected static string $resource = TagihanPinjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('verifikasi')
                ->label('Verifikasi Lunas')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Verifikasi')
                ->modalDescription('Apakah Anda yakin dokumen dan transaksi ini sudah sesuai? Tindakan ini tidak dapat dibatalkan.')
                ->modalSubmitActionLabel('Ya, Verifikasi sekarang')
                ->action(function () {
                    $this->record->update(['status' => 'Lunas']);
                    $this->refreshFormData(['status']);
                })
                ->visible(fn () => $this->record->status === 'Menunggu Verifikasi'),

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
                ->visible(fn () => $this->record->status === 'Menunggu Verifikasi'),

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
                ->visible(fn () => in_array($this->record->status, ['Menunggu Verifikasi', 'Revisi'])),
        ];
    }
}
