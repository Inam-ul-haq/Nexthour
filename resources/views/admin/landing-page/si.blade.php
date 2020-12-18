@extends('layouts.admin')
@section('title','Social Icon Setting')
@section('content')
 <div class="admin-form-main-block mrg-t-40">
   
 <h4 class="admin-form-text"><a href="{{url('admin/')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Social Icon Setting</h4>
<div class="row">
		<div class="col-md-6">
			 <div class="admin-form-block z-depth-1">
			 	<form action="{{ route('socialic') }}" method="POST">
			 		{{ csrf_field() }}
				<label for=""><i class="fa fa-facebook"></i> Facebook URL:</label>
				<input autofocus="" placeholder="http://facebook.com/mediacity" type="text" class="form-control" name="url1" value="{{ $si->url1 }}">
				<br>
				<label for=""><i class="fa fa-twitter"></i> Twitter URL:</label>
				<input type="text" placeholder="http://twitter.com/mediacity" class="form-control" name="url2" value="{{ $si->url2 }}">
				<br>
				<label for=""><i class="fa fa-youtube"></i> Youtube URL:</label>
				<input type="text" placeholder="http://youtube.com/mediacity" class="form-control" name="url3" value="{{ $si->url3 }}">

				<br>
				<button type="submit" class="btn btn-md btn-primary">Save</button>
				</form>


				</div>
			 	
			 	
			 </div>
		</div>
</div>
 @endsection