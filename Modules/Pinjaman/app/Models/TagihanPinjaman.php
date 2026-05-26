<?php

namespace Modules\Pinjaman\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Pinjaman\Database\Factories\TagihanPinjamanFactory;

class TagihanPinjaman extends Model
{
    use HasFactory;

    protected $table = 'tagihan_pinjamans';
    protected $fillable = [
        'kode_tagihan', 'pinjaman_id', 'tagihan_ke', 'jatuh_tempo',
        'nominal_pokok', 'nominal_bunga', 'total_tagihan', 'denda',
        'status', 'bukti_bayar_transfer', 'tanggal_bayar', 'catatan_penolakan',
    ];

    public function pinjaman()
    {
        return $this->belongsTo(Pinjaman::class);
    }

    public function getIsTelatAttribute(): bool
    {
        return $this->jumlah_hari_telat > 0;
    }

    public function getJumlahHariTelatAttribute(): int
    {
        $jatuhTempo = \Carbon\Carbon::parse($this->jatuh_tempo)->endOfDay();
        $paymentDate = $this->tanggal_bayar ? \Carbon\Carbon::parse($this->tanggal_bayar) : now();
        $paymentDate = $paymentDate->startOfDay();

        if ($paymentDate->gt($jatuhTempo)) {
            return (int) $paymentDate->diffInDays($jatuhTempo);
        }

        return 0;
    }

    public function getHitungDendaAttribute(): float
    {
        if (!$this->is_telat) return 0;

        $dendaRate = \Modules\Sistem\Models\DendaKeterlambatan::getAktif('Pinjaman');
        if (!$dendaRate) return 0;

        return (float) ($this->jumlah_hari_telat * $dendaRate->nominal_denda);
    }

    // protected static function newFactory(): TagihanPinjamanFactory
    // {
    //     // return TagihanPinjamanFactory::new();
    // }

    protected static function booted()
    {
        static::updated(function ($tagihan) {
            if ($tagihan->isDirty('status')) {
                if ($tagihan->status === 'Menunggu Verifikasi') {
                    $admins = \App\Models\User::role(\App\Support\RoleConstant::adminRoles())->get();
                    \Filament\Notifications\Notification::make()
                        ->title('Pembayaran Cicilan Pinjaman')
                        ->body('Anggota mengunggah bukti bayar cicilan ke-' . $tagihan->tagihan_ke . '.')
                        ->info()
                        ->sendToDatabase($admins);
                } elseif ($tagihan->status === 'Lunas') {
                    \Filament\Notifications\Notification::make()
                        ->title('Cicilan Lunas')
                        ->body('Pembayaran cicilan pinjaman ke-' . $tagihan->tagihan_ke . ' terverifikasi lunas.')
                        ->success()
                        ->sendToDatabase($tagihan->pinjaman->user);
                } elseif ($tagihan->status === 'Ditolak') {
                    \Filament\Notifications\Notification::make()
                        ->title('Cicilan Ditolak')
                        ->body($tagihan->catatan_penolakan ?? 'Bukti pembayaran cicilan pinjaman Anda ditolak.')
                        ->danger()
                        ->sendToDatabase($tagihan->pinjaman->user);
                }
            }
        });
    }
}
