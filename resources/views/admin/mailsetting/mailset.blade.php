@extends('layouts.admin')
@section('title', 'Mail Setting')

@section('content')
  <div class="admin-form-main-block mrg-t-40">
  <div class="tabsetting">
  <a href="{{url('admin/settings')}}" style="color: #7f8c8d;" ><button class="tablinks ">Genral Setting</button></a>
  <a href="{{url('admin/seo')}}" style="color: #7f8c8d;" ><button class="tablinks">SEO Setting</button></a>
  <a href="{{url('admin/api-settings')}}" style="color: #7f8c8d;"><button class="tablinks">API Setting</button></a>
  <a href="#" style="color: #7f8c8d;"><button class="tablinks active">Mail Setting</button></a>
  <a href="{{url('/admin/page-settings')}}" style="color: #7f8c8d;"><button class="tablinks">Page Setting</button></a>
</div>
      {!! Form::model($env_files, ['method' => 'POST', 'action' => 'ConfigController@changeMailEnvKeys']) !!}
        <div class="row admin-form-block z-depth-1">
          <div class="api-main-block">
            <h5 class="form-block-heading">Mail Settings</h5>

            <div class="payment-gateway-block">

              <div class="form-group{{ $errors->has('MAIL FROM NAME') ? ' has-error' : '' }}">
                  {!! Form::label('MAIL_FROM_NAME', 'Sender Name') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter sender name"></i>
                  <input class="form-control" type="text" name="MAIL_FROM_NAME" value="{{ $env_files['MAIL_FROM_NAME'] }}">
                  <small class="text-danger">{{ $errors->first('MAIL_FROM_NAME') }}</small>
              </div>

              <div class="form-group{{ $errors->has('MAIL HOST') ? ' has-error' : '' }}">
                  {!! Form::label('MAIL_DRIVER', 'MAIL DRIVER') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter mail driver (ex. : sendmail, smtp, mail)"></i>
                  {!! Form::text('MAIL_DRIVER', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('MAIL_DRIVER') }}</small>
              </div>
              <div class="form-group{{ $errors->has('MAIL_FROM_ADDRESS') ? ' has-error' : '' }}">
                  {!! Form::label('MAIL_DRIVER', 'MAIL FROM ADDRESS') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter mail from address (ex. : yourmail@gmail.com)"></i>
                  {!! Form::email('MAIL_FROM_ADDRESS', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('MAIL_FROM_ADDRESS') }}</small>
              </div>
              <div class="form-group{{ $errors->has('MAIL HOST') ? ' has-error' : '' }}">
                  {!! Form::label('MAIL_HOST', 'MAIL HOST') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter mail host (ex. : smtp.gmail.com)"></i>
                  {!! Form::text('MAIL_HOST', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('MAIL_HOST') }}</small>
              </div>

               <div class="form-group{{ $errors->has('MAIL_PORT') ? ' has-error' : '' }}">
                  {!! Form::label('MAIL_PORT', 'MAIL PORT') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter mail port (ex. : 587, 487)"></i>
                  {!! Form::text('MAIL_PORT', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('MAIL_PORT') }}</small>
              </div>

               <div class="form-group{{ $errors->has('MAIL_USERNAME') ? ' has-error' : '' }}">
                  {!! Form::label('MAIL_USERNAME', 'MAIL_USERNAME') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter mail username (ex. : yourmail@gmail.com)"></i>
                  {!! Form::text('MAIL_USERNAME', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('MAIL_USERNAME') }}</small>
              </div>

              <div class="search form-group{{ $errors->has('MAIL_PASSWORD') ? ' has-error' : '' }}">
                  {!! Form::label('MAIL_PASSWORD', 'MAIL PASSWORD') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter mail password"></i>
                  <input type="password" name="MAIL_PASSWORD" id="mailpass" value="{{$env_files['MAIL_PASSWORD']}}" class="form-control">
                  <span toggle="#mailpass" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                  <small class="text-danger">{{ $errors->first('MAIL_PASSWORD') }}</small>
              </div>

               <div class="form-group{{ $errors->has('MAIL_ENCRYPTION') ? ' has-error' : '' }}">
                  {!! Form::label('MAIL_ENCRYPTION', 'MAIL_ENCRYPTION') !!}
                  <i class="fa fa-info-circle" data-toggle="tooltip" data-placement="top" title="Please enter mail encryption (ex. : SSL, TLS)"></i>
                  {!! Form::text('MAIL_ENCRYPTION', null, ['class' => 'form-control']) !!}
                  <small class="text-danger">{{ $errors->first('MAIL_ENCRYPTION') }}</small>
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
@endsection
