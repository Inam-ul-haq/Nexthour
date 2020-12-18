
<!DOCTYPE html>
<!--
**********************************************************************************************************
    Copyright (c) 2020 .
    **********************************************************************************************************  -->
<!--
Template Name: Next Hour - Movie Tv Show & Video Subscription Portal Cms Web and Mobile App
Version: 2.8.2
Author: Media City
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]> -->
<html lang="en">
<!-- <![endif]-->
<!-- head -->
<head>
<meta name="google-site-verification" content="googleeacc2166ce777ac3.html" />
  <title>@yield('title') - {{$w_title}}</title>
  <meta charset="utf-8" />
  
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta name="Description" content="{{$description}}" />
  <meta name="keyword" content="{{$w_title}}, {{$keyword}}">
  <meta name="MobileOptimized" content="320" />    
  @yield('custom-meta')
  <meta name="csrf-token" content="{{ csrf_token() }}"><!-- CSRF Token -->

  <link rel="icon" type="image/icon" href="{{asset('images/favicon/favicon.png')}}"> <!-- favicon icon -->
  <link href="{{asset('css/starrating.css')}}" rel="stylesheet" type="text/css"/> 
  <!-- Star Rating -->
  <!-- theme style -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> <!-- google font -->
  <link href="{{asset('css/videojs-icons.css')}}" rel="stylesheet" type="text/css"/> <!-- google font -->
  <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/> <!-- bootstrap css -->
  <link href="https://vjs.zencdn.net/6.6.0/video-js.css" rel="stylesheet"> <!-- videojs css -->
  <link href="{{asset('css/menumaker.css')}}" type="text/css" rel="stylesheet"> <!-- menu css -->
  <link href="{{asset('css/owl.carousel.min.css')}}" rel="stylesheet" type="text/css"/> <!-- owl carousel css -->
  <link href="{{asset('css/owl.theme.default.min.css')}}" rel="stylesheet" type="text/css"/> <!-- owl carousel css -->
  <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/> <!-- fontawsome css -->
  <link href="{{asset('css/popover.css')}}" rel="stylesheet" type="text/css"/> <!-- bootstrap popover css -->
  <link href="{{asset('css/layers.css')}}" rel="stylesheet" type="text/css"/> <!-- revolution css -->
  <link href="{{asset('css/navigation.css')}}" rel="stylesheet" type="text/css"/> <!-- revolution css -->
  <link href="{{asset('css/pe-icon-7-stroke.css')}}" rel="stylesheet" type="text/css"/> <!-- revolution css -->
  <link href="{{asset('css/settings.css')}}" rel="stylesheet" type="text/css"/> <!-- revolution css -->
  <link href="{{asset('css/videojs-playlist-ui.vertical.css')}}" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" href="{{ url('css/colorbox.css') }}">
  <link rel="manifest" href="{{asset('/manifest.json')}}"> <!-- bootstrap css -->

  
  
  <!-- videojs playlist ui css -->
  {{-- style css for different color schemes --}}
  @if($color=='default')
  @if($color_dark==1)
  {{-- light color --}}
  <link href="{{asset('css/style-light.css')}}" rel="stylesheet" type="text/css"/>
  @else
  <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css"/>
  {{-- dark color --}}
  @endif
  @elseif($color=='green')
  @if($color_dark==1)
  {{-- light color --}}
    <link href="{{asset('css/style-light-green.css')}}" rel="stylesheet" type="text/css"/>
  @else
  {{-- dark color --}}
   <link href="{{asset('css/style-green.css')}}" rel="stylesheet" type="text/css"/>
  @endif
  @elseif($color=='orange')
  @if($color_dark==1)
  {{-- light color --}}
     <link href="{{asset('css/style-light-orange.css')}}" rel="stylesheet" type="text/css"/>
  @else
  {{-- dark color --}}
   <link href="{{asset('css/style-orange.css')}}" rel="stylesheet" type="text/css"/>
  @endif
  @elseif($color=='yellow')
  @if($color_dark==1)
  {{-- light color --}}
    <link href="{{asset('css/style-light-yellow.css')}}" rel="stylesheet" type="text/css"/>
  @else
  {{-- dark color --}}
   <link href="{{asset('css/style-yellow.css')}}" rel="stylesheet" type="text/css"/>
  @endif
   @elseif($color=='red')
  @if($color_dark==1)
  {{-- light color --}}
    <link href="{{asset('css/style-light-red.css')}}" rel="stylesheet" type="text/css"/>
  @else
  {{-- dark color --}}
   <link href="{{asset('css/style-red.css')}}" rel="stylesheet" type="text/css"/>
  @endif
  @elseif($color=='pink')
  @if($color_dark==1)
  {{-- light color --}}
   <link href="{{asset('css/style-light-pink.css')}}" rel="stylesheet" type="text/css"/>
  @else
  {{-- dark color --}}
    <link href="{{asset('css/style-pink.css')}}" rel="stylesheet" type="text/css"/>
  @endif
  @endif
  
  <link href="{{asset('css/custom-style.css')}}" rel="stylesheet" type="text/css"/>
  <link href="{{asset('css/goto.css')}}" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" href="{{ asset('content/global.css') }}"><!-- go to top css -->
  <script src="https://js.stripe.com/v3/"></script> <!-- stripe script -->
  <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
  <script type="text/javascript" src="{{ asset('java/FWDUVPlayer.js') }}"></script> <!-- jquery library js -->


  <script>
    window.Laravel =  <?php echo json_encode([
      'csrfToken' => csrf_token(),
      ]); ?>
    </script>
    <script type="text/javascript" src="{{asset('js/app.js')}}"></script> <!-- app library js -->
    <!-- notification icon style -->
    <style type="text/css">
     #ex4 .p1[data-count]:after{
      position:absolute;
      right:10%;
      top:8%;
      content: attr(data-count);
      font-size:40%;
      padding:.2em;
      border-radius:50%;
      line-height:1em;
      color: white;
      background:#c0392b;
      text-align:center;
      min-width: 1em;
      //font-weight:bold;
    }
  </style>
  <!-- end theme style -->

  @yield('player-sc')

</head>
<!-- end head -->
<!--body start-->
<body>
  <!-- preloader -->
  @if ($preloader == 1)
  <div class="loading">
    <div class="logo">
      <img src="{{ asset('images/logo/'.$logo) }}" class="img-responsive" alt="{{$w_title}}">
    </div>
    <div class="loading-text">
      <span class="loading-text-words">L</span>
      <span class="loading-text-words">O</span>
      <span class="loading-text-words">A</span>
      <span class="loading-text-words">D</span>
      <span class="loading-text-words">I</span>
      <span class="loading-text-words">N</span>
      <span class="loading-text-words">G</span>
    </div>
  </div>
  @endif
  <!-- end preloader -->
  <div class="body-overlay-bg"></div>

  @if (Session::has('added'))
  <div id="sessionModal" class="sessionmodal rgba-green-strong z-depth-2">
    <i class="fa fa-check-circle"></i> <p>{{session('added')}}</p>
  </div>
  @elseif (Session::has('updated'))
  <div id="sessionModal" class="sessionmodal rgba-cyan-strong z-depth-2">
    <i class="fa fa-exclamation-triangle"></i> <p>{{session('updated')}}</p>
  </div>
  @elseif (Session::has('deleted'))
  <div id="sessionModal" class="sessionmodal rgba-red-strong z-depth-2">
    <i class="fa fa-window-close"></i> <p>{{session('deleted')}}</p>
  </div>
  @endif
  <!-- preloader -->
  <div class="preloader">
    <div class="status">
      <div class="status-message">
      </div>
    </div>
  </div>

 @php
  $subscribed = null;
  $withlogin= App\Config::findOrFail(1)->withlogin;
  $catlog = App\Config::findOrFail(1)->catlog;    
  if (isset($auth)) {
    $current_date = Illuminate\Support\Carbon::now();
    $paypal=App\PaypalSubscription::where('user_id',$auth->id)->orderBy('created_at','desc')->first();

    if (isset($paypal)) {
      if (date($current_date) <= date($paypal->subscription_to)) {
        if ($paypal->package_id==0) {
          $nav_menus=App\Menu::all();
          $subscribed=1;
        }
      }
    }

    $auth = Illuminate\Support\Facades\Auth::user();
    if ($auth->is_admin == 1) {
      $subscribed = 1;
      $nav_menus=App\Menu::orderBy('position','ASC')->get();
    } else{
      Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
      if ($auth->stripe_id != null) {
        $customer = Stripe\Customer::retrieve($auth->stripe_id);
      }
      if (isset($customer)) {         
        $data = $auth->subscriptions->last();      
      } 
      if (isset($paypal) && $paypal != null && $paypal->count()>0) {
        $last = $paypal;
      } 
      $stripedate = isset($data) ? $data->created_at : null;
      $paydate = isset($last) ? $last->created_at : null;
      if($stripedate > $paydate){
        if($auth->subscribed($data->name) && date($current_date) <= date($data->subscription_to) && $data->ends_at == null){
          $subscribed = 1;
          $planmenus= DB::table('package_menu')->where('package_id',$data->stripe_plan)->get();
           if(isset($planmenus)){ 
            foreach ($planmenus as $key => $value) {
              $menus[]=$value->menu_id;
            }
          }
          if(isset($menus)){ 
            $nav_menus=App\Menu::whereIn('id',$menus)->get();
          }
        }
      }
      elseif($stripedate < $paydate){
        if ((date($current_date) <= date($last->subscription_to)) && $last->status == 1){
          $subscribed = 1;
          $planmenus= DB::table('package_menu')->where('package_id', $last->plan['plan_id'])->get();
          if(isset($planmenus)){ 
            foreach ($planmenus as $key => $value) {
              $menus[]=$value->menu_id;
            }
          }
          if(isset($menus)){ 
            $nav_menus=App\Menu::whereIn('id',$menus)->get();
          }
        }
      }
    }
  }
$menuh=App\Menu::orderBy('position','ASC')->get();
$config=App\Config::first();
@endphp
<!-- end preloader -->
<!-- navigation -->
<div class="navigation">
  <div class="container-fluid nav-container">
    <div class="row">
      <div class="col-sm-12 col-md-12 col-lg-2">
        <div class="nav-logo">
           <a href="{{url('/')}}" title="{{$w_title}}"><img src="{{asset('images/logo/'.$logo)}}" class="img-responsive" alt="{{$w_title}}"></a>
        </div>
      </div>
     <div class="col-md-4">
       @if($withlogin==1 && $catlog==1 && $subscribed!=1)
        <div id="cssmenu">

          @if (isset($menuh) )
          <ul>
            @foreach ($menuh as $menus)
            <li><a class="{{ Nav::hasSegment($menus['slug']) }}" href="{{url('/guest', $menus['slug'])}}"  title="{{$menus['name']}}">
              {{ $menus->name }}
            </a></li>
            @endforeach
          </ul>
          @endif
        </div>


        @endif
        @auth
        @if($withlogin==0 && $catlog==1 && $subscribed!=1)
        <div id="cssmenu">

          @if (isset($menuh) )
          <ul>
            @foreach ($menuh as $menus)
              <li>
                <a class="{{ Nav::hasSegment($menus['slug']) }}" href="{{url('/', $menus['slug'])}}"  title="{{$menus['name']}}">
                   {{ $menus->name }}
                </a>
              </li>
            @endforeach
          </ul>
          @endif

        </div>

        @else
        @if($subscribed == 1)
          <div id="cssmenu">
            @if (isset($nav_menus) && count($nav_menus) > 0)
            <ul>
              @foreach ($nav_menus as $menu)
                <li>
                  <a class="{{ Nav::hasSegment($menu->slug) }}" href="{{url('/', $menu->slug)}}"  title="{{$menu->name}}">
                     {{ $menu->name }}
                  </a>
                </li>
              @endforeach
            </ul>
            @endif
          </div>
        @endif
        @endif
        @endauth
     </div>

    
      <div class="col-sm-12 col-md-12 col-lg-6 pull-right">
        <div class="login-panel-main-block">
          <ul>
            @auth
            @if($subscribed == 1)
            <li class="prime-search-block">
              {!! Form::open(['method' => 'GET', 'action' => 'HomeController@search', 'class' => 'search_form']) !!}
              <div class="aa-input-container" id="aa-input-container">
                {!! Form::text('search', null, ['class' => 'search-input', 'placeholder' => 'Search','required']) !!}
                <button type="submit" class="search-button"><i class="fa fa-search"></i>
                </button>
              </div>
              {!! Form::close() !!}
            </li>
            <!-- notificaion -->
            <li> <div id="ex4" class="dropdown prime-dropdown">

              <span class="p1 fa-stack fa-2x has-badge dropdown-toggle" type="button" data-toggle="dropdown" data-count="{{auth()->user()->unreadnotifications->count()}}">

                <i class="p3 fa fa-bell fa-stack-1x xfa-inverse" data-count="4b"></i>

              </span>

              <ul class="dropdown-menu prime-dropdown-menu">


                @foreach (auth()->user()->unreadnotifications as $n) 
                <li>
                  @php
                  $tv=null;$movie=null;$tvname=null;$moviename=null;
                  if(isset($n->tv_id) && !is_null($n->tv_id)){
                    $season=App\Season::where('id',$n->tv_id)->first();
                    if(isset($season)){
                      $tv=App\TvSeries::findOrFail($season->tv_series_id);
                    }
                  }
                  if(isset($n->movie_id) && !is_null($n->movie_id)){
                    $movie=App\Movie::where('id',$n->movie_id)->get();
                    if(isset($movie)){
                      foreach($movie as $m){
                        $moviename=$m->title;
                      }

                    }
                  }
                  @endphp
                  <div id="notification_id" onclick="readed('{{$n->id}}')" class="card" style="padding: 6px;" >
                    <p style="color: #2980b9; font-size: 17px; padding: 3px;"><b> {{$n->title}}</b></p>
                    <p style="margin-top: -6px; font-size: 16px;"> {{$n->data['data']}} &nbsp 
                      @if(isset($tv))
                      <a type="button" href="{{url('show/detail',$season->id)}}" style="font-size: 16px; color:  #a9ea81">
                        <b> "{{$tv->title}}"</b></a>
                        @endif 
                        &nbsp
                        @if(isset($moviename))
                        <a type="button" href="{{url('movie/detail', $n->movie_id)}}" style="font-size: 16px;color: #a9ea81">
                          <b> "{{$moviename}}"</b>
                        </a> @endif 
                      </p>

                    </div>
                    <hr style="margin-top: 1px;">
                  </li>
                  @endforeach
                </ul>
              </div> 
            </li>
            @endif
            @if (isset($languages) && count($languages) > 0)

                  @if(count($languages)!=1)
            <li class="sign-in-block language-switch-block">
              <div class="dropdown prime-dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-globe"></i> {{Session::has('changed_language') ? ucfirst(Session::get('changed_language')) : ''}}</button>
                <span class="caret caret-one"></span></button>
                <ul class="dropdown-menu prime-dropdown-menu">
                
                   @foreach ($languages as $language)

                  <li>

                    <a href="{{ route('languageSwitch', $language->local) }}">
                      {{$language->name}} 
                    </a>
                  </li>

                  @endforeach
                
                </ul>
              </div>
            </li>
            @endif
            @endif
            <li class="sign-in-block">
              <div class="dropdown prime-dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="fa fa-user-circle"></i> @if(Session::has('nickname')) {{ Session::get('nickname') }} @else {{$auth ? $auth->name : ''}} @endif
                  <span class="caret"></span></button>
                  <ul class="dropdown-menu prime-dropdown-menu">
                    @if($auth->is_admin == 1)
                    <li><a href="{{url('admin')}}" target="_blank">Admin {{$header_translations->where('key', 'dashboard') ? $header_translations->where('key', 'dashboard')->first->value['value'] : ''}}</a></li>
                    
                    @endif
                     @if($auth->is_assistant == 1)
                    <li>

                      <a href="{{url('admin/movies')}}" target="_blank">Manager {{$header_translations->where('key', 'dashboard') ? $header_translations->where('key', 'dashboard')->first->value['value'] : ''}}</a>
                     </li>
                    
                    @endif
                    @if(isset($nav_menus))
                    @if($catlog==1)
                    @if($subscribed == 1)
                     @foreach ($nav_menus as $menu)
                      <li><a href="{{url('account/watchlist', $menu->slug)}}" class="active">{{$header_translations->where('key', 'watchlist')->first->value['value']}}</a></li>
                    @break;
                    @endforeach

                      <li><a href="{{route('watchhistory')}}" >{{$header_translations->where('key', 'watch history') ? $header_translations->where('key', 'watch history')->first->value['value'] : ''}}</a></li>
                    @else
                    <li><a href="{{url('account/purchaseplan')}}">Subscribe</a></li>
                    @endif
                    @else
                    <li><a href="{{url('account/watchlist', $menu->slug)}}" class="active">{{$header_translations->where('key', 'watchlist')->first->value['value']}}</a></li>
                     <li><a href="{{route('watchhistory')}}" >{{$header_translations->where('key', 'watch history') ? $header_translations->where('key', 'watch history')->first->value['value'] : ''}}</a></li>
                    @endif

                    @endif
                    <li><a href="{{url('account')}}">{{$header_translations->where('key', 'dashboard') ? $header_translations->where('key', 'dashboard')->first->value['value'] : ''}}</a></li>
                     @if(isset(Auth::user()->paypal_subscriptions) && $subscribed == 1 && $config->blog==1)
                    <li><a href="{{url('account/blog')}}">Blog</a></li>
                 @endif
                    @if(isset(Auth::user()->paypal_subscriptions) && $subscribed == 1)
                    <li><a href="{{url('/manageprofile/mus/'.Auth::user()->id)}}">Manage Profiles</a></li>
                    @endif
                    @php
                    $data=App\Config::findOrFail(1);
                    $donation= $data->donation;
                    $donation_link=$data->donation_link;
                    @endphp
                    @if(!is_null($donation) && !is_null($donation_link) && $donation==1)
                    <li><a target="_blank" href="{{$donation_link}}">{{$header_translations->where('key', 'donation') ? $header_translations->where('key', 'donation')->first->value['value'] : ''}}</a></li>
                    @endif
                    <li><a href="{{url('faq')}}">{{$header_translations->where('key', 'faqs') ? $header_translations->where('key', 'faqs')->first->value['value'] : ''}}</a></li>
                    <li>
                      <a href="{{ route('custom.logout') }}">
                       {{$header_translations->where('key', 'sign out') ? $header_translations->where('key', 'sign out')->first->value['value'] : ''}}
                     </a>
                                      </li>
                </ul>
              </div>
            </li>
            @else

            <li class="sign-in-block sign-in-block-one sign-in-block-two mrgn-rt-20"><a class="sign-in" href="{{url('login')}}"><i class="fa fa-sign-in"></i> {{$header_translations->where('key', 'sign in') ? $header_translations->where('key', 'sign in')->first->value['value'] : ''}}</a></li>
            <li class="sign-in-block sign-in-block-one "><a class="sign-in" href="{{url('register')}}"><i class="fa fa-user-plus"></i> {{$header_translations->where('key', 'register') ? $header_translations->where('key', 'register')->first->value['value'] : ''}}</a></li>
            @endauth
          </ul>
        </div>
      </div>
    </div>
  </div>
</div>
<div>
 @if($auth)
 @if($subscribed!=1)
 <div style="
 position: -webkit-sticky;
 position: sticky;
 top: 0;
 width: 100%;
 background-color: #c0392b;
 color: white;
 text-align: center;" >
 <p>Please Subscribe to a Plan. &nbsp<a href="{{url('account/purchaseplan')}}" style="color: #1B1464;">Click Here</a></p>
</div>
@endif
@endif



<!-- end navigation -->
@yield('main-wrapper')
<!-- footer -->
@if($prime_footer == 1)
<footer id="prime-footer" class="prime-footer-main-block">
  <div class="container-fluid">
    <div style="height:0px;">
      <a id="back2Top" title="Back to top" href="#">&#10148;</a>
    </div>
    <div class="logo">
      <img src="{{asset('images/logo/'.$logo)}}" class="img-responsive" alt="{{$w_title}}">
    </div>

    <div class="text-center">
      @php
      $si = App\SocialIcon::first();
      @endphp
      <div class="footer-widgets social-widgets social-btns">
        <ul>
          <li><a href="{{ $si->url1 }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
          <li><a href="{{ $si->url2 }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
          <li><a href="{{ $si->url3 }}" target="_blank"><i class="fa fa-youtube"></i></a></li>
        </ul>
      </div>
    </div>
    @php
    $config=App\Config::first();
    $isplay=$config->is_playstore;
    $isappstore=$config->is_appstore;
    $appstore=$config->appstore;
    $playstore=$config->playstore;
    @endphp
    <div class="text-center">
      <div class="footer-widgets social-widgets social-btns">
        <ul>
         @if($isappstore==1)
         <li> <a href="{{$appstore}}" target="_blank"> <img width="12%" height="12%" src="{{asset('images/app_store_download.png')}}"></a></li>
         @endif
         @if($isplay==1)
         <li>
           <a href="{{$playstore}}"  target="_blank"> <img  width="12%" height="12%" src="{{asset('images/google_play_download.png')}}"></a>
         </li>
         @endif
       </ul>
     </div>
   </div>

   <div class="copyright">
    <ul>
      <li>
        @if(isset($copyright))
        &copy;{{date('Y')}} {!! $copyright !!}
        @endif
      </li>
    </ul>
    <ul>
      <li><a href="{{url('terms_condition')}}">{{$footer_translations->where('key', 'terms and condition') ? $footer_translations->where('key', 'terms and condition')->first->value['value'] : ''}}</a></li>
      <li><a href="{{url('privacy_policy')}}">{{$footer_translations->where('key', 'privacy policy') ? $footer_translations->where('key', 'privacy policy')->first->value['value'] : ''}}</a></li>
      <li><a href="{{url('refund_policy')}}">{{$footer_translations->where('key', 'refund policy') ? $footer_translations->where('key', 'refund policy')->first->value['value'] : ''}}</a></li>
      <li><a href="{{url('faq')}}">{{$footer_translations->where('key', 'help') ? $footer_translations->where('key', 'help')->first->value['value'] : ''}}</a></li>
      <li><a href="{{url('contactus')}}">Contact us</a></li>



    </ul>




  </div>
</div>
</div>
</footer>
@else
<footer id="footer-main-block" class="footer-main-block">
  <div class="pre-footer">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-3">
          <div class="footer-logo footer-widgets">
            @if(isset($logo))
            <img src="{{asset('images/logo/'.$logo)}}" class="img-responsive" alt="{{$w_title}}">
            @endif
          </div>
        </div>
        
        <div class="col-md-4">
          <div class="footer-widgets">
            <div class="row">
              <div class="col-md-6">
                <div class="footer-links-block">
                  <h4 class="footer-widgets-heading">{{$footer_translations->where('key', 'corporate') ? $footer_translations->where('key', 'corporate')->first->value['value'] : ''}}</h4>
                  <ul>
                    <li><a href="{{url('terms_condition')}}">{{$footer_translations->where('key', 'terms and condition') ? $footer_translations->where('key', 'terms and condition')->first->value['value'] : ''}}</a></li>
                    <li><a href="{{url('privacy_policy')}}">{{$footer_translations->where('key', 'privacy policy') ? $footer_translations->where('key', 'privacy policy')->first->value['value'] : ''}}</a></li>
                    <li><a href="{{url('refund_policy')}}">{{$footer_translations->where('key', 'refund policy') ? $footer_translations->where('key', 'refund policy')->first->value['value'] : ''}}</a></li>
                    <li><a href="{{url('faq')}}">{{$footer_translations->where('key', 'help') ? $footer_translations->where('key', 'help')->first->value['value'] : ''}}</a></li>

                  </ul>
                </div>
              </div>
              <div class="col-md-6">
                <div class="footer-links-block">
                  <h4 class="footer-widgets-heading">{{$footer_translations->where('key', 'sitemap') ? $footer_translations->where('key', 'sitemap')->first->value['value'] : ''}}</h4>
                  <ul>
                   {{--  <li><a href="{{url('home')}}">Home</a></li>
                    <li><a href="{{url('movies')}}">Movies</a></li>
                    <li><a href="{{url('tvseries')}}">Tv Shows</a></li>
                    <li><a href="#">Corporate</a></li> --}}
                    @php
                      $memu = App\Menu::all();
                    @endphp
                    @if(isset($memu))
                      @foreach($memu as $value)
                        @if($value->slug != null ||$value->slug != '')  
                              @php $mySlug = $value->slug; @endphp
                               <li><a href="{{url($mySlug)}}">{{$value->name}}</a></li>
                        @endif      
                      @endforeach
                    @endif
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="footer-widgets subscribe-widgets">
            <h4 class="footer-widgets-heading">{{$footer_translations->where('key', 'subscribe') ? $footer_translations->where('key', 'subscribe')->first->value['value'] : ''}}</h4>
            <p class="subscribe-text">{{$footer_translations->where('key', 'subscribe text') ? $footer_translations->where('key', 'subscribe text')->first->value['value'] : ''}}</p>
            {!! Form::open(['method' => 'POST', 'action' => 'emailSubscribe@subscribe']) !!}
            {{ csrf_field() }}
            <div class="form-group">
              <input type="email" name="email" class="form-control subscribe-input" placeholder="Enter your e-mail">
              <button type="submit" class="subscribe-btn"><i class="fa fa-long-arrow-alt-right"></i></button>
            </div>
            {!! Form::close() !!}
          </div>
        </div>
        <div class="col-md-2">
          @php
          $si = App\SocialIcon::first();
          @endphp
          <div class="footer-widgets social-widgets social-btns">
            <ul>
              <li><a href="{{ $si->url1 }}" target="_blank"><i class="fa fa-facebook"></i></a></li>
              <li><a href="{{ $si->url2 }}" target="_blank"><i class="fa fa-twitter"></i></a></li>
              <li><a href="{{ $si->url3 }}" target="_blank"><i class="fa fa-youtube"></i></a></li>
              @php
              $config=App\Config::first();
              $isplay=$config->is_playstore;
              $isappstore=$config->is_appstore;
              $appstore=$config->appstore;
              $playstore=$config->playstore;
              @endphp
              
              @if($isappstore==1)
              <li> <a href="{{$appstore}}" target="_blank"> <img width="72%" height="72%" src="{{asset('images/app_store_download.png')}}"></a></li>
              @endif
              @if($isplay==1)
              <li>
               <a href="{{$playstore}}"  target="_blank"> <img  width="72%" height="72%" src="{{asset('images/google_play_download.png')}}"></a>
             </li>
             @endif
             
           </ul>
         </div>
       </div>
     </div>
   </div>

 </div>

 <div class="container-fluid">
  <div class="copyright-footer">
    @if(isset($copyright))
   &copy;{{date('Y')}} {!! $copyright !!}
    @endif
  </div>
</div>
</footer>
@endif
<!-- end footer -->
<!-- jquery -->
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script> <!-- bootstrap js -->
<script type="text/javascript" src="{{asset('js/playlist.js')}}"></script> <!-- playlist js -->
<script type="text/javascript" src="{{asset('js/youtube-videojs.min.js')}}"></script> <!-- youtube video js -->
<script type="text/javascript" src="{{asset('js/videojs-hls.js')}}"></script> <!-- videojs hls js -->
<script type="text/javascript" src="{{asset('js/vimeo.min.js')}}"></script> <!-- vimeo video js -->
<script type="text/javascript" src="{{asset('js/jquery.popover.js')}}"></script> <!-- bootstrap popover js -->
<script type="text/javascript" src="{{asset('js/menumaker.js')}}"></script> <!-- menumaker js -->
<script type="text/javascript" src="{{asset('js/jquery.curtail.min.js')}}"></script> <!-- menumaker js -->
<script type="text/javascript" src="{{asset('js/owl.carousel.min.js')}}"></script> <!-- owl carousel js -->
<script type="text/javascript" src="{{asset('js/jquery.scrollSpeed.js')}}"></script> <!-- owl carousel js -->
<script type="text/javascript" src="{{asset('js/TweenMax.min.js')}}"></script> <!-- animation gsap js -->
<script type="text/javascript" src="{{asset('js/ScrollMagic.min.js')}}"></script> <!-- custom js -->
<script type="text/javascript" src="{{asset('js/videojs-playlist-ui.min.js')}}"></script> <!-- videojs playlist js -->
<script type="text/javascript" src="{{asset('js/animation.gsap.min.js')}}"></script> <!-- animation gsap js -->
<script type="text/javascript" src="{{asset('js/debug.addIndicators.min.js')}}"></script> <!-- debug addIndicators js -->
<script type="text/javascript" src="{{asset('js/modernizr-custom.js')}}"></script> <!-- debug addIndicators js -->
<script type="text/javascript" src="{{asset('js/theme.js')}}"></script> <!-- custom js -->
<script type="text/javascript" src="{{asset('js/custom-js.js')}}"></script>
<script type="text/javascript" src="{{ url('js/colorbox.js') }}"></script>
{{-- start rating js --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
<!-- end jquery -->
@yield('custom-script')
<script>

if ('serviceWorker' in navigator) {
  window.addEventListener('load', () => {
    navigator.serviceWorker.register('{{ url('sw.js') }}')
        .then((reg) => {
          console.log('Service worker registered.', reg);
        });
  });
}
</script>
<script>
  (function($) {
// Session Popup
$('.sessionmodal').addClass("active");
setTimeout(function() {
  $('.sessionmodal').removeClass("active");
}, 7000);

if (window.location.hash == '#_=_'){
  history.replaceState
  ? history.replaceState(null, null, window.location.href.split('#')[0])
  : window.location.hash = '';
}
})(jQuery);
</script>

@if($google)
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
    (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
    m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', '{{$google}}', 'auto');
  ga('send', 'pageview');

</script>
@endif
@if($fb)
<!-- facebook pixel -->
<script>
  !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
      document,'script','https://connect.facebook.net/en_US/fbevents.js');
    fbq('init', '{{$fb}}');
    fbq('track', 'PageView');
  </script>
  <!--End facebook pixel -->
  @endif

  @if($rightclick == 1)
  <script type="text/javascript" language="javascript">
// Right click disable
$(function() {
  $(this).bind("contextmenu", function(inspect) {
    inspect.preventDefault();
  });
});
// End Right click disable
</script>
@endif

@if($inspect == 1)
<script type="text/javascript" language="javascript">
//all controller is disable
$(function() {
  var isCtrl = false;
  document.onkeyup=function(e){
    if(e.which == 17) isCtrl=false;
  }

  document.onkeydown=function(e){
    if(e.which == 17) isCtrl=true;
    if(e.which == 85 && isCtrl == true) {
      return false;
    }
  };
  $(document).keydown(function (event) {
        if (event.keyCode == 123) { // Prevent F12
          return false;
        }
      else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I
        return false;
      }
    });
});
// end all controller is disable
</script>
@endif


@if($goto==1)
<script type="text/javascript">
 // go to top
 $(window).scroll(function() {
  var height = $(window).scrollTop();
  if (height > 100) {
    $('#back2Top').fadeIn();
  } else {
    $('#back2Top').fadeOut();
  }
});
 $(document).ready(function() {
  $("#back2Top").click(function(event) {
    event.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "slow");
    return false;
  });

});
// end go to top
</script>
@endif
<script type="text/javascript">
 function readed(id){

   $.ajax({
    type : 'GET',
    data : { id:id },
    url  : '{{ url('/user/notification/read') }}/'+id,
    success :function(data){
      console.log(data);
    }
  });
 }
 
</script>
@yield('script')
</body>
<!--body end -->
</html>
