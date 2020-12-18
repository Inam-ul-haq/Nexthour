<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title> Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
        rel="stylesheet">
  <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/> <!-- fontawsome css -->
  <!-- Admin (main) Style Sheet -->
  <link rel="stylesheet" href="{{asset('css/admin.css')}}">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
<!-- Main content -->
{{-- {{$invoice}} --}}
@if (isset($invoice) && $invoice != null)
<section class="invoice">
  <!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa-globe"></i> {{$w_title}}
        <small class="pull-right">{{date("d/m/Y", $invoice->data[0]->created)}}</small>
      </h2>
    </div>
    <!-- /.col -->
  </div>
  <!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
      From
      <address>
        <strong>{{$w_title}}</strong><br>
        {{$invoice_add}}
        Email: {{$w_email}}
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      To
      <address>
        <strong>{{auth()->user()->name}}</strong><br>
        Email: {{auth()->user()->email}}
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      <b>Invoice #{{$invoice->data[0]->id}}</b><br>
      <br>
      <b>Order ID:</b> {{$invoice->data[0]->number}}<br>
      <b>Payment Due:{{$invoice->data[0]->paid == true ? 'N/A' : 'DUE'}}</b><br>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <!-- Table row -->
  <div class="row">
    <div class="col-xs-12 table-responsive">
      <table class="table table-striped">
        <thead>
        <tr>
          <th>#</th>
          <th>User Name</th>
          <th>Package Name</th>
          <th>Method</th>
          <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>1</td>
          <td>{{auth()->user()->name}}</td>
          <td>
            @php
              $plan = App\Package::where('plan_id',$invoice->data[0]->lines->data[0]->plan->id)->first();
            @endphp
            {{ucfirst($plan->name)}}</td>
          <td>Stripe</td>
          <td>{{strtoupper($currency_code)}} {{$invoice->data[0]->lines->data[0]->plan->amount/100}}</td>
        </tr>
        </tbody>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <!-- accepted payments column -->
    <div class="col-xs-6">
      <p class="lead">Payment Methods:</p>
      <img src="{{asset('images/credit/visa.png')}}" alt="Visa">
      <img src="{{asset('images/credit/mastercard.png')}}" alt="Mastercard">
      <img src="{{asset('images/credit/american-express.png')}}" alt="American Express">
      <img src="{{asset('images/credit/paypal2.png')}}" alt="Paypal">

      <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
        Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles, weebly ning heekya handango imeem plugg
        dopplr jibjab, movity jajah plickers sifteo edmodo ifttt zimbra.
      </p>
    </div>
    <!-- /.col -->
    <div class="col-xs-6">
      <div class="table-responsive">
        <h2 style="margin-top: 100px"> Total Amount: {{strtoupper($currency_code)}} {{$invoice->data[0]->lines->data[0]->plan->amount/100}}</h2>
      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
@elseif (isset($paypal_sub) && $paypal_sub != null)
<section class="invoice">
  <!-- title row -->
  <div class="row">
    <div class="col-xs-12">
      <h2 class="page-header">
        <i class="fa fa-globe"></i> {{$company_name}}
        <small class="pull-right">{{$paypal_sub->created_at->toDateString()}}</small>
      </h2>
    </div>
    <!-- /.col -->
  </div>
  <!-- info row -->
  <div class="row invoice-info">
    <div class="col-sm-4 invoice-col">
      From
      <address>
        <strong>{{$company_name}}</strong><br>
        {{$invoice_add}}
        Email: {{$w_email}}
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      To
      <address>
        <strong>{{auth()->user()->name}}</strong><br>
        Email: {{auth()->user()->email}}
      </address>
    </div>
    <!-- /.col -->
    <div class="col-sm-4 invoice-col">
      <b>Invoice #{{$paypal_sub->id}}</b><br>
      <br>
      <b>Order ID:</b> {{$paypal_sub->payment_id}}<br>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <!-- Table row -->
  <div class="row">
    <div class="col-xs-12 table-responsive">
      <table class="table table-striped">
        <thead>
        <tr>
          <th>#</th>
          <th>User Name</th>
          <th>Package Name</th>
          <th>Method</th>
          <th>Subtotal</th>
        </tr>
        </thead>
        <tbody>
        <tr>
          <td>1</td>
          <td>{{auth()->user()->name}}</td>
          <td>{{$paypal_sub->plan->name}}</td>
          <td>{{$paypal_sub->method}}</td>
          <td>{{strtoupper($currency_code)}} {{$paypal_sub->price}}</td>
        </tr>
        </tbody>
      </table>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->

  <div class="row">
    <!-- accepted payments column -->
    <div class="col-xs-6">
      <p class="lead">Payment Methods:</p>
      <img src="{{asset('images/credit/visa.png')}}" alt="Visa">
      <img src="{{asset('images/credit/mastercard.png')}}" alt="Mastercard">
      <img src="{{asset('images/credit/american-express.png')}}" alt="American Express">
      <img src="{{asset('images/credit/paypal2.png')}}" alt="Paypal">


    </div>
    <!-- /.col -->
    <div class="col-xs-6">
      <div class="table-responsive">
        <h2 style="margin-top: 100px"> Total Amount: {{strtoupper($currency_code)}} {{$paypal_sub->price}}</h2>
      </div>
    </div>
    <!-- /.col -->
  </div>
  <!-- /.row -->
</section>
@endif

<!-- /.content -->
<div class="clearfix"></div>
<!-- ./wrapper -->
<script src="{{asset('js/jquery.min.js')}}" type="text/javascript"></script>
<script src="{{asset('js/admin.js')}}" type="text/javascript"></script>
</body>
</html>
