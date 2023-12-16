<?php

namespace App\Models;

use App\Enums\SpeakerCategory;
use App\Models\Meeting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Speaker extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'name',
        'image',
        'type',
        'meeting_id'
    ];

    protected $casts = [
        'type' => SpeakerCategory::class
    ];

    public function getFullNameAttribute(): string
    {
        return $this->title.' '.$this->name;
    }
    /**
     * Get the meeting that owns the Speaker
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }
}
