@extends('layouts.theme')
@section('title',$footer_translations->where('key', 'terms and condition') ? $footer_translations->where('key', 'terms and condition')->first->value['value'] : '')
@section('main-wrapper')
  <!-- main wrapper -->
  <section id="main-wrapper" class="main-wrapper home-page user-account-section">
    <div class="container-fluid faq-main-block">
      <h4 class="heading">{{$footer_translations->where('key', 'terms and condition') ? $footer_translations->where('key', 'terms and condition')->first->value['value'] : ''}}</h4>
      <ul class="bradcump">
        <li><a href="{{url('account')}}">Dashboard</a></li>
        <li>/</li>
        <li>Terms and Condition</li>
      </ul>
      <div class="panel-setting-main-block">
        <div class="panel-setting">
          <div class="row">
            <div class="col-md-9">              
              @if(isset($term_con))
                <div class="info">{!! $term_con !!}</div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- end main wrapper -->
@endsection