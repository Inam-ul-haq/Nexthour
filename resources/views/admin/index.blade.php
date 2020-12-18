@extends('layouts.admin')
@section('title','Dashboard')
@section('stylesheet')
   {!! Charts::assets() !!}
@endsection
@section('content')
  <div class="content-main-block mrg-t-40">
    <h4 class="admin-form-text">Dashboard</h4>
    <div class="row">
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/users')}}" class="small-box z-depth-1 hoverable bg-aqua default-color">
          <div class="inner">
            <h3>{{$users_count}}</h3>
            <p>Total Registered Users</p>
          </div>
          <div class="icon">
           <i class="fa fa-users" aria-hidden="true"></i>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/users')}}" class="small-box z-depth-1 hoverable bg-olive">
          <div class="inner">
            <h3>{{ $activeusers }}</h3>
            <p>Total Active Users</p>
          </div>
          <div class="icon">
            <i class="fa fa-line-chart" aria-hidden="true"></i>
          </div>
        </a>
      </div>

      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/movies')}}" class="small-box z-depth-1 hoverable bg-red danger-color">
          <div class="inner">
            <h3>{{$movies_count}}</h3>
            <p>Total Movies</p>
          </div>
          <div class="icon">
            <i class="fa fa-film" aria-hidden="true"></i>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/tvseries')}}" class="small-box z-depth-1 hoverable bg-green success-color">
          <div class="inner">
            <h3>{{$tvseries_count}}</h3>
            <p>Total Tv Serieses</p>
          </div>
          <div class="icon">
            <i class="fa fa-file-video-o" aria-hidden="true"></i>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/packages')}}" class="small-box z-depth-1 hoverable bg-yellow secondary-color">
          <div class="inner">
            <h3>{{$package_count}}</h3>
            <p>Total Packages</p>
          </div>
          <div class="icon">
            <i class="fa fa-sticky-note" aria-hidden="true"></i>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/coupons')}}" class="small-box z-depth-1 hoverable bg-green warning-color">
          <div class="inner">
            <h3>{{$coupon_count}}</h3>
            <p>Total Coupons</p>
          </div>
          <div class="icon">
            <i class="fa fa-ticket" aria-hidden="true"></i>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/faqs')}}" class="small-box z-depth-1 hoverable bg-yellow pink darken-4">
          <div class="inner">
            <h3>{{$faq_count}}</h3>
            <p>Total Faqs</p>
          </div>
          <div class="icon">
            <i class="fa fa-question-circle-o" aria-hidden="true"></i>
          </div>
        </a>
      </div>
      <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/genres')}}" class="small-box z-depth-1 hoverable bg-aqua  grey darken-2">
          <div class="inner">
            <h3>{{$genres_count}}</h3>
            <p>Total Genres</p>
          </div>
          <div class="icon">
            <i class="fa fa-filter" aria-hidden="true"></i>
          </div>
        </a>
      </div>

    {{--   <div class="col-lg-3 col-xs-6">
        <!-- small box -->
        <a href="{{url('admin/report/revenue')}}" class="small-box z-depth-1 hoverable bg-blue darken-2">
          <div class="inner">
            <h3> <i class="{{ $currency_symbol }}" aria-hidden="true"></i> {{$totalrevnue}}</h3>
            <p>Total Revenue</p>
          </div>
          <div class="icon">
            <i class="{{ $currency_symbol }}" aria-hidden="true"></i>
          </div>
        </a>
      </div> --}}

      
    </div>
    <div class="row">
      <div class="col-md-6">
        {!! $chart->render() !!}
      </div>

      <div class="col-md-6">
        {!! $chart2->render() !!}
      </div>
    </div>
    <br>
      <div class="panel panel-default">
       <div class="panel-heading">Recently Registered Users</div>
        <div class="panel-body">
          
          <div class="row">
            @foreach(App\User::where('is_admin','!=','1')->orderBy('id','DESC')->take(6)->get() as $user)
              <div class="col-md-4">
              <!-- Widget: user widget style 1 -->
              <div class="box box-widget widget-user">
                <!-- Add the bg color to the header using any of the bg-* classes -->
                <div class="widget-user-header bg-aqua-active">
                  <h3 class="widget-user-username">{{ $user->name }}</h3>
                  
                </div>
                <div class="widget-user-image">
                  <img class="img-circle" src="{{ url('images/default.jpg') }}" alt="User Avatar">
                </div>
                <div class="box-footer">
                  <div class="row">
                    
                    <div class="col-sm-12 border-right">
                      <div class="description-block">
                        <h5 class="description-header">{{ $user->email }}</h5>
                        <span class="description-text">Email</span>
                      </div>
                      <!-- /.description-block -->
                    </div>
                   
                  </div>
                  <!-- /.row -->
                </div>
              </div>
              <!-- /.widget-user -->
            </div>
            @endforeach
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection

