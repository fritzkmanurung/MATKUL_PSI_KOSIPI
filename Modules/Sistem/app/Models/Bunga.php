<?php

namespace Modules\Sistem\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Modules\Sistem\Database\Factories\BungaFactory;

class Bunga extends Model
{
    use HasFactory;

    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    // protected static function newFactory(): BungaFactory
    // {
    //     // return BungaFactory::new();
    // }
}
