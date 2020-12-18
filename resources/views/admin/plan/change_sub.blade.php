@extends('layouts.admin')
@section('title','Change Subscription')
@section('content')
  <div class="admin-form-main-block mrgn-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/plan')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Change Or Add Subscription</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">          
          {!! Form::open(['method' => 'POST', 'action' => 'UsersController@change_subscription', 'files' => true]) !!}
            <div class="info form-group">
              <h5>User Name: {{$user->name}}</h5>
              @php
              if (isset($plans)) {
                $planname='not exist';
                  if (isset($last_payment->plan->name) && !is_null($last_payment)){
                     $planname=$last_payment->plan->name;
                   }else{
                    if (isset($user_stripe_plan) && !is_null($user_stripe_plan)) {
                     $planname=$user_stripe_plan->name;
                    }
                   }
               
              }else{
                  $planname='not exist';
              }

              @endphp
             
            <h5>Last Subscription Plan: {{$planname}}</h5>
         
            </div>
            <input type="hidden" name="user_stripe_plan_id" value="{{$user_stripe_plan != null ? $user_stripe_plan->id : null}}">
            <input type="hidden" name="last_payment_id" value="{{$last_payment != null ? $last_payment->id : null}}">
            <input type="hidden" name="user_id" value="{{$user->id}}">
            <div class="form-group{{ $errors->has('plan') ? ' has-error' : '' }}">
              {!! Form::label('plan', 'Select a plan') !!} 
              <p class="inline info"> - Please select plan for user</p>
              {!! Form::select('plan_id', $plan_list, null, ['class' => 'form-control select2', 'required' => 'required', 'autofocus']) !!}
              <small class="text-danger">{{ $errors->first('plan') }}</small>
            </div>
            <div class="btn-group pull-right">
              <button type="submit" class="btn btn-success">Change Subscription</button>
            </div>
            <div class="clear-both"></div>
          {!! Form::close() !!}
        </div>  
      </div>
    </div>
  </div>
@endsection
