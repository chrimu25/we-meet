@extends('layouts.app')
@section('title',$meeting->title)
@push('extra-css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" 
integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" 
crossorigin="anonymous">
@endpush
@section('content')
<section class="heading-page header-text" id="top" style="
  background:linear-gradient(0deg, rgb(0, 0, 0, 0.5), rgb(0, 0, 0, 0.5)), url('{{  asset("storage/".$meeting->cover_image) }}');
  background-repeat: norepeat;
  background-size: cover;
  ">
    <div class="container">
      <div class="row">
        <div class="col-lg-12">
          <h6>{{ $meeting->moto }}</h6>
          <h2>{{ $meeting->title }}</h2>
          <div class="d-flex justify-content-center align-items-center">
            <span class="badge mr-2 badge-pill badge-{{ $meeting->meeting_date->isFuture() ? 'warning' : 'danger' }}">
              {{ $meeting->meeting_date->isFuture() ? 'Upcoming' : 'Past Event' }}
            </span>
            <span class="badge badge-pill badge-primary">
              {{ $meeting->meeting_date->format('jS F, Y') }}
            </span>
          </div>
        </div>
      </div>
    </div>
</section>

<section class="meetings-page px-5" id="meetings">
    <div class="container-fluid">
      @livewire('meeting-front-component', ['meeting' => $meeting], key($meeting->id))
    </div>
    @include('footer')
</section>
@push('extra-js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js"></script>
<script>
  window.addEventListener('closeModal', event => {
      $('#questionModal').modal('hide');
  });
  window.addEventListener('showModal', event => {
      $('#NewCommentModal').modal('show');
  })
</script>
<script>
  var countDownDate = new Date("{{ $meeting->meeting_date->format('Y-m-d').' '.$meeting->start_time->format('H:i:s') }}").getTime();
  var x = setInterval(function() {
    var now = new Date().getTime();
    var distance = countDownDate - now;
    var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
    document.getElementById("demo").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";
    if (distance < 0) {
      clearInterval(x);
      document.getElementById("demo").innerHTML = "EXPIRED";
    }
  }, 1000);
  </script>
@endpush
@endsection