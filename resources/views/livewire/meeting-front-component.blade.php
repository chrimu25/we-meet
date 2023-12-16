<div class="row">
  @php
  use Carbon\Carbon;
  $currentDate = Carbon::now()->format('Y-m-d');
  $currentTime = Carbon::now()->format('H:i');
  $currentEvent = ($meeting->meeting_date->format('Y-m-d') == $currentDate) AND ((now() >= $meeting->start_time->format('H:i')) && ($meeting->end_time->format('H:i') > now()));
  $pastEvent = $meeting->meeting_date->format('Y-m-d') < $currentDate;
  @endphp
    <div class="col-lg-9">
      <div class="card shadow">
        <div class="row">
          <div class="col-lg-12 align-self-center">
            @if($currentEvent || $pastEvent)
            <div class="video w-100">
              {!! $meeting->meeting_link !!}
            </div>
            @else
            <div class="col-md-10 d-flex flex-column align-items-center justify-content-center">
              <h3 class="mt-4">Count Down Till The Day</h3>
              <hr class="w-25 ">
              <h2 id="demo"></h2>
            </div>
            @endif
          </div>
          <div class="w-100 d-flex justify-content-between align-items-center">
            @if($currentEvent)
            @auth
              <h2 class="pl-5">Questions</h2>
              <div class="main-button-red pb-2 mr-3">
              @if(auth()->user()->role == 'Youth')
                <a href="#!" data-toggle="modal" data-target="#questionModal">Ask Question</a>
              @endif
              </div>
            @endauth
            @elseif($meeting->meeting_date->isPast())
            <h2 class="pl-5">Asked Questions</h2>
            @endif
          </div>
          @foreach ($meeting->questions()->latest()->get() as $question)
            <div class="container bootstrap snippets bootdey">
              <div class="row">
              <div class="col-md-12">
              <div class="blog-comment">
                <ul class="comments">
                <li class="clearfix">
                <img src="https://ui-avatars.com/api/?name={{ $question->youth->loginInfo->name }}&background=random" class="avatar" alt="">
                <div class="post-comments">
                    <p class="meta">{{ $question->created_at->format('jS M, Y H:i:s') }} <a href="#">{{ $question->youth->loginInfo->name }}</a> Asked : </p>
                    <p> {{ $question->question }} </p>
                    <div class="d-flex justify-content-between" 
                    style="border-bottom:none; padding 8px 0px 0px 0px; border-top: 1px solid #eee;margin-top: 10px !important;">
                    <div class="d-flex">
                        <span title="Comments">
                        <i class="fa fa-comments"></i> {{ $question->comments()->whereStatus('Approved')->count() }}
                        </span>
                    </div>
                    @if($currentEvent)
                    <div class="d-flex">
                      @auth
                        @if(auth()->user()->role == 'Youth')
                          <a href="#!" wire:click="NewComment({{ $question->id }})"><small>Comment</small></a>
                        @endif
                        @if(empty($question->reply) AND auth()->user()->role == 'Coordinator')
                        <span class="mx-1">|</span>
                        <a href="#!" wire:click="NewReply({{ $question->id }})"><small>Reply</small></a>
                        @endif
                      @endauth
                    </div>
                    @endif
                    </div>
                </div>
                <ul class="comments">
                    @if(!empty($question->reply))
                    <li class="clearfix" style="display: block">
                        <img src="https://ui-avatars.com/api/?name=Meeting+Coordinator&background=random" class="avatar" alt="">
                        <div class="post-comments">
                          <p class="meta">Meeting Coordinator Replied 
                          <svg xmlns="http://www.w3.org/2000/svg" class="text-primary" width="13" height="13" fill="currentColor" 
                          class="bi bi-patch-check" viewBox="0 0 16 16">
                          <path fill-rule="evenodd" d="M10.354 6.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 
                          1 1 .708-.708L7 8.793l2.646-2.647a.5.5 0 0 1 .708 0z"/>
                          <path d="m10.273 2.513-.921-.944.715-.698.622.637.89-.011a2.89 2.89 0 0 1 2.924 2.924l-.01.89.636.622a2.89 
                          2.89 0 0 1 0 4.134l-.637.622.011.89a2.89 2.89 0 0 1-2.924 2.924l-.89-.01-.622.636a2.89 2.89 0 0 
                          1-4.134 0l-.622-.637-.89.011a2.89 2.89 0 0 1-2.924-2.924l.01-.89-.636-.622a2.89 2.89 0 0 1 
                          0-4.134l.637-.622-.011-.89a2.89 2.89 0 0 1 2.924-2.924l.89.01.622-.636a2.89 2.89 0 0 1 4.134 
                          0l-.715.698a1.89 1.89 0 0 0-2.704 0l-.92.944-1.32-.016a1.89 1.89 0 0 0-1.911 1.912l.016 1.318-.944.921a1.89 
                          1.89 0 0 0 0 2.704l.944.92-.016 1.32a1.89 1.89 0 0 0 1.912 1.911l1.318-.016.921.944a1.89 1.89 0 0 0 2.704 
                          0l.92-.944 1.32.016a1.89 1.89 0 0 0 1.911-1.912l-.016-1.318.944-.921a1.89 1.89 0 0 0 
                          0-2.704l-.944-.92.016-1.32a1.89 1.89 0 0 0-1.912-1.911l-1.318.016z"/>
                          </svg> :</p>
                          <p>{!! $question->reply !!}</p>
                        </div>
                    </li>
                    @endif
                    @if($question->comments()->count() > 0)
                    @foreach ($question->comments()->whereStatus('Approved')->latest()->get() as $comment)
                    <li class="clearfix" style="display: block">
                    <img src="https://ui-avatars.com/api/?name={{ $comment->youth->loginInfo->name }}&background=random" class="avatar" alt="">
                    <div class="post-comments">
                        <p class="meta">{{ $comment->created_at->format('jS M, Y H:i:s') }} {{ $comment->youth->loginInfo->name }} Commented :</p>
                        <p>{{ $comment->comment }}</p>
                    </div>
                    </li>
                    @endforeach
                    @endif
                </ul>
                </li>
                </ul>
              </div>
              </div>
            </div>
            </div>
          @endforeach
        </div>
        @auth
        @if(auth()->user()->role == 'Youth')
        <div wire:ignore.self class="modal fade" id="questionModal" tabindex="-1" role="dialog" aria-labelledby="questionModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="questionModalLabel">New Question Form</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form wire:submit.prevent="saveData" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                    <label for="exampleFormControlTextarea1">Question in brief</label>
                    <textarea class="form-control" wire:model="question" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                  <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
              </form>
            </div>
          </div>
        </div>  
        @endif        
        @endauth
    </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow">
        @if($addReply AND !$addComment)
        <div class="row p-3">
            <h6 class="card-title">Reply to {{ $name }}'s Question</h6>
            <form wire:submit.prevent="saveReply" method="POST">
                @csrf
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Reply</label>
                <textarea class="form-control" wire:model="reply" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-warning w-100">Reply</button>
            </form>
        </div>
        @endif
        @if($addComment AND !$addReply)
        <div class="row p-3">
            <h6 class="card-title">Comment to {{ $name }}'s Question</h6>
            <form wire:submit.prevent="saveComment" method="POST">
                @csrf
            <div class="form-group">
                <label for="exampleFormControlTextarea1">Comment</label>
                <textarea class="form-control" wire:model="comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-sm btn-warning w-100">Comment Now</button>
            </form>
        </div>
        @endif
        @if(!$addReply AND !$addComment)
        <div class="meeting-single-item">
          <div class="down-content">
            <h4>{{ $meeting->title }}</h4>
            <p>{{ $meeting->moto }}</p>
            <hr>
            <p class="description">{!! $meeting->description!!}</p>
            <hr>
            <div class="row">
              <div class="col-lg-12">
                <div class="hours">
                  <h5>Hours</h5>
                  <p>{{ $meeting->meeting_date->format('l jS d M, Y') }}<br>{{ $meeting->time }}</p>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="location">
                  <h5>Location</h5>
                  <p>{{ $meeting->location }}, 
                  <br>{{ $meeting->venue }}</p>
                </div>
              </div>
              <div class="col-lg-12">
                <div class="book now">
                  <h5>Speakers</h5>
                  <p>@foreach ($meeting->speakers()->orderBy('type','asc')->get() as $speaker)
                    <span class="d-flex align-items-center">
                       <img src="{{ asset('storage/'.$speaker->image) }}" 
                       style="height: 35px!important; width: 35px!important; border-radius: 50px;margin-right: .5rem;" 
                       alt="{{ $speaker->name }}"
                       >
                       {{ $speaker->name }}
                    </span> <br>  
                  @endforeach</p>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
  </div>