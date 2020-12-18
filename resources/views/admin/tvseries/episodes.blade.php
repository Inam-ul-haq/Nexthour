@extends('layouts.admin')
@section('title','Manage Episodes')
<style type="text/css">
    body{
            background-color: #efefef;
        }
        .container-4 input#hyv-search {
            width: 500px;
            height: 30px;
            border: 1px solid #c6c6c6;
            font-size: 10pt;
            float: left;
            padding-left: 15px;
            -webkit-border-top-left-radius: 5px;
            -webkit-border-bottom-left-radius: 5px;
            -moz-border-top-left-radius: 5px;
            -moz-border-bottom-left-radius: 5px;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
         .container-4 input#vimeo-search {
            width: 500px;
            height: 30px;
            border: 1px solid #c6c6c6;
            font-size: 10pt;
            float: left;
            padding-left: 15px;
            -webkit-border-top-left-radius: 5px;
            -webkit-border-bottom-left-radius: 5px;
            -moz-border-top-left-radius: 5px;
            -moz-border-bottom-left-radius: 5px;
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }
        .container-4 button.icon {
            height: 30px;
            background: #f0f0f0 url('images/searchicon.png') 10px 1px no-repeat;
            background-size: 24px;
            -webkit-border-top-right-radius: 5px;
            -webkit-border-bottom-right-radius: 5px;
            -moz-border-radius-topright: 5px;
            -moz-border-radius-bottomright: 5px;
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
            border: 1px solid #c6c6c6;
            width: 50px;
            margin-left: -44px;
            color: #4f5b66;
            font-size: 10pt;
        }
    
</style>
@section('content')
  <div class="admin-form-main-block mrg-t-40">
<!--youtube API Modal -->
<div id="myyoutubeModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">
    <!--youtube API Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Search From Youtube API</h5>
      </div>
      <div class="modal-body">
        @if(is_null(env('YOUTUBE_API_KEY')))
        <p>Make Sure You Have Added Youtube API Key in <a href="{{url('admin/api-settings')}}">API Settings</a></p>
        @endif
       
          <div id="hyv-page-container" style="clear:both;">
                <div class="hyv-content-alignment">
                    <div id="hyv-page-content" class="" style="overflow:hidden;">
                        <div class="container-4">
                            <form action="" method="post" name="hyv-yt-search" id="hyv-yt-search">
                                <input type="search" name="hyv-search" id="hyv-search" placeholder="Search..." class="ui-autocomplete-input" autocomplete="off">
                                <button class="icon" id="hyv-searchBtn"></button>
                            </form>
                        </div>
                        <div>
                            <input type="hidden" id="pageToken" value="">
                            <div class="btn-group" role="group" aria-label="...">
                              <button type="button" id="pageTokenPrev" value="" class="btn btn-default">Prev</button>
                              <button type="button" id="pageTokenNext" value="" class="btn btn-default">Next</button>
                            </div>
                        </div>
                        <div id="hyv-watch-content" class="hyv-watch-main-col hyv-card hyv-card-has-padding">
                            <ul id="hyv-watch-related" class="hyv-video-list">
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

    <h4 class="admin-form-text"><a href="{{url('admin/tvseries', $season->tvseries->id)}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Manage Episodes <span>Of {{$season->tvseries->title}} Season {{$season->season_no}}
      @if ($season->tmdb == 'Y')
        <span class="min-info">{!!$season->tmdb == 'Y' ? '<i class="material-icons">check_circle</i> by tmdb' : ''!!}</span>
      @endif
    </span></h4>

<!--vimeo API Modal -->
<div id="myvimeoModal" class="modal fade" role="dialog">
  <div class="modal-dialog modal-lg">

    <!--vimeo API Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h5 class="modal-title">Search From Vimeo API</h5>
      </div>
      <div class="modal-body">
        @if(is_null(env('VIMEO_ACCESS')))
        <p>Make Sure You Have Added Vimeo API Key in <a href="{{url('admin/api-settings')}}">API Settings</a></p>
        @endif
       
          <div id="vimeo-page-container" style="clear:both;">
                <div class="vimeo-content-alignment">
                    <div id="vimeo-page-content" class="" style="overflow:hidden;">
                        <div class="container-4">
                            <form action="" method="post" name="vimeo-yt-search" id="vimeo-yt-search">
                                <input type="search" name="vimeo-search" id="vimeo-search" placeholder="Search..." class="ui-autocomplete-input" autocomplete="off">
                                <button class="icon" id="vimeo-searchBtn"></button>
                            </form>
                        </div>
                        <div>
                            <input type="hidden" id="vpageToken" value="">
                            <div class="btn-group" role="group" aria-label="...">
                              <button type="button" id="vpageTokenPrev" value="" class="btn btn-default">Prev</button>
                              <button type="button" id="vpageTokenNext" value="" class="btn btn-default">Next</button>
                            </div>
                        </div>
                        <div id="vimeo-watch-content" class="vimeo-watch-main-col vimeo-card vimeo-card-has-padding">
                            <ul id="vimeo-watch-related" class="vimeo-video-list">
                            </ul>
                        </div>

                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
    <div class="admin-create-btn-block">
      <a id="createButton" onclick="showCreateForm()" class="btn btn-danger btn-md"><i class="material-icons left">add</i> Create Episode</a>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">
          <div id="createForm" class="create-form">
            {!! Form::open(['method' => 'POST', 'action' => 'TvSeriesController@store_episodes', 'files' => true]) !!}


              <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                {!! Form::label('title', 'Episode Title') !!}
                <p class="inline info"> - Enter your episode title</p>
                {!! Form::text('title', null, ['class' => 'form-control', 'min' => '1']) !!}
                <small class="text-danger">{{ $errors->first('title') }}</small>
              </div>
              <div class="form-group{{ $errors->has('episode_no') ? ' has-error' : '' }}">
                {!! Form::label('episode_no', 'Episode No.') !!}
                <p class="inline info"> - (must fill by tmdb)</p>
                {!! Form::number('episode_no', null, ['class' => 'form-control', 'min' => '1']) !!}
                <small class="text-danger">{{ $errors->first('episode_no') }}</small>
              </div>
              <div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}">
                {!! Form::label('duration', 'Duration') !!} <p class="inline info">- in minutes (exa. 60)</p>
                {!! Form::text('duration', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('duration') }}</small>
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
    <div class="upload-image-main-block" style="display: none;">
      <div class="row">
       
          <div class="form-group{{ $errors->has('thumbnail') ? ' has-error' : '' }} input-file-block">
            {!! Form::label('thumbnail', 'Thumbnail') !!} - <p class="info">Help block text</p>
            {!! Form::file('thumbnail', ['class' => 'input-file', 'id'=>'thumbnail']) !!}
            <label for="thumbnail" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Thumbnail">
              <i class="icon fa fa-check"></i>
              <span class="js-fileName">Choose a File</span>
            </label>
            <p class="info">Choose custom thumbnail</p>
            <small class="text-danger">{{ $errors->first('thumbnail') }}</small>
          </div>
      
      </div>
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
           
              
      {{-- select to upload code start from here --}}
      <div class="form-group{{ $errors->has('selecturl') ? ' has-error' : '' }}">
        {!! Form::label('selecturls', 'Add Video') !!}
        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please select one of the options to add Video/Movie"></i>
        {!! Form::select('selecturl', array('iframeurl' => 'IFrame URL/Embed URL', 
           'youtubeapi' =>'Youtube API', 'vimeoapi' => 'Vimeo API',
           'customurl'=>'Custom URL/ Youtube URL/ Vimeo URL','multiqcustom' => 'Multi Quality Custom URL & URL Upload'), null, ['class' => 'form-control select2','id'=>'selecturl']) !!}
        <small class="text-danger">{{ $errors->first('selecturl') }}</small>
      </div>


            <div id="ifbox" style="display: none;" class="form-group">
              <label for="iframeurl">IFRAME URL/Embed URL: </label> <a data-toggle="modal" data-target="#embdedexamp"><i class="fa fa-question-circle-o"> </i></a>
              <input  type="text" class="form-control" name="iframeurl" placeholder="">
            </div>

              <div style="display: none;" id="custom_url">
                
                <p style="color: red" class="inline info">Upload videos not support wmv and mkv video format !</p>
                <br>
                <p class="inline info">Openload, Google drive and other url add here!</p>
                <br><br>
                <div class="row">
                  <div class="col-md-8">
                     <div class="form-group{{ $errors->has('url_360') ? ' has-error' : '' }}">
                        {!! Form::label('url_360', 'Video Url for 360 Quality') !!}
                        <p class="inline info"> - Please enter your video url</p>
                        {!! Form::text('url_360', null, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('url_360') }}</small>
                     </div>
                  </div>
                  <div class="col-md-4">
                    {!! Form::label('upload_video', 'Upload Video in 360p') !!} - <p class="inline info">Choose A Video</p>
                    {!! Form::file('upload_video_360', ['class' => 'input-file', 'id'=>'upload_video_360']) !!}
                    <label for="upload_video_360" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Upload Video in 360p Quality">
                      <i class="icon fa fa-check"></i>
                      <span class="js-fileName">Choose a File</span>
                    </label>
                    <small class="text-danger">{{ $errors->first('upload_video') }}</small>
                  </div>
                </div>
                <div class="form-group{{ $errors->has('url_480') ? ' has-error' : '' }}">
                  <div class="row">
                    <div class="col-md-8">
                      {!! Form::label('url_480', 'Video Url for 480 Quality') !!}
                      <p class="inline info"> - Please enter your video url</p>
                      {!! Form::text('url_480', null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('url_480') }}</small>
                    </div>
                    <div class="col-md-4">
                       
                          {!! Form::label('upload_video', 'Upload Video in 480p') !!} - <p class="inline info">Choose A Video</p>
                          {!! Form::file('upload_video_480', ['class' => 'input-file', 'id'=>'upload_video_480']) !!}
                          <label for="upload_video_480" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Upload Video in 480p Quality">
                            <i class="icon fa fa-check"></i>
                            <span class="js-fileName">Choose a File</span>
                          </label>
                          <small class="text-danger">{{ $errors->first('upload_video') }}</small>
                        
                    </div>
                  </div>
                    
                </div>
                <div class="form-group{{ $errors->has('url_720') ? ' has-error' : '' }}">
                    
                    
                    <div class="row">

                      <div class="col-md-8">
                        {!! Form::label('url_720', 'Video Url for 720 Quality') !!}
                        <p class="inline info"> - Please enter your video url</p>
                        {!! Form::text('url_720', null, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('url_720') }}</small>
                      </div>

                      <div class="col-md-4">
                         {!! Form::label('upload_video', 'Upload Video in 720p') !!} - <p class="inline info">Choose A Video</p>
                          {!! Form::file('upload_video_720', ['class' => 'input-file', 'id'=>'upload_video_720']) !!}
                          <label for="upload_video_720" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Upload Video in 720p Quality">
                            <i class="icon fa fa-check"></i>
                            <span class="js-fileName">Choose a File</span>
                          </label>
                          <small class="text-danger">{{ $errors->first('upload_video') }}</small>
                      </div>
                    </div>

                </div>
                <div class="form-group{{ $errors->has('url_1080') ? ' has-error' : '' }}">
                   
                   <div class="row">
                     <div class="col-md-8">
                        {!! Form::label('url_1080', 'Video Url for 1080 Quality') !!}
                        <p class="inline info"> - Please enter your video url</p>
                        {!! Form::text('url_1080', null, ['class' => 'form-control']) !!}
                        <small class="text-danger">{{ $errors->first('url_1080') }}</small>
                     </div>

                     <div class="col-md-4">
                      {!! Form::label('upload_video', 'Upload Video in 1080p') !!} - <p class="inline info">Choose A Video</p>
                          {!! Form::file('upload_video_1080', ['class' => 'input-file', 'id'=>'upload_video_1080']) !!}
                          <label for="upload_video_1080" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Upload Video in 1080p Quality">
                            <i class="icon fa fa-check"></i>
                            <span class="js-fileName">Choose a File</span>
                          </label>
                          <small class="text-danger">{{ $errors->first('upload_video') }}</small>
                    </div>

                   </div>
    
                </div>
              </div>

          
          <div class="modal fade" id="embdedexamp" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h6 class="modal-title" id="myModalLabel">Embded URL Examples: </h6>
                </div>
                <div class="modal-body">
                  <p style="font-size: 15px;"><b>Youtube:</b> https://www.youtube.com/embed/videoID </p>

                  <p style="font-size: 15px;"><b>Google Drive:</b> https://drive.google.com/file/d/videoID/preview </p>

                  <p style="font-size: 15px;"><b>Openload:</b> https://openload.co/embed/videoID </p>

                  <p style="font-size: 15px;"><b>Note:</b> Do not include &lt;iframe&gt; tag before URL</p>
                </div>
                
              </div>
            </div>
          </div>

      {{-- youtube and vimeo url --}}
              <div id="ready_url" style="display: none;" class="form-group{{ $errors->has('ready_url') ? ' has-error' : '' }}">
               <label id="ready_url_text"></label>
               <p class="inline info"> - Please enter your video url</p>
               {!! Form::text('ready_url', null, ['class' => 'form-control','id'=>'apiUrl']) !!}
               <small class="text-danger">{{ $errors->first('ready_url') }}</small>
             </div>
        

           {{-- upload video --}}
              <div id="uploadvideo" style="display: none;" class="form-group{{ $errors->has('upload_video') ? ' has-error' : '' }} input-file-block">
              {!! Form::label('upload_video', 'Upload Video') !!} - <p class="inline info">Choose A Video</p>
              {!! Form::file('upload_video', ['class' => 'input-file', 'id'=>'upload_video']) !!}
              <label for="upload_video" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Upload Video">
                <i class="icon fa fa-check"></i>
                <span class="js-fileName">Choose a File</span>
              </label>
              <p class="info">Choose Video</p>
              <small class="text-danger">{{ $errors->first('upload_video') }}</small>
               <label for="">Upload To AWS </label>
        <br>
        <label class="switch">
         <input type="checkbox" name="upload_aws" class="checkbox-switch" id="upload_aws">
         <span class="slider round"></span>

       </label>
            </div>
            {{-- select to upload or add links code ends here --}}
          

            

               <div style="display: none;" id="subtitle_section">
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
               <label>Subtitle:</label>
             <table class="table table-bordered" id="dynamic_field">  
                    <tr> 
                        <td>
                           <div class="form-group{{ $errors->has('sub_t') ? ' has-error' : '' }} input-file-block">
                            <input type="file" name="sub_t[]"/>
                            <p class="info">Choose subtitle file ex. subtitle.srt, or. txt</p>
                            <small class="text-danger">{{ $errors->first('sub_t') }}</small>
                          </div>
                        </td>

                        <td>
                          <input type="text" name="sub_lang[]" placeholder="Subtitle Language" class="form-control name_list" />
                        </td>  
                        <td><button type="button" name="add" id="add" class="btn btn-xs btn-success">
                          <i class="fa fa-plus"></i>
                        </button></td>  
                    </tr>  
            </table>
            </div>


              <div class="switch-field">
                <div class="switch-title">Want TMDB Data And More Or Custom?</div>
                <input type="radio" id="switch_left" class="imdb_btn" name="tmdb" value="Y" checked/>
                <label for="switch_left">TMDB</label>
                <input type="radio" id="switch_right" class="custom_btn" name="tmdb" value="N" />
                <label for="switch_right">Custom</label>
              </div>
              <div id="custom_dtl" class="custom-dtl">
                <div class="form-group{{ $errors->has('released') ? ' has-error' : '' }}">
                  {!! Form::label('released', 'Released') !!} <p class="inline info">- release date</p>
                  {!! Form::date('released', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('released') }}</small>
                </div>
                <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                  {!! Form::label('detail', 'Description') !!}
                  {!! Form::textarea('detail', null, ['class' => 'form-control materialize-textarea', 'rows' => '5']) !!}
                  <small class="text-danger">{{ $errors->first('detail') }}</small>
                </div>
              </div>


              {!! Form::hidden('seasons_id', $season->id) !!}
              {!! Form::hidden('tv_series_id', $season->tvseries->id) !!}
              <div class="btn-group pull-right">
                <button type="reset" class="btn btn-info"><i class="material-icons left">toys</i> Reset</button>
                <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> Create</button>
              </div>
              <div class="clear-both"></div>
            {!! Form::close() !!}
          </div>
         
        </div>
      </div>
      <div class="col-md-6">
        <div class="admin-form-block content-block z-depth-1">
          <table class="table table-hover">
            <thead>
              <tr class="table-heading-row side-table">
                <th>#</th>
                <th>Title</th>
                <th>By TMDB</th>
                <th>Duration</th>
                <th>Actions</th>
              </tr>
            </thead>
            @if ($episodes)
              <tbody>
                <?php $i=0;?>
              @foreach ($episodes as $episode)
                @php $i++; @endphp
                <tr>
                  <td>
                      {{ $i }}
                  </td>
                  <td>
                    {{$episode->title}}
                  </td>
                  <td>
                    @if($episode->tmdb == 'Y')
                      <i class="material-icons done">done</i>
                    @else
                      -
                    @endif
                  </td>
                  <td>{{$episode->duration}} mins</td>
                  <td>
                    <div class="admin-table-action-block side-table-action">
                      <a href="{{route('edit_episodes',['id'=>$season->id,'ep_id'=>$episode->id])}}" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a>
                      <button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#{{$episode->id}}deleteModal"><i class="material-icons">delete</i> </button>
                    </div>
                  </td>
                </tr>
                <!-- Modal -->
                <div id="{{$episode->id}}deleteModal" class="delete-modal modal fade" role="dialog">
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
                        {!! Form::open(['method' => 'DELETE', 'action' => ['TvSeriesController@destroy_episodes', $episode->id]]) !!}
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
  <script>

     $('.for-custom-image input').click(function(){
    if($(this).prop("checked") == true){
      $('.upload-image-main-block').fadeIn();
    }
    else if($(this).prop("checked") == false){
      $('.upload-image-main-block').fadeOut();
    }
  });
    $(document).ready(function(){
    
     $("#selecturl").select2({
        placeholder: "Add Video Through...",
       
    });
    $('#ifbox').show();
     $('#subtitle_section').show();
    $('#selecturl').change(function(){  
     selecturl = document.getElementById("selecturl").value;
     if (selecturl == 'iframeurl') {
    $('#ifbox').show();
    $('#uploadvideo').hide();
    $('#subtitle_section').show();
    $('#ready_url').hide();
    $('#custom_url').hide();

   }else if (selecturl == 'uploadvideo') {
    $('#custom_url').hide();
    $('#uploadvideo').show();
    $('#ready_url').hide();
    $('#subtitle_section').show();
    $('#ifbox').hide();

   }else if (selecturl=='customurl') {
    $('#custom_url').hide();
    $('#ready_url_text').text('Enter Custom URL or Vimeo or Youtube URL');
    $('#ready_url').show();
    $('#ifbox').hide();
    $('#subtitle_section').show();
    $('#uploadvideo').hide();
   }
    else if (selecturl == 'youtubeapi') {
   $('#uploadvideo').hide();
   $('#ready_url').show();
 
   $('#ifbox').hide();
     $('#subtitle_section').show();
   $('#ready_url_text').text('Import From Youtube API');
$('#custom_url').hide();
 }else if(selecturl=='vimeoapi'){
   $('#ifbox').hide();
   $('#uploadvideo').hide();
   $('#ready_url').show();
     $('#subtitle_section').show();
 $('#custom_url').hide();
   $('#ready_url_text').text('Import From Vimeo API');
 }
 else if(selecturl=='multiqcustom'){
   $('#ifbox').hide();
   $('#uploadvideo').hide();
   $('#ready_url').hide();
   $('#subtitle_section').show();
   $('#custom_url').show();
 }

 });

      var i= 1;
      $('#add').click(function(){  
           i++;  
           $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="file" name="sub_t[]"/></td><td><input type="text" name="sub_lang[]" placeholder="Subtitle Language" class="form-control name_list" /></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn-sm btn_remove">X</button></td></tr>');  
      });

      $(document).on('click', '.btn_remove', function(){  
           var button_id = $(this).attr("id");   
           $('#row'+button_id+'').remove();  
      });  

      $('#createForm').siblings().hide();
      // $('.custom-dtl').hide();
      // $('.custom_url').hide();
      var get = $('.TheCheckBox').val();
      if(get == 1){

            $('.ready_url').show();
            $('.custom_url').hide();
      }
      else{

             $('.ready_url').hide();
             $('.custom_url').show();
      }
      $('.TheCheckBox').on('switchChange.bootstrapSwitch', function (event, state) {

          if (state == true) {

             $('.ready_url').show();
            $('.custom_url').hide();

          } else if (state == false) {

            $('.ready_url').hide();
            $('.custom_url').show();

          };

      });

      $('.subtitle_list').hide();
      $('.subtitle-file').hide();
      $('input[name="subtitle"]').click(function(){
          if($(this).prop("checked") == true){
              $('.subtitle_list').fadeIn();
              $('.subtitle-file').fadeIn();
          }
          else if($(this).prop("checked") == false){
            $('.subtitle_list').fadeOut();
              $('.subtitle-file').fadeOut();
          }
      });
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

      var ifbtn = '#iframecheck2'+id;
      var rcbtn = '#TheCheckBox'+id;

      if($(ifbtn).is(':checked')){
        $('#urlbox2'+id).hide();
        $('#ifbox2'+id).show();
      }else{
        $('#urlbox2'+id).show();
        $('#ifbox2'+id).hide();
      }

      if ($(rcbtn).is(':checked')) {

        $('#ready_url'+id).show();
        $('#custom_url'+id).hide();

      }else{
         $('#ready_url'+id).hide();
         $('#custom_url'+id).show();
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
    function epilink(id){
      if ($('#iframecheck2'+id).is(':checked')){
             $('#urlbox2'+id).hide();
             $('#ifbox2'+id).show();
      }else{
            $('#urlbox2'+id).show();
            $('#ifbox2'+id).hide();
      }
    }

    function changes(id)
    {
      if ($('#TheCheckBox'+id).is(':checked')){

          $('#ready_url_check'+id).val(1);

  
      }else{
     
          $('#ready_url_check'+id).val(0);

      }
    }
  </script>

  <script>
        $(document).ready(function() {
           var videourl;
            youtubeApiCall();
            $("#pageTokenNext").on( "click", function( event ) {
                $("#pageToken").val($("#pageTokenNext").val());
                youtubeApiCall();
            });
            $("#pageTokenPrev").on( "click", function( event ) {
                $("#pageToken").val($("#pageTokenPrev").val());
                youtubeApiCall();
            });
            $("#hyv-searchBtn").on( "click", function( event ) {
                youtubeApiCall();
                return false;
            });
            jQuery( "#hyv-search" ).autocomplete({
              source: function( request, response ) {
                //console.log(request.term);
                var sqValue = [];
                jQuery.ajax({
                    type: "POST",
                    url: "http://suggestqueries.google.com/complete/search?hl=en&ds=yt&client=youtube&hjson=t&cp=1",
                    dataType: 'jsonp',
                    data: jQuery.extend({
                        q: request.term
                    }, {  }),
                    success: function(data){
                        console.log(data[1]);
                        obj = data[1];
                        jQuery.each( obj, function( key, value ) {
                            sqValue.push(value[0]);
                        });
                        response( sqValue);
                    }
                });
              },
              select: function( event, ui ) {
                setTimeout( function () { 
                    youtubeApiCall();
                }, 300);
              }
            });  
        });
function youtubeApiCall(){
    $.ajax({
        cache: false,
        data: $.extend({
            key: '{{env('YOUTUBE_API_KEY')}}',
            q: $('#hyv-search').val(),
            part: 'snippet'
        }, {maxResults:15,pageToken:$("#pageToken").val()}),
        dataType: 'json',
        type: 'GET',
        timeout: 5000,
        url: 'https://www.googleapis.com/youtube/v3/search'
    })
    .done(function(data) {
        if (typeof data.prevPageToken === "undefined") {$("#pageTokenPrev").hide();}else{$("#pageTokenPrev").show();}
        if (typeof data.nextPageToken === "undefined") {$("#pageTokenNext").hide();}else{$("#pageTokenNext").show();}
        var items = data.items, videoList = "";
        $("#pageTokenNext").val(data.nextPageToken);
        $("#pageTokenPrev").val(data.prevPageToken);
        // console.log(items);
        $.each(items, function(index,e) {
             
             videourl="https://www.youtube.com/watch?v="+e.id.videoId;
               console.log(videourl);
            videoList = videoList 
            + '<li class="hyv-video-list-item" ><div class="hyv-content-wrapper"><p  class="hyv-content-link" title="'+e.snippet.title+'"><span class="title">'+e.snippet.title+'</span><span class="stat attribution">by <span>'+e.snippet.channelTitle+'</span></span></p><button class="bn btn-info btn-sm inline" onclick=setVideoURl("'+videourl+'")>Add</button></div><div class="hyv-thumb-wrapper"><p class="hyv-thumb-link"><span class="hyv-simple-thumb-wrap"><img alt="'+e.snippet.title+'" src="'+e.snippet.thumbnails.default.url+'" height="90"></span></p></div></li>';
              
          
        });

        $("#hyv-watch-related").html(videoList);
       
    });
}
    </script>
<script type="text/javascript">
  function setVideoURl(videourls){
    console.log(videourls);
  $('#apiUrl').val(videourls); 
    $('#myyoutubeModal').modal("hide");
  }
</script>
<script type="text/javascript">
  $(document).ready(function(){ 
    $('#selecturl').change(function() {
     $('#apiUrl').val('');  
        var opval = $(this).val(); //Get value from select element
        if(opval=="youtubeapi"){ //Compare it and if true
            $('#myyoutubeModal').modal("show"); //Open Modal
        }
    });
});
</script>
{{-- vimeo api code --}}

<script>
        $(document).ready(function() {
           var videourl;
            vimeoApiCall();
            $("#vpageTokenNext").on( "click", function( event ) {
                $("#vpageToken").val($("#vpageTokenNext").val());
                vimeoApiCall();
            });
            $("#vpageTokenPrev").on( "click", function( event ) {
                $("#vpageToken").val($("#vpageTokenPrev").val());
                vimeoApiCall();
            });
            $("#vimeo-searchBtn").on( "click", function( event ) {
                vimeoApiCall();
                return false;
            });
            jQuery( "#vimeo-search" ).autocomplete({
              source: function( request, response ) {
                //console.log(request.term);
                var sqValue = [];
                var accesstoken='{{env('VIMEO_ACCESS')}}';
                var myvimeourl='https://api.vimeo.com/videos?query=videos'+'&access_token=' + accesstoken +'&per_page=1';
                console.log(myvimeourl);
                jQuery.ajax({
                    type: "GET",
                    url: myvimeourl,
                    dataType: 'jsonp',
                    
                    success: function(data){
                        console.log(data[1]);
                        obj = data[1];
                        jQuery.each( obj, function( key, value ) {
                            sqValue.push(value[0]);
                        });
                        response( sqValue);
                    }
                });
              },
              select: function( event, ui ) {
                setTimeout( function () { 
                    vimeoApiCall();
                }, 300);
              }
            });  
        });
function vimeoApiCall(){
  
    var accesstoken='{{env('VIMEO_ACCESS')}}';
    var text=$("#vimeo-search").val();
   var next=  $("#vpageTokenNext").val();
   console.log('jxhh'+next);
   var prev= $("#vpageTokenPrev").val();
    var myvimeourl=null;
   if (next != null && next !='') {
     myvimeourl='https://api.vimeo.com'+next;
   }else if (prev != null && prev !='') {
       myvimeourl='https://api.vimeo.com'+prev;
   }else{
       myvimeourl='https://api.vimeo.com/videos?query='+ text + '&access_token=' + accesstoken+'&per_page=5';
   }
  
   console.log('url'+myvimeourl);
    $.ajax({
        cache: false,
     
        dataType: 'json',
        type: 'GET',
       
        url: myvimeourl,

    })
    .done(function(data) {
      console.log(data);
    // alert('duhjf');
        if ( data.paging.previous === null) {$("#vpageTokenPrev").hide();}else{$("#vpageTokenPrev").show();}
        if ( data.paging.next === null) {$("#vpageTokenNext").hide();}else{$("#vpageTokenNext").show();}
        var items = data.data, videoList = "";
     
        $("#vpageTokenNext").val(data.paging.next);
        $("#vpageTokenPrev").val(data.paging.previous);
        console.log(items);
        $.each(items, function(index,e) {
             
             videourl=e.link;
               // console.log(videourl);
            videoList = videoList 
            + '<li class="hyv-video-list-item" ><div class="hyv-thumb-wrapper"><p class="hyv-thumb-link"><span class="hyv-simple-thumb-wrap"><img alt="'+e.name+'" src="'+e.pictures.sizes[3].link+'" height="90"></span></p></div><div class="hyv-content-wrapper"><p  class="hyv-content-link">'+e.name+'<span class="title">'+e.description.substr(0, 105)+'</span><span class="stat attribution">by <span>'+e.user.name+'</span></span></p><button class="bn btn-info btn-sm inline" onclick=setVideovimeoURl("'+videourl+'")>Add</button></div></li>';
              
          
        });

        $("#vimeo-watch-related").html(videoList);
       
    });

}
</script>
<script type="text/javascript">
  function setVideovimeoURl(videourls){
    console.log(videourls);
  $('#apiUrl').val(videourls); 
    $('#myvimeoModal').modal("hide");
  }
</script>
<script type="text/javascript">
  $(document).ready(function(){ 
    $('#selecturl').change(function() {
     $('#apiUrl').val('');  
        var opval = $(this).val(); //Get value from select element
        if(opval=="youtubeapi"){ //Compare it and if true
            $('#myyoutubeModal').modal("show"); //Open Modal
        }
        if(opval=="vimeoapi"){ //Compare it and if true
            $('#myvimeoModal').modal("show"); //Open Modal
        }
    });
});
</script>
@endsection
