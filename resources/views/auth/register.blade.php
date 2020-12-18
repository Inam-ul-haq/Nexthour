<!DOCTYPE html>
<html>
<head>
  <title>{{$w_title}}</title>
  <meta charset="utf-8" />  
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <meta name="Description" content="{{$description}}" />
  <meta name="keyword" content="{{$w_title}}, {{$keyword}}">
  <meta name="MobileOptimized" content="320" />
  <meta name="csrf-token" content="{{ csrf_token() }}">  
  <link rel="icon" type="image/icon" href="{{asset('images/favicon/favicon.png')}}"> <!-- favicon-icon -->
  <!-- theme style -->
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,900" rel="stylesheet"> <!-- google font -->
  <link href="{{asset('css/bootstrap.min.css')}}" rel="stylesheet" type="text/css"/> <!-- bootstrap css -->
  <link href="https://vjs.zencdn.net/6.6.0/video-js.css" rel="stylesheet"> <!-- videojs css -->
  <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/> <!-- fontawsome css -->
  <link href="{{asset('css/style.css')}}" rel="stylesheet" type="text/css"/> <!-- custom css -->
  <link href="{{asset('css/custom-style.css')}}" rel="stylesheet" type="text/css"/>
</head>
<body class="bg-black">
  <div class="signup__container container">
    <div class="row"> 
      <div class="col-sm-6 col-md-offset-2 col-md-4 pad-0">
        <div class="container__child signup__thumbnail" style="background-image: url({{ asset('images/login/'.$auth_customize->image) }});">
          <div class="thumbnail__logo">
            @if($logo != null)
              <a href="{{url('/')}}" title="{{$w_title}}"><img src="{{asset('images/logo/'.$logo)}}" class="img-responsive" alt="{{$w_title}}"></a>
            @endif
          </div>
          <div class="thumbnail__content text-center">
            {!! $auth_customize->detail !!}
          </div>
          
          <div class="signup__overlay"></div>
        </div>
      </div>
      <div class="col-sm-6 col-md-4 pad-0">
        <div class="container__child signup__form">
          <form method="POST" action="{{ route('register') }}">
            {{ csrf_field() }}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              <label for="name">Username</label>
              <input id="name" type="text" class="form-control" name="name" placeholder="Please Enter Your Username" value="{{ old('name') }}" required autofocus>
              @if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              <label for="email">Email</label>
              <input id="email" type="text" class="form-control" name="email" placeholder="Please Enter Your Email" value="{{ old('email') }}" required autofocus>
              @if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
              @endif
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              <label for="password">Password</label>
              <input id="password" type="password" class="form-control" name="password" placeholder="Please Enter Your Password" value="{{ old('password') }}" required>
                @if ($errors->has('password'))
                  <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif
            </div>
            <div class="form-group">
              <label for="password-confirm">Repeat Password</label>
              <input id="password-confirm" type="password" class="form-control" name="password_confirmation" placeholder="Please Enter Your Password Again" required>
            </div>
            <div class="m-t-lg">
              <input class="btn btn--form btn--form-login" type="submit" value="Register" />
              <div class="social-login">
                <div class="row">
                    @php
              $config=App\Config::first();
              @endphp
                  <div class="col-md-12">
                    @if($config->fb_login==1)
                <a href="{{ url('/auth/facebook') }}" class="btn btn--form btn--form-login fb-btn" title="Login With Facebook"><i class="fa fa-facebook-f"></i> Register With Facebook</a>
                @endif
                  @if($config->google_login==1)
                <a href="{{ url('/auth/google') }}" class="btn btn--form btn--form-login gplus-btn" title="Login With Google"><i class="fa fa-google"></i> Register With Google</a>
                @endif
                  @if($config->gitlab_login==1)
                 <a style="background: linear-gradient(270deg, #48367d 0%, #241842 100%);" href="{{ url('/auth/gitlab') }}" class="btn btn--form btn--form-login" title="Login With Gitlab"><i class="fa fa-gitlab"></i> Register With GitLab</a>
                 @endif                  </div>
                </div>
              </div>
              <a class="signup__link" href="{{url('login')}}">I am already a member</a>
            </div>
          </form>  
        </div>
      </div>
    </div>
  </div>
  <!-- Scripts -->
  <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
  <script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script> <!-- bootstrap js -->
  <script type="text/javascript" src="{{asset('js/jquery.popover.js')}}"></script> <!-- bootstrap popover js -->
  <script type="text/javascript" src="{{asset('js/jquery.curtail.min.js')}}"></script> <!-- menumaker js -->
  <script type="text/javascript" src="{{asset('js/jquery.scrollSpeed.js')}}"></script> <!-- owl carousel js -->
  <script type="text/javascript" src="{{asset('js/custom-js.js')}}"></script>
</body>
</html>