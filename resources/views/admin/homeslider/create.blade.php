@extends('layouts.admin')
@section('title','Create Slider')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/home_slider')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Add Slide</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">
          {!! Form::open(['method' => 'POST', 'action' => 'HomeSliderController@store', 'files' => true]) !!}
            <div class="bootstrap-checkbox slide-option-switch form-group{{ $errors->has('prime_main_slider') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-md-7">
                  <h5 class="bootstrap-switch-label">Slide For</h5>
                </div>
                <div class="col-md-5 pad-0">
                  <div class="make-switch">
                    {!! Form::checkbox('', 1, 1, ['class' => 'bootswitch', 'id' => 'TheCheckBox', "data-on-text"=>"Movies", "data-off-text"=>"Tv Series", "data-size"=>"small"]) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <small class="text-danger">{{ $errors->first('prime_main_slider') }}</small>
              </div>
            </div>
            <div id="movie_id_block" class="form-group{{ $errors->has('movie_id') ? ' has-error' : '' }}">
              {!! Form::label('movie_id', 'Select Slide For Movie') !!}
              <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please select slide for movie"></i>
              {!! Form::select('movie_id', $movie_list, null, ['class' => 'form-control select2', 'placeholder' => '']) !!}
              <small class="text-danger">{{ $errors->first('movie_id') }}</small>
            </div>
            <div id="tv_series_id_block" class="form-group{{ $errors->has('tv_series_id') ? ' has-error' : '' }}">
              {!! Form::label('tv_series_id', 'Select Slide For Tv Show') !!}
              {!! Form::select('tv_series_id', $tv_series_list, null, ['class' => 'form-control select2', 'placeholder' => '']) !!}
              <small class="text-danger">{{ $errors->first('tv_series_id') }}</small>
            </div>
            <div class="form-group{{ $errors->has('slide_image') ? ' has-error' : '' }} input-file-block">
              {!! Form::label('slide_image', 'Slide Image') !!}
              <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Upload slide image"></i>
              {!! Form::file('slide_image', ['class' => 'input-file', 'id'=>'slide_image']) !!}
              <label for="slide_image" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="slide image">
                <i class="icon fa fa-check"></i>
                <span class="js-fileName">Choose a File</span>
              </label>
              <p class="info">Choose slide image</p>
              <small class="text-danger">{{ $errors->first('slide_image') }}</small>
            </div>
            <div class="form-group{{ $errors->has('active') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-xs-3">
                  {!! Form::label('active', 'Active') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">
                    {!! Form::checkbox('active', 1, 1, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('series') }}</small>
              </div>
            </div>
            <div class="btn-group pull-right">
              <button type="reset" class="btn btn-info"><i class="material-icons left">toys</i> Reset</button>
              <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> Add Slide</button>
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
    $(document).ready(function(){

      $('#tv_series_id_block').hide();

      $('#TheCheckBox').on('switchChange.bootstrapSwitch', function (event, state) {

          if (state == true) {

            $('#tv_series_id_block').hide();
            $('#movie_id_block').show();

          } else if (state == false) {

            $('#tv_series_id_block').show();
            $('#movie_id_block').hide(); 

          };

      });
      
    });
  </script>
@endsection
