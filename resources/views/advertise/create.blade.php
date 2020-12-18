@extends('layouts.admin')
@section('title','Create Advertise')
@section('content')
<br>
<a href="{{ route('ads') }}" class="btn btn-md btn-danger"><< Back</a>
	<form style="margin-top:-15px;" enctype="multipart/form-data" method="POST" action="{{ route('ad.store') }} ">
		<br>
			{{ csrf_field() }}
		<label for="ad_location">Ad Location:</label>
		<select name="ad_location" id="test" class="form-control">
			<option value="popup">Popup</option>
			<option value="onpause">Onpause</option>
			<option id="skipad" value="skip">SkipAd</option>
		</select>

		
		<div id="s_img" class="form-group">
			<div class="form-group{{ $errors->has('ad_image') ? ' has-error' : '' }}">
				<label for="ad_image">Ad Image</label>
				<input type="file" name="ad_image" class="form-control">
				<span class="help-block">
                  <strong>{{ $errors->first('ad_image') }}</strong>
         		 </span>
			</div>
		</div>
		<br>
		<div style="display: none;"  id="type">
		<input  type="radio" value="upload" checked name="checkType" id="ch1"> Upload 
		<input  type="radio" value="url" name="checkType" id="ch2"> URL
		</div>
	
		<input style="display: none;" placeholder="http://" type="text" name="ad_url" id="ad_url">
		

		<div id="s_video" style="display: none;" class="form-group">
			<div class="form-group{{ $errors->has('ad_video') ? ' has-error' : '' }}">
			<label for="ad_image">Ad Video</label>
			<input type="file" name="ad_video" class="form-control">
			<span class="help-block">
                  <strong>{{ $errors->first('ad_video') }}</strong>
         		 </span>
		</div>
		</div>

		<label for="">Enter Ad Target :</label>
		<input type="text" class="form-control" placeholder="Enter Ad Target URL: http://" name="ad_target">
	
		<div id="forpopup1">
		<label for="">Enter Start Time :</label>
		<input type="text" class="form-control" name="time" placeholder="ex. 00:00:10" >
		<small class="text-danger">{{ $errors->first('time') }}</small>
		</div>
	
		<div style="display: none;" id="ad_hold_time">
			<label for="ad_hold">Ad Hold Time:</label>
			<input type="text" class="form-control" placeholder="eg. 5" name="ad_hold">
		</div>

		<div id="forpopup">
		<label for="">Enter End Time :</label>
		<input type="text" class="form-control" name="endtime" placeholder="ex. 00:00:20" >
		<small class="text-danger">{{ $errors->first('endtime') }}</small>
		</div>
		

		<input type="submit" class="btn btn-primary">

	</form>
@endsection

@section('custom-script')
	<script type="text/javascript">
		$('#test').change(function() {
    if($(this).val() == 'skip')
    {
    	$('#s_video').show();
    	$('#s_img').hide();
    	$('#type').show();
    	$('#forpopup1').show();
    	$('#forpopup').hide();
    	$('#ad_hold_time').show();
    }

    	else
    {
    	$('#s_video').hide();
    	$('#s_img').show();
    	$('#type').hide();
    	$('#ad_hold_time').hide();

    }

    if($(this).val() == 'popup')
    {
    	$('#s_video').hide();
    	$('#s_img').show();
    	$('#forpopup1').show();
    	$('#forpopup').show();
    	$('#type').hide();
    	$('#ad_hold_time').hide();
    }

     if($(this).val() == 'onpause')
    {
    	$('#s_video').hide();
    	$('#s_img').show();
    	$('#forpopup').hide();
    	$('#forpopup1').hide();
    	$('#type').hide();
    	$('#ad_hold_time').hide();
    }
        
	});

		$('#ch2').click(function(){
			$('#s_video').hide();
			$('#ad_url').show();
		});

		$('#ch1').click(function(){
			$('#s_video').show();
			$('#ad_url').hide();
		});

		
  

	</script>

	<script>
  $(function() {
    $('#toggle-event').change(function() {
      $('#url').val(+ $(this).prop('checked'))
    })
  })
</script>
@endsection