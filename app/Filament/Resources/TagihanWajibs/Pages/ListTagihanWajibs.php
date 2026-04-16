<?php

namespace App\Filament\Resources\TagihanWajibs\Pages;

use App\Filament\Resources\TagihanWajibs\TagihanWajibResource;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Select;
use Filament\Resources\Pages\ListRecords;
use Filament\Notifications\Notification;
use Modules\Simpanan\Models\TagihanWajib;
use App\Models\User;

class ListTagihanWajibs extends ListRecords
{
    protected static string $resource = TagihanWajibResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('generate_tagihan')
                ->label('Generate Tagihan Wajib')
                ->icon('heroicon-o-bolt')
                ->color('success')
                ->form([
                    Select::make('jumlah_bulan')
                        ->label('Jumlah Bulan Tagihan')
                        ->options([
                            1 => '1 Bulan',
                            2 => '2 Bulan',
                            3 => '3 Bulan',
                            6 => '6 Bulan',
                            12 => '12 Bulan',
                        ])
                        ->required()
                        ->default(1),
                    TextInput::make('nominal')
                        ->label('Nominal per Bulan')
                        ->numeric()
                        ->prefix('Rp')
                        ->required()
                        ->default(50000),
                ])
                ->action(function (array $data) {
                    $jumlahBulan = (int) $data['jumlah_bulan'];
                    $nominal = $data['nominal'];

                    // Ambil semua user dengan role anggota
                    $anggota = User::role(['anggota', 'Anggota'])->get();

                    if ($anggota->isEmpty()) {
                        Notification::make()
                            ->title('Tidak ada anggota aktif!')
                            ->danger()
                            ->send();
                        return;
                    }

                    $count = 0;
                    foreach ($anggota as $user) {
                        for ($i = 0; $i < $jumlahBulan; $i++) {
                            $targetDate = now()->addMonths($i);
                            $periode = $targetDate->format('Y-m');
                            $bulan = $targetDate->format('m');

                            // Cek apakah sudah ada tagihan untuk user + periode ini
                            $exists = TagihanWajib::where('user_id', $user->id)
                                ->where('periode', $periode)
                                ->exists();

                            if (!$exists) {
                                TagihanWajib::create([
                                    'user_id' => $user->id,
                                    'kode_tagihan' => 'TWJ-' . $periode . '-' . $user->id . '-' . rand(100, 999),
                                    'periode' => $periode,
                                    'bulan' => $bulan,
                                    'nominal_tagihan' => $nominal,
                                    'status' => 'Belum Lunas',
                                ]);
                                $count++;
                            }
                        }
                    }

                    Notification::make()
                        ->title("Berhasil generate {$count} tagihan wajib!")
                        ->success()
                        ->send();
                }),
        ];
    }
}
