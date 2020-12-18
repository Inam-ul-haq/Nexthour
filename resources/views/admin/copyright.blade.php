@extends('layouts.admin')
@section('title','Copyright')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text">Copyright Text</h4>
    @if ($config)
      {!! Form::model($config, ['method' => 'PATCH', 'route' => 'copyright']) !!}
        <div class="form-group{{ $errors->has('copyright') ? ' has-error' : '' }}">
          {!! Form::label('copyright', 'Copyright Text') !!}
          {!! Form::textarea('copyright', null, ['id' => 'editor1', 'class' => 'form-control']) !!}
          <small class="text-danger">{{ $errors->first('copyright') }}</small>
        </div>
        <div class="btn-group pull-right">
          <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> Save</button>
        </div>
        <div class="clear-both"></div>
      {!! Form::close() !!}
    @endif
  </div>
@endsection

@section('custom-script')
  <script>
    $(function () {
      CKEDITOR.replace('editor1');
    });
  </script>
@endsection