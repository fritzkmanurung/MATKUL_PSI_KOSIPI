<?php

namespace App\Filament\Resources\Pinjamen\Pages;

use App\Filament\Resources\Pinjamen\PinjamanResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewPinjaman extends ViewRecord
{
    protected static string $resource = PinjamanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // --- TAHAP 1: PERSETUJUAN AWAL ---
            Action::make('setuju_awal')
                ->label('Setuju Awal')
                ->icon('heroicon-o-document-text')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Setujui Tahap Awal')
                ->modalDescription('Izinkan anggota untuk melanjutkan ke tahap penandatanganan dan unggah dokumen persetujuan.')
                ->modalSubmitActionLabel('Ya, Lanjut ke Unggah Dokumen')
                ->action(function () {
                    $this->record->update(['status' => 'Menunggu Dokumen']);
                    $this->refreshFormData(['status']);
                })
                ->visible(fn () => in_array($this->record->status, ['Menunggu', 'Revisi'])),

            Action::make('revisi_data')
                ->label('Revisi Data')
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
                ->visible(fn () => in_array($this->record->status, ['Menunggu'])),

            Action::make('tolak_pengajuan')
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


            // --- TAHAP 2: VERIFIKASI DOKUMEN & PENCAIRAN ---
            Action::make('cairkan_dana')
                ->label('Cairkan Dana')
                ->icon('heroicon-o-banknotes')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Pencairan Dana')
                ->modalDescription('Pastikan dokumen yang diunggah valid. Unggah bukti transfer pencairan untuk difinalisasi.')
                ->form([
                    \Filament\Forms\Components\DatePicker::make('tanggal_pinjaman')
                        ->label('Tanggal Pencairan')
                        ->required()
                        ->default(now()),
                    \Filament\Forms\Components\FileUpload::make('bukti_transfer_admin')
                        ->label('Bukti Transfer Pencairan')
                        ->directory('bukti-pencairan-pinjaman')
                        ->image()
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'Disetujui',
                        'tanggal_pinjaman' => $data['tanggal_pinjaman'],
                        'bukti_transfer_admin' => $data['bukti_transfer_admin'],
                        'catatan_penolakan' => null, // Reset if was previously rejected
                    ]);
                    $this->refreshFormData(['status', 'tanggal_pinjaman', 'bukti_transfer_admin']);
                })
                ->visible(fn () => $this->record->status === 'Menunggu Verifikasi Dokumen'),

            Action::make('revisi_dokumen')
                ->label('Revisi Dokumen')
                ->icon('heroicon-o-exclamation-triangle')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Tolak Dokumen')
                ->form([
                    \Filament\Forms\Components\Textarea::make('catatan_penolakan')
                        ->label('Catatan Revisi Dokumen')
                        ->helperText('Beritahu anggota bagian mana dari dokumen yang salah/kurang jelas.')
                        ->required(),
                ])
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'Ditolak Dokumen',
                        'catatan_penolakan' => $data['catatan_penolakan'],
                    ]);
                    $this->refreshFormData(['status', 'catatan_penolakan']);
                })
                ->visible(fn () => $this->record->status === 'Menunggu Verifikasi Dokumen'),
        ];
    }
}
