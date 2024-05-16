<?php

namespace App\Models;

use App\Models\Youth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MeetingYouth extends Pivot
{
    use HasFactory;

    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class, 'meeting_id', 'id');
    }

    public function youth(): BelongsTo
    {
        return $this->belongsTo(Youth::class, 'youth_id', 'id');
    }
}
