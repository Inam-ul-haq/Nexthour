@extends('layouts.admin')
@section('title','Create FAQ')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/faqs')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Create Faq</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">
          {!! Form::open(['method' => 'POST', 'action' => 'FaqController@store']) !!}
            <div class="form-group{{ $errors->has('question') ? ' has-error' : '' }}">
                {!! Form::label('question', 'Faq Question') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your faq question"></i>
                {!! Form::text('question', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Please enter your faq question']) !!}
                <small class="text-danger">{{ $errors->first('question') }}</small>
            </div>
            <div class="form-group{{ $errors->has('answer') ? ' has-error' : '' }}">
                {!! Form::label('answer', 'Faq Answer') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your faq answer"></i>
                {!! Form::textarea('answer', null, ['class' => 'form-control materialize-textarea', 'rows' => '5', 'placeholder' => 'Please enter your faq answer']) !!}
                <small class="text-danger">{{ $errors->first('answer') }}</small>
            </div>
            <div class="btn-group pull-right">
              <button type="reset" class="btn btn-info"><i class="material-icons left">toys</i> Reset</button>
              <button type="submit" class="btn btn-success"><i class="material-icons left">add_to_photos</i> Create</button>
            </div>
            <div class="clear-both"></div>
          {!! Form::close() !!}
        </div>  
      </div>
    </div>
  </div>
@endsection
