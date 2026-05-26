<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas\Schemas;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Components\ImageEntry;

class PenarikanAnggotaInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('catatan_penolakan')
                    ->default('-')
                    ->hiddenLabel()
                    ->formatStateUsing(function ($record, $state) {
                        $note = $state ?? '-';
                        $status = $record?->status ?? '';
                        
                        if ($status === 'Revisi') {
                            $colorClass = 'border-warning-500/20 bg-warning-500/10 text-warning-700 dark:text-warning-400';
                            $iconColorClass = 'text-warning-500';
                        } else {
                            $colorClass = 'border-danger-500/20 bg-danger-500/10 text-danger-700 dark:text-danger-400';
                            $iconColorClass = 'text-danger-500';
                        }

                        return new \Illuminate\Support\HtmlString('<div class="rounded-lg border ' . $colorClass . ' p-3 text-sm font-medium flex items-start gap-2"><svg class="w-5 h-5 shrink-0 ' . $iconColorClass . '" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg><div><strong>Catatan Admin:</strong><br>' . nl2br(e($note)) . '</div></div>');
                    })
                    ->html()
                    ->visible(fn ($record) => $record && in_array($record->status, ['Ditolak', 'Revisi']))
                    ->columnSpanFull(),

                Grid::make(2)->schema([
                    TextEntry::make('nominal_penarikan')
                        ->label('Nominal Penarikan')
                        ->money('IDR', locale: 'id')
                        ->size(\Filament\Support\Enums\TextSize::Large)
                        ->weight(\Filament\Support\Enums\FontWeight::Bold)
                        ->color('primary'),
                    TextEntry::make('status')
                        ->badge()
                        ->color(fn (string $state): string => match ($state) {
                            'Menunggu' => 'gray',
                            'Disetujui' => 'success',
                            'Revisi' => 'warning',
                            'Ditolak' => 'danger',
                            default => 'primary',
                        })
                        ->label('Status'),

                    TextEntry::make('tanggal_penarikan')
                        ->label('Tanggal Penarikan')
                        ->date('d F Y')
                        ->placeholder('-'),
                    TextEntry::make('created_at')
                        ->label('Waktu Pengajuan')
                        ->dateTime('d M Y, H:i'),
                ]),
                    
                ImageEntry::make('bukti_penarikan')
                    ->label('Bukti Transfer dari Admin')
                    ->height('300px')
                    ->extraImgAttributes([
                        'class' => 'w-full object-contain rounded-xl border border-gray-200 shadow-sm dark:border-gray-700',
                        'style' => 'max-height: 400px;'
                    ])
                    ->columnSpanFull()
                    ->visible(fn ($record) => $record && $record->status === 'Disetujui' && $record->bukti_penarikan),
            ]);
    }
}
