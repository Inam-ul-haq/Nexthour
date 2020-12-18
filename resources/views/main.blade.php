@extends('layouts.theme')
@section('title','Welcome')
@section('main-wrapper')
<!-- main wrapper -->

  

  <section id="main-wrapper" class="main-wrapper home-page">
    @if (isset($blocks) && count($blocks) > 0)
      @foreach ($blocks as $block)
        <!-- home out section -->
        <div id="home-out-section-1" class="home-out-section" style="background-image: url('{{ asset('images/main-home/'.$block->image) }}')">
          <div class="overlay-bg {{$block->left == 1 ? 'gredient-overlay-left' : 'gredient-overlay-right'}} "></div>
          <div class="container-fluid">
            <div class="row">
              <div class="col-md-6 col-sm-6 {{$block->left == 1 ? 'col-md-offset-6 col-sm-offset-6 col-sm-6 col-md-6 text-right' : ''}}">
                <h2 class="section-heading">{{$block->heading}}</h2>
                <p class="section-dtl {{$block->left == 1 ? 'pad-lt-100' : ''}}">{{$block->detail}}</p>
                @if ($block->button == 1)
                  @if ($block->button_link == 'login')
                    @guest
                      <a href="{{url('login')}}" class="btn btn-prime">{{$block->button_text}}</a>
                    @endguest
                  @else
                    @guest
                      <a href="{{url('register')}}" class="btn btn-prime">{{$block->button_text}}</a>
                    @endguest
                  @endif
                @endif
              </div>
            </div>
          </div>
        </div>
        <!-- end out section -->
      @endforeach
    @endif
    <!-- Pricing plan main block -->
    

    
    @if(isset($plans) && count($plans) > 0)
      <div class="purchase-plan-main-block main-home-section-plans">
        <div class="panel-setting-main-block">
          <div class="container">
            <div class="plan-block-dtl">
              <h3 class="plan-dtl-heading">Membership Plans</h3>
              <ul>
                <li>Select any of your preferred membership package &amp; make payment.
                </li>
                <li>You can cancel your subscription anytime later. 
                  
                  @if(Auth::check())
                    @php  
                       $id = Auth::user()->id;
                       $getuserplan = App\PaypalSubscription::where('status','=','1')->where('user_id',$id)->first();
                    @endphp
                  @endif

                  <?php
                    $today =  date('Y-m-d h:i:s');
                  ?>

    
                </li>
              </ul>
            </div>
            <div class="snip1404 row">
                
              @foreach($plans as $plan)
              @if($plan->delete_status ==1 )
                @if($plan->status == 1)
                  <div class="col-md-4 col-sm-6">
                    <div class="main-plan-section">
                      <header>
                        <h4 class="plan-title">
                          {{$plan->name}}
                        </h4>
                        <div class="plan-cost"><span class="plan-price"><i class="{{$plan->currency_symbol}}"></i>{{$plan->amount}}</span><span class="plan-type">
                            <i class="{{$plan->currency_symbol}}"></i> {{number_format(($plan->amount) / ($plan->interval_count),2)}}/
                              {{$plan->interval}}
                            
                        </span></div>
                      </header>
                      @php
                    $pricingTexts = App\PricingText::where('package_id',$plan->id)->get();
                      @endphp
                      @foreach ($pricingTexts as $element)
                      <ul class="plan-features">
                        @if (isset($pricingTexts) && count($pricingTexts) > 0)

                      @if(isset($element->title1) && !is_null($element->title1))
                        <li><i class="fa fa-check"> </i>{{ $element->title1 }}</li>
                      @endif
                      @if(isset($element->title2) && !is_null($element->title2))
                        <li><i class="fa fa-check"> </i>{{ $element->title2 }}</li>
                      @endif
                      @if(isset($element->title3) && !is_null($element->title3))
                        <li><i class="fa fa-check"> </i>{{ $element->title3 }}</li>
                      @endif
                      @if(isset($element->title4) && !is_null($element->title4))
                        <li><i class="fa fa-check"> </i>{{ $element->title4 }}</li>
                      @endif
                      @if(isset($element->title5) && !is_null($element->title5))
                        <li><i class="fa fa-check"> </i>{{ $element->title5 }}</li>
                      @endif
                      @if(isset($element->title6) && !is_null($element->title6))
                        <li><i class="fa fa-check"> </i>{{ $element->title6 }}</li>
                      @endif
                        @endif
                      </ul>
                      @endforeach
                      
                      @auth
                      @if($getuserplan['package_id'] == $plan->id && $getuserplan->status == "1" && $today <= $getuserplan->subscription_to )
                        
                        <div class="plan-select"><a class="btn btn-prime">Already Subscribed</a></div>

                      @else
                      
                        <div class="plan-select"><a href="{{route('get_payment', $plan->id)}}" class="btn btn-prime">Subscribe</a></div>

                      @endif
                        @else
                        <div class="plan-select"><a href="{{route('register')}}">Register Now</a></div>
                      @endauth
                    </div>
                  </div>
                @endif
              @endif
              @endforeach
            </div>
          </div>
        </div>
      </div>
    @endif


{{--  @if(isset(Auth::user()->multiplescreen))

 <div style="margin-top:50px;" id="showM" class="modal fade" tabindex="1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 style="color:#000" class="modal-title">
          Select Profile :
        </h4>
      </div>
      <div class="modal-body">
       <div class="container">
                <div class="row">
                  <form action="{{ route('mus.update',Auth::user()->id) }}" method="POST">
                      {{ csrf_field() }}
                    @if(Auth::user()->multiplescreen->screen1 != null)
                      <div class="col-lg-3 col-sm-6 col-6">
                          <img title="{{ Auth::user()->multiplescreen->screen1 }}" width="200px" height="200px" src="{{ url('images/avtar/03.jpg') }}" alt="">
                          <label class="user-name"><input value="{{ Auth::user()->multiplescreen->screen1 }}" type="radio" name="defscreen"> {{ Auth::user()->multiplescreen->screen1 }}</label>
                      </div>
                    @endif

                    @if(Auth::user()->multiplescreen->screen2 != null)
                      <div class="col-lg-3 col-sm-6 col-6">
                          <img title="{{ Auth::user()->multiplescreen->screen2 }}" width="200px" height="200px" src="{{ url('images/avtar/02.png') }}" alt="">
                          <label class="user-name"><input type="radio" value="{{ Auth::user()->multiplescreen->screen2 }}" name="defscreen"> {{ Auth::user()->multiplescreen->screen2 }}</label> 
                      </div>
                    @endif
                    
                    @if(Auth::user()->multiplescreen->screen3 != null)
                      <div class="col-lg-3 col-sm-6 col-6">
                          <img title="{{ Auth::user()->multiplescreen->screen3 }}" width="200px" height="200px" src="{{ url('images/avtar/03.jpg') }}" alt="">
                          <label class="user-name"><input type="radio" name="defscreen"> {{ Auth::user()->multiplescreen->screen3 }} </label>
                      </div>
                     @endif

                   @if(Auth::user()->multiplescreen->screen4 != null)
                      <div class="col-lg-4 col-sm-6 col-6">
                          <img title="{{ Auth::user()->multiplescreen->screen4 }}" width="200px" height="200px" src="{{ url('images/avtar/02.png') }}" alt="">
                          <label class="user-name"><input type="radio" value="{{Auth::user()->multiplescreen->screen4}}" name="defscreen"> {{ Auth::user()->multiplescreen->screen4 }}</label>  
                      </div>
                    @endif
                    
                    @if(Auth::user()->multiplescreen->screen5 != null)
                      <div class="col-lg-4 col-sm-6 col-6">
                          <img title="{{ Auth::user()->multiplescreen->screen5 }}" width="200px" height="200px" src="{{ url('images/avtar/08.png') }}" alt="">
                          <label class="user-name"><input value="{{ Auth::user()->multiplescreen->screen5 }}" type="radio" name="defscreen"> {{ Auth::user()->multiplescreen->screen5 }}</label>
                      </div>
                    @endif
                    
                     @if(Auth::user()->multiplescreen->screen6 != null)
                       <div class="col-lg-4 col-sm-6 col-6">
                          <img title="{{ Auth::user()->multiplescreen->screen6 }}" width="200px" height="200px" src="{{ url('images/avtar/02.png') }}" alt="">
                          <label class="user-name"><input type="radio" value="{{ Auth::user()->multiplescreen->screen6 }}" name="defscreen"> {{ Auth::user()->multiplescreen->screen6 }}</label>
                      </div>
                    @endif
                    <div align="left" class="col-md-offset-7 col-md-3">
                      <input type="submit" value="Save Profile !" class="btn btn-lg btn-primary">
                    </div>

                    
                    </form>
                </div>
            </div>
            
      </div>
      
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
  </div><!-- /.modal -->
 @else
 @auth
  @php
    $muser = new App\Multiplescreen;
    $getpkgid;
    $screen;
    foreach (Auth::user()->paypal_subscriptions as $value) {
     
        if($value->status == 1){

          $getpkgid = $value->package_id;

          $pkg = App\Package::where('id',$value->package_id)->first();

          if(isset($pkg))
          {
             $screen = $pkg->screens;
             $muser->pkg_id = $pkg->id;
          
         
          $muser->user_id = Auth::user()->id;

          if($screen ==1){
            $muser->screen1 = Auth::user()->name;
           
          }elseif($screen == 2){
            $muser->screen1= Auth::user()->name;
            $muser->screen2 = "NH2-User";
          }elseif($screen == 3)
          {
            $muser->screen1= Auth::user()->name;
            $muser->screen2 = "NH2-User";
            $muser->screen3 = "NH3-User";
          }elseif($screen == 4)
          {
            $muser->screen1= Auth::user()->name;
            $muser->screen2 = "NH2-User";
            $muser->screen3 = "NH3-User";
            $muser->screen4 = "NH4-User";
          }
          elseif($screen == 5)
          {
            $muser->screen1= Auth::user()->name;
            $muser->screen2 = "NH2-User";
            $muser->screen3 = "NH3-User";
            $muser->screen4 = "NH4-User";
            $muser->screen5 = "NH5-User";
          }
          elseif($screen == 6)
          {
            $muser->screen1= Auth::user()->name;
            $muser->screen2 = "NH2-User";
            $muser->screen3 = "NH3-User";
            $muser->screen4 = "NH4-User";
            $muser->screen5 = "NH5-User";
            $muser->screen6 = "NH6-User";
          }

          $muser->save(); 
          header("Location:",'/');

        }
        }
    }

    
  @endphp
  @endauth
 @endif --}}
    
    <!-- end featured main block -->
    <!-- end out section -->
  </section>
<!-- end main wrapper -->
@endsection
@section('script')
<script>
        
        @if(isset(Auth::user()->multiplescreen))
        @if((Auth::user()->multiplescreen->activescreen!= NULL))
         $(document).ready(function(){

           $('#showM').hide();

           });
          @else
           $(document).ready(function(){

            $('#showM').modal();

           });
          @endif
          @endif



</script>
@endsection