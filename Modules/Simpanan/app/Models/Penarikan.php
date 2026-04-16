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

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function simpanan()
    {
        return $this->belongsTo(Simpanan::class);
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): PenarikanFactory
    // {
    //     // return PenarikanFactory::new();
    // }
}
