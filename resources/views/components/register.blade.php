@if(auth()->user()->role == 'Youth')
    @if(!auth()->user()->youthDetails->attendedMeetings()->find($meeting->id))
        <a href="{{ route('meetings.attend',['meeting'=>$meeting->id, 'youth'=>auth()->user()->youthDetails->id]) }}" class="btn btn-primary w-100 mt-0 pt-0">
            Register your Attendance
        </a>
    @endif
@endif