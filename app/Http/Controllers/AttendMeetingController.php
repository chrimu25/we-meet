<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Models\Youth;
use Illuminate\Http\Request;

class AttendMeetingController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($meeting, $youth)
    {
        $meeting = Meeting::findOrFail($meeting);
        $youth = Youth::findOrFail($youth);
        $meeting->attendees()->attach($youth);
        return back();
    }
}
