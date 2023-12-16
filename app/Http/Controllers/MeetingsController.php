<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\View\View;
use Illuminate\Http\Request;

class MeetingsController extends Controller
{
    function show(Meeting $meeting) : View {
        return view('meetings.details', compact('meeting'));
    }
}
