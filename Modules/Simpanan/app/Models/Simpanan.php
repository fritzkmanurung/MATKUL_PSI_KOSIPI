<?php

namespace Modules\Simpanan\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Modules\Simpanan\Observers\SimpananObserver;
use App\Models\User;

#[ObservedBy(SimpananObserver::class)]
class Simpanan extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): SimpananFactory
    // {
    //     // return SimpananFactory::new();
    // }
}
