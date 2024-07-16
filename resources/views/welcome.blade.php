<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="TemplateMo">
    <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,300,400,500,600,700,800,900" rel="stylesheet">

    <title>{{ config('app.name') }} - Welcome</title>

    <!-- Bootstrap core CSS -->
    <link href="{{ asset('front/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="{{ asset('front/assets/css/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/templatemo-edu-meeting.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/owl.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets/css/lightbox.css') }}">
    @livewireStyles
<!--

TemplateMo 569 Edu Meeting

https://templatemo.com/tm-569-edu-meeting

-->
  </head>

<body>
  <!-- ***** Header Area Start ***** -->
  <header class="header-area">
      <div class="container">
          <div class="row">
              <div class="col-12">
                  <nav class="main-nav">
                      <!-- ***** Logo Start ***** -->
                      <a href="/" class="logo">
                        {{ config('app.name') }}
                      </a>
                      <!-- ***** Logo End ***** -->
                      <!-- ***** Menu Start ***** -->
                      <ul class="nav">
                          <li class="scroll-to-section"><a href="#top" class="active">Home</a></li>
                          <li><a href="{{ route('meetings') }}">Meetings</a></li>
                          @guest
                          <li class="scroll-to-section"><a href="{{ route('account') }}">Create Account</a></li>
                          <li class="scroll-to-section"><a href="{{ route('filament.admin.auth.login') }}">Login</a></li> 
                          @else
                          <li class="scroll-to-section"><a href="{{ route('filament.admin.auth.login') }}">Dashboard</a></li> 
                          @endguest
                          <li class="scroll-to-section"><a href="#contact">Contact Us</a></li> 
                      </ul>        
                      <a class='menu-trigger'>
                          <span>Menu</span>
                      </a>
                      <!-- ***** Menu End ***** -->
                  </nav>
              </div>
          </div>
      </div>
  </header>
    <!-- ***** Main Banner Area Start ***** -->
  <section class="section main-banner" id="top" data-section="section1">
    <video autoplay muted loop id="bg-video">
        <source src="{{ asset('front/assets/images/kcc.mp4') }}" type="video/mp4" />
    </video>

    <div class="video-overlay header-text">
        <div class="container">
          <div class="row">
            <div class="col-lg-12">
              <div class="caption">
            <h6>Hello,</h6>
            <h2>Welcome to {{ config('app.name') }}</h2>
            <p>This is an edu meeting HTML CSS template provided by <a rel="nofollow" href="https://templatemo.com/page/1" target="_blank">TemplateMo website</a>. This is a Bootstrap v5.1.3 layout. The video background is taken from Pexels website, a group of young people by <a rel="nofollow" href="https://www.pexels.com/@pressmaster" target="_blank">Pressmaster</a>.</p>
            <div class="main-button-red">
                <div class="scroll-to-section"><a href="#contact">Join Us Now!</a></div>
            </div>
        </div>
            </div>
          </div>
        </div>
    </div>
</section>
<!-- ***** Main Banner Area End ***** -->

<section class="upcoming-meetings" id="meetings">
  <div class="container">
    <div class="row">
      <div class="col-lg-12">
        <div class="section-heading">
          <h2>Upcoming Meetings</h2>
        </div>
      </div>
      <div class="col-lg-4">
        <div class="categories">
          <h4>Meeting Catgories</h4>
          <ul>
            @forelse ($meetings as $item)
            <li><a href="{{ route('meetings.details',$item->slug) }}">{{ $item->title }}</a></li>              
            @empty
              <li>
                <h4>No upcoming meetings</h4>
              </li>
            @endforelse
          </ul>
          <div class="main-button-red">
            <a href="{{ route('meetings') }}">All Upcoming Meetings</a>
          </div>
        </div>
      </div>
      <div class="col-lg-8">
        <div class="row">
          @foreach($meetings as $meeting)
          <div class="col-lg-6">
            <div class="meeting-item">
              <div class="thumb">
                <div class="price">
                  <span>Upcoming</span>
                </div>
                <a href="{{ route('meetings.details',$meeting->slug) }}">
                  <img src="{{ asset('storage/'.$meeting->cover_image) }}" 
                  style="max-height: 300px!important; width: 100%!important; object-fit:cover"
                    alt="{{ $meeting->title }}"
                  >
                </a>
              </div>
              <div class="down-content d-flex">
                <div class="date">
                  <h6>{{ $meeting->meeting_date->format('M') }}<span>{{ $meeting->meeting_date->format('d') }}</span></h6>
                </div>
                <div>
                  <a href="{{ route('meetings.details',$meeting->slug) }}"><h4>{{ $meeting->title }}</h4></a>
                  <p>{{ $meeting->moto }}</p>
                </div>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</section>


<section class="contact-us" id="contact">
  <div class="container">
    <div class="row">
      <div class="col-lg-9 align-self-center">
        <div class="row">
          <div class="col-lg-12">
            <form id="contact" action="{{ route('contact.save') }}" method="post">
              @csrf
              <div class="row">
                <div class="col-lg-12">
                  <h2>Let's get in touch</h2>
                </div>
                <div class="col-lg-4">
                  <fieldset>
                    <input name="name" type="text" id="name" value="{{ old('name') }}" placeholder="YOURNAME...*" required="">
                    @error('name')
                      <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </fieldset>
                </div>
                <div class="col-lg-4">
                  <fieldset>
                  <input name="email" type="email" id="email" value="{{ old('email') }}" pattern="[^ @]*@[^ @]*" placeholder="YOUR EMAIL..." required="">
                  @error('email')
                    <span class="text-danger">{{ $message }}</span>
                  @enderror
                </fieldset>
                </div>
                  <fieldset>
                    <input name="subject" type="text" id="subject" value="{{ old('subject') }}" placeholder="SUBJECT...*" required="">
                    @error('subject')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <textarea name="message" type="text" class="form-control" id="message" 
                    placeholder="YOUR MESSAGE..." required="">{{ old('message') }}</textarea>
                    @error('message')
                    <span class="text-danger">{{ $message }}</span>
                    @enderror
                  </fieldset>
                </div>
                <div class="col-lg-12">
                  <fieldset>
                    <button type="submit" id="form-submit" class="button">SEND MESSAGE NOW</button>
                  </fieldset>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <div class="col-lg-3">
        <div class="right-info">
          <ul>
            <li>
              <h6>Phone Number</h6>
              <span>078-000-0340</span>
            </li>
            <li>
              <h6>Email Address</h6>
              <span>info@wemeet.edu</span>
            </li>
            <li>
              <h6>Street Address</h6>
              <span>Kicukiro, Sonatube, UTB</span>
            </li>
            <li>
              <h6>Website URL</h6>
              <span>www.wemeet.edu</span>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  @include('footer')
</section>
@livewireScripts
  <script src="{{ asset('front/vendor/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('front/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('front/assets/js/isotope.min.js') }}"></script>
  <script src="{{ asset('front/assets/js/owl-carousel.js') }}"></script>
  <script src="{{ asset('front/assets/js/lightbox.js') }}"></script>
  <script src="{{ asset('front/assets/js/tabs.js') }}"></script>
  <script src="{{ asset('front/assets/js/video.js') }}"></script>
  <script src="{{ asset('front/assets/js/slick-slider.js') }}"></script>
  <script src="{{ asset('front/assets/js/custom.js') }}"></script>
  <script>
    //according to loftblog tut
    $('.nav li:first').addClass('active');

    var showSection = function showSection(section, isAnimate) {
      var
      direction = section.replace(/#/, ''),
      reqSection = $('.section').filter('[data-section="' + direction + '"]'),
      reqSectionPos = reqSection.offset().top - 0;

      if (isAnimate) {
        $('body, html').animate({
          scrollTop: reqSectionPos },
        800);
      } else {
        $('body, html').scrollTop(reqSectionPos);
      }

    };

    var checkSection = function checkSection() {
      $('.section').each(function () {
        var
        $this = $(this),
        topEdge = $this.offset().top - 80,
        bottomEdge = topEdge + $this.height(),
        wScroll = $(window).scrollTop();
        if (topEdge < wScroll && bottomEdge > wScroll) {
          var
          currentId = $this.data('section'),
          reqLink = $('a').filter('[href*=\\#' + currentId + ']');
          reqLink.closest('li').addClass('active').
          siblings().removeClass('active');
        }
      });
    };

    $(window).scroll(function () {
      checkSection();
    });
</script>
</body>

</body>
</html>