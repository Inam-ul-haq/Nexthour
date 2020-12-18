@extends('layouts.theme')
@section('title','Manage Profile')
@section('main-wrapper')

	<div class="container">
		<div class="manage-profile">
		<br>
		<div align="left">
				<h4>Hey! {{ Auth::user()->name }} select your personal profile and start browsing {{ config('app.name') }}:</h4>	
		</div>
		<hr>
		<div class="row">
				@if(!isset($result))
				 <p>No Profiles Are Available For You</p>
				@endif
				<div align="center"><p id="msg"></p></div>

			<form action="{{ route('mus.pro.update',Auth::user()->id) }}" method="POST">
				{{ csrf_field() }}
			
			@if(isset($result->screen1))
			<div class="col-md-3  col-sm-4  col-xs-6">
				<div class="btm-20 manage-profile-block">

				<img class="imageprofile @if(Session::has('nickname')) {{ Session::get('nickname') == $result->screen1 ? "imgactive" : "" }} @endif" @if($result->screen_1_used == 'NO') onclick="changescreen('{{ $result->screen1 }}','{{ 1 }}')" @endif title="{{ $result->screen1 }}" src="{{ Avatar::create($result->screen1)->toBase64() }}" alt="">
				
				@if($result->device_mac_1 != '' && $_SERVER['REMOTE_ADDR'] == $result->device_mac_1)
				<br><br>
					<input class="screen2 form-control" name="screen1" type="text" value="{{ $result->screen1 }}">
					<div class="text-center">
						<br>
						<span class="label label-success">Currently Active</span>
					</div>
				@elseif($result->device_mac_1 == '')
				<br><br>
					<input class="screen2 form-control" name="screen1" type="text" value="{{ $result->screen1 }}">
				@else
					
					<div class="text-center">
						<br>
						<span class="label label-success">In Use</span>
					</div>
				
				@endif
				</div>

			</div>
			@endif

			@if(isset($result->screen2))
			<div class="col-md-3 col-sm-4 col-xs-6">
				<div class="btm-20 manage-profile-block">
			<img class="img-fluid imageprofile @if(Session::has('nickname')) {{ Session::get('nickname') == $result->screen2 ? "imgactive" : "" }} @endif" @if($result->screen_2_used == 'NO') onclick="changescreen('{{ $result->screen2 }}','{{ 2 }}')" @endif title="{{ $result->screen2 }}" src="{{ Avatar::create($result->screen2)->toBase64() }}" alt="{{ $result->screen2 }}" >
				
				@if($result->device_mac_2 != '' && $_SERVER['REMOTE_ADDR'] == $result->device_mac_2)
				<br><br>
					<input class="screen2 form-control" name="screen2" type="text" value="{{ $result->screen2 }}">
					<div class="text-center">
						<br>
						<span class="label label-success">Currently Active</span>
					</div>
				@elseif($result->device_mac_2 == '')
				<br><br>
					<input class="screen2 form-control" name="screen2" type="text" value="{{ $result->screen2 }}">
				@else
					<div class="text-center">
						<br>
						<span class="label label-success">In Use</span>
					</div>
				@endif
				
			</div>
				</div>
			@endif


			@if(isset($result->screen3))
			<div class="col-md-3  col-sm-4  col-xs-6">
				<div class="btm-20 manage-profile-block">
				<img class="imageprofile @if(Session::has('nickname')) {{ Session::get('nickname') == $result->screen3 ? "imgactive" : "" }} @endif" @if($result->screen_3_used == 'NO') onclick="changescreen('{{ $result->screen3 }}','{{ 3 }}')" @endif title="{{ $result->screen3 }}" src="{{ Avatar::create($result->screen3)->toBase64() }}" alt="{{ $result->screen3 }}">
				
				@if($result->device_mac_3 != '' && $_SERVER['REMOTE_ADDR'] == $result->device_mac_3)
				<br><br>
					<input class="screen2 form-control" name="screen3" type="text" value="{{ $result->screen3 }}">
					<div class="text-center">
						<br>
						<span class="label label-success">Currently Active</span>
					</div>
				@elseif($result->device_mac_3 == '')
				<br><br>
					<input class="screen2 form-control" name="screen3" type="text" value="{{ $result->screen3 }}">
				@else
					<div class="text-center">
						<br>
						<span class="label label-success">In Use</span>
					</div>
				@endif
				</div>
			</div>
			@endif

			@if(isset($result->screen4))
			<div class="col-md-3  col-sm-4  col-xs-6">
				<div class="btm-20 manage-profile-block">
				<img class="imageprofile @if(Session::has('nickname')) {{ Session::get('nickname') == $result->screen4 ? "imgactive" : "" }} @endif" @if($result->screen_4_used == 'NO') onclick="changescreen('{{ $result->screen4 }}','{{ 4 }}')" @endif title="{{ $result->screen4 }}" src="{{ Avatar::create($result->screen4)->toBase64() }}" alt="{{ $result->screen4 }}">
				
				@if($result->device_mac_4 != '' && $_SERVER['REMOTE_ADDR'] == $result->device_mac_4)
				<br><br>
					<input class="screen2 form-control" name="screen4" type="text" value="{{ $result->screen4 }}">
					<div class="text-center">
						<br>
						<span class="label label-success">Currently Active</span>
					</div>
				@elseif($result->device_mac_4 == '')
				<br><br>
					<input class="screen2 form-control" name="screen4" type="text" value="{{ $result->screen4 }}">
				@else
					<div class="text-center">
						<br>
						<span class="label label-success">In Use</span>
					</div>
				@endif
				</div>
			</div>
			@endif
 
			
		  @if(isset($result))

			<div class="mg15 col-md-12  col-sm-12 col-xs-12 col-md-offset-5">
 
				<div class="manage-profile-btn">
				<button type="submit" class="btn btn-lg btn-primary" value="Done"><i class="fa fa-check"></i> Done</button>

				</div>
			</div>
			@endif
				
			</form>
		</div>
	</div>
	</div>

@endsection

@section('custom-script')
	<script>
		function changescreen(screen,count){

			$.ajax({
				type : 'GET',
				data : {screen : screen, count : count},
				url  : '{{ url('/changescreen/'.Auth::user()->id) }}',
				success : function(data){
					console.log(data);
					
					$('#msg').html(data);

					

					setTimeout(function(){ 
						location.reload();
					}, 700);


				}
			});
		}
	</script>
@endsection