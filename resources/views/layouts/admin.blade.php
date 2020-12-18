<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title') - Admin - {{$w_title}}</title>
  <!-- favicon-icon -->
  <link rel="icon" type="image/icon" href="{{asset('images/favicon/favicon.png')}}"/>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport"/>
  <!-- Google Fonts -->
  <link href="//fonts.googleapis.com/css?family=Open+Sans:400,600,700" rel="stylesheet"/>
  <!-- Material Icons -->
  <link href="//fonts.googleapis.com/icon?family=Material+Icons"
  rel="stylesheet"/>
  {{-- datable css --}}
   {{-- datable offline files --}}
   <link rel="stylesheet" type="text/css" href="{{asset('css/button.datatable.css')}}">
   <link rel="stylesheet" type="text/css" href="{{asset('css/datatable.min.css')}}"/>
   <link href ="{{asset('css/datatable_material.css')}}" rel="stylesheet" />
 
  <link href ="{{asset('css/dataTables.material.min.css')}}" rel="stylesheet" />
 
   <link href="//cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css" rel="stylesheet">
  {{-- smooth jquery css --}}
  
<link rel="stylesheet" href="{{asset('css/maincss.css')}}"/>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" type="text/css" />

 
  <!-- Jquery Ui Css -->
  <link rel="stylesheet" href="{{asset('css/jquery-ui.min.css')}}"/>
  <link rel="stylesheet" href="{{asset('css/jquery-jvectormap.css')}}"/>
  <!-- Admin (main) Style Sheet -->
  <link rel="stylesheet" href="{{asset('css/admin.css')}}"/>

  <link rel="stylesheet" href="{{ asset('css/bootstrap-tagsinput.css') }}"/>
  <link rel="stylesheet" href="{{ asset('css/custom-style.css') }}"/>

  <!-- select 2 -->
  
  <link href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/css/select2.min.css" rel="stylesheet" />

  <script>
    window.Laravel =  <?php echo json_encode([
      'csrfToken' => csrf_token(),
    ]); ?>
  </script>
  <style media="screen">
    .ht::first-letter{
      text-transform: uppercase;
    }


  </style>

  @yield('stylesheet')
</head>
<body class="hold-transition skin-blue">
  <div class="loading-block">
    <div class="loading z-depth-4"></div>
  </div>
  <div class="wrapper">
    <!-- Main Header -->
    <header class="main-header">
      <!-- Logo -->
      <a href="{{url('/admin')}}" class="logo" title="{{$w_title}}">
        @if(isset($logo))
        <img src="{{asset('images/logo/'.$logo)}}" class="img-responsive" alt="{{$w_title}}">
        @endif
      </a>
      @php
      $nav_menus=App\Menu::all();
      @endphp
      <!-- Header Navbar -->
      <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
          <span class="sr-only">Toggle navigation</span>
        </a>
        @if (isset($nav_menus) && count($nav_menus) > 0)
        <a href="{{isset($nav_menus[0]) ? route('home', $nav_menus[0]->slug) : '#'}}" target="_blank" class="visit-site-btn btn" title="Visit Site">Visit Site <i class="material-icons right">keyboard_arrow_right</i></a>
        @else
        <a href="#" data-toggle="tooltip" data-placement="bottom" data-original-title="Please create at least one menu to visit the site" class="visit-site-btn btn">Visit Site <i class="material-icons right">keyboard_arrow_right</i></a>
        @endif
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
            <li class="dropdown admin-nav">
              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="material-icons">language</i> {{Session::has('changed_language') ? Session::get('changed_language') : ''}}</button>
              <ul class="dropdown-menu animated flipInX">
                @if (isset($languages) && count($languages) > 0)
                @foreach ($languages as $language)
                <li><a href="{{ route('languageSwitch', $language->local) }}">{{$language->name}} ({{$language->local}}) </a></li>
                @endforeach
                @endif
              </ul>
            </li>
            <li class="dropdown admin-nav">
              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown"><i class="material-icons">account_circle</i></button>
              <ul class="dropdown-menu animated flipInX">
                <li><a href="{{url('admin/profile')}}" title="My Profile">My Profile</a></li>
                <li>
                  <a href="{{ route('logout') }}"
                  onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();" title="logout">
                  Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
                </form>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar" style="background-image: url({{asset('images/sidebar-7.jpg')}});">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel">
        <div class="pull-left image">
          <i class="material-icons">account_circle</i>
        </div>
        <div class="pull-left info">
          <h4 class="user-name">{{ucfirst($auth->name)}}</h4>
          @if(Auth::user()->is_admin == 1)
            <p>Admin</p>
          @else
            <p>Producer</p>
          @endif
        </div>
      </div>
      <!-- Sidebar Menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <!-- Optionally, you can add icons to the links -->
        @if(Auth::user()->is_assistant != 1)
          <li><a class="{{ Nav::isRoute('dashboard') }}" href="{{url('/admin')}}" title="Dashboard"><i class="material-icons">dashboard</i> <span>Dashboard</span></a></li>
        @endif
        @if(Auth::user()->is_assistant != 1)
          <li><a class="{{ Nav::isResource('users') }}" href="{{url('/admin/users')}}" title="Users"><i class="material-icons">people</i> <span>Users</span></a></li>
        @endif
        @if(Auth::user()->is_assistant != 1 && App\PaypalSubscription::count()>0)
        <li><a class="{{ Nav::isResource('plan') }}" href="{{url('/admin/plan')}}" title="Active Plan"><i class="material-icons">description</i> <span>Users Subscription</span></a>
        </li>
        @endif
       
        <li><a class="{{ Nav::isResource('movies') }}" href="{{url('/admin/movies')}}" title="Movies"><i class="material-icons">ondemand_video</i> <span>Movies</span></a></li>
        <li><a class="{{ Nav::isResource('livetv') }}" href="{{url('/admin/livetv')}}" title="Live TV"><i class="material-icons">shop_two</i> <span>Live TV</span></a></li>
        <li><a class="{{ Nav::isResource('tvseries') }}" href="{{url('/admin/tvseries')}}" title="TV Series"><i class="material-icons">movie_filter</i> <span>TV Series</span></a></li>
      
         <li class="treeview">
          <a href="#" class="" title="Producer Settings">
            <i class="material-icons">ondemand_video</i> <span>Producer Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @if(Auth::user()->is_assistant != 1)
              <li><a class="{{ Nav::isRoute('addedmovies') }}" href="{{route('addedmovies')}}" title="Movies"><i class="fa fa-circle-o"></i> <span>Added Movies</span></a></li>
              <li><a class="{{ Nav::isRoute('addedTvSeries') }}" href="{{route('addedTvSeries')}}" title="Movies"><i class="fa fa-circle-o"></i> <span>Added TV Series</span></a></li>
              <li><a class="{{ Nav::isRoute('addedLiveTv') }}" href="{{route('addedLiveTv')}}" title="Live TV"><i class="fa fa-circle-o"></i> <span>Added LiveTv</span></a></li>
            @endif
          </ul>
        </li>
        @if(Auth::user()->is_assistant != 1)
        <li><a class="{{ Nav::isResource('packages') }}" href="{{url('/admin/packages')}}" title="Packages"><i class="material-icons">poll</i> <span>Packages</span></a></li>
        <li><a class="{{ Nav::isResource('blog') }}" href="{{route('blog.index')}}" title="Blogs"><i class="material-icons">pages</i> <span>Blog</span></a></li>
        <li><a class="{{ Nav::isResource('directors') }}" href="{{url('/admin/directors')}}" title="Directors"><i class="material-icons">stars</i> <span>Directors</span></a></li>
        <li><a class="{{ Nav::isResource('actors') }}" href="{{url('/admin/actors')}}" title="Actors"><i class="material-icons">star_border</i> <span>Actors</span></a></li>
        <li><a class="{{ Nav::isResource('genres') }}" href="{{url('/admin/genres')}}" title="Genres"><i class="material-icons">filter_list</i> <span>Genres</span></a></li>

        <li><a class="{{ Nav::isResource('notification') }}" href="{{route('notification.create')}}" title="Genres"><i class="material-icons">notifications_active</i> <span>Notification</span></a></li>

        <li><a class="{{ Nav::isResource('audio_language') }}" href="{{url('/admin/audio_language')}}" title="Audio Languages"><i class="material-icons">queue_music</i> <span>Audio Languages</span></a></li>
        
        <li><a class="{{ Nav::isResource('menu') }}" href="{{url('/admin/menu')}}" title="Menu"><i class="material-icons">menu</i> <span>Menu / Navigation</span></a></li>
      
     
      <li class="treeview">
          <a href="#" class="" title="Stripe Settings">
            <i class="material-icons">more</i> <span>Stripe Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
                  <li><a class="{{ Nav::isResource('coupons') }}" href="{{url('/admin/coupons')}}" title="Stripe Coupons"><i class="material-icons">more</i> <span>Stripe Coupons</span></a></li>
                   @if(env('STRIPE_SECRET') != "")
        <li><a class="{{ Nav::isResource('report') }}" href="{{url('/admin/report')}}" title="Stripe Reports"><i class="material-icons">assignment</i> <span>Stripe Reports</span></a></li>
        @endif
          </ul>
        </li>
             
        <li class="treeview">
          <a href="#" class="{{ Nav::isRoute('player.set') }} {{ Nav::isRoute('ads') }}" title="Site Settings">
            <i class="material-icons">settings</i> <span>Player Setting</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
           <li class="{{ Nav::isRoute('player.set') }}"><a href="{{route('player.set')}}" title="Create ad"><i class="fa fa-circle-o"></i>Player Customization</a></li>
           <li class="{{ Nav::isResource('ads') }}"><a href="{{url('admin/ads')}}" title="Create ad"><i class="fa fa-circle-o"></i>Advertise</a></li>
           @php $ads = App\Ads::all(); @endphp
         
           


         </ul>
       </li>
        <li class="treeview">
          <a href="#" class="{{ Nav::isRoute('front.slider.limit') }} {{ Nav::isResource('customize') }}" title="Site Customization">
            <i class="material-icons">view_quilt</i> <span>Site Customization</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
               <li><a class="{{ Nav::isResource('home_slider') }}" href="{{url('/admin/home_slider')}}" title="Slider Settings"><i class="fa fa-circle-o"></i> <span>Slider Settings</span></a></li>
            <li class="{{ Nav::isResource('landing-page') }}"><a href="{{url('admin/customize/landing-page')}}" title="Landing Page"><i class="fa fa-circle-o"></i> Landing Page</a></li>
            <li class="{{ Nav::isResource('auth-page-customize') }}"><a href="{{url('admin/customize/auth-page-customize')}}" title="Login"><i class="fa fa-circle-o"></i> Sign In / Sign Up</a></li>

            <li class="{{ Nav::isRoute('social.ico') }}"><a href="{{route('social.ico')}}" title="Login"><i class="fa fa-circle-o"></i> Social Icon Setting</a></li>

            <li class="{{ Nav::isRoute('front.slider.limit') }}"><a href="{{route('front.slider.limit')}}" title="Login"><i class="fa fa-circle-o"></i> Front Page Slider Limit</a></li>
          </ul>
        </li>
        
        <li class="treeview">
          <a href="#" class="{{ Nav::isResource('settings') }} {{ Nav::isRoute('term_con') }} {{ Nav::isRoute('pri_pol') }} {{ Nav::isRoute('refund_pol') }}{{ Nav::isRoute('adsense') }}{{ Nav::isRoute('sociallogin') }} {{ Nav::isRoute('copyright') }} {{ Nav::isRoute('mail.getset') }}" title="Site Settings">
            <i class="material-icons">settings</i> <span>Site Settings</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li class="{{ Nav::isResource('settings') }}"><a href="{{url('admin/settings')}}" title="Settings"><i class="fa fa-circle-o"></i> Settings</a></li>
           
             <li class="{{ Nav::isRoute('sociallogin') }}"><a href="{{url('/admin/social-login')}}" title="Social Login Setting"><span><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Social Login Settings</span></a></li>
            
            <li class="{{ Nav::isRoute('adsense') }}"><a href="{{url('/admin/adsensesetting')}}" title="Page Setting"><span><i class="fa fa-circle-o"></i> &nbsp;&nbsp;Adsense Settings</span></a></li>
            <li class="{{ Nav::isRoute('term_con') }}"><a href="{{url('admin/term&con')}}" title="Terms &amp; Condition"><i class="fa fa-circle-o"></i> Terms &amp; Condition</a></li>
            <li class="{{ Nav::isRoute('pri_pol') }}"><a href="{{url('admin/pri_pol')}}" title="Privacy Policy"><i class="fa fa-circle-o"></i> Privacy Policy</a></li>
            <li class="{{ Nav::isRoute('refund_pol') }}"><a href="{{url('admin/refund_pol')}}" title="Refund Policy"><i class="fa fa-circle-o"></i> Refund Policy</a></li>
            <li class="{{ Nav::isRoute('copyright') }}"><a href="{{url('admin/copyright')}}" title="Copyright"><i class="fa fa-circle-o"></i> Copyright</a></li>

            <li class="{{ Nav::isRoute('customstyle') }}"><a href="{{url('admin/custom-style-settings')}}" title="Custom Css and Style"><i class="fa fa-circle-o"></i> Custom Style</a></li>


          </ul>
        </li>



        <li class="treeview">
          <a href="#" class="{{ Nav::isRoute('pricing.text') }} {{ Nav::isResource('translation') }}">
            <i class="material-icons">translate</i> <span>Translations</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a class="{{ Nav::isResource('languages') }}" href="{{url('/admin/languages')}}" title="Languages"><i class="fa fa-circle-o"></i>language <span>Languages</span></a></li>
            <li class="{{ Nav::isRoute('header-translation-index') }}"><a href="{{url('admin/header-translations')}}" title="Header"><i class="fa fa-circle-o"></i>Header</a></li>
            <li class="{{ Nav::isRoute('footer-translation-index') }}"><a href="{{url('admin/footer-translations')}}" title="Footer"><i class="fa fa-circle-o"></i>Footer</a></li>
            <li class="{{ Nav::isRoute('home-translation-index') }}"><a href="{{url('admin/home-translations')}}" title="Home Page"><i class="fa fa-circle-o"></i>Home Page</a></li>
            <li class="{{ Nav::isRoute('popover-detail-translations-index') }}"><a href="{{url('admin/popover-detail-translations')}}" title="Popover Detail"><i class="fa fa-circle-o"></i>Popover Detail</a></li>
            @php
            $package=App\Package::first();
            @endphp
            @if(isset($package))
           
    <li class="{{ Nav::isRoute('pricing.get') }}"><a href="{{route('pricing.get',$package->id)}}" title="Custom Pricing text"><i class="fa fa-circle-o"></i>Pricing Text</a></li>
          
            @endif
          </ul>
        </li>
        <li><a class="{{ Nav::isResource('faqs') }}" href="{{url('/admin/faqs')}}" title="FAQ's"><i class="material-icons">question_answer</i> <span>FAQ's</span></a></li>
        <li><a class="{{ Nav::isRoute('view.track') }}" href="{{ route('view.track') }}" title="View Tracker"><i class="material-icons">visibility</i> <span>View Tracker</span></a></li>
       @endif
   

     </ul>
     <!-- /.sidebar-menu -->
   </section>
   <!-- /.sidebar -->
 </aside>
 <!-- Content Wrapper. Contains page content -->
 <div class="content-wrapper">
  @if (Session::has('added'))
  <div id="sessionModal" class="sessionmodal rgba-green-strong z-depth-2">
    <i class="fa fa-check-circle"></i> <p>{{session('added')}}</p>
  </div>
  @elseif (Session::has('updated'))
  <div id="sessionModal" class="sessionmodal rgba-cyan-strong z-depth-2">
    <i class="fa fa-check-circle"></i> <p>{{session('updated')}}</p>
  </div>
  @elseif (Session::has('deleted'))
  <div id="sessionModal" class="sessionmodal rgba-red-strong z-depth-2">
    <i class="fa fa-window-close"></i> <p>{{session('deleted')}}</p>
  </div>
  @endif
  <!-- Content Header (Page header) -->
  <section class="content-header">
  </section>
  <!-- Main content -->
  <section class="content container-fluid">
    @yield('content')

  </section>

  <!-- /.content -->
</div>
<p class="version">Version 2.8.2&emsp;</p>
<!-- /.content-wrapper -->
<!-- Main Footer -->

</div>
<!-- ./wrapper -->
{{-- smooth jquery js --}}


<!-- Admin Js -->
<script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js" type="text/javascript"></script>
<script src="{{asset('js/admin.js')}}" type="text/javascript"></script>
<script src="{{asset('js/app.js')}}" type="text/javascript"></script>
<script src="{{asset('js/ckeditor.js')}}" type="text/javascript"></script>
<script src="{{asset('js/datatables.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/datatable.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery-ui.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/chart.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/utils.js')}}" type="text/javascript"></script>
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-pageLoadMore/1.0.0/js/dataTables.pageLoadMore.min.js"></script>
<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>
<script src="{{asset('js/jquery-jvectormap-1.2.2.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/jquery-jvectormap-world-mill-en.js')}}" type="text/javascript"></script>
<script src="{{ asset('js/bootstrap-tagsinput.min.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.8/js/select2.min.js"></script>
{{-- yajra scripts --}}

{{-- data table scripts --}}
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

 
<script src="//cdn.datatables.net/responsive/2.2.3/js/dataTables.responsive.min.js"></script>
<script src="//cdn.datatables.net/1.10.20/js/dataTables.material.min.js"></script>

<script type="text/javascript" src="//cdn.datatables.net/buttons/1.6.0/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.6.0/js/buttons.flash.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.6.0/js/buttons.html5.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.6.0/js/buttons.print.min.js"></script>

{{-- end yajra  --}}


<script src="{{ asset('js/custom-js.js') }}"></script>
<script>
  $(function () {
    // DataTables
   $('#movies_table').DataTable({
     
      responsive: true,
      "sDom": "<'row'><'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>r>t<'row'<'col-sm-12'p>>",
      "language": {
        "paginate": {
          "previous": '<i class="material-icons paginate-btns">keyboard_arrow_left</i>',
          "next": '<i class="material-icons paginate-btns">keyboard_arrow_right</i>'
          }
      },
      buttons: [
        {
          extend: 'print',
          exportOptions: {
              columns: ':visible'
          }
        },
        'csvHtml5',
        'excelHtml5',
        'colvis',
      ]
    });

    $('#full_detail_table').DataTable({
      responsive: true,
      "sDom": "<'row'><'row'<'col-md-4'l><'col-md-4'B><'col-md-4'f>r>t<'row'<'col-sm-12'p>>",
      "language": {
      "paginate": {
        "previous": '<i class="material-icons paginate-btns">keyboard_arrow_left</i>',
        "next": '<i class="material-icons paginate-btns">keyboard_arrow_right</i>'
        }
      },
      buttons: [
        {
          extend: 'print',
          exportOptions: {
              columns: ':visible'
          }
        },
        'csvHtml5',
        'excelHtml5',
        'colvis',
      ]
    });
    
    $(".js-select2").select2({
        placeholder: "Pick states",
        theme: "material"
    });

    $(".select2-selection__arrow")
        .addClass("material-icons")
        .html("arrow_drop_down");
  });
</script>
    
</script>
<script>
  $(function () {
    $('[data-toggle="popover"]').popover()
  })
</script>
@yield('custom-script')
</body>
</html>
