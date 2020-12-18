@extends('layouts.theme')
@section('title','Our Blog')
@section('main-wrapper')
 <section class="main-wrapper">
    <div class="container-fluid">
    @if(isset($blogs) && count($blogs) > 0)
      <div class="purchase-plan-main-block main-home-section-plans">
        <div class="panel-setting-main-block">
          <div class="container-fluid">
            <div class="plan-block-dtl">
              <h3 class="plan-dtl-heading">Our Blogs</h3>
            </div>
            <div class="snip1404 row">
              @foreach($blogs as $blog)
                  <div class="col-md-6" style="height: 600px;">
                        <div class="col-sm-12 plan-title imageblog">
                          @if(isset($blog->image))
                               <a href="{{url('account/blog/'.$blog->slug)}}"><img src="{{ asset('images/blog/'.$blog->image) }}"  class="img-responsive" alt="image"></a>
                               @endif

                           <br/>

                            <div class="main-plan-section">

                              <div>
                                @php
                                  $uname=App\User::where('id',$blog->user_id)->get();
                                  foreach($uname as $name)
                                  {
                                    $user_name = $name->name;
                                  }
                                  @endphp
                                  <p class="pull-right">
                                    <span><i class="fa fa-clock-o" style="color:white;"></i></span> {{date ('d.m.Y',strtotime($blog->created_at))}}&emsp;<span><i class="fa fa-user" style="color:white;"></i></span>{{$user_name}}
                                  </p>
                                  <h5><a href="{{url('account/blog/'.$blog->slug)}}" title="{{$blog->title}}">{{str_limit($blog->title, 30)}}</a> </h5><br/>
                              </div>
                              <div class="" >
                                  <p class="blog" >{!! str_limit($blog->detail, 60) !!}</p>
                                   
                              </div>
                              
                           </div>
                        </div>
                        <div class="plan-select pull-right"><a href="{{url('account/blog/'.$blog->slug)}}">Read More</a></div><br/>
                  </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
@endif
	</div>
	</section>
 
  @endsection