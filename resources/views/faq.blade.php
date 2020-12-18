@extends('layouts.theme')
@section('title',"FAQ's")
@section('main-wrapper')
  <!-- main wrapper -->
  <section id="main-wrapper" class="main-wrapper home-page user-account-section">
    <div class="container-fluid faq-main-block">
      <h4 class="heading">{{$home_translations->where('key', 'frequently asked questions')->first->value['value']}}</h4>
      <ul class="bradcump">
        <li><a href="{{url('account')}}">Dashboard</a></li>
        <li>/</li>
        <li>FAQ's</li>
      </ul>
      <div class="panel-setting-main-block">
        @if(isset($faqs))
          @foreach($faqs as $key => $faq)
            <div class="panel-setting">
              <div class="row">
                <div class="col-md-1 col-sm-2 col-xs-3">
                  <i class="fa fa-question-circle-o"></i>
                </div>
                <div class="col-md-9 col-xs-9">
                  <h4 class="panel-setting-heading">{{$faq->question}}</h4>
                  <p class="info">{{$faq->answer}}</p>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </section>
  <!-- end main wrapper -->
@endsection