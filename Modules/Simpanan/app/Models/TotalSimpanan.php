<?php

namespace Modules\Simpanan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class TotalSimpanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'total_simpanan_pokok', 'total_simpanan_wajib',
        'total_simpanan_sukarela', 'total_simpanan',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Metode Pakar untuk merangkum dan menghitung ulang seluruh Transaksi Finansial
     * Menjamin perhitungan sinkron (Event Sourcing) dengan database locking.
     */
    public static function recalculate($userId)
    {
        return DB::transaction(function () use ($userId) {
            // Lock row untuk mencegah race condition
            $totalSimpanan = self::lockForUpdate()->firstOrNew(['user_id' => $userId]);

            // Hitung Setoran Diterima
            $totalPokok = Simpanan::where('user_id', $userId)
                ->where('jenis_simpanan', 'Pokok')
                ->where('status', 'Diterima')->sum('nominal_simpanan');

            $totalWajib = Simpanan::where('user_id', $userId)
                ->where('jenis_simpanan', 'Wajib')
                ->where('status', 'Diterima')->sum('nominal_simpanan');

            $totalSukarelaMasuk = Simpanan::where('user_id', $userId)
                ->where('jenis_simpanan', 'Sukarela')
                ->where('status', 'Diterima')->sum('nominal_simpanan');

            // Hitung Penarikan Keluar (Hanya Sukarela yang boleh ditarik di koperasi)
            $totalPenarikan = Penarikan::where('user_id', $userId)
                ->where('status', 'Disetujui')->sum('nominal_penarikan');

            // Kalkulasi Bersih
            $saldoSukarela = $totalSukarelaMasuk - $totalPenarikan;
            $totalSimpananNet = $totalPokok + $totalWajib + $saldoSukarela;

            $totalSimpanan->fill([
                'total_simpanan_pokok' => $totalPokok,
                'total_simpanan_wajib' => $totalWajib,
                'total_simpanan_sukarela' => $saldoSukarela,
                'total_simpanan' => $totalSimpananNet,
            ])->save();

            return $totalSimpanan;
        });
    }

    // {
    //     // return TotalSimpananFactory::new();
    // }
}
