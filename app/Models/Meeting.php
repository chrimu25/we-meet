<?php

namespace App\Models;

use App\Models\Comment;
use App\Models\Speaker;
use App\Models\Question;
use App\Models\Coordinator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'moto',
        'description',
        'location',
        'venue',
        'meeting_date',
        'start_time',
        'end_time',
        'slug',
        'coordinator_id',
        'cover_image',
        'meeting_link',
    ];

    protected $casts = [
        'meeting_date' => 'datetime',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    // getting exact time for the meeting by combining starting time and ending time
    public function getTimeAttribute()
    {
        return '['.$this->start_time . ' - ' . $this->end_time.']';
    }

    protected static function booted()
    {
        static::creating(function ($meeting) {
            $meeting->slug = Str::slug($meeting->title);
            $meeting->start_time = date('H:i:s', strtotime($meeting->start_time));
            $meeting->end_time = date('H:i:s', strtotime($meeting->end_time));
        });

        static::updating(function ($meeting) {
            $meeting->slug = Str::slug($meeting->title);
        });
    }
 
    /**
     * Get the coordinator that owns the Meeting
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coordinator(): BelongsTo
    {
        return $this->belongsTo(Coordinator::class, 'coordinator_id', 'id');
    }

    /**
     * Get all of the speakers for the Meeting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function speakers(): HasMany
    {
        return $this->hasMany(Speaker::class, 'meeting_id', 'id');
    }

    /**
     * Get all of the comments for the Meeting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class, 'meeting_id', 'id');
    }

    /**
     * Get all of the comments for the Meeting
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function comments(): HasManyThrough
    {
        return $this->hasManyThrough(Comment::class, Question::class);
    }
}
