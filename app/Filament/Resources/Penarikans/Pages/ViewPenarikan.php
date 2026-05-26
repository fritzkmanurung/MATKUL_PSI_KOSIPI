<?php

namespace App\Filament\Resources\Penarikans\Pages;

use App\Filament\Resources\Penarikans\PenarikanResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewPenarikan extends ViewRecord
{
    protected static string $resource = PenarikanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('verifikasi')
                ->label('Setujui')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Konfirmasi Verifikasi')
                ->modalDescription('Unggah bukti transfer untuk menyetujui penarikan ini.')
                ->form([
                    \Filament\Forms\Components\FileUpload::make('bukti_penarikan')
                        ->label('Bukti Transfer')
                        ->image()
                        ->directory('bukti-penarikan')
                        ->required(),
                ])
                ->modalSubmitActionLabel('Ya, Setujui sekarang')
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'Disetujui',
                        'bukti_penarikan' => $data['bukti_penarikan'],
                    ]);
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
