@extends('layouts.admin')
@section('title',"Edit Language - $language->name")
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/languages')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Edit Language</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">
          {!! Form::model($language, ['method' => 'PATCH', 'action' => ['LanguageController@update', $language->id]]) !!}
            <div class="form-group{{ $errors->has('local') ? ' has-error' : '' }}">
                {!! Form::label('local', 'local') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter language local name eg:en"></i>
                {!! Form::text('local', null, ['class' => 'form-control', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('local') }}</small>
            </div>
            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {!! Form::label('name', 'Name') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter language local name eg:English"></i>
                {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('name') }}</small>
            </div>

            <div class="form-group">
              <label for="">Set Default</label>
              <br>
              <label class="switch">
                     <input name="def" {{ $language->def==1 ? "checked" : "" }} type="checkbox" class="checkbox-switch" id="logo_chk">
                    <span class="slider round"></span>
                </label>
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
