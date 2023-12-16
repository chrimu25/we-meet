<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Youth extends Model
{
    use HasFactory;

    protected $fillable = [
        'phone',
        'national_id',
        'date_of_birth',
        'province',
        'district',
        'sector',
        'cell',
        'user_id'
    ];

    protected $casts = [
        'date_of_birth' => 'date',
    ];

    public function loginInfo(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id', 'id');
    }

    /**
     * Get all of the comments for the Youth
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'youth_id', 'id');
    }
}
