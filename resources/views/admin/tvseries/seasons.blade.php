@extends('layouts.admin')
@section('title','Manage Season')
@section('content')
<div class="admin-form-main-block mrg-t-40">
  <h4 class="admin-form-text"><a href="{{url('admin/tvseries')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Manage Seasons <span>Of {{$tv_series->title}}
    @if ($tv_series->tmdb == 'Y')
      <span class="min-info">{!!$tv_series->tmdb == 'Y' ? '<i class="material-icons">check_circle</i> by tmdb' : ''!!}</span>
    @endif
  </span></h4>
  <div class="admin-create-btn-block">
    <a id="createButton" onclick="showCreateForm()" class="btn btn-danger btn-md"><i class="material-icons left">add</i> Create Season</a>
  </div>
  <div class="row">
    <div class="col-md-6">
      <div class="admin-form-block z-depth-1">
        <div id="createForm">
          {!! Form::open(['method' => 'POST', 'action' => 'TvSeriesController@store_seasons', 'files' => true]) !!}
            <div class="form-group{{ $errors->has('season_no') ? ' has-error' : '' }}">
              {!! Form::label('season_no', 'Season No.') !!}
              {!! Form::number('season_no', null, ['class' => 'form-control', 'min' => '1']) !!}
              <small class="text-danger">{{ $errors->first('season_no') }}</small>
            </div>
            <div class="form-group{{ $errors->has('a_language') ? ' has-error' : '' }}">
                {!! Form::label('a_language', 'Audio Languages') !!}
                <p class="inline info"> - Please select audio language</p>
                <div class="input-group">
                  {!! Form::select('a_language[]', $a_lans, null, ['class' => 'form-control select2', 'multiple']) !!}
                  <a href="#" data-toggle="modal" data-target="#AddLangModal" class="input-group-addon"><i class="material-icons left">add</i></a>
                </div>
                <small class="text-danger">{{ $errors->first('a_language') }}</small>
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
                    <label for="thumbnail" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Thumbnail">
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
                    <label for="poster" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Poster">
                      <i class="icon fa fa-check"></i>
                      <span class="js-fileName">Choose a File</span>
                    </label>
                    <p class="info">Choose custom poster</p>
                    <small class="text-danger">{{ $errors->first('poster') }}</small>
                  </div>
                </div>
              </div>
            </div>
            <div class="pad_plus_border">
              <div class="form-group{{ $errors->has('subtitle') ? ' has-error' : '' }}">
                <div class="row">
                  <div class="col-xs-6">
                    {!! Form::label('subtitle', 'Subtitle') !!}
                  </div>
                  <div class="col-xs-5 pad-0">
                    <label class="switch">
                      {!! Form::checkbox('subtitle', 1, 0, ['class' => 'checkbox-switch']) !!}
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
                <div class="col-xs-12">
                  <small class="text-danger">{{ $errors->first('subtitle') }}</small>
                </div>
              </div>
              <div class="form-group{{ $errors->has('subtitle_list') ? ' has-error' : '' }} subtitle_list">
                  {!! Form::label('subtitle_list', 'Subtitles List') !!}
                  <div class="input-group">
                    {!! Form::select('subtitle_list[]', $a_lans, null, ['class' => 'form-control select2', 'multiple']) !!}
                    <a href="#" data-toggle="modal" data-target="#AddLangModal" class="input-group-addon"><i class="material-icons left">add</i></a>
                  </div>
                  <small class="text-danger">{{ $errors->first('subtitle_list') }}</small>
              </div>
            </div>
            {{ Form::hidden('tv_series_id', $id) }}
            <div class="switch-field">
              <div class="switch-title">Want IMDB Ratings And More Or Custom?</div>
              <input type="radio" id="switch_left" class="imdb_btn" name="tmdb" value="Y" checked/>
              <label for="switch_left">TMDB</label>
              <input type="radio" id="switch_right" class="custom_btn" name="tmdb" value="N" />
              <label for="switch_right">Custom</label>
            </div>
            <div id="custom_dtl" class="custom-dtl">
              <div class="form-group{{ $errors->has('actor_id') ? ' has-error' : '' }}">
                  {!! Form::label('actor_id', 'Actors') !!}
                  <p class="inline info"> - Please select tvseries seasons's  actor</p>
                  {!! Form::select('actor_id[]', $actor_ls, null, ['class' => 'form-control select2', 'multiple']) !!}
                  <small class="text-danger">{{ $errors->first('actor_id') }}</small>
              </div>
              <div class="form-group{{ $errors->has('publish_year') ? ' has-error' : '' }}">
                {!! Form::label('publish_year', 'Publish year') !!}
                {!! Form::number('publish_year', null, ['class' => 'form-control', 'min' => '0']) !!}
                <small class="text-danger">{{ $errors->first('publish_year') }}</small>
              </div>
              <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                {!! Form::label('detail', 'Description') !!}
                {!! Form::text('detail', null, ['class' => 'form-control']) !!}
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
        @if(isset($seasons))
          @foreach($seasons as $key => $season)
            @php
                $all_languages = App\AudioLanguage::all();
                // get old audio language values
                $old_lans = collect();
                $a_lans = collect();
                if ($season->a_language != null){
                  $old_list = explode(',', $season->a_language);
                  for ($i = 0; $i < count($old_list); $i++) {
                    $old1 = App\AudioLanguage::find($old_list[$i]);
                    if ( isset($old1) ) {
                      $old_lans->push($old1);
                    }
                  }
                }
                $a_lans = $all_languages->diff($old_lans);

                // get old subtitle language values
                $old_subtitles = collect();
                $a_subs = collect();
                if ($season->subtitle == 1) {
                  if ($season->subtitle_list != null){
                    $old_list = explode(',', $season->subtitle_list);
                    for ($i = 0; $i < count($old_list); $i++) {
                      $old2 = App\AudioLanguage::find($old_list[$i]);
                      if ( isset($old2) ) {
                        $old_subtitles->push($old2);
                      }
                    }
                  }
                }
                $a_subs = $all_languages->diff($old_subtitles);

            @endphp
            <div id="editForm{{$season->id}}" class="edit-form">
              {!! Form::model($season, ['method' => 'PATCH', 'files' => true, 'action' => ['TvSeriesController@update_seasons', $season->id]]) !!}
                <div class="form-group{{ $errors->has('season_no') ? ' has-error' : '' }}">
                  {!! Form::label('season_no', 'Season No.') !!}
                  {!! Form::number('season_no', null, ['class' => 'form-control', 'min' => '1']) !!}
                  <small class="text-danger">{{ $errors->first('season_no') }}</small>
                </div>
                {{ Form::hidden('tv_series_id', $id) }}
                <div class="form-group{{ $errors->has('a_language') ? ' has-error' : '' }}">
                  {!! Form::label('a_language', 'Audio Languages') !!}
                  <div class="input-group">
                    <select name="a_language[]" id="a_language" class="form-control select2" multiple="multiple">
                      @if(isset($old_lans) && count($old_lans) > 0)
                        @foreach($old_lans as $old)
                          <option value="{{$old->id}}" selected="selected">{{$old->language}}</option>
                        @endforeach
                      @endif
                      @if(isset($a_lans))
                        @foreach($a_lans as $rest)
                          <option value="{{$rest->id}}">{{$rest->language}}</option>
                        @endforeach
                      @endif
                    </select>
                    <a href="#" data-toggle="modal" data-target="#AddLangModal" class="input-group-addon"><i class="material-icons left">add</i></a>
                  </div>
                  <small class="text-danger">{{ $errors->first('a_language') }}</small>
                </div>
                <div class="form-group{{ $errors->has('subtitle') ? ' has-error' : '' }}">
                  <div class="row">
                    <div class="col-xs-6">
                      {!! Form::label('subtitle', 'Subtitle') !!}
                    </div>
                    <div class="col-xs-5 pad-0">
                      <label class="switch">
                        {!! Form::checkbox('subtitle', 1, $season->subtitle, ['class' => 'checkbox-switch']) !!}
                        <span class="slider round"></span>
                      </label>
                    </div>
                  </div>
                  <div class="col-xs-12">
                    <small class="text-danger">{{ $errors->first('subtitle') }}</small>
                  </div>
                </div>
                <div class="form-group{{ $errors->has('subtitle_list') ? ' has-error' : '' }} subtitle_list">
                  {!! Form::label('subtitle_list', 'Subtitles List') !!}
                  <div class="input-group">
                    <select name="subtitle_list[]" id="subtitle_list" class="form-control select2" multiple="multiple">
                      @if(isset($old_subtitles) && count($old_subtitles) > 0)
                        @foreach($old_subtitles as $old)
                          <option value="{{$old->id}}" selected="selected">{{$old->language}}</option>
                        @endforeach
                      @endif
                      @if(isset($a_subs))
                        @foreach($a_subs as $rest)
                          <option value="{{$rest->id}}">{{$rest->language}}</option>
                        @endforeach
                      @endif
                    </select>
                    <a href="#" data-toggle="modal" data-target="#AddLangModal" class="input-group-addon"><i class="material-icons left">add</i></a>
                  </div>
                  <small class="text-danger">{{ $errors->first('subtitle_list') }}</small>
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
                        {!! Form::file('thumbnail', ['class' => 'input-file', 'id'=>'thumbnail'.$season->id]) !!}
                        <label for="thumbnail{{$season->id}}" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Thumbnail">
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
                        {!! Form::file('poster', ['class' => 'input-file', 'id'=>'poster'.$season->id]) !!}
                        <label for="poster{{$season->id}}" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Poster">
                          <i class="icon fa fa-check"></i>
                          <span class="js-fileName">Choose a File</span>
                        </label>
                        <p class="info">Choose custom poster</p>
                        <small class="text-danger">{{ $errors->first('poster') }}</small>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="switch-field">
                  <div class="switch-title">Want IMDB Ratings And More Or Custom?</div>
                  <input type="radio" id="switch_left{{$season->id}}" class="imdb_btn" name="tmdb" value="Y" {{$season->tmdb == 'Y' ? 'checked' : ''}}/>
                  <label for="switch_left{{$season->id}}" onclick="hide_custom({{$season->id}})">TMDB</label>
                  <input type="radio" id="switch_right{{$season->id}}" class="custom_btn" name="tmdb" value="N" {{$season->tmdb != 'Y' ? 'checked' : ''}}/>
                  <label for="switch_right{{$season->id}}" onclick="show_custom({{$season->id}})">Custom</label>
                </div>
                <div id="custom_dtl{{$season->id}}" class="custom-dtl">
                  @php
                    // get old actor list
                    $actor_ls = App\Actor::all();
                    $old_actor = collect();
                    if ($season->actor_id != null){
                      $old_list = explode(',', $season->actor_id);
                      for ($i = 0; $i < count($old_list); $i++) {
                        $old3 = App\Actor::find(trim($old_list[$i]));
                        if ( isset($old3) ) {
                          $old_actor->push($old3);
                        }
                      }
                    }
                    $old_actor = $old_actor->filter(function($value, $key) {
                      return  $value != null;
                    });
                    $actor_ls = $actor_ls->diff($old_actor);

                  @endphp

                  <div class="form-group{{ $errors->has('actor_id') ? ' has-error' : '' }}">
    									{!! Form::label('actor_id', 'Actors') !!}
                      <p class="inline info"> - Please select tvseries seasons's actor</p>
                      <div class="input-group">
                        <select name="actor_id[]" id="actor_id" class="form-control select2" multiple="multiple">
                          @if(isset($old_actor) && count($old_actor) > 0)
                            @foreach($old_actor as $old)
                              <option value="{{$old->id}}" selected="selected">{{$old->name}}</option>
                            @endforeach
                          @endif
                          @if(isset($actor_ls))
                            @foreach($actor_ls as $rest)
                              <option value="{{$rest->id}}">{{$rest->name}}</option>
                            @endforeach
                          @endif
                        </select>
                        <a href="#" data-toggle="modal" data-target="#AddActorModal" class="input-group-addon"><i class="material-icons left">add</i></a>
                      </div>
    									<small class="text-danger">{{ $errors->first('actor_id') }}</small>
    							</div>





                  <div class="form-group{{ $errors->has('publish_year') ? ' has-error' : '' }}">
                    {!! Form::label('publish_year', 'Publish year') !!}
                    {!! Form::number('publish_year', null, ['class' => 'form-control', 'min' => '0']) !!}
                    <small class="text-danger">{{ $errors->first('publish_year') }}</small>
                  </div>
                  <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                    {!! Form::label('detail', 'Description') !!}
                    {!! Form::text('detail', null, ['class' => 'form-control']) !!}
                    <small class="text-danger">{{ $errors->first('detail') }}</small>
                  </div>
                </div>
                <div class="btn-group pull-right">
                  <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> update season</button>
                </div>
                <div class="clear-both"></div>
              {!! Form::close() !!}
            </div>
          @endforeach
        @endif
      </div>
    </div>
    <div class="col-md-6">
      <div class="admin-form-block content-block z-depth-1">
        <table class="table table-hover">
          <thead>
          <tr class="table-heading-row side-table">
            <th>#</th>
            <th>Thumbnail</th>
            <th>Season</th>
            <th>Episodes</th>
            <th>By TMDB</th>
            <th>Actions</th>
          </tr>
          </thead>
          @if ($seasons)
            <tbody>
            @foreach ($seasons as $key => $season)
              <tr>
                <td>{{$key+1}}</td>
                <td>
                  @if ($season->thumbnail != null)
                    <img src="{{ asset('images/tvseries/thumbnails/'.$season->thumbnail) }}" width="45px" class="img-responsive" alt="image">
                  @endif
                </td>
                <td>
                  Season {{$season->season_no}}
                </td>
                <td>
                  @if (isset($season->episodes) && count($season->episodes) > 0)
                    {{count($season->episodes)}} episodes
                  @else
                    N/A
                  @endif
                </td>
                <td>{!!$season->tmdb == 'Y' ? '<i class="material-icons done">done</i>' : '-'!!}</td>
                <td>
                  <div class="admin-table-action-block side-table-action">
                    <a id="editButton{{$season->id}}" onclick="showForms({{$season->id}})" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a>
                    <a href="{{route('show_episodes', $season->id)}}" data-toggle="tooltip" data-original-title="Manage Episodes" class="btn-success btn-floating"><i class="material-icons">settings</i></a>
                    <button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#{{$season->id}}deleteModal"><i class="material-icons">delete</i> </button>
                  </div>
                </td>
              </tr>
              <!-- Delete Modal -->
              <div id="{{$season->id}}deleteModal" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">Are You Sure ?</h4>
                      <p>Do you really want to delete these records? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                      {!! Form::open(['method' => 'DELETE', 'action' => ['TvSeriesController@destroy_seasons', $season->id]]) !!}
                      {!! Form::reset("No", ['class' => 'btn btn-gray', 'data-dismiss' => 'modal']) !!}
                      {!! Form::submit("Yes", ['class' => 'btn btn-danger']) !!}
                      {!! Form::close() !!}
                    </div>
                  </div>
                </div>
              </div>
            @endforeach
            </tbody>
          @endif
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Actor Modal -->
<div id="AddActorModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Add Actor</h5>
      </div>
      {!! Form::open(['method' => 'POST', 'action' => 'ActorController@store', 'files' => true]) !!}
        <div class="modal-body admin-form-block">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Name') !!}
              {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
          <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} input-file-block">
            {!! Form::label('image', 'Director Image') !!} - <p class="inline info">Help block text</p>
            {!! Form::file('image', ['class' => 'input-file', 'id'=>'image']) !!}
            <label for="image" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Director pic">
              <i class="icon fa fa-check"></i>
              <span class="js-fileName">Choose a File</span>
            </label>
            <p class="info">Choose custom image</p>
            <small class="text-danger">{{ $errors->first('image') }}</small>
          </div>
        </div>
        <div class="modal-footer">
          <div class="btn-group pull-right">
            <button type="reset" class="btn btn-info"><i class="material-icons left">toys</i> Reset</button>
            <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> Create</button>
          </div>
        </div>
        <div class="clear-both"></div>
      {!! Form::close() !!}
    </div>
  </div>
</div>

<!-- Add Language Modal -->
<div id="AddLangModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-sm">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Add Language</h5>
      </div>
      {!! Form::open(['method' => 'POST', 'action' => 'AudioLanguageController@store']) !!}
      <div class="modal-body">
        <div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
          {!! Form::label('language', 'Language') !!}
          {!! Form::text('language', null, ['class' => 'form-control', 'required' => 'required']) !!}
          <small class="text-danger">{{ $errors->first('language') }}</small>
        </div>
      </div>
      <div class="modal-footer">
        <div class="btn-group pull-right">
          <button type="reset" class="btn btn-info">Reset</button>
          <button type="submit" class="btn btn-success">Create</button>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
  </div>
</div>
@endsection

@section('custom-script')
  <script>
    $(document).ready(function(){
      $('#createForm').siblings().hide();
      $('.custom-dtl').hide();
      $('.upload-image-main-block').hide();
      $('.subtitle_list').hide();
      $('input[name="subtitle"]').click(function(){
        if($(this).prop("checked") == true){
          $('.subtitle_list').fadeIn();
        }
        else if($(this).prop("checked") == false){
          $('.subtitle_list').fadeOut();
        }
      });
    });
    $('.for-custom-image input').click(function(){
      if($(this).prop("checked") == true){
        $('.upload-image-main-block').fadeIn();
      }
      else if($(this).prop("checked") == false){
        $('.upload-image-main-block').fadeOut();
      }
    });
    let showCreateForm = () => {
      $('#createForm').show().siblings().hide();
    };
    let showForms = (id) => {
      let editForm = '#editForm' + id;
      $(editForm).show().siblings().hide();
      var custom_dtl = '#custom_dtl'+id;
      var custom_check = '#switch_right'+id;
      if ($(custom_check).is(':checked')) {
        $(custom_dtl).show();
      }
    };
    let hide_custom = (id) => {
      var custom_dtl = '#custom_dtl'+id;
      $(custom_dtl).hide();
    };
    let show_custom = (id) => {
      var custom_dtl = '#custom_dtl'+id;
      $(custom_dtl).show();
    };
  </script>
  
<script>
     $(document).ready(function() {
  var SITEURL = '{{URL::to('')}}';

 
        $.ajax({
            type: "GET",
            url: SITEURL + "/admin/tvshow/upload_video/converting",
            success: function (data) {
           console.log('Success:',data);
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    
     });
</script>
@endsection
