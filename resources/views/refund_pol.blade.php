@extends('layouts.theme')
@section('title',$footer_translations->where('key', 'refund policy') ? $footer_translations->where('key', 'refund policy')->first->value['value'] : '')
@section('main-wrapper')
  <!-- main wrapper -->
  <section id="main-wrapper" class="main-wrapper home-page user-account-section">
    <div class="container-fluid faq-main-block">
      <h4 class="heading">{{$footer_translations->where('key', 'refund policy') ? $footer_translations->where('key', 'refund policy')->first->value['value'] : ''}}</h4>
      <ul class="bradcump">
        <li><a href="{{url('account')}}">Dashboard</a></li>
        <li>/</li>
        <li>Refund Policy</li>
      </ul>
      <div class="panel-setting-main-block">
        <div class="panel-setting">
          <div class="row">
            <div class="col-md-9">
              @if(isset($refund_pol))
                <div class="info">{!! $refund_pol !!}</div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end main wrapper -->
@endsection