<?php

namespace Modules\Simpanan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Modules\Simpanan\Observers\PenarikanObserver;
use App\Models\User;

#[ObservedBy(PenarikanObserver::class)]
class Penarikan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'simpanan_id', 'nominal_penarikan', 'alasan', 'status', 'catatan_penolakan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function simpanan()
    {
        return $this->belongsTo(Simpanan::class);
    }

    // protected static function newFactory(): PenarikanFactory
    // {
    //     // return PenarikanFactory::new();
    // }
}
