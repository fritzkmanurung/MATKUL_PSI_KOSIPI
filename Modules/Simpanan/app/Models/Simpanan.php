<?php

namespace Modules\Simpanan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Modules\Simpanan\Observers\SimpananObserver;
use App\Models\User;
use Modules\Sistem\Models\DendaKeterlambatan;
use Modules\Sistem\Models\TenggatWaktu;


#[ObservedBy(SimpananObserver::class)]
class Simpanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'nominal_simpanan', 'denda', 'jenis_simpanan',
        'waktu_simpanan', 'periode', 'bulan', 'jenis_pembayaran',
        'status', 'bukti_transfer', 'catatan_penolakan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getIsTelatAttribute(): bool
    {
        return $this->jumlah_hari_telat > 0;
    }

    public function getJumlahHariTelatAttribute(): int
    {
        if ($this->jenis_simpanan !== 'Wajib') return 0;

        $tenggat = TenggatWaktu::getAktif('Simpanan');
        if (!$tenggat) return 0;

        $createdAt = $this->created_at ?? now();
        $targetDate = \Carbon\Carbon::parse($createdAt)->copy()->day($tenggat->tanggal_akhir)->endOfDay();

        $paymentDate = $this->waktu_simpanan ? \Carbon\Carbon::parse($this->waktu_simpanan) : now();
        $paymentDate = $paymentDate->startOfDay();

        if ($paymentDate->gt($targetDate)) {
            return (int) $paymentDate->diffInDays($targetDate);
        }

        return 0;
    }

    public function getHitungDendaAttribute(): float
    {
        if (!$this->is_telat) return 0;

        $dendaRate = DendaKeterlambatan::getAktif('Simpanan Wajib');
        if (!$dendaRate) return 0;

        return (float) ($this->jumlah_hari_telat * $dendaRate->nominal_denda);
    }

    // protected static function newFactory(): SimpananFactory
    // {
    //     // return SimpananFactory::new();
    // }
}
