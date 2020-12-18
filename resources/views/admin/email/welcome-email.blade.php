<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<style>
		@import url('https://fonts.googleapis.com/css?family=Open+Sans');
		body{
			background: #000;
			font-family: 'Open Sans', sans-serif;
		}

		h1{
			font-family: 'Open Sans', sans-serif;
			color: #fff;
			text-transform: uppercase;
		}

		.box
		{
			max-width: 50%;
		}

		.wel{
			width: 200px;
			border-radius: 0.5em;
			padding: 10px;
			background-image: linear-gradient(to right top, #44a1c5, #537196, #4b465e, #2e242d, #000000);
			border:none;
			color: #fff;
			font-weight: 600;
			font-size: 18px;
			font-family: 'Open Sans', sans-serif;
		}
	</style>
</head>
<body>
	<center>
	<div style="padding:50px;background: url({{ url('images/email-bg.jpg') }});background-color:#111;background-size: cover;width: 100%;height: 100%;" class="box">
		<div align="center" class="logo">
			<img src="{{ asset('images/logo/'.$logo) }}" alt="logo">

			<h1>Welcome !</h1>

			<p style="font-size:18px;font-family: 'Open Sans', sans-serif;text-align: justify;color: #fff;">
				Hello {{$user['name']}},
				<br><br>
				Thank you very much for joining {{ config('app.name') }}. We're really excited about having you with us. 
				<br>
				<br>
				Now that you're with us, prepare to enjoy fresh, exclusive, and epic stories made for you alone.
			</p>

			<div align="center">
				<a style="cursor: pointer;" href="{{ config('app.url') }}"><button style="cursor: pointer;" class="wel">Explore Now !</button></a>
			</div>

			<p style="font-size:18px;font-family: 'Open Sans', sans-serif;text-align: justify;color: #fff;">
				Have fun!
				<br>
				{{ config('app.name') }}
			</p>

			<div style="width:100%; height:2px;background:linear-gradient(to right top, #44a1c5, #537196, #4b465e, #2e242d, #000000);">
				
			</div>
				@php
					$url= \DB::table('social_icons')->where('id',1)->first();
				@endphp
			<div align="left" class="social">
				<p style="color: #fff;font-family: 'Open Sans', sans-serif;">	Question? email us at: <a style="cursor: pointer;" href="mailto:{{ $w_email }}">{{ $w_email }}</a></p>

				<a href="{{ $url->url1 }}"><img src="{{ url('images/fb.png') }}" alt=""></a>
				<a href="{{ $url->url2 }}"><img style="margin-left: 15px;" src="{{ url('images/tw.png') }}" alt=""></a>
				<a href="{{ $url->url3 }}"><img style="margin-left: 15px;" src="{{ url('images/yt.png') }}" alt=""></a>
			</div>
		</div>
	</div>
</center>
</body>
</html>