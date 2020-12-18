@extends('layouts.theme')
@section('title', 'Account Setting')
@section('main-wrapper')
<!-- main wrapper -->
<section id="main-wrapper" class="main-wrapper home-page user-account-section">
  <div class="container-fluid">
    <h4 class="heading">Account &amp; Settings</h4>
    <ul class="bradcump">
      <li><a href="{{url('account')}}">Dashboard</a></li>
      <li>/</li>
      <li>Account &amp; Settings</li>
    </ul>
    <div class="panel-setting-main-block">
      <div class="edit-profile-main-block">
        <div class="row">
          <div class="col-md-6">
            <div class="edit-profile-block">
              <h4 class="panel-setting-heading">Change Email</h4>
              <div class="info">Current Email: {{auth()->user()->email}}</div>
              {!! Form::open(['method' => 'POST', 'action' => 'UserAccountController@update_profile']) !!}
              <div class="form-group{{ $errors->has('new_email') ? ' has-error' : '' }}">
                {!! Form::label('new_email', 'New Email') !!}
                {!! Form::text('new_email', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('new_email') }}</small>
              </div>
              <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                {!! Form::label('current_password', 'Current Password') !!}
                {!! Form::password('current_password', ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('current_password') }}</small>
              </div>
              <div class="btn-group pull-right">
                {!! Form::submit("Update", ['class' => 'btn btn-success']) !!}
              </div>
              {!! Form::close() !!}
            </div>
          </div>
          <div class="col-md-6">
            <div class="edit-profile-block">
              <h4 class="panel-setting-heading">Change Password</h4>
              <div class="info">want to change your password ?</div>
              {!! Form::open(['method' => 'POST', 'action' => 'UserAccountController@update_profile']) !!}
              <div class="form-group{{ $errors->has('current_password') ? ' has-error' : '' }}">
                {!! Form::label('current_password', 'Current Password') !!}
                {!! Form::password('current_password', ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('current_password') }}</small>
              </div>
              <div class="form-group{{ $errors->has('new_password') ? ' has-error' : '' }}">
                {!! Form::label('new_password', 'New Password') !!}
                {!! Form::password('new_password', ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('new_password') }}</small>
              </div>
              <div class="btn-group pull-right">
                {!! Form::submit("Update", ['class' => 'btn btn-success']) !!}
              </div>
              {!! Form::close() !!}
            </div>
          </div>
          <div class="col-md-6">
            <div class="edit-profile-block">
              <h4 class="panel-setting-heading">Update Age / Mobile Number</h4>
              <div class="info">want to change age or mobile number ?</div>
              {!! Form::open(['method' => 'POST', 'action' => 'UsersController@update_age']) !!}
              
              <div class="search form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
                {!! Form::label('dob', 'Date Of Birth') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter date of Birth of User"></i>

                <input type="date" class="form-control"  name="dob" @if(isset(Auth::user()->dob)) value="{{Auth::user()->dob}}" @endif />   
                <small class="text-danger">{{ $errors->first('dob') }}</small>
              </div>
              <div class="search form-group{{ $errors->has('mobile') ? ' has-error' : '' }}">
                {!! Form::label('mobile', 'Mobile Number') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your Mobile Number"></i>
                <input type="number" class="form-control"  name="mobile"  @if(isset(Auth::user()->mobile)) value="{{Auth::user()->mobile}}"@endif />   
                <small class="text-danger">{{ $errors->first('mobile') }}</small>
              </div>

              <div class="btn-group pull-right">
                {!! Form::submit("Update", ['class' => 'btn btn-success']) !!}
              </div>

              {!! Form::close() !!}
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
</section>
<!-- end main wrapper -->
@endsection