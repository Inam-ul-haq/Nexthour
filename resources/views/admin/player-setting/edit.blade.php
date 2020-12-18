@extends('layouts.admin')
@section('title',"Player Sttings")
@section('content')
  <div class="admin-form-main-block">
    <h4 class="admin-form-text"><a href="{{url('admin/')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Player Settings</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">       
          {!! Form::model($ps, ['method' => 'POST', 'action' => ['PlayerSettingController@update', $ps->id], 'files' => true]) !!}

          <div class="row">
           <div class="form-group{{ $errors->has('logo_enable') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('logo_enable', 'Logo Enable: ') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('logo_enable', 1, $ps->share_opt, ['class' => 'checkbox-switch', 'id'=>'logo_enable']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('logo_enable') }}</small>
              </div>
            </div>
             <div class="col-md-6 "  id="logobox" style="{{ $ps->logo != '' ? ""  : "display:none" }}">
                  <div class="logobox form-group{{ $errors->has('logo') ? ' has-error' : '' }} input-file-block">
                   {!! Form::label('logo', 'logo') !!} - <p class="info">Help block text</p>
                    {!! Form::file('logo', ['class' => 'input-file', 'id'=>'logo']) !!}
                    <label for="logo" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="logo">
                      <i class="icon fa fa-check"></i>
                      <span class="js-fileName">Choose a File</span>
                    </label>
                    <p class="info">Choose custom logo</p>
                    <small class="text-danger">{{ $errors->first('logo') }}</small>
                  </div>
                </div>
                </div>
            <div class="form-group{{ $errors->has('cpy_text') ? ' has-error' : '' }}">
              {!! Form::label('cpy_text', 'Copyright Text') !!}
              <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your Copyright Text"></i>
              {!! Form::text('cpy_text', null, ['class' => 'form-control', 'required' => 'required',]) !!}
              <small class="text-danger">{{ $errors->first('cpy_text') }}</small>
            </div>
           
            <div class="form-group{{ $errors->has('share_opt') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('share_opt', 'Share Option: ') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('share_opt', 1, $ps->share_opt, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('share_opt') }}</small>
              </div>
            </div>
             <div class="form-group{{ $errors->has('auto_play') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('auto_play', 'Auto Play: ') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('auto_play', 1, $ps->auto_play, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('speed') }}</small>
              </div>
            </div>
             <div class="form-group{{ $errors->has('speed') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('speed', 'Speed Options: ') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('speed', 1, $ps->speed, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('speed') }}</small>
              </div>
            </div>
             
              <div class="form-group{{ $errors->has('info_window') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('info_window', 'Info-Window Option: ') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('info_window', 1, $ps->info_window, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('info_window') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('skin') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('skin', 'Player Select Skin: ') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <select class="select2" name="skin" id="skin">
                    @if($ps->skin=='minimal_skin_dark')
                    <option value="minimal_skin_dark" selected="true">Minimal Dark</option>
                    @else
                      <option value="minimal_skin_dark">Minimal Dark</option>
                    @endif
                     @if($ps->skin=='minimal_skin_white')
                    <option value="minimal_skin_white" selected="true">Minimal White</option>
                    @else
                      <option value="minimal_skin_white">Minimal White</option>
                    @endif
                     @if($ps->skin=='classic_skin_dark')
                   <option value="classic_skin_dark" selected="true">Classic Dark</option>
                    @else
                     
                    <option value="classic_skin_dark">Classic Dark</option>
                    @endif
                     @if($ps->skin=='classic_skin_white')
                    <option value="classic_skin_white" selected="true">Classic White</option>
                    @else
                     
                    <option value="classic_skin_white">Classic White</option>
                    @endif
                     @if($ps->skin=='modern_skin_dark')
                    <option value="modern_skin_dark" selected="true">Modern Dark</option>
                    @else
                     
                     <option value="modern_skin_dark">Modern Dark</option>
                    @endif
                     @if($ps->skin=='modern_skin_white')
                    <option value="modern_skin_white" selected="true">Modern White</option>
                    @else
                     
                     <option value="modern_skin_white" >Modern White</option>
                    @endif
                   
                  </select>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('skin') }}</small>
              </div>
            </div>
             <div class="form-group{{ $errors->has('loop_video') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('loop_video', 'Loop-Video Option: ') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('loop_video', 1, $ps->loop_video, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('loop_video') }}</small>
              </div>
            </div>
             <div class="form-group{{ $errors->has('is_resume') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-xs-4">
                  {!! Form::label('is_resume', 'Resume/Playback Option: ') !!}
                </div>
                <div class="col-xs-5 pad-0">
                  <label class="switch">                
                    {!! Form::checkbox('is_resume', 1, $ps->is_resume, ['class' => 'checkbox-switch']) !!}
                    <span class="slider round"></span>
                  </label>
                </div>
              </div>
              <div class="col-xs-12">
                <small class="text-danger">{{ $errors->first('is_resume') }}</small>
              </div>
            </div>
            <div class="btn-group pull-right">
              <button type="submit" class="btn btn-success">Update</button>
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
  $(function(){
    $('form').on('submit', function(event){
      $('.loading-block').addClass('active');
    });
  });

 $('#logo_enable').on('change',function(){
  if($('#logo_enable').is(':checked')){
    //show
    $('#logobox').show();
  }else{
    //hide
     $('#logobox').hide();
  }
});
</script>
@endsection