@extends('layouts.admin')
@section('title','Refund Policy')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text">Refund Policy Text</h4>
    @if ($config)
      <div class="admin-form-block z-depth-1">
        {!! Form::model($config, ['method' => 'PATCH', 'route' => 'refund_pol']) !!}
        <div class="form-group{{ $errors->has('refund_pol') ? ' has-error' : '' }}">
          {!! Form::label('refund_pol', 'Refund Policy Text') !!}
          {!! Form::textarea('refund_pol', null, ['id' => 'editor1', 'class' => 'form-control']) !!}
          <small class="text-danger">{{ $errors->first('refund_pol') }}</small>
        </div>
        <div class="btn-group pull-right">
          <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> Save</button>
        </div>
        <div class="clear-both"></div>
        {!! Form::close() !!}
      </div>
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