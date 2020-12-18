@extends('layouts.admin')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> My Profile</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">
          <h5 class="admin-form-heading">Change Email</h5>
          <p class="info">Currnet email: {{$auth->email}}</p>
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
              <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> Update</button>
            </div>
            <div class="clear-both"></div>
          {!! Form::close() !!}
        </div>
      </div>
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">
          <h5 class="admin-form-heading">Change Password</h5>
          <p class="info">Do you want to change password ?</p>
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
              <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> Update</button>
            </div>
            <div class="clear-both"></div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection
