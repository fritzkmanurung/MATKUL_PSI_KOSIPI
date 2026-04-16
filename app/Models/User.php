<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Modules\Sistem\Models\Agama;
use Modules\Sistem\Models\Instansi;
use Modules\Sistem\Models\Status;
use Modules\Sistem\Models\UnitKerja;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    /**
     * Determine if the user can access the given Filament panel.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        if ($panel->getId() === 'admin') {
            return $this->hasRole(['super_admin', 'admin', 'bendahara', 'Super Admin', 'Admin', 'Bendahara']);
        }
        
        if ($panel->getId() === 'member') {
            return $this->hasRole(['anggota', 'Anggota']);
        }

        return false;
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function agama()
    {
        return $this->belongsTo(Agama::class);
    }

    public function unitKerja()
    {
        return $this->belongsTo(UnitKerja::class);
    }

    public function instansi()
    {
        return $this->belongsTo(Instansi::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
}
