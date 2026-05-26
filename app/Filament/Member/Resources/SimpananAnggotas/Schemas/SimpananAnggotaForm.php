<?php

namespace App\Filament\Member\Resources\SimpananAnggotas\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class SimpananAnggotaForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Forms\Components\Placeholder::make('catatan_penolakan_display')
                    ->hiddenLabel()
                    ->content(function (?\Illuminate\Database\Eloquent\Model $record) {
                        $note = $record?->catatan_penolakan ?? '-';
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
                    ->visible(fn (?\Illuminate\Database\Eloquent\Model $record) => $record && in_array($record->status, ['Ditolak', 'Revisi']))
                    ->columnSpanFull(),

                Grid::make(['default' => 1, 'md' => 2])
                    ->schema([
                        Forms\Components\Select::make('jenis_simpanan')
                            ->options([
                                'Sukarela' => 'Simpanan Sukarela',
                            ])
                            ->default('Sukarela')
                            ->selectablePlaceholder(false)
                            ->disabled()
                            ->dehydrated()
                            ->hiddenOn(['edit', 'view'])
                            ->required()
                            ->label('Jenis Setoran')
                            ->columnSpan(1),
                        Forms\Components\TextInput::make('nominal_simpanan')
                            ->numeric()
                            ->required()
                            ->prefix('Rp')
                            ->label('Nominal Setoran')
                            ->columnSpan(1),
                        Forms\Components\DatePicker::make('waktu_simpanan')
                            ->required()
                            ->label('Tanggal Setoran')
                            ->native(false)
                            ->displayFormat('d F Y')
                            ->maxDate(now())
                            ->columnSpan(1),
                        Forms\Components\Select::make('jenis_pembayaran')
                            ->options([
                                'Tunai' => 'Tunai',
                                'Transfer' => 'Transfer',
                            ])
                            ->required()
                            ->label('Jenis Pembayaran')
                            ->columnSpan(1),
                        Forms\Components\FileUpload::make('bukti_transfer')
                            ->image()
                            ->required()
                            ->label('Unggah Bukti Transfer')
                            ->directory('bukti-simpanan')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
