@extends('layouts.admin', [
  'page_header' => 'Edit Package'
])
@section('title','Edit Coupan')
@section('content')
  <div class="admin-form">
    {!! Form::model($package, ['method' => 'PATCH', 'action' => ['PackageController@update', $package->id]]) !!}
    <div class="row">
        <div class="col-md-6">
          <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
              {!! Form::label('name', 'Plan Name') !!}
              {!! Form::text('name', null, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('name') }}</small>
          </div>
          <div class="form-group{{ $errors->has('trial_period_days') ? ' has-error' : '' }}">
              {!! Form::label('trial_period_days', 'Enter Your Plan Trail Period Days') !!}
              {!! Form::number('trial_period_days', null, ['class' => 'form-control', 'required' => 'required']) !!}
              <small class="text-danger">{{ $errors->first('trial_period_days') }}</small>
          </div>
          <div class="form-group{{ $errors->has('screen') ? ' has-error' : '' }}">
              {!! Form::label('screen', 'Screen') !!}
              {!! Form::select('screen', array('' => '','1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5', '6' => '6', '7' => '7', '8' => '8'), null, ['class' => 'form-control', 'placeholder' => '']) !!}
              <small class="text-danger">{{ $errors->first('screen') }}</small>
          </div>
          <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
              {!! Form::label('status', 'Status') !!}
              {!! Form::select('status', array('0' => 'Inactive', '1' => 'Active'), null, ['class' => 'form-control', 'placeholde' => '']) !!}
              <small class="text-danger">{{ $errors->first('status') }}</small>
          </div>
          <div class="btn-group pull-right">
              {!! Form::submit("Update", ['class' => 'btn btn-success']) !!}
          </div>
        </div>
      </div>
    {!! Form::close() !!}
  </div>
@endsection
