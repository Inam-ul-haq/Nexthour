@extends('layouts.admin')
@section('title','Create Coupon')
@section('content')
  <div class="admin-form-main-block mrg-t-40">
    <h4 class="admin-form-text"><a href="{{url('admin/coupons')}}" data-toggle="tooltip" data-original-title="Go back" class="btn-floating"><i class="material-icons">reply</i></a> Create Coupon</h4>
    <div class="row">
      <div class="col-md-6">
        <div class="admin-form-block z-depth-1">
          {!! Form::open(['method' => 'POST', 'action' => 'CouponController@store']) !!}
            <div class="form-group{{ $errors->has('coupon_code') ? ' has-error' : '' }}">
                {!! Form::label('coupon_code', 'Coupon Code (Stripe Coupon Id)') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter unique coupon code"></i>
                {!! Form::text('coupon_code', null, ['class' => 'form-control', 'required' => 'required', 'placeholder' => 'Please enter unique coupon code']) !!}
                <small class="text-danger">{{ $errors->first('coupon_code') }}</small>
            </div>
            <div class="bootstrap-checkbox {{ $errors->has('percent_check') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-md-7">
                  <h6>Amount Off Or Percent (%) Off</h6>
                </div>
                <div class="col-md-5 pad-0">
                  <div class="make-switch">
                    {!! Form::checkbox('percent_check', 1, 1, ['class' => 'bootswitch', "data-on-text"=>"Percent Off", "data-off-text"=>"Amount Off", "data-size"=>"small"]) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <small class="text-danger">{{ $errors->first('percent_check') }}</small>
              </div>
            </div>
            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
  						{!! Form::number('amount', null, ['class' => 'form-control selection-input', 'min' => 0]) !!}
  						<small class="text-danger">{{ $errors->first('amount') }}</small>
            </div>
            {!! Form::hidden('currency', $currency_code) !!}
  					<div class="form-group{{ $errors->has('duration') ? ' has-error' : '' }}">
  							{!! Form::label('duration', 'Duration') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please select coupon duration"></i>
  							{!! Form::select('duration', ['once'=>'Once', 'repeating' => 'Repeating', 'forever' => 'Forever'], null, ['class' => 'form-control select2', 'required' => 'required']) !!}
  							<small class="text-danger">{{ $errors->first('duration') }}</small>
  					</div>
            <div id="coupon_month_duration" class="form-group{{ $errors->has('duration_in_months') ? ' has-error' : '' }}">
                {!! Form::label('duration_in_months', 'Duration In Months') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter coupon duration for months"></i>
                {!! Form::number('duration_in_months', null, ['class' => 'form-control', 'min' => 0]) !!}
                <small class="text-danger">{{ $errors->first('duration_in_months') }}</small>
            </div>
            <div class="form-group{{ $errors->has('max_redemptions') ? ' has-error' : '' }}">
                {!! Form::label('max_redemptions', 'Max Redemptions') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter total coupon use count"></i>
                {!! Form::number('max_redemptions', null, ['class' => 'form-control', 'min' => 0, 'required' => 'required']) !!}
                <small class="text-danger">{{ $errors->first('max_redemptions') }}</small>
            </div>
            <div class="form-group{{ $errors->has('redeem_by') ? ' has-error' : '' }}">
                {!! Form::label('redeem_by', 'Redeem By') !!}
                <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter coupon validate upto"></i>
                {!! Form::date('redeem_by', null, ['class' => 'form-control', 'placeholder' => '']) !!}
                <small class="text-danger">{{ $errors->first('redeem_by') }}</small>
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

@section('custom-script')
  <script>
    // Duration In Repeating (Show Duration In Months)  
    $("input[name='duration_in_months']").parent().hide();
    $("select[name='duration']").on('change',function(){
      if(this.value === 'repeating'){
        $("input[name='duration_in_months']").parent().fadeIn();
      }
      else {
        $("input[name='duration_in_months']").parent().fadeOut();
      }
    });
  </script>
@endsection