@extends('layouts.theme')
@section('title','Contact us')
@section('main-wrapper')

 <div class="container" style="background-color: #333333;">
 	<br>
 		@if(Session::has('success'))
 		<div class="alert alert-success">
 			Success : {{ Session::get('success') }}
 		</div>
 		@endif
 	<h3 class="text-center">CONTACT <span class="us_text">US</span></h3>
 	<br>
 	<h5 class="text-center">REACH OUT TO US FOR ANY QUERIES, SUGGESTIONS OR FEEDBACK !</h5>
 	<form action="{{ route('send.contactus') }}" method="post">
 		{{ csrf_field() }}
    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
 	<label style="color: #fff;" for="">Name:</label>
 	<input type="text" class="form-control custom-field-contact" name="name">
 	@if ($errors->has('name'))
                <span class="help-block">
                  <strong>{{ $errors->first('name') }}</strong>
                </span>
    @endif
 	</div>

 	<div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
 	<label style="color: #fff;" for="">Email:</label>
 	<input type="email" class="search-input form-control custom-field-contact" name="email">
 	@if ($errors->has('email'))
                <span class="help-block">
                  <strong>{{ $errors->first('email') }}</strong>
                </span>
    @endif
 	</div>

 	<div class="form-group{{ $errors->has('subj') ? ' has-error' : '' }}">
 	<label style="color: #fff;" for="">Subject:</label>
 	<select name="subj" id="" class="form-control custom-field-contact">
 		<option value="Billing Issue">Billing Issue</option>
 		<option value="Streaming Issue">Streaming Issue</option>
 		<option value="Application Issue">Application Issue</option>
 		<option value="Advertising">Advertising</option>
 		<option value="Partnership">Partnership</option>
 		<option value="Other">Other</option>
 	</select>
 	@if ($errors->has('subj'))
                <span class="help-block">
                  <strong>{{ $errors->first('subj') }}</strong>
                </span>
    @endif
 	</div>

 	<div class="form-group{{ $errors->has('msg') ? ' has-error' : '' }}">
 	<label style="color: #fff;" for="">Message:</label>
 	<textarea name="msg" class="form-control custom-field-contact" rows="5" cols="50"></textarea>
 	@if ($errors->has('msg'))
                <span class="help-block">
                  <strong>{{ $errors->first('msg') }}</strong>
                </span>
    @endif
 	</div>

 	<input type="submit" class="btn btn-primary" value="Send"> 
 	</form>
 	
 	<br>
 </div>
@endsection