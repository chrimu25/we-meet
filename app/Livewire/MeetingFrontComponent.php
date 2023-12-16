<?php

namespace App\Livewire;

use App\Models\Meeting;
use App\Models\Question;
use Livewire\Attributes\Rule;
use Livewire\Component;

class MeetingFrontComponent extends Component
{
    public $meeting;

    #[Rule('required|max:3000|string')]
    public $question = '';

    #[Rule('required|max:3000|string')]
    public $reply = '';

    #[Rule('required|max:3000|string')]
    public $comment = '';

    public $addComment = false, $questionId = NULL, $name = null;
    public $addReply = false;

    public function NewComment(Question $question){
        $this->addReply = false;
        $this->addComment = true;
        $this->name = $question->youth->loginInfo->name;
        $this->questionId = $question->id;
    }

    public function NewReply(Question $question){
        $this->addComment = false;
        $this->addReply = true;
        $this->name = $question->youth->loginInfo->name;
        $this->questionId = $question->id;
    }

    public function saveComment(){
        $question = Question::findOrFail($this->questionId);
        $this->validate([
            'comment' => 'required|max:3000|string',
        ]);
        $question->comments()->create([
            'comment' => $this->comment,
            'youth_id' => auth()->user()->youthDetails->id,
        ]);
        $this->reset('comment','addComment','questionId','name');
        $this->dispatch('alert', type: 'success', message: 'Comment Added Successfully');
    }

    public function saveReply(){
        $question = Question::findOrFail($this->questionId);
        $this->validate([
            'reply' => 'required|max:3000|string',
        ]);
        $question->update([
            'reply' => $this->reply,
        ]);
        $this->reset('comment','addReply','questionId','name');
        $this->dispatch('alert', type: 'success', message: 'Reply Added Successfully');
    }

    public function saveData(){
        // dd('something');
        $this->validate([
            'question' => 'required|max:3000|string',
        ]);
        $meeting = Question::create([
            'question' => $this->question,
            'youth_id' => auth()->user()->youthDetails->id,
            'meeting_id' => $this->meeting->id,
        ]);
        return redirect()->route('meeting.details',$this->meeting->slug);
    }

    public function mount(Meeting $meeting)
    {
        $this->meeting = $meeting;
    }
    
    public function render()
    {
        return view('livewire.meeting-front-component');
    }
}
