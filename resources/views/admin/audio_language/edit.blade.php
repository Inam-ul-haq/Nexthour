@extends('layouts.admin')
@section('title',"Edit: $a_lan->language")
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/audio_language')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Create Language</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">
        {!! Form::model($a_lan, ['method' => 'PATCH', 'action' => ['AudioLanguageController@update', $a_lan->id]]) !!}
          <div class="form-group{{ $errors->has('language') ? ' has-error' : '' }}">
            {!! Form::label('language', 'Language') !!}
            <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter audio and subtitle language eg:English"></i>
            {!! Form::text('language', null, ['class' => 'form-control', 'required' => 'required']) !!}
            <small class="text-danger">{{ $errors->first('language') }}</small>
          </div>
          <div class="btn-group pull-right">
            <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> Update</button>
          </div>
          <div class="clear-both"></div>
        {!! Form::close() !!}
      </div>
      </div>
    </div>
  </div>
@endsection
