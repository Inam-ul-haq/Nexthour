@extends('layouts.admin')
@section('title','Edit Home Translation')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text">Home Translation Keys</h4>
    <div class="admin-form-block z-depth-1">
      <div class="row">
        {!! Form::model($translations, ['method' => 'POST', 'action' => 'HomeTranslationController@update']) !!}
            @if (isset($translations) && count($translations) > 0)
              @php
                $collectionHalves = array_chunk($translations->all(), ceil($translations->count() / 2));
              @endphp
              @foreach ($collectionHalves[0] as $element)  
                <div class="col-md-4">
                  {!! Form::hidden('id[]', $element->id) !!}
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      {!! Form::label('name', ucfirst($element->key)) !!}
                      {{-- <p class="inline info"> - Please enter genre name</p> --}}
                      {!! Form::text('name[]', $element->value, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('name') }}</small>
                  </div>
                </div>
              @endforeach
              @foreach ($collectionHalves[1] as $element)  
                <div class="col-md-4">
                  {!! Form::hidden('id[]', $element->id) !!}
                  <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                      {!! Form::label('name', ucfirst($element->key)) !!}
                      {{-- <p class="inline info"> - Please enter genre name</p> --}}
                      {!! Form::text('name[]', $element->value, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('name') }}</small>
                  </div>
                </div>
              @endforeach
            @endif
          <div class="">
            <button type="submit" class="btn btn-block btn-success">Update</button>
          </div>
          <div class="clear-both"></div>
        {!! Form::close() !!}
      </div>
    </div>
  </div>
@endsection
