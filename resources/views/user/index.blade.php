@extends('layouts.theme')
@section('title','User Dashboard')
@section('main-wrapper')
  <!-- main wrapper -->
  <section id="main-wrapper" class="main-wrapper home-page user-account-section">
    <div class="container-fluid">
      <h4 class="heading">Dashboard</h4>
      
      <div class="panel-setting-main-block">
        <div class="panel-setting">
          <div class="row">
            <div class="col-md-6">
              <h4 class="panel-setting-heading">Your Details</h4>
              <p>Change your Name, Email, Mobile Number, Password, and more.</p>
            </div>
            <div class="col-md-3">
              <p class="info">Your Email: {{$auth->email}}</p>
            </div>
            <div class="col-md-3">
              <div class="panel-setting-btn-block text-right">
                <a href="{{url('account/profile')}}" class="btn btn-setting">Edit Details</a>
              </div>
            </div>
          </div>
        </div>
        <div class="panel-setting">
          <div class="row">
            <div class="col-md-6">
              <h4 class="panel-setting-heading">Your Membership</h4>
              <p>Want to Change your Membership.</p>
            </div>
            <div class="col-md-3">
              @php
                $bfree = null;
                 $config=App\Config::first();
                 $auth=Auth::user();
                  if ($auth->is_admin==1) {
                $bfree=1;
              }else{
                 $ps=App\PaypalSubscription::where('user_id',$auth->id)->first();
                 if (isset($ps)) {
                   $current_date = Illuminate\Support\Carbon::now();
            if (date($current_date) <= date($ps->subscription_to)) {
            
               if ($ps->package_id==100) {
            $bfree=1;
            }else{
              $bfree=0;
            }
      }
                 }
              }
                 
              @endphp
              @if($auth->is_admin==1)
               <p class="info">Current Subscription: FREE</p>
              @else
            
             @if($bfree==1)

                <p class="info">Current Subscription: FREE till 
                  {{date($ps->subscription_to)}}</p>

              @elseif($bfree==0)
               @if(isset($ps))
                @php
                   $psn=App\Package::where('id',$ps->package_id)->first();
                @endphp
                 <p class="info">Current Subscription: {{ucfirst($psn['name'])}}</p>
                 @endif
             @else
              @if($current_subscription != null)
                <p class="info">Current Subscription: {{$method == 'stripe' ? ucfirst($current_subscription->name) : ucfirst($current_subscription->plan->name)}}</p>
              @endif
              @endif
                @endif
            </div>
            <div class="col-md-3">
              <div class="panel-setting-btn-block text-right">
                @if($current_subscription != null && $method == 'stripe') 
                  @if($auth->subscription($current_subscription->name)->cancelled())
                    <a href="{{route('resumeSub', $current_subscription->stripe_plan)}}" class="btn btn-setting"><i class="fa fa-edit"></i>Resume Subscription</a>
                  @else
                    <a href="{{route('cancelSub', $current_subscription->stripe_plan)}}" class="btn btn-setting"><i class="fa fa-edit"></i>Cancel Subscription</a>
                  @endif
                @elseif($current_subscription != null && $method == 'paypal') 
                  @if($current_subscription->status == 0)
                    <a href="{{route('resumeSubPaypal')}}" class="btn btn-setting"><i class="fa fa-edit"></i>Resume Subscription</a>
                  @elseif ($current_subscription->status == 1)
                    <a href="{{route('cancelSubPaypal')}}" class="btn btn-setting"><i class="fa fa-edit"></i>Cancel Subscription</a>
                  @endif
                @else               
                  <a href="{{url('account/purchaseplan')}}" class="btn btn-setting">Subscribe Now</a>
                @endif
              </div>
            </div>
          </div>
        </div>
        <div class="panel-setting">
          <div class="row">
            <div class="col-md-6">
              <h4 class="panel-setting-heading">Your Payment History</h4>
              <p>View your payment history.</p>
            </div>
            <div class="col-md-offset-3 col-md-3">
              <div class="panel-setting-btn-block text-right">
                <a href="{{url('account/billing_history')}}" class="btn btn-setting">View Details</a>
              </div>
            </div>
          </div>
        </div>
        {{-- <div class="panel-setting">
          <div class="row">
            <div class="col-md-6">
              <h4 class="panel-setting-heading">Parent Controll</h4>
              <p>Change your parent controll settings.</p>
            </div>
            <div class="col-md-offset-3 col-md-3">
              <div class="panel-setting-btn-block text-right">
                <a href="#" class="btn btn-setting"><i class="fa fa-edit"></i>Change Settings</a>
              </div>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
  </section>
  <!-- end main wrapper -->
@endsection