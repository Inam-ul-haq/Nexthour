@extends('layouts.admin')
@section('title','Sign in/Sign Up Customization')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text">Sign In / Sign Up Customization</h4>
    <div class="row">
      <div class="col-md-12">
        <div class="admin-form-block z-depth-1">
          {!! Form::model($auth_customize, ['method' => 'POST', 'action' => 'AuthCustomizeController@store', 'files' => true]) !!}
            <div class="form-group{{ $errors->has('detail') ? ' has-error' : '' }}">
              {!! Form::label('detail', 'Heading Text') !!}
              {!! Form::textarea('detail', null, ['id' => 'editor1', 'class' => 'form-control']) !!}
              <small class="text-danger">{{ $errors->first('detail') }}</small>
            </div>
            <div class="row">
              <div class="col-md-6 form-group">
                @if ($auth_customize->image != null)
                  <img src="{{ asset('images/login/'.$auth_customize->image) }}" class="img-responsive">
                @else
                  <div class="image-block"></div>                    
                @endif
              </div>
            </div>
            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }} input-file-block">
              {!! Form::label('image', 'Select a image') !!}  <p class="inline info"></p>
              {!! Form::file('image', ['class' => 'input-file', 'id'=>'image']) !!}
              <label for="image" class="btn btn-danger js-labelFile" data-toggle="tooltip" data-original-title="Project image">
                <i class="icon fa fa-check"></i>
                <span class="js-fileName">Choose a File</span>
              </label>
              <p class="info">Choose a image</p>
              <small class="text-danger">{{ $errors->first('image') }}</small>
            </div>
            <div class="">
              <button type="submit" class="btn btn-success btn-block">Save</button>
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
    $(function () {
      CKEDITOR.replace('editor1');
    });
  </script>
@endsection