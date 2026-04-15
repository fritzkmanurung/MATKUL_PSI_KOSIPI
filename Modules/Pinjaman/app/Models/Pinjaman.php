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
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): PinjamanFactory
    // {
    //     // return PinjamanFactory::new();
    // }
}
