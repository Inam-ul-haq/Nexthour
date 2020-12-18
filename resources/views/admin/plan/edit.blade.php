@extends('layouts.admin')
@section('content')
  <div class="admin-form-main-block">
    <h4 class="admin-form-text"><a href="{{url('admin/plan')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Edit User</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">       
          {!! Form::model($user, ['method' => 'PATCH', 'action' => ['PlanController@update', $plan->id], 'files' => true]) !!}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Enter Name') !!}
              <p class="inline info"> - Please enter your name</p>
              {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              {!! Form::label('email', 'Email address') !!}
              <p class="inline info"> - Please enter your email</p>
              {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'eg: foo@bar.com']) !!}
              <small class="text-danger">{{ $errors->first('email') }}</small>
            </div>
            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::label('password', 'Password') !!}
              <p class="inline info"> - Please enter your password</p>
              {!! Form::password('password', ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('password') }}</small>
            </div>
            <div class="form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
              {!! Form::label('confirm_password', 'Confirm Password') !!}
              <p class="inline info"> - Please enter your password again</p>
              {!! Form::password('confirm_password', ['class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('confirm_password') }}</small>
            </div>
            <div class="form-group{{ $errors->has('is_admin') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_admin', 'Administrator') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">								
                    {!! Form::checkbox('is_admin', 1, $user->is_admin, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_admin') }}</small>
              </div>
            </div>
            <div class="btn-group pull-right">
              <button type="submit" class="btn btn-success">Update</button>
            </div>
          <div class="clear-both"></div>
          {!! Form::close() !!}
        </div>  
      </div>
    </div>
  </div>
@endsection
@section('custom-script')
<script>
  $(function(){
    $('form').on('submit', function(event){
      $('.loading-block').addClass('active');
    });
  });
</script>
@endsection