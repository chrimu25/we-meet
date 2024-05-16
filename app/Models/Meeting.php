<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Comment;
use App\Models\Speaker;
use App\Models\Question;
use App\Models\Coordinator;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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

    protected function startTime(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('H:i'),
        );
    }

    protected function endTime(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->format('H:i'),
        );
    }

    protected $appends = ['start_time', 'end_time'];

    protected $casts = [
        'meeting_date' => 'date',
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

    // scope that check whether the meeting is active or not
    public function scopeActive($query)
    {
        return $query->whereDate('meeting_date', date('Y-m-d'));
    }

    // scope that check whether the meeting is upcoming or not
    public function scopeUpcoming($query)
    {
        return $query->whereDate('meeting_date', '>', date('Y-m-d'))
            ->orWhere(function ($query) {
                $query->whereDate('meeting_date', date('Y-m-d'))
                    ->whereTime('start_time', '>', date('H:i:s'));
            });
    }

    // scope that check whether the meeting is past or not
    public function scopePast($query)
    {
        return $query->whereDate('meeting_date', '<', date('Y-m-d'))
            ->orWhere(function ($query) {
                $query->whereDate('meeting_date', date('Y-m-d'))
                    ->whereTime('end_time', '<', date('H:i:s'));
            });
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
    
    public function attendees(): BelongsToMany
    {
        return $this->belongsToMany(Youth::class, 'meeting_youth', 'youth_id', 'meeting_id')
            ->withPivot(['status','created_at'])
            ->withTimestamps();
    }

    public function delete()
    {
        $this->speakers()->delete();
        $this->questions()->delete();
        $this->comments()->delete();
        $this->attendees()->detach();
        return parent::delete();
    }
}
