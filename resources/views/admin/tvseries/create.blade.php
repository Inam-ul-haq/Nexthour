@extends('layouts.admin')
@section('title','Create Tv Series')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/tvseries')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Create Tv Series</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">
          {!! Form::open(['method' => 'POST', 'action' => 'TvSeriesController@store', 'files' => true]) !!}

            <label for="">Search Tv Series By Title :</label>
          <br>
          <label class="switch">
                     <input type="checkbox" name="tv_by_id" checked="" class="checkbox-switch" id="tv_id">
                    <span class="slider round"></span>

          </label>
            <div id="tv_title" class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', 'Series Title') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Enter tvseries title eg:Arrow"></i>
                {!! Form::text('title', null, ['class' => 'form-control', 'autofocus', 'placeholder'=> 'Please enter your tvseries title']) !!}
                <small class="text-danger">{{ $errors->first('title') }}</small>
            </div>
             <div id="tvs_id" style="display: none;" class="form-group{{ $errors->has('title2') ? ' has-error' : '' }}">
                {!! Form::label('title', 'Tv Series ID') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter TV ID (TMDB ID)"></i>
                {!! Form::text('title2', null, ['class' => 'form-control', 'placeholder' => 'Please enter TV ID (TMDB ID)']) !!}
                <small class="text-danger">{{ $errors->first('title2') }}</small>
            </div>
            
             <div class="form-group">
              <label for="">Meta Keyword: </label>
              <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter meta keyword"></i>
             <input name="keyword" type="text" class="form-control" data-role="tagsinput"/>

               
            </div>

            <div class="form-group">
              <label for="">Meta Description: </label>
              <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter meta description"></i>
              <textarea name="description" id="" cols="30" rows="10" class="form-control"></textarea>
            </div>

            <div class="form-group">
              <div class="row">
                <div class="col-xs-6">
                  {!! Form::label('', 'Choose custom thumbnail & poster') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch for-custom-image">
                    {!! Form::checkbox('', 1, 0, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
            </div>
            <div class="upload-image-main-block">
              <div class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('thumbnail') ? ' has-error' : '' }} input-file-block">
                    {!! Form::label('thumbnail', 'Thumbnail') !!} - <p class="inline info">Help block text</p>
                    {!! Form::file('thumbnail', ['class' => 'input-file', 'id'=>'thumbnail']) !!}
                    <label for="thumbnail" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Profile pic">
                      <i class="icon fa fa-check"></i>
                      <span class="js-fileName">Choose a File</span>
                    </label>
                    <p class="info">Choose custom thumbnail</p>
                    <small class="text-danger">{{ $errors->first('thumbnail') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('poster') ? ' has-error' : '' }} input-file-block">
                    {!! Form::label('poster', 'Poster') !!} - <p class="inline info">Help block text</p>
                    {!! Form::file('poster', ['class' => 'input-file', 'id'=>'poster']) !!}
                    <label for="poster" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Profile pic">
                      <i class="icon fa fa-check"></i>
                      <span class="js-fileName">Choose a File</span>
                    </label>
                    <p class="info">Choose custom poster</p>
                    <small class="text-danger">{{ $errors->first('poster') }}</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="form-group{{ $errors->has('featured') ? ' has-error' : '' }}">
  						<div class="row">
  							<div class="col-xs-6">
  								{!! Form::label('featured', 'Featured') !!}
  							</div>
  							<div class="col-xs-5 pad-0">
  								<label class="switch">
  									{!! Form::checkbox('featured', 1, 0, ['class' => 'checkbox-switch']) !!}
  									<span class="slider round"></span>
  								</label>
  							</div>
  						</div>
  						<div class="col-xs-12">
  							<small class="text-danger">{{ $errors->first('featured') }}</small>
  						</div>
            </div>
            <div class="form-group{{ $errors->has('maturity_rating') ? ' has-error' : '' }}">
                {!! Form::label('maturity_rating', 'Maturity Rating') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please select tvseries maturity rating"></i>
                {!! Form::select('maturity_rating', array('all age' => 'All age', '13+' =>'13+', '16+' => '16+', '18+'=>'18+'), null, ['class' => 'form-control select2']) !!}
                <small class="text-danger">{{ $errors->first('maturity_rating') }}</small>
            </div>
            <div class="menu-block">
              <h6 class="menu-block-heading">Please Select Menu</h6>
              @if (isset($menus) && count($menus) > 0)
                <ul>
                  @foreach ($menus as $menu)
                    <li>
                      <div class="inline">
                        <input type="checkbox" class="filled-in material-checkbox-input" name="menu[]" value="{{$menu->id}}" id="checkbox{{$menu->id}}" {{$menu->name == 'Home' ?  'checked' : ($menu->name == 'TvSeries' ? 'checked' : '')}}>
                        <label for="checkbox{{$menu->id}}" class="material-checkbox"></label>
                      </div>
                      {{$menu->name}}
                    </li>
                  @endforeach
                </ul>
              @endif
            </div>
            <div class="switch-field">
              <div class="switch-title">Want IMDB Ratings And More Or Custom?</div>
              <input type="radio" id="switch_left" class="imdb_btn" name="tmdb" value="Y" checked/>
              <label for="switch_left">TMDB</label>
              <input type="radio" id="switch_right" class="custom_btn" name="tmdb" value="N" />
              <label for="switch_right">Custom</label>
            </div>
            <div id="custom_dtl" class="custom-dtl">
              <div class="form-group{{ $errors->has('genre_id') ? ' has-error' : '' }}">
                  {!! Form::label('genre_id', 'Genre') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please select tvseries genres"></i>
                  {!! Form::select('genre_id[]', $genre_ls, null, ['class' => 'form-control select2', 'multiple']) !!}
                  <small class="text-danger">{{ $errors->first('genre_id') }}</small>
              </div>
              <div class="form-group{{ $errors->has('rating') ? ' has-error' : '' }}">
                  {!! Form::label('rating', 'Ratings') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter tvseries rating eg:5.8"></i>
                  {!! Form::text('rating', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('rating') }}</small>
              </div>
              <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                  {!! Form::label('detail', 'Description') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter tvseries description"></i>
                  {!! Form::textarea('detail', null, ['class' => 'form-control materialize-textarea', 'rows' => '5']) !!}
                  <small class="text-danger">{{ $errors->first('detail') }}</small>
              </div>  
            </div>
            <div class="btn-group pull-right">
              <button type="reset" class="btn btn-info"><i class="material-icons left">toys</i> Reset</button>
              <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> Create</button>
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
      $('.upload-image-main-block').hide();
      $('.for-custom-image input').click(function(){
        if($(this).prop("checked") == true){
          $('.upload-image-main-block').fadeIn();
        }
        else if($(this).prop("checked") == false){
          $('.upload-image-main-block').fadeOut();
        }
      });
    });
	</script>

   <script>
    $('#tv_id').on('change',function(){
      if ($('#tv_id').is(':checked')){
        $('#tv_title').show('fast');
        $('#tvs_id').hide('fast');
      }else{
         $('#tvs_id').show('fast');
        $('#tv_title').hide('fast');
      }
    });
  </script>
@endsection