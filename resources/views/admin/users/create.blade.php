@extends('layouts.admin')
@section('title','Create User')
@section('content')
  <div class="admin-form-main-block mrgn-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/users')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Create User</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">          
          {!! Form::open(['method' => 'POST', 'action' => 'UsersController@store', 'files' => true]) !!}
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Enter Name') !!}
              {{-- <p class="inline info"> - Please enter your name</p> --}} 
              <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your name"></i>
              {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required', 'autofocus', 'placeholder' => 'Please enter your name' ]) !!}
              <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>
            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
              {!! Form::label('email', 'Email Address') !!}
              <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your email"></i>
              {!! Form::email('email', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Please enter your email']) !!}
              <small class="text-danger">{{ $errors->first('email') }}</small>
            </div>
            <div class="search form-group{{ $errors->has('password') ? ' has-error' : '' }}">
              {!! Form::label('password', 'Password') !!}
              <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your password"></i>
              {!! Form::password('password', ['id' => 'password',' class' => 'form-control', 'required' => 'required', 'placeholder' => 'Please enter your password']) !!}
               <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
              <small class="text-danger">{{ $errors->first('password') }}</small>
            </div>
            <div class="search form-group{{ $errors->has('confirm_password') ? ' has-error' : '' }}">
              {!! Form::label('confirm_password', 'Confirm Password') !!}
              <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your password again"></i>
              {!! Form::password('confirm_password', ['id' => 'confirm_password','class' => 'form-control', 'required' => 'required', 'placeholder' => 'Please enter your password again']) !!}
               <span toggle="#confirm_password" class="fa fa-fw fa-eye field-icon toggle-password2"></span>

              <small class="text-danger">{{ $errors->first('confirm_password') }}</small>
            </div>
            <div class="search form-group{{ $errors->has('dob') ? ' has-error' : '' }}">
              {!! Form::label('dob', 'Date Of Birth') !!}
              <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter date of Birth of User"></i>
             <input type="date" name="dob"  />
            
              <small class="text-danger">{{ $errors->first('dob') }}</small>
            </div>
            <div class="form-group{{ $errors->has('is_admin') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_admin', 'Administrator') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">								
                    {!! Form::checkbox('is_admin', 1, 0, ['class' => 'checkbox-switch', 'id' => 'is_admin_cb']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_admin') }}</small>
              </div>
            </div>

            <div class="form-group{{ $errors->has('is_assistant') ? ' has-error' : '' }} switch-main-block">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_assistant', 'Producer') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('is_assistant', 1, 0, ['class' => 'checkbox-switch','id' => 'is_producer_cb']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_admin') }}</small>
              </div>
            </div>

            <div class="btn-group pull-right">
              <button type="reset" class="btn btn-info">Reset</button>
              <button type="submit" class="btn btn-success">Create</button>
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

  $(".toggle-password2").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
  });
  
</script>

<script>
    $('#is_admin_cb').on('change',function(){
      $('#is_producer_cb').prop('checked',false);
    })
</script>

<script>
    $('#is_producer_cb').on('change',function(){
      $('#is_admin_cb').prop('checked',false);
    })
</script>
@endsection