@extends('layouts.admin')
@section('title','Edit Block')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/customize/landing-page')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Edit Block</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">
          {!! Form::model($landing_page, ['method' => 'PATCH', 'action' => ['LandingPageController@update', $landing_page->id], 'files' => true]) !!}
            <div class="form-group{{ $errors->has('heading') ? ' has-error' : '' }}">
                {!! Form::label('heading', 'Heading') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter heading"></i>
                {!! Form::text('heading', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('heading') }}</small>
            </div>
            <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
                {!! Form::label('detail', 'Detail') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter detail"></i>
                {!! Form::textarea('detail', null, ['class' => 'form-control materialize-textarea']) !!}
                <small class="text-danger">{{ $errors->first('detail') }}</small>
            </div>
            <div class="pad_plus_border">
              <div class="form-group{{ $errors->has('button') ? ' has-error' : '' }}">
                <div class="row">
                  <div class="col-xs-6">
                    {!! Form::label('button', 'Button') !!}
                  </div>
                  <div class="col-xs-5 text-right">
                    <label class="switch">
                      {!! Form::checkbox('button', 1, $landing_page->button, ['class' => 'checkbox-switch']) !!}
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
                <div class="col-xs-12">
                  <small class="text-danger">{{ $errors->first('button') }}</small>
                </div>
              </div>
              <div class="bootstrap-checkbox form-group{{ $errors->has('button_link') ? ' has-error' : '' }}">
                <div class="row">
                  <div class="col-md-7">
                    {!! Form::label('button_link', 'Button Link') !!}
                  </div>
                  <div class="col-md-5 pad-0">
                    <div class="make-switch">
                      {!! Form::checkbox('button_link', 1, ($landing_page->button_link == 'login' ? 1 : 0), ['class' => 'bootswitch', "data-on-text"=>"Login", "data-off-text"=>"Register", "data-size"=>"small"]) !!}
                    </div>
                  </div>
                </div>
                <div class="col-md-12">
                  <small class="text-danger">{{ $errors->first('button_link') }}</small>
                </div>
              </div>
              <div class="form-group{{ $errors->has('button_text') ? ' has-error' : '' }} button_text">
                {!! Form::label('button_text', 'Button Text') !!}
                {!! Form::text('button_text', null, ['class' => 'form-control']) !!}
                <small class="text-danger">{{ $errors->first('button_text') }}</small>
              </div>
            </div>
            <div class="bootstrap-checkbox form-group{{ $errors->has('left') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-md-7">
                  <h5 class="bootstrap-switch-label">IMAGE POSITION</h5>
                </div>
                <div class="col-md-5 pad-0">
                  <div class="make-switch">
                    {!! Form::checkbox('left', 1, $landing_page->left, ['class' => 'bootswitch', "data-on-text"=>"Left", "data-off-text"=>"Right", "data-size"=>"small"]) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <small class="text-danger">{{ $errors->first('left') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} input-file-block">
              {!! Form::label('image', 'Image') !!} <p class="inline info"></p>
              {!! Form::file('image', ['class' => 'input-file', 'id'=>'image']) !!}
              <label for="image" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Project image">
                <i class="icon fa fa-check"></i>
                <span class="js-fileName">Choose a File</span>
              </label>
              <p class="info">Choose a image</p>
              <small class="text-danger">{{ $errors->first('image') }}</small>
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
