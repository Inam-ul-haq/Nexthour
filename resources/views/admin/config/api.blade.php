@extends('layouts.admin')
@section('title', 'API Settings')

@section('content')
  <div class="admin-form-main-block mrg-t-40">
 <div class="tabsetting">
  <a href="{{url('admin/settings')}}" style="color: #7f8c8d;" ><button class="tablinks ">Genral Setting</button></a>
  <a href="{{url('admin/seo')}}" style="color: #7f8c8d;" ><button class="tablinks">SEO Setting</button></a>
  <a href="#" style="color: #7f8c8d;"><button class="tablinks active">API Setting</button></a>
  <a href="{{route('mail.getset')}}" style="color: #7f8c8d;"><button class="tablinks">Mail Setting</button></a>
  <a href="{{url('/admin/page-settings')}}" style="color: #7f8c8d;"><button class="tablinks">Page Setting</button></a>
</div>
  
      {!! Form::model($env_files, ['method' => 'POST', 'action' => 'ConfigController@changeEnvKeys']) !!}

      <div class="row admin-form-block z-depth-1">
       
            <h6 class="form-block-heading apipadding">YouTube Api</h6>
                    <br>
              
                <div class="form-group{{ $errors->has('YOUTUBE_API_KEY') ? ' has-error' : '' }}">
                    {!! Form::label('YOUTUBE_API_KEY', 'YouTube API KEY') !!}
                      <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter youtube api key"></i>
                    {!! Form::text('YOUTUBE_API_KEY',null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('YOUTUBE_API_KEY') }}</small>
                  </div>
             
          </div>
          <div class="row admin-form-block z-depth-1">
        
            <h6 class="form-block-heading apipadding">Vimeo Api</h6>
          
               <br>
                <div class="form-group{{ $errors->has('VIMEO_ACCESS') ? ' has-error' : '' }}">
                    {!! Form::label('VIMEO_ACCESS', 'Vimeo API KEY') !!}
                      <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter Vimeo api key"></i>
                    {!! Form::text('VIMEO_ACCESS',null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('VIMEO_ACCESS') }}</small>
                  </div>
                 
           
          
          </div>
        <div class="row admin-form-block z-depth-1">
          <div class="api-main-block">
            <h5 class="form-block-heading apipadding">Payment Gateways</h5>
            <div class="payment-gateway-block">
              <div class="form-group">
                <div class="row">
                  <div class="col-xs-6">
                    {!! Form::label('stripe_payment', 'STRIPE PAYMENT') !!}
                  </div>
                  <div class="col-xs-5 text-right">
                    <label class="switch">
                      {!! Form::checkbox('stripe_payment', 1, $config->stripe_payment, ['class' => 'checkbox-switch']) !!}
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
              </div>
              <div style="{{ $config->stripe_payment==1 ? "" : "display: none" }}" id="stripe_box" class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('STRIPE_KEY') ? ' has-error' : '' }}">
                      {!! Form::label('STRIPE_KEY', 'STRIPE KEY') !!}
                      <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter stripe key"></i>
                      {!! Form::text('STRIPE_KEY', null, ['class' => 'form-control']) !!}

                      <small class="text-danger">{{ $errors->first('STRIPE_KEY') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="search form-group{{ $errors->has('STRIPE_SECRET') ? ' has-error' : '' }}">
                      
                          {!! Form::label('STRIPE_SECRET', 'STRIPE SECRET KEY') !!}
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter stripe secret key"></i>
                          {{-- {!! Form::password('STRIPE_SECRET', null, ['id' => 'password-field', 'class' => 'form-control']) !!} --}}

                          <input type="password" id="password-field" name="STRIPE_SECRET" value="{{ $env_files['STRIPE_SECRET'] }}">
                        

                          <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                        

                     

                      <small class="text-danger">{{ $errors->first('STRIPE_SECRET') }}</small>
                  </div>
                </div>
              </div>
            </div>
            
             <div class="payment-gateway-block">
              <div class="form-group">
                <div class="row">
                  <div class="col-xs-6">
                    {!! Form::label('razorpay_payment', 'Razorpay PAYMENT') !!}
                  </div>
                  <div class="col-xs-5 text-right">
                    <label class="switch">
                      {!! Form::checkbox('razorpay_payment', 1, $config->razorpay_payment, ['class' => 'checkbox-switch']) !!}
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
              </div>
              <div style="{{ $config->razorpay_payment==1 ? "" : "display: none" }}" id="razorpay_box" class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('RAZOR_PAY_KEY') ? ' has-error' : '' }}">
                      {!! Form::label('RAZOR_PAY_KEY', 'RAZOR PAY KEY') !!}
                      <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter Razorpay key"></i>
                      {!! Form::text('RAZOR_PAY_KEY', null , ['class' => 'form-control']) !!}

                      <small class="text-danger">{{ $errors->first('RAZOR_PAY_KEY') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="search form-group{{ $errors->has('RAZOR_PAY_SECRET') ? ' has-error' : '' }}">
                      
                          {!! Form::label('RAZOR_PAY_SECRET', 'RAZOR PAY SECRET KEY') !!}
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter Razorpay secret key"></i>
                          

                          <input type="password" id="razorpay_secret" name="RAZOR_PAY_SECRET" value="{{ $env_files['RAZOR_PAY_SECRET'] }}" >
                        

                          <span toggle="#razorpay_secret" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                        

                     

                      <small class="text-danger">{{ $errors->first('RAZOR_PAY_SECRET') }}</small>
                  </div>
                </div>
              </div>
            </div>


            <div  class="payment-gateway-block">
              <div class="form-group">
                <div class="row">
                  <div class="col-xs-6">
                    {!! Form::label('paypal_payment', 'PAYPAL PAYMENT') !!}
                  </div>
                  <div class="col-xs-5 text-right">
                    <label class="switch">
                      {!! Form::checkbox('paypal_payment', 1, $config->paypal_payment, ['class' => 'checkbox-switch']) !!}
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
              </div>
            <div id="paypal_box" style="{{ $config->paypal_payment==1 ? "" : "display: none" }}" id="paypal_box">

              <div class="search form-group{{ $errors->has('PAYPAL_CLIENT_ID') ? ' has-error' : '' }}">
                
                 
                    {!! Form::label('PAYPAL_CLIENT_ID', 'PAYPAL CLIENT ID') !!}
                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter paypal client id"></i>
                    <input type="password" name="PAYPAL_CLIENT_ID" id="pclientid" value="{{ $env_files['PAYPAL_CLIENT_ID'] }}" class="form-control">
                
                  
                    <span toggle="#pclientid" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                  
                

                  <small class="text-danger">{{ $errors->first('PAYPAL_CLIENT_ID') }}</small>
              



              <div class="search form-group{{ $errors->has('PAYPAL_SECRET_ID') ? ' has-error' : '' }}">
                
                  
                    {!! Form::label('PAYPAL_SECRET_ID', 'PAYPAL SECRET ID') !!}
                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter paypal secret id"></i>
                    <input type="password" name="PAYPAL_SECRET_ID" value="{{ $env_files['PAYPAL_SECRET_ID'] }}" id="paypal_secret" class="form-control">
                 
                 
                      <span toggle="#paypal_secret" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                    
               

                  <small class="text-danger">{{ $errors->first('PAYPAL_SECRET_ID') }}</small>
              </div>
              <div class="search form-group{{ $errors->has('PAYPAL_MODE') ? ' has-error' : '' }}">
                  {!! Form::label('PAYPAL_MODE', 'PAYPAL MODE') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter paypal mode (sandbox, live)"></i>
                  {!! Form::text('PAYPAL_MODE', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('PAYPAL_MODE') }}</small>
              </div>

            </div>
            </div>
            
          </div>

          <div class="payment-gateway-block">
              <div class="form-group">
                <div class="row">
                  <div class="col-xs-6">
                    {!! Form::label('payu_payment', 'PAYU PAYMENT (Indian payment)') !!}
                  </div>
                  <div class="col-xs-5 text-right">
                    <label class="switch">
                      {!! Form::checkbox('payu_payment', 1, $config->payu_payment, ['class' => 'checkbox-switch']) !!}
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
              </div>
              <div id="payu_box" style="{{ $config->payu_payment==1 ? "" : "display: none" }}" class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('PAYU_METHOD') ? ' has-error' : '' }}">
                      {!! Form::label('PAYU_METHOD', 'PAYU METHOD') !!}
                      <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter payu method test (development) or secure (live)"></i>
                      {!! Form::text('PAYU_METHOD', null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('PAYU_METHOD') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('PAYU_DEFAULT') ? ' has-error' : '' }}">
                      {!! Form::label('PAYU_DEFAULT', 'PAYU DEFAULT OPTION') !!}
                      <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter payu default option (payubiz or )"></i>
                      {!! Form::text('PAYU_DEFAULT', null, ['class' => 'form-control']) !!}
                      <small class="text-danger">{{ $errors->first('PAYU_DEFAULT') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="search form-group{{ $errors->has('PAYU_MERCHANT_KEY') ? ' has-error' : '' }}">
                   
                        {!! Form::label('PAYU_MERCHANT_KEY', 'PAYU MERCHANT KEY') !!}
                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter payu merchant key"></i>
                        <input id="payum" type="password" class="form-control" name="PAYU_MERCHANT_KEY" value="{{ $env_files['PAYU_MERCHANT_KEY'] }}">
                     

                     
                        <span toggle="#payum" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                     

                    

                      <small class="text-danger">{{ $errors->first('PAYU_MERCHANT_KEY') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="search form-group{{ $errors->has('PAYU_MERCHANT_SALT') ? ' has-error' : '' }}">
                    
                      
                        {!! Form::label('PAYU_MERCHANT_SALT', 'PAYU MERCHANT SALT') !!}
                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter payu merchant salt"></i>
                        <input type="password" value="{{ $env_files['PAYU_MERCHANT_SALT'] }}" name="PAYU_MERCHANT_SALT" id="payusalt" class="form-control">
                     
                        <span toggle="#payusalt" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                     

                      <small class="text-danger">{{ $errors->first('PAYU_MERCHANT_SALT') }}</small>
                  
                </div>
              </div>
            </div>

          </div>
            {{-- braintree payment --}}
              <div class="payment-gateway-block">
              <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6">
                      {!! Form::label('braintree', 'BRAINTREE PAYMENT') !!}
                    </div>
                    <div class="col-xs-5 text-right">
                      <label class="switch">
                        {!! Form::checkbox('braintree', 1, $config->braintree, ['class' => 'checkbox-switch', 'id' => 'braintree_check']) !!}
                        <span class="slider round"></span>
                      </label>
                    </div>
                  </div>
                </div>

                <div id="braintree_box" style="{{ $config->braintree == 1 ? "" : "display:none" }}">
                    <div class="form-group">
                        <label>BTREE ENVIRONMENT: </label>
                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant ID"></i>
                        <input type="text" name="BTREE_ENVIRONMENT" value="{{ $env_files['BTREE_ENVIRONMENT'] }}" class="form-control">
                      </div>
      
                      <div class="form-group">
                          <label>BTREE MERCHANT ID: </label>
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant key"></i>
                          <input type="text" name="BTREE_MERCHANT_ID" value="{{ $env_files['BTREE_MERCHANT_ID'] }}" class="form-control">
                      </div>
                        <div class="form-group">
                          <label>BTREE MERCHANT ACCOUNT ID: </label>
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant key"></i>
                          <input type="text" name="BTREE_MERCHANT_ACCOUNT_ID" value="{{ $env_files['BTREE_MERCHANT_ACCOUNT_ID'] }}" class="form-control">
                      </div>

           

                      <div class="form-group">
                          <label>BTREE PUBLIC KEY: </label>
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant key"></i>
                          <input type="text" name="BTREE_PUBLIC_KEY" value="{{ $env_files['BTREE_PUBLIC_KEY'] }}" class="form-control">
                      </div>

                      <div class="form-group">
                          <label>BTREE PRIVATE KEY: </label>
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant key"></i>
                          <input type="text" name="BTREE_PRIVATE_KEY" value="{{ $env_files['BTREE_PRIVATE_KEY'] }}" class="form-control">
                      </div>

           
                </div>
               

               
          </div>

          {{-- coinpay payment --}}
          <div class="payment-gateway-block">
              <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6">
                      {!! Form::label('coinpay', 'COIN PAYMENT') !!}
                      <label><a href="https://www.coinpayments.net/">  (Coin Payment Site)</a></label>
                    </div>
                    <div class="col-xs-5 text-right">
                      <label class="switch">
                        {!! Form::checkbox('coinpay', 1, $config->coinpay, ['class' => 'checkbox-switch', 'id' => 'coinpay_check']) !!}
                        <span class="slider round"></span>
                      </label>
                    </div>
                  </div>
                </div>

                <div id="coinpay_box" style="{{ $config->coinpay == 1 ? "" : "display:none" }}">
                    <div class="form-group">
                        <label>COINPAYMENTS MERCHANT ID: </label>
                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant ID"></i>
                        <input type="text" name="COINPAYMENTS_MERCHANT_ID" value="{{ $env_files['COINPAYMENTS_MERCHANT_ID'] }}" class="form-control">
                      </div>
      
                    
           

                      <div class="form-group">
                          <label>COINPAYMENTS PUBLIC KEY: </label>
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant key"></i>
                          <input type="text" name="COINPAYMENTS_PUBLIC_KEY" value="{{ $env_files['COINPAYMENTS_PUBLIC_KEY'] }}" class="form-control">
                      </div>

                      <div class="form-group">
                          <label>COINPAYMENTS PRIVATE KEY: </label>
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant key"></i>
                          <input type="text" name="COINPAYMENTS_PRIVATE_KEY" value="{{ $env_files['COINPAYMENTS_PRIVATE_KEY'] }}" class="form-control">
                      </div>

           
                </div>
               

               
          </div>
              <div class="payment-gateway-block">
              <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6">
                      {!! Form::label('paystack', 'PAYSTACK PAYMENT') !!}
                      <label> (Only Works on NGN Currency)</label>
                    </div>
                    <div class="col-xs-5 text-right">
                      <label class="switch">
                        {!! Form::checkbox('paystack', 1, $config->paystack, ['class' => 'checkbox-switch', 'id' => 'paystack_check']) !!}
                        <span class="slider round"></span>
                      </label>
                    </div>
                  </div>
                </div>

                <div id="paystack_box" style="{{ $config->paystack == 1 ? "" : "display:none" }}">
                    <div class="form-group">
                        <label>PAYSTACK PUBLIC KEY: </label>
                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant ID"></i>
                        <input type="text" name="PAYSTACK_PUBLIC_KEY" value="{{ $env_files['PAYSTACK_PUBLIC_KEY'] }}" class="form-control">
                      </div>
      
                      <div class="form-group">
                          <label>PAYSTACK SECRET KEY: </label>
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant key"></i>
                          <input type="text" name="PAYSTACK_SECRET_KEY" value="{{ $env_files['PAYSTACK_SECRET_KEY'] }}" class="form-control">
                      </div>
                      <div class="form-group">
                          <label>MERCHANT EMAIL: </label>
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant key"></i>
                          <input type="text" name="MERCHANT_EMAIL" value="{{ $env_files['MERCHANT_EMAIL'] }}" class="form-control">
                      </div>
                      <div class="form-group">
                          <label>PAYSTACK PAYMENT URL: </label>
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant key"></i>
                          <input type="text" name="PAYSTACK_PAYMENT_URL" value="{{ $env_files['PAYSTACK_PAYMENT_URL'] }}" class="form-control">
                      </div>
           
                </div>
               

               
          </div>

          <div class="payment-gateway-block">
              <div class="form-group">
                  <div class="row">
                    <div class="col-xs-6">
                      {!! Form::label('paypal_payment', 'PAYTM PAYMENT (Indian Payement Gateway)') !!}
                    </div>
                    <div class="col-xs-5 text-right">
                      <label class="switch">
                        {!! Form::checkbox('paytm_payment', 1, $config->paytm_payment, ['class' => 'checkbox-switch', 'id' => 'paytm_check']) !!}
                        <span class="slider round"></span>
                      </label>
                    </div>
                  </div>
                </div>

                <div id="paytm_box" style="{{ $config->paytm_payment == 1 ? "" : "display:none" }}">
                    <div class="form-group">
                        <label>Merchant ID: </label>
                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant ID"></i>
                        <input type="text" name="PAYTM_MID" value="{{ $env_files['PAYTM_MID'] }}" class="form-control">
                      </div>
      
                      <div class="form-group">
                          <label>Merchant KEY: </label>
                          <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter merchant key"></i>
                          <input type="text" name="PAYTM_MERCHANT_KEY" value="{{ $env_files['PAYTM_MERCHANT_KEY'] }}" class="form-control">
                      </div>
            <div class="bootstrap-checkbox form-group{{ $errors->has('paytm_test') ? ' has-error' : '' }}">
              <div class="row">
                <div class="col-md-7">
                  <h5 class="bootstrap-switch-label">Paytm Testing/Live</h5>
                </div>
                <div class="col-md-5 pad-0">
                  <div class="make-switch">
                    {!! Form::checkbox('paytm_test', 1, ($config->paytm_test == 1 ? 1 : 0), ['class' => 'bootswitch', "data-on-text"=>"Live", "data-off-text"=>"Test", "data-size"=>"small"]) !!}
                  </div>
                </div>
              </div>
              <div class="col-md-12">
                <small class="text-danger">{{ $errors->first('paytm_test') }}</small>
              </div>
            </div>
                </div>
               

               
          </div>
              <div class="payment-gateway-block">
              <div class="form-group">
                <div class="row">
                  <div class="col-xs-6">
                    {!! Form::label('bankdetails', 'BANK DETAILS') !!}
                  </div>
                  <div class="col-xs-5 text-right">
                    <label class="switch">
                      {!! Form::checkbox('bankdetails', 1, $config->bankdetails, ['class' => 'checkbox-switch']) !!}
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
              </div>
              <div id="bank_box" style="{{ $config->bankdetails==1 ? "" : "display: none" }}" class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('account_no') ? ' has-error' : '' }}">
                      {!! Form::label('account_no', 'Account Number') !!}
                      <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your Bank Account Number"></i>
                      <input id="payum" type="text" class="form-control" value="{{$config->account_no}}" name="account_no">
                     
                      <small class="text-danger">{{ $errors->first('account_no') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('account_name') ? ' has-error' : '' }}">
                      {!! Form::label('account_name', 'Account Name') !!}
                      <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your Account Holder Names"></i>
                      <input id="payum" type="text" class="form-control" value="{{$config->account_name}}" name="account_name">
                     
                      <small class="text-danger">{{ $errors->first('account_name') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="search form-group{{ $errors->has('ifsc_code') ? ' has-error' : '' }}">
                   
                        {!! Form::label('ifsc_code', 'IFSC Code') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter payu merchant key"></i>
                  <input id="payum" type="text" class="form-control" value="{{$config->ifsc_code}}" name="ifsc_code">
                  
                     <small class="text-danger">{{ $errors->first('ifsc_code') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="search form-group{{ $errors->has('bank_name') ? ' has-error' : '' }}">
                    
                        {!! Form::label('bank_name', 'Bank Name') !!}
                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter payu merchant salt"></i>
                        <input type="text" name="bank_name" value="{{$config->bank_name}}" id="payusalt" class="form-control">
                     
                      <small class="text-danger">{{ $errors->first('bank_name') }}</small>
                  
                </div>
              </div>
            </div>

          </div>
           <div class="payment-gateway-block">
              <div class="form-group">
                <div class="row">
                  <div class="col-xs-6">
                    {!! Form::label('aws', 'AWS Storage Details') !!}
                  </div>
                  <div class="col-xs-5 text-right">
                    <label class="switch">
                      {!! Form::checkbox('aws', 1, $config->aws, ['class' => 'checkbox-switch']) !!}
                      <span class="slider round"></span>
                    </label>
                  </div>
                </div>
              </div>
              <div id="aws_box" style="{{ $config->aws==1 ? "" : "display: none" }}" class="row">
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('key') ? ' has-error' : '' }}">
                      {!! Form::label('key', 'AWS AccessKey') !!}
                      <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your Bank Account Number"></i>
                      <input id="payum" type="text" class="form-control" value="{{$env_files['key'] }}" name="key">
                     
                      <small class="text-danger">{{ $errors->first('key') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="form-group{{ $errors->has('secret') ? ' has-error' : '' }}">
                      {!! Form::label('secret', 'AWS Secret Key') !!}
                      <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter your Account Holder Names"></i>
                      <input id="payum" type="text" class="form-control" value="{{$env_files['secret'] }}" name="secret">
                     
                      <small class="text-danger">{{ $errors->first('secret') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="search form-group{{ $errors->has('region') ? ' has-error' : '' }}">
                   
                        {!! Form::label('region', 'AWS Bucket Region') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter payu merchant key"></i>
                  <input id="payum" type="text" class="form-control" value="{{$env_files['region'] }}" name="region">
                  
                     <small class="text-danger">{{ $errors->first('region') }}</small>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="search form-group{{ $errors->has('bucket') ? ' has-error' : '' }}">
                    
                        {!! Form::label('bucket', 'AWS Bucket Name') !!}
                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter payu merchant salt"></i>
                        <input type="text" name="bucket" value="{{$env_files['bucket'] }}" id="payusalt" class="form-control">
                     
                      <small class="text-danger">{{ $errors->first('bucket') }}</small>
                  
                </div>
              </div>
            </div>

          </div>

          <div class="payment-gateway-block">

          <div class="api-main-block">
            <h5 class="form-block-heading apipadding">Other Apis</h5>
            <div class="row">
              <div class="col-md-12">
                <div class="col-md-6">
                  <div class="search form-group{{ $errors->has('MAILCHIMP_APIKEY') ? ' has-error' : '' }}">
                    
                      
                        {!! Form::label('MAILCHIMP_APIKEY', 'MAILCHIMP API KEY') !!}
                        <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter mailchimp api key"></i>
                        <input type="password" id="mailc" value="{{ $env_files['MAILCHIMP_APIKEY'] }}" name="MAILCHIMP_APIKEY" class="form-control">
                     

                     
                        <span toggle="#mailc" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                     
                   

                      <small class="text-danger">{{ $errors->first('MAILCHIMP_APIKEY') }}</small>
                  </div>
                <div class="form-group{{ $errors->has('MAILCHIMP_LIST_ID') ? ' has-error' : '' }}">
                    {!! Form::label('MAILCHIMP_LIST_ID', 'MAILCHIMP LIST ID') !!}
                    <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter mailchimp list id"></i>
                    {!! Form::text('MAILCHIMP_LIST_ID', null, ['class' => 'form-control']) !!}


                    <small class="text-danger">{{ $errors->first('MAILCHIMP_LIST_ID') }}</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="search form-group{{ $errors->has('TMDB_API_KEY') ? ' has-error' : '' }}">
                  
                   
                      {!! Form::label('TMDB_API_KEY', 'TMDB API KEY') !!}
                      <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter tmdb api key"></i>
                      <input type="password" id="tmdb_secret" name="TMDB_API_KEY" value="{{ $env_files['TMDB_API_KEY'] }}" id="tmdb_secret" class="form-control">
                   
                  
                      <span toggle="#tmdb_secret" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                    
                 

                    <small class="text-danger">{{ $errors->first('TMDB_API_KEY') }}</small>
                </div>
               </div>
              </div>
            </div>

          </div>
          <div class="btn-group col-xs-12">
            <button type="submit" class="btn btn-block btn-success">Save Settings</button>
          </div>
          <div class="clear-both"></div>
        </div>
      {!! Form::close() !!}
  </div>
@endsection
@section('custom-script')


  <script>


  $(".toggle-password").click(function() {

  $(this).toggleClass("fa-eye fa-eye-slash");
  var input = $($(this).attr("toggle"));
  if (input.attr("type") == "password") {
    input.attr("type", "text");
  } else {
    input.attr("type", "password");
  }
});

$(".toggle-password2").click(function() {

$(this).toggleClass("fa-eye fa-eye-slash");
var input = $($(this).attr("toggle"));
if (input.attr("type") == "password") {
  input.attr("type", "text");
} else {
  input.attr("type", "password");
}
});

  </script>

  <script>
    $('#stripe_payment').on('change',function(){
      if ($('#stripe_payment').is(':checked')){
           $('#stripe_box').show('fast');
        }else{
          $('#stripe_box').hide('fast');
        }
    });  

    $('#razorpay_payment').on('change',function(){
      if ($('#razorpay_payment').is(':checked')){
           $('#razorpay_box').show('fast');
        }else{
          $('#razorpay_box').hide('fast');
        }
    });    

     $('#paypal_payment').on('change',function(){
      if ($('#paypal_payment').is(':checked')){
           $('#paypal_box').show('fast');
        }else{
          $('#paypal_box').hide('fast');
        }
    });   

      $('#payu_payment').on('change',function(){
      if ($('#payu_payment').is(':checked')){
           $('#payu_box').show('fast');
        }else{
          $('#payu_box').hide('fast');
        }
    }); 

       $('#bankdetails').on('change',function(){
      if ($('#bankdetails').is(':checked')){
           $('#bank_box').show('fast');
        }else{
          $('#bank_box').hide('fast');
        }
    }); 
      

    $('#paytm_check').on('change',function(){
      if ($('#paytm_check').is(':checked')){
           $('#paytm_box').show('fast');
        }else{
          $('#paytm_box').hide('fast');
        }
    });  
     $('#braintree_check').on('change',function(){
      if ($('#braintree_check').is(':checked')){
           $('#braintree_box').show('fast');
        }else{
          $('#braintree_box').hide('fast');
        }
    }); 
     $('#paystack_check').on('change',function(){
      if ($('#paystack_check').is(':checked')){
           $('#paystack_box').show('fast');
        }else{
          $('#paystack_box').hide('fast');
        }
    });  
     $('#coinpay_check').on('change',function(){
      if ($('#coinpay_check').is(':checked')){
           $('#coinpay_box').show('fast');
        }else{
          $('#coinpay_box').hide('fast');
        }
    });    
       $('#aws').on('change',function(){
      if ($('#aws').is(':checked')){
           $('#aws_box').show('fast');
        }else{
          $('#aws_box').hide('fast');
        }
    });    
  </script>




@endsection
