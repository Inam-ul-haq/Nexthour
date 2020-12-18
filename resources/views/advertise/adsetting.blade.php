@extends('layouts.admin')
@section('title','Advertise Setting')
@section('content')
	<br>
	<div class="box-header">
  <h5>Advertise Settings</h5>
</div>
		<div>

  <!-- Nav tabs -->
  <ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Skip AD Setting</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Pop Up Ad Setting</a></li>
    
  </ul>

  <!-- Tab panes -->
  <div class="tab-content">

    <div role="tabpanel" class="tab-pane fade in active" id="home">
    	<form action="{{ route('ad.update') }}" method="POST">
    		{{ csrf_field() }}
    		{{ method_field('PUT') }}
    		<br>
    		
    		<label for="">Skip AD Timer</label>
    		<select name="timer_check" id="timer" class="form-control">
    			<option value="no">No</option>
    			<option value="yes">Yes</option>
    			
    		</select>
			<br>
			<div style="display: none;" id="t">
    		<label for="time">Time : ( Please Ensure that its not conflict with popup ad start time )</label>
    		<input type="text" placeholder="00:00:10" name="ad_timer" class="form-control">
        <br>
        <label for="">Ad Hold Time: </label>
        <input type="number" name="ad_hold" min="0" max="10" placeholder="eg. 5" class="form-control">
    		</div>

    		

    		<input type="submit" value="Save" class="btn btn-md btn-success">
    	</form>
    </div>

    <div role="tabpanel" class="fade tab-pane" id="profile">
      
        <form action="{{ route('ad.pop.update') }}" method="POST">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <br>
        
        
        <label for="">Start Time: <span class="help-block">( Please Ensure that its not conflict with video ad start time )</span></label>
        <input type="text" name="time" placeholder="00:00:10" class="form-control">
        <br>
        <label for="">End Time: </label>
        <input type="text" name="endtime" placeholder="00:00:30" class="form-control">

        

        <input type="submit" value="Save" class="btn btn-md btn-success">
      </form>
    </div>

 
      
  	</div>

</div>
	
	
@endsection
@section('custom-script')
	<script type="text/javascript">
		$('#timer').change(function(){
			if($(this).val() == 'no')
			{
				$('#t').hide();
			}else
			{
				$('#t').show();
			}
		});
	</script>
@endsection