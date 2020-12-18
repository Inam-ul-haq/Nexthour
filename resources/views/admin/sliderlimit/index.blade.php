@extends('layouts.admin')
@section('title','Front Page Section Slider Limit')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text">Front Page Section Slider Limit</h4>
    <div class="admin-form-block z-depth-1">
		
			<div class="row">


				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							@php
							  $get1 = App\HomeTranslation::where('id',1)->first();
							@endphp

							{{$get1->value}}
						</div>

						<div class="panel-body">
							@php
								$update1 = App\FrontSliderUpdate::where('id',1)->first();
							@endphp
							<form action="{{ route('front.slider.update',$update1->id) }}" method="POST">
								{{ csrf_field() }}

								<div class="row">

									<div class="col-md-12">
											<div class="form-group">
													<label>Total Items To Show :</label>
													<input type="number" min="1" value="{{ $update1->item_show }}" name="item_show">
											</div>
									</div>

									

								</div>
								
								<div class="form-group">
									<label>View In</label>
									<br>
									<label class="switch">
											<input value="1" name="order" type="checkbox" {{ $update1->orderby == 1 ? "checked" : "" }} class="checkbox-switch" id="orderBy">
										    <span class="slider round"></span>
									</label>
									@if($update1->orderby == 1)
									<small id="textorder">ASC Order</small>
									@else
									<small id="textorder">DESC Order</small>
									@endif
								</div>
								<div class="form-group">
									<label>Slider View</label>
									<br>
									<label class="switch">
									        <input value="1" name="slider" type="checkbox" {{ $update1->sliderview == 1 ? "checked" : "" }} class="checkbox-switch" id="slider">
										    <span class="slider round"></span>
									</label>
									@if($update1->sliderview == 1)
									<small id="textslider">Slider View</small>
									@else
									<small id="textslider">Grid View</small>
									@endif
								</div>

								<input value="Update" type="submit" class="btn btn-md btn-primary">
							</form>
						</div>
				</div>
				</div>

				<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								@php
								  $get2 = App\HomeTranslation::where('id',2)->first();
								@endphp
	
								{{$get2->value}}
							</div>
	
							<div class="panel-body">
								@php
									$update2 = App\FrontSliderUpdate::where('id',2)->first();
								@endphp
								<form action="{{ route('front.slider.update',$update2->id) }}" method="POST">
									{{ csrf_field() }}
	
									<div class="row">
	
										<div class="col-md-12">
												<div class="form-group">
														<label>Total Items To Show :</label>
														<input max="{{ $movie_max }}" type="number" min="1" value="{{ $update2->item_show }}" name="item_show">
												</div>
										</div>
	
										
	
									</div>
									
									<div class="form-group">
										<label>View In</label>
										<br>
										<label class="switch">
												<input value="1" name="order" type="checkbox" {{ $update2->orderby == 1 ? "checked" : "" }} class="checkbox-switch" id="orderBymovies">
												<span class="slider round"></span>
										</label>
										@if($update2->orderby == 1)
										<small id="textorder2">ASC Order</small>
										@else
										<small id="textorder2">DESC Order</small>
										@endif
									</div>
	                                 <div class="form-group">
									<label>Slider View</label>
									<br>
									<label class="switch">
									 <input value="1" name="slider" type="checkbox" {{ $update2->sliderview == 1 ? "checked" : "" }} class="checkbox-switch" id="slidermovies">
										    <span class="slider round"></span>
									</label>
									@if($update2->sliderview == 1)
									<small id="textslider1">Slider View</small>
									@else
									<small id="textslider1">Grid View</small>
									@endif
								</div>
									<input value="Update" type="submit" class="btn btn-md btn-primary">
								</form>
							</div>
					</div>
				</div>

				<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								@php
								  $get3 = App\HomeTranslation::where('id',3)->first();
								@endphp
	
								{{$get3->value}}
							</div>
	
							<div class="panel-body">
								@php
									$update3 = App\FrontSliderUpdate::where('id',3)->first();
								@endphp
								<form action="{{ route('front.slider.update',$update3->id) }}" method="POST">
									{{ csrf_field() }}
	
									<div class="row">
	
										<div class="col-md-12">
												<div class="form-group">
														<label>Total Items To Show :</label>
														<input type="number" max="{{ $season_max }}" min="1" value="{{ $update3->item_show }}" name="item_show">
												</div>
										</div>
	
										
	
									</div>
									
									<div class="form-group">
										<label>View In</label>
										<br>
										<label class="switch">
												<input value="1" name="order" type="checkbox" {{ $update3->orderby == 1 ? "checked" : "" }} class="checkbox-switch" id="orderByTvs">
												<span class="slider round"></span>
										</label>
										@if($update3->orderby == 1)
										<small id="textorder3">ASC Order</small>
										@else
										<small id="textorder3">DESC Order</small>
										@endif
									</div>
	                           <div class="form-group">
									<label>Slider View</label>
									<br>
									<label class="switch">
									 <input value="1" name="slider" type="checkbox" {{ $update3->sliderview == 1 ? "checked" : "" }} class="checkbox-switch" id="slidertvs">
										    <span class="slider round"></span>
									</label>
									@if($update3->sliderview == 1)
									<small id="textslider2">Slider View</small>
									@else
									<small id="textslider2">Grid View</small>
									@endif
								</div>
									<input value="Update" type="submit" class="btn btn-md btn-primary">
								</form>
							</div>
					</div>
				</div>


             <div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							@php
							  $get5 = App\HomeTranslation::where('id',20)->first();
							@endphp

							Genre {{$get5->value}}
						</div>

						<div class="panel-body">
							@php
							   $update5 = App\FrontSliderUpdate::where('id',4)->first();
							@endphp
							<form action="{{ route('front.slider.update',$update5->id) }}" method="POST">
								{{ csrf_field() }}
								<div class="row">
	
										<div class="col-md-12">
												<div class="form-group">
														<label>Total Items To Show :</label>
														<input type="number" max="{{ $movie_max }}" min="1" value="{{ $update5->item_show }}" name="item_show">
												</div>
										</div>
	
										
	
									</div>
								<div class="form-group">
									<label>View In</label>
									<br>
									<label class="switch">
									    <input value="1" name="order" type="checkbox" {{ $update5->orderby == 1 ? "checked" : "" }} class="checkbox-switch" id="orderBygmovie">
										<span class="slider round"></span>
									</label>
									@if($update5->orderby == 1)
									<small id="textorder5">ASC Order</small>
									@else
									<small id="textorder5">DESC Order</small>
									@endif
								</div>
								<div class="form-group">
									<label>Slider View</label>
									<br>
									<label class="switch">
									        <input value="1" name="slider" type="checkbox" {{ $update5->sliderview == 1 ? "checked" : "" }} class="checkbox-switch" id="slidergmovie">
										    <span class="slider round"></span>
									</label>
									@if($update5->sliderview == 1)
									<small id="textslider5">Slider View</small>
									@else
									<small id="textslider5">Grid View</small>
									@endif
								</div>

								<input value="Update" type="submit" class="btn btn-md btn-primary">
							</form>
						</div>
				</div>
				</div>
				  <div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							@php
							  $get6 = App\HomeTranslation::where('id',21)->first();
							@endphp

							Genre {{$get6->value}}
						</div>

						<div class="panel-body">
							@php
							   $update6 = App\FrontSliderUpdate::where('id',5)->first();
							@endphp
							<form action="{{ route('front.slider.update',$update6->id) }}" method="POST">
								{{ csrf_field() }}
								<div class="row">
	
										<div class="col-md-12">
												<div class="form-group">
														<label>Total Items To Show :</label>
														<input type="number" max="{{ $season_max }}" min="1" value="{{ $update6->item_show }}" name="item_show">
												</div>
										</div>
	
										
	
									</div>
								<div class="form-group">
									<label>View In</label>
									<br>
									<label class="switch">
									    <input value="1" name="order" type="checkbox" {{ $update6->orderby == 1 ? "checked" : "" }} class="checkbox-switch" id="orderBygtvshow">
										<span class="slider round"></span>
									</label>
									@if($update6->orderby == 1)
									<small id="textorder6">ASC Order</small>
									@else
									<small id="textorder6">DESC Order</small>
									@endif
								</div>
								<div class="form-group">
									<label>Slider View</label>
									<br>
									<label class="switch">
									        <input value="1" name="slider" type="checkbox" {{ $update6->sliderview == 1 ? "checked" : "" }} class="checkbox-switch" id="slidergtvshow">
										    <span class="slider round"></span>
									</label>
									@if($update6->sliderview == 1)
									<small id="textslider6">Slider View</small>
									@else
									<small id="textslider6">Grid View</small>
									@endif
								</div>

								<input value="Update" type="submit" class="btn btn-md btn-primary">
							</form>
						</div>
				</div>
				</div>
				
				<!-- Language Box for movie and Tv Shows -->

				 <div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							@php
							  $get7 = App\HomeTranslation::where('id',20)->first();
							@endphp

							Language {{$get7->value}}
						</div>

						<div class="panel-body">
							@php
							   $update7 = App\FrontSliderUpdate::where('id',6)->first();
							@endphp
							<form action="{{ route('front.slider.update',$update7->id) }}" method="POST">
								{{ csrf_field() }}
								<div class="row">
	
										<div class="col-md-12">
												<div class="form-group">
														<label>Total Items To Show :</label>
														<input type="number" max="{{ $movie_max }}" min="1" value="{{ $update7->item_show }}" name="item_show">
												</div>
										</div>
	
										
	
									</div>
								<div class="form-group">
									<label>View In</label>
									<br>
									<label class="switch">
									    <input value="1" name="order" type="checkbox" {{ $update7->orderby == 1 ? "checked" : "" }} class="checkbox-switch" id="orderBylmovie">
										<span class="slider round"></span>
									</label>
									@if($update7->orderby == 1)
									<small id="textorder7">ASC Order</small>
									@else
									<small id="textorder7">DESC Order</small>
									@endif
								</div>
								<div class="form-group">
									<label>Slider View</label>
									<br>
									<label class="switch">
									        <input value="1" name="slider" type="checkbox" {{ $update7->sliderview == 1 ? "checked" : "" }} class="checkbox-switch" id="sliderlmovie">
										    <span class="slider round"></span>
									</label>
									@if($update7->sliderview == 1)
									<small id="textslider7">Slider View</small>
									@else
									<small id="textslider7">Grid View</small>
									@endif
								</div>

								<input value="Update" type="submit" class="btn btn-md btn-primary">
							</form>
						</div>
				</div>
				</div>
				  <div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							@php
							  $get8 = App\HomeTranslation::where('id',21)->first();
							@endphp

							Language {{$get8->value}}
						</div>

						<div class="panel-body">
							@php
							   $update8 = App\FrontSliderUpdate::where('id',7)->first();
							@endphp
							<form action="{{ route('front.slider.update',$update8->id) }}" method="POST">
								{{ csrf_field() }}
								<div class="row">
	
										<div class="col-md-12">
												<div class="form-group">
														<label>Total Items To Show :</label>
														<input type="number" max="{{ $season_max }}" min="1" value="{{ $update8->item_show }}" name="item_show">
												</div>
										</div>
	
										
	
									</div>
								<div class="form-group">
									<label>View In</label>
									<br>
									<label class="switch">
									    <input value="1" name="order" type="checkbox" {{ $update8->orderby == 1 ? "checked" : "" }} class="checkbox-switch" id="orderByltvshow">
										<span class="slider round"></span>
									</label>
									@if($update8->orderby == 1)
									<small id="textorder8">ASC Order</small>
									@else
									<small id="textorder8">DESC Order</small>
									@endif
								</div>
								<div class="form-group">
									<label>Slider View</label>
									<br>
									<label class="switch">
									        <input value="1" name="slider" type="checkbox" {{ $update8->sliderview == 1 ? "checked" : "" }} class="checkbox-switch" id="sliderltvshow">
										    <span class="slider round"></span>
									</label>
									@if($update8->sliderview == 1)
									<small id="textslider8">Slider View</small>
									@else
									<small id="textslider8">Grid View</small>
									@endif
								</div>

								<input value="Update" type="submit" class="btn btn-md btn-primary">
							</form>
						</div>
				</div>
				</div>
				

				<!-- Featured Box -->

             <div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							@php
							  $get9 = App\HomeTranslation::where('id',20)->first();
							@endphp

							Featured {{$get9->value}}
						</div>

						<div class="panel-body">
							@php
							   $update9 = App\FrontSliderUpdate::where('id',8)->first();
							@endphp
							<form action="{{ route('front.slider.update',$update9->id) }}" method="POST">
								{{ csrf_field() }}
								<div class="row">
	
										<div class="col-md-12">
												<div class="form-group">
														<label>Total Items To Show :</label>
														<input type="number" max="{{ $movie_max }}" min="1" value="{{ $update9->item_show }}" name="item_show">
												</div>
										</div>
	
										
	
									</div>
								<div class="form-group">
									<label>View In</label>
									<br>
									<label class="switch">
									    <input value="1" name="order" type="checkbox" {{ $update9->orderby == 1 ? "checked" : "" }} class="checkbox-switch" id="orderByfmovie">
										<span class="slider round"></span>
									</label>
									@if($update9->orderby == 1)
									<small id="textorder9">ASC Order</small>
									@else
									<small id="textorder9">DESC Order</small>
									@endif
								</div>
								<div class="form-group">
									<label>Slider View</label>
									<br>
									<label class="switch">
									        <input value="1" name="slider" type="checkbox" {{ $update9->sliderview == 1 ? "checked" : "" }} class="checkbox-switch" id="sliderfmovie">
										    <span class="slider round"></span>
									</label>
									@if($update9->sliderview == 1)
									<small id="textslider9">Slider View</small>
									@else
									<small id="textslider9">Grid View</small>
									@endif
								</div>

								<input value="Update" type="submit" class="btn btn-md btn-primary">
							</form>
						</div>
				</div>
				</div>
				  <div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							@php
							  $get10 = App\HomeTranslation::where('id',21)->first();
							@endphp

							Featured {{$get10->value}}
						</div>

						<div class="panel-body">
							@php
							   $update10 = App\FrontSliderUpdate::where('id',9)->first();
							@endphp
							<form action="{{ route('front.slider.update',$update10->id) }}" method="POST">
								{{ csrf_field() }}
								<div class="row">
	
										<div class="col-md-12">
												<div class="form-group">
														<label>Total Items To Show :</label>
														<input type="number" max="{{ $season_max }}" min="1" value="{{ $update9->item_show }}" name="item_show">
												</div>
										</div>
	
										
	
									</div>
								<div class="form-group">
									<label>View In</label>
									<br>
									<label class="switch">
									    <input value="1" name="order" type="checkbox" {{ $update10->orderby == 1 ? "checked" : "" }} class="checkbox-switch" id="orderByftvshow">
										<span class="slider round"></span>
									</label>
									@if($update10->orderby == 1)
									<small id="textorder10">ASC Order</small>
									@else
									<small id="textorder10">DESC Order</small>
									@endif
								</div>
								<div class="form-group">
									<label>Slider View</label>
									<br>
									<label class="switch">
									        <input value="1" name="slider" type="checkbox" {{ $update10->sliderview == 1 ? "checked" : "" }} class="checkbox-switch" id="sliderftvshow">
										    <span class="slider round"></span>
									</label>
									@if($update10->sliderview == 1)
									<small id="textslider10">Slider View</small>
									@else
									<small id="textslider10">Grid View</small>
									@endif
								</div>

								<input value="Update" type="submit" class="btn btn-md btn-primary">
							</form>
						</div>
				</div>
				</div>
			</div>
			
    </div>
  </div>
@endsection
@section('custom-script')
	<script>
		$('#orderBy').on('change',function(){
			if ($('#orderBy').is(':checked')){
				$('#textorder').text('ASC Order');
			}else{
				$('#textorder').text('DESC Order');
			}
		});
	</script>

	<script>
		$('#slider').on('change',function(){
			if ($('#slider').is(':checked')){
				$('#textslider').text('Slider View');
			}else{
				$('#textslider').text('Grid View');
			}
		});
	</script>


	<!-- genre by movie -->
<script>
		$('#orderBygmovie').on('change',function(){
			if ($('#orderBygmovie').is(':checked')){
				$('#textorder5').text('ASC Order');
			}else{
				$('#textorder5').text('DESC Order');
			}
		});
	</script>
	<script>
		$('#slidergmovie').on('change',function(){
			if ($('#slidergmovie').is(':checked')){
				$('#textslider5').text('Slider View');
			}else{
				$('#textslider5').text('Grid View');
			}
		});
	</script>
	<!-- feature by movie -->
	<script>
		$('#orderByfmovie').on('change',function(){
			if ($('#orderByfmovie').is(':checked')){
				$('#textorder9').text('ASC Order');
			}else{
				$('#textorder9').text('DESC Order');
			}
		});
	</script>

	<!-- genre by tv show -->
	<script>
		$('#orderBygtvshow').on('change',function(){
			if ($('#orderBygtvshow').is(':checked')){
				$('#textorder6').text('ASC Order');
			}else{
				$('#textorder6').text('DESC Order');
			}
		});
	</script>
<script>
		$('#slidergtvshow').on('change',function(){
			if ($('#slidergtvshow').is(':checked')){
				$('#textslider6').text('Slider View');
			}else{
				$('#textslider6').text('Grid View');
			}
		});
	</script>
	
	<!-- language movies -->
	<script>
		$('#orderBylmovie').on('change',function(){
			if ($('#orderBylmovie').is(':checked')){
				$('#textorder7').text('ASC Order');
			}else{
				$('#textorder7').text('DESC Order');
			}
		});
	</script>
	<script>
		$('#sliderlmovie').on('change',function(){
			if ($('#sliderlmovie').is(':checked')){
				$('#textslider7').text('Slider View');
			}else{
				$('#textslider7').text('Grid View');
			}
		});
	</script>
	<!-- featured tv showa -->
	<script>
		$('#orderByftvshow').on('change',function(){
			if ($('#orderByftvshow').is(':checked')){
				$('#textorder10').text('ASC Order');
			}else{
				$('#textorder10').text('DESC Order');
			}
		});
	</script>
<script>
		$('#sliderftvshow').on('change',function(){
			if ($('#sliderftvshow').is(':checked')){
				$('#textslider10').text('Slider View');
			}else{
				$('#textslider10').text('Grid View');
			}
		});
	</script>
	<!-- language tv show -->
	<script>
		$('#orderByltvshow').on('change',function(){
			if ($('#orderByltvshow').is(':checked')){
				$('#textorder8').text('ASC Order');
			}else{
				$('#textorder8').text('DESC Order');
			}
		});
	</script>
<script>
		$('#sliderltvshow').on('change',function(){
			if ($('#sliderltvshow').is(':checked')){
				$('#textslider8').text('Slider View');
			}else{
				$('#textslider8').text('Grid View');
			}
		});
	</script>
	<!-- featured tv show -->
	<script>
		$('#orderByftvshow').on('change',function(){
			if ($('#orderByftvshow').is(':checked')){
				$('#textorder10').text('ASC Order');
			}else{
				$('#textorder10').text('DESC Order');
			}
		});
	</script>

	<script>
		$('#sliderftvshow').on('change',function(){
			if ($('#sliderftvshow').is(':checked')){
				$('#textslider10').text('Slider View');
			}else{
				$('#textslider10').text('Grid View');
			}
		});
	</script>
	<!-- feture movies -->
	<script>
		$('#sliderfmovie').on('change',function(){
			if ($('#sliderfmovie').is(':checked')){
				$('#textslider9').text('Slider View');
			}else{
				$('#textslider9').text('Grid View');
			}
		});
	</script>
	
	
	
	<script>
		$('#slidertvs').on('change',function(){
			if ($('#slidertvs').is(':checked')){
				$('#textslider2').text('Slider View');
			}else{
				$('#textslider2').text('Grid View');
			}
		});
	</script>
	<script>
		$('#slidermovies').on('change',function(){
			if ($('#slidermovies').is(':checked')){
				$('#textslider1').text('Slider View');
			}else{
				$('#textslider1').text('Grid View');
			}
		});
	</script>

<script>
		$('#orderBymovies').on('change',function(){
			if ($('#orderBymovies').is(':checked')){
				$('#textorder2').text('ASC Order');
			}else{
				$('#textorder2').text('DESC Order');
			}
		});
	</script>

<script>
		$('#orderByTvs').on('change',function(){
			if ($('#orderByTvs').is(':checked')){
				$('#textorder3').text('ASC Order');
			}else{
				$('#textorder3').text('DESC Order');
			}
		});
	</script>


@endsection