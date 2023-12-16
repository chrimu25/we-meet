<?php

namespace App\Models;

use App\Models\User;
use App\Models\Meeting;
use App\Enums\NamePrefix;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Coordinator extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix',
        'phone',
        'user_id'
    ];

    protected $casts = [
        'prefix' => NamePrefix::class,
    ];

    public function getNameAttribute()
    {
        return $this->prefix->value . ' ' . $this->loginInfo->name;
    }

    public function loginInfo(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    /**
     * Get all of the meetings for the Coordinator
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function meetings(): HasMany
    {
        return $this->hasMany(Meeting::class, 'coordinator_id', 'id');
    }
}
