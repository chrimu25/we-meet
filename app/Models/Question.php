<?php

namespace App\Models;

use App\Models\Youth;
use App\Models\Comment;
use App\Models\Meeting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'meeting_id',
        'youth_id',
        'question',
        'reply',
    ];

    /**
     * Get the youth that owns the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function youth(): BelongsTo
    {
        return $this->belongsTo(Youth::class, 'youth_id', 'id');
    }

    /**
     * Get the meeting that owns the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    /**
     * Get all of the comments for the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class, 'question_id', 'id');
    }
}
