@extends('layouts.admin')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text">SEO</h4>
    @if ($button)
       {!! Form::model($button, ['method' => 'PATCH', 'action' => ['ButtonController@update', $button->id], 'files' => true]) !!}
       <div class="bootstrap-checkbox form-group{{ $errors->has('goto') ? ' has-error' : '' }}">
            <div class="row">
              <div class="col-md-7">
                <h5 class="bootstrap-switch-label">Go to Top</h5>
              </div>
              <div class="col-md-5 pad-0">
                <div class="make-switch">
                  {!! Form::checkbox('goto', 1, ($button->goto == 1 ? true : false), ['class' => 'bootswitch', "data-on-text"=>"1", "data-off-text"=>"0", "data-size"=>"small"]) !!}
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <small class="text-danger">{{ $errors->first('goto') }}</small>
            </div>
        </div>
         <div class="bootstrap-checkbox form-group{{ $errors->has('color') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-md-7">
                  <h5 class="bootstrap-switch-label">Color Schemes</h5>
                </div>
                <div class="col-md-5 pad-0">
                  <div class="make-switch">
                    {!! Form::checkbox('color', 1, ($button->color == 1 ? true : false), ['class' => 'bootswitch', "data-on-text"=>"Light", "data-off-text"=>"Dark", "data-size"=>"small"]) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <small class="text-danger">{{ $errors->first('inspect') }}</small>
              </div>
            </div>  
            <div class="bootstrap-checkbox form-group{{ $errors->has('inspect') ? ' has-error' : '' }}">
            <div class="row">
              <div class="col-md-7">
                <h5 class="bootstrap-switch-label">Inspect</h5>
              </div>
              <div class="col-md-5 pad-0">
                <div class="make-switch">
                  {!! Form::checkbox('inspect', 1, ($button->inspect == 1 ? true : false), ['class' => 'bootswitch', "data-on-text"=>"1", "data-off-text"=>"0", "data-size"=>"small"]) !!}
                </div>
              </div>
            </div>
            <div class="col-md-12">
              <small class="text-danger">{{ $errors->first('inspect') }}</small>
            </div>
        </div>
            <div class="bootstrap-checkbox form-group{{ $errors->has('rightclick') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-md-7">
                  <h5 class="bootstrap-switch-label">Rightclick Disable</h5>
                </div>
                <div class="col-md-5 pad-0">
                  <div class="make-switch">
                    {!! Form::checkbox('rightclick', 1, ($button->rightclick == 1 ? true : false), ['class' => 'bootswitch', "data-on-text"=>"On", "data-off-text"=>"OFF", "data-size"=>"small"]) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <small class="text-danger">{{ $errors->first('rightclick') }}</small>
              </div>
            </div> 
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