<?php

namespace App\Filament\Member\Resources\PenarikanAnggotas\Schemas;

use Filament\Forms\Components;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

class PenarikanAnggotaForm
{
    public static function configure(Schema $schema): Schema
    {
        $getAvailableAmount = function (?\Illuminate\Database\Eloquent\Model $record) {
            $sukarelaAmount = \Modules\Simpanan\Models\TotalSimpanan::where('user_id', auth()->id())->first()?->total_simpanan_sukarela ?? 0;
            
            $query = \Modules\Simpanan\Models\Penarikan::where('user_id', auth()->id())
                ->whereIn('status', ['Menunggu', 'Revisi']);
            
            if ($record && $record->exists) {
                $query->where('id', '!=', $record->id);
            }
            
            $pendingAmount = $query->sum('nominal_penarikan');
            return max(0, $sukarelaAmount - $pendingAmount);
        };

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

                Forms\Components\Placeholder::make('sisa_saldo_sukarela')
                    ->hiddenLabel()
                    ->content(function (?\Illuminate\Database\Eloquent\Model $record) use ($getAvailableAmount) {
                        $available = $getAvailableAmount($record);
                        $formatted = 'Rp ' . number_format($available, 0, ',', '.');
                        return new \Illuminate\Support\HtmlString('
                            <div class="rounded-lg border border-primary-500/20 bg-primary-500/5 p-4 flex items-center gap-3">
                                <div class="flex items-center justify-center w-10 h-10 rounded-full bg-primary-500/10">
                                    <svg class="w-5 h-5 text-primary-600 dark:text-primary-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 dark:text-gray-400">Saldo Tersedia untuk Ditarik</p>
                                    <p class="text-lg font-bold text-primary-700 dark:text-primary-300">' . $formatted . '</p>
                                </div>
                            </div>
                        ');
                    })
                    ->columnSpanFull(),

                Grid::make(['default' => 1])
                    ->schema([
                        Forms\Components\TextInput::make('nominal_penarikan')
                            ->required()
                            ->numeric()
                            ->inputMode('numeric')
                            ->prefix('Rp')
                            ->minValue(1)
                            ->maxValue($getAvailableAmount)
                            ->label('Nominal Penarikan')
                            ->mask(\Filament\Support\RawJs::make('$money($input, \',\', \'.\', 0)'))
                            ->stripCharacters('.')
                            ->extraInputAttributes(function (?\Illuminate\Database\Eloquent\Model $record) use ($getAvailableAmount) {
                                $max = $getAvailableAmount($record);
                                return [
                                    'x-on:input' => '
                                        let raw = $el.value.replace(/\./g, \'\');
                                        let max = ' . $max . ';
                                        if (raw !== \'\') {
                                            if (parseInt(raw) != Math.min(parseInt(raw), max)) {
                                                setTimeout(() => {
                                                    $el.value = max.toString();
                                                    $el.dispatchEvent(new Event(\'input\'));
                                                }, 0);
                                            }
                                        }
                                    ',
                                ];
                            })
                            ->helperText(function (?\Illuminate\Database\Eloquent\Model $record) use ($getAvailableAmount) {
                                $max = $getAvailableAmount($record);
                                return $max > 0 ? 'Maksimal penarikan: Rp ' . number_format($max, 0, ',', '.') : 'Saldo sukarela yang tersedia kosong.';
                            }),
                    ])
                    ->columnSpanFull(),
            ])
            ->columns(1);
    }
}
