<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Filament\Panel;
use App\Models\Youth;
use App\Models\Coordinator;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;

class User extends Authenticatable implements FilamentUser
{
    use HasApiTokens, HasFactory, Notifiable, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'role',
        'userable_type',
        'userable_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    /**
     * Get the youthDetails associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function youthDetails(): HasOne
    {
        return $this->hasOne(Youth::class, 'user_id', 'id');
    }

    /**
     * Get the coordinatorDetails associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function coordinatorDetails(): HasOne
    {
        return $this->hasOne(Coordinator::class, 'user_id', 'id');
    }

    // public function userable(): MorphTo
    // {
    //     return $this->morphTo(__FUNCTION__, 'userable_type', 'userable_id');
    // }
}
