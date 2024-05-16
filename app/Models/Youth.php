<?php

namespace App\Models;

use App\Models\User;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

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
    
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'youth_id', 'id');
    }
    
    public function attendedMeetings(): BelongsToMany
    {
        return $this->belongsToMany(Meeting::class, 'meeting_youth', 'meeting_id', 'youth_id')
            ->withPivot(['status','created_at'])
            ->withTimestamps();
    }
}
