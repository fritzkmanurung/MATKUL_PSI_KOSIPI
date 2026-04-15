<?php

namespace Modules\Simpanan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\DB;

class TotalSimpanan extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * Metode Pakar untuk merangkum dan menghitung ulang seluruh Transaksi Finansial
     * Menjamin perhitungan sinkron (Event Sourcing).
     */
    public static function recalculate($userId)
    {
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

        // Tembak Update/Create
        return self::updateOrCreate(
            ['user_id' => $userId],
            [
                'total_simpanan_pokok' => $totalPokok,
                'total_simpanan_wajib' => $totalWajib,
                'total_simpanan_sukarela' => $saldoSukarela,
                'total_simpanan' => $totalSimpananNet,
            ]
        );
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    // {
    //     // return TotalSimpananFactory::new();
    // }
}
