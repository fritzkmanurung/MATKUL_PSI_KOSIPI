<?php

namespace Modules\Pinjaman\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Modules\Pinjaman\Observers\PinjamanObserver;

#[ObservedBy(PinjamanObserver::class)]
class Pinjaman extends Model
{
    use HasFactory;


    protected $table = 'pinjamans';
    protected $fillable = [
        'kode_pinjaman', 'user_id', 'jumlah_pinjaman', 'tenor_bulan',
        'bunga_persen', 'alasan', 'status_pegawai', 'masa_kontrak',
        'pekerjaan', 'status', 'dokumen_persetujuan_1', 'dokumen_persetujuan_2',
        'bukti_transfer_admin', 'tanggal_pinjaman', 'catatan_penolakan',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function tagihanPinjamans()
    {
        return $this->hasMany(\Modules\Pinjaman\Models\TagihanPinjaman::class);
    }

    /**
     * Pilar 4: Cek apakah anggota masih punya pinjaman aktif.
     * Status aktif = Menunggu, Menunggu Dokumen, Disetujui (belum lunas).
     */
    public static function hasAktifPinjaman($userId): bool
    {
        return static::where('user_id', $userId)
            ->whereIn('status', ['Menunggu', 'Menunggu Dokumen', 'Disetujui'])
            ->exists();
    }

    /**
     * Pilar 3: Cek apakah anggota memiliki tunggakan (tagihan wajib belum dibayar / denda belum lunas).
     */
    public static function hasTunggakan($userId): array
    {
        $tagihanBelumBayar = \Modules\Simpanan\Models\Simpanan::where('user_id', $userId)
            ->where('jenis_simpanan', 'Wajib')
            ->where('status', 'Belum Dibayar')
            ->count();

        $totalDenda = \Modules\Simpanan\Models\Simpanan::where('user_id', $userId)
            ->where('jenis_simpanan', 'Wajib')
            ->where('denda', '>', 0)
            ->whereIn('status', ['Belum Dibayar', 'Menunggu'])
            ->sum('denda');

        return [
            'ada_tunggakan' => $tagihanBelumBayar > 0 || $totalDenda > 0,
            'jumlah_tagihan_belum_bayar' => $tagihanBelumBayar,
            'total_denda' => $totalDenda,
        ];
    }

    /**
     * Pilar 1 & 2: Hitung limit pinjaman berdasarkan saldo pribadi & likuiditas koperasi.
     */
    public static function getLimitPinjaman($userId): array
    {
        $config = config('koperasi.pinjaman');

        // Pilar 1: Limit Pribadi = Total Saldo Simpanan x multiplier
        $totalSimpanan = \Modules\Simpanan\Models\TotalSimpanan::where('user_id', $userId)->first();
        $saldoPribadi = $totalSimpanan ? (float) $totalSimpanan->total_simpanan : 0;
        $limitPribadi = $saldoPribadi * $config['multiplier_limit_pribadi'];

        // Pilar 2: Limit Likuiditas = Total Kas Koperasi x multiplier
        $totalKasKoperasi = (float) \Modules\Simpanan\Models\TotalSimpanan::sum('total_simpanan');
        $limitLikuiditas = $totalKasKoperasi * $config['multiplier_limit_likuiditas'];

        // Final: ambil yang terkecil
        $limitFinal = min($limitPribadi, $limitLikuiditas);

        return [
            'saldo_pribadi' => $saldoPribadi,
            'limit_pribadi' => $limitPribadi,
            'total_kas_koperasi' => $totalKasKoperasi,
            'limit_likuiditas' => $limitLikuiditas,
            'limit_final' => max(0, $limitFinal),
        ];
    }

    // protected static function newFactory(): PinjamanFactory
    // {
    //     // return PinjamanFactory::new();
    // }
}
