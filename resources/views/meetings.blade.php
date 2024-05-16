@extends('layouts.app')
@section('title','Meeting List')
@section('content')
<section class="heading-page header-text" id="top">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h6>Here are our upcoming meetings</h6>
          <h2>Upcoming Meetings</h2>
        </div>
      </div>
    </div>
  </section>

  <section class="meetings-page" id="meetings">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <div class="row">
            <div class="col-lg-12">
              <div class="filters">
                <ul>
                  <li data-filter="*"  class="active">All Meetings</li>
                  <li data-filter=".upcoming">Soon</li>
                  <li data-filter=".recent">Recent</li>
                </ul>
              </div>
            </div>
            <div class="col-lg-12">
              <div class="row grid">
                @forelse ($meetings as $meeting)
                <div class="col-lg-4 templatemo-item-col all {{ $meeting->upcoming || $meeting->active ? 'upcoming' : 'recent' }}">
                  <div class="meeting-item">
                    <div class="thumb">
                      {{-- <div class="price">
                        <span>{{ $meeting->meeting_date > today() ? 'Upcoming' : ($meeting->meeting_date == date('Y-m-d') ? 'Happening' : 'Past Event')  }}</span>
                      </div> --}}
                      <a href="{{ route('meetings.details',$meeting->slug) }}">
                        <img src="{{ asset('storage/'.$meeting->cover_image) }}" 
                        style="max-height: 300px!important; width: 100%!important; object-fit:cover"
                            alt="{{ $meeting->title }}">
                    </a>
                    </div>
                    <div class="down-content">
                        <div class="d-flex">
                          <div class="date" style="width: 90px">
                            <h6>{{ $meeting->meeting_date->format('Y M') }} <span>{{ $meeting->meeting_date->format('d') }}</span></h6>
                          </div>
                          <a href="{{ route('meetings.details',$meeting->slug) }}"><h4>{{ $meeting->title }}</h4></a>
                      </div>
                      <p>{{ $meeting->moto }}</p>
                    </div>
                  </div>
                </div>                    
                @empty
                    
                @endforelse
              </div>
            </div>
            <div class="col-lg-12">
              <div class="pagination">
                {{ $meetings->links() }}
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    @include('footer')
  </section>
@endsection