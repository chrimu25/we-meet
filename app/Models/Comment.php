<?php

namespace App\Models;

use App\Enums\Status;
use App\Models\Youth;
use App\Models\Meeting;
use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_id',
        'youth_id',
        'parent_id',
        'comment',
        'status',
    ];

    // protected $casts = [
    //     'status' => Status::class,
    // ];

    /**
     * Get the meeting that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class, 'question_id', 'id');
    }

    /**
     * Get the meeting that owns the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function youth(): BelongsTo
    {
        return $this->belongsTo(Youth::class, 'youth_id', 'id');
    }

    /**
     * Get the meeting that owns the parentComment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parentComment(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id', 'id');
    }

    /**
     * Get all of the replies for the Comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function replies(): HasMany
    {
        return $this->hasMany(Comment::class, 'id', 'parent_id');
    }
}
