
@extends('layouts.admin')
@section('title','Social Login')
@section('content')

 <div class="admin-form-main-block mrgn-t-40">
<div class="container">
	<div class="box-body">
		@if ($errors->any())
		    <div class="alert alert-danger">
		        <ul>
		            @foreach ($errors->all() as $error)
		                <li>{{ $error }}</li>
		            @endforeach
		        </ul>
		    </div>
		@endif
		<div class="row">
		
		@php
		$fb_login_status = App\Config::select('fb_login')->where('id','=',1)->first();
		$google_login_status = App\Config::select('google_login')->where('id','=',1)->first();
		$gitlab_login_status = App\Config::select('gitlab_login')->where('id','=',1)->first();

		@endphp
		<div class="col-md-6">
			
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-facebook"></i> Facebook Login Setting
				</div>
				
				<div class="panel-body">
					<form action="{{ route('key.facebook') }}" method="POST">
		    {{ csrf_field() }}
		    <div class="form-group">
		    <label for="">Enable Facebook Login: </label>
			<input {{ $fb_login_status->fb_login == 1 ? 'checked' : "" }} type="checkbox" class="toggle-input" name="fb_check" id="fb_check">
            <label for="fb_check"></label>
				 
		    </div>
			<div id="fb_box_dtl" style="{{ $fb_login_status->fb_login == 1 ? '' : "display: none
			" }}">
				<div class="form-group">
			<label for="">Facebook Client ID:</label>
			<input type="text" value="{{ $env_files['FACEBOOK_CLIENT_ID'] }}" name="FACEBOOK_CLIENT_ID" class="form-control">
			</div>
			<div class="search form-group">
				<label for="">Facebook Secret ID:</label>	
			<input type="password" value="{{ $env_files['FACEBOOK_CLIENT_SECRET'] }}" name="FACEBOOK_CLIENT_SECRET" class="form-control" id="password-field" >
			<span  toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
			</div>
			
			<div class="form-group">
				<label for="">Facebook Redirect URL:</label>
			<input type="text" placeholder="https://yoursite.com/login/facebook/callback" value="{{ $env_files['FACEBOOK_CALLBACK'] }}" name="FACEBOOK_CALLBACK" class="form-control">
			</div>
			</div>
			<button type="submit" class="btn btn-md btn-primary">
				<i class="fa fa-save"></i> Save
			</button>
			</form>
				</div>
			</div>
			
			
		</div>
		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-google"></i> Google Login Setting
				</div>
				
				<div class="panel-body">
					
			<form action="{{  route('key.google') }}" method="POST">
		     {{ csrf_field() }}

			<div class="form-group">
				<label for="">Enable Google Login: </label>
			<input {{ $google_login_status->google_login == 1 ? 'checked' : "" }} type="checkbox" class="toggle-input" name="google_login" id="google_login" >
             <label for="google_login"></label>
			</div>
			
			<div id="g_box_detail" style="{{ $google_login_status->google_login == 1 ? '' : "display: none
			" }}">
				<div class="form-group">
				<label for="">Google Client ID:</label>
			<input type="text" value="{{ $env_files['GOOGLE_CLIENT_ID'] }}" name="GOOGLE_CLIENT_ID" class="form-control" >
			</div>
			
			
			<div class="search form-group">
			<label for="">Google Secret ID:</label>
			<input type="text" value="{{ $env_files['GOOGLE_CLIENT_SECRET'] }}" name="GOOGLE_CLIENT_SECRET" class="form-control" id="password-field2" >
			
			<span toggle="#password-field2" class="fa fa-fw fa-eye field-icon toggle-password">
			</span>

			</div>
			
			<div class="form-group">
				<label for="">Google Redirect URL:</label>
				<input type="text" placeholder="https://yoursite.com/login/google/callback" value="{{ $env_files['GOOGLE_CALLBACK'] }}" name="GOOGLE_CALLBACK" class="form-control"  >
			</div>
			</div>
			
			
			
			<button type="submit" class="btn btn-md btn-primary">
				<i class="fa fa-save"></i> Save
			</button>
			</form>
				</div>
			</div>
			

		</div>

		<div class="col-md-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<i class="fa fa-gitlab"></i> GitLab Login Setting
				</div>
				
				<div class="panel-body">
					
			<form action="{{  route('key.gitlab') }}" method="POST">
		     {{ csrf_field() }}

			<div class="form-group">
				<label for="">Enable GITLAB Login: </label>
				<input {{ $gitlab_login_status->gitlab_login == 1 ? 'checked' : "" }} type="checkbox" class="toggle-input" name="git_lab_check" id="git_lab_check">
             <label for="git_lab_check"></label>
			</div>
			
			<div style="{{ $gitlab_login_status->gitlab_login == 1 ? '' : "display: none
			" }}" id="git_lab_box">
				<div class="form-group">
		    	<label for="">GITLAB Client ID:</label>
				<input type="text" value="{{ $env_files['GITLAB_CLIENT_ID'] }}" name="GITLAB_CLIENT_ID" class="form-control" >
		    	</div>
			
			
				<div class="search form-group">
					<label for="">GITLAB Secret ID:</label>
				<input type="password" value="{{ $env_files['GITLAB_CLIENT_SECRET'] }}" name="GITLAB_CLIENT_SECRET" class="form-control" id="password-field3" >
				
				<span toggle="#password-field3" class="fa fa-fw fa-eye field-icon toggle-password">
				</span>
				
				</div>
			
				<div class="form-group">
					<label for="">GITLAB Redirect URL:</label>
					<input type="text" placeholder="https://yoursite.com/login/google/callback" value="{{ $env_files['GITLAB_CALLBACK'] }}" name="GITLAB_CALLBACK" class="form-control">
				</div>
			
			
			
			</div>


			<button type="submit" class="btn btn-md btn-primary">
				<i class="fa fa-save"></i> Save
			</button>
		    
			</form>
				</div>
			</div>
			

		</div>
	</div>
	</div>
</div>
	</div>

@endsection
@section('custom-script')
<script type="text/javascript">
  
  $(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
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


 $('#fb_check').on('change',function(){
 	if ($('#fb_check').is(':checked')){
   		$('#fb_box_dtl').show('fast');
	}else{
		$('#fb_box_dtl').hide('fast');
	}
 });

 $('#google_login').on('change',function(){
 	if ($('#google_login').is(':checked')){
   		$('#g_box_detail').show('fast');
	}else{
		$('#g_box_detail').hide('fast');
	}
 });


 $('#git_lab_check').on('change',function(){
 	if ($('#git_lab_check').is(':checked')){
   		$('#git_lab_box').show('fast');
	}else{
		$('#git_lab_box').hide('fast');
	}
 });


  

</script>



@endsection