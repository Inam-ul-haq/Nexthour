@extends('layouts.admin')
@section('title','Reports')
@section('content')
  <div class="content-main-block mrg-t-40">
    <h4 class="admin-form-text">All Reports</h4>
    <div class="content-block box-body">
      <table id="full_detail_table" class="table table-hover">
        <thead>
        <tr class="table-heading-row">
          <th>#</th>
          <th>Date</th>
          <th>Subscribed Package</th>
          <th>Paid Amount</th>
          <th>Method</th>
          <th>User</th>
        </tr>
        </thead>
        <tbody>
          @if (isset($all_reports) && count($all_reports->data) > 0)
            @php
              $sell = null;
            @endphp
            @foreach ($all_reports->data as $key => $report)
              @php
                \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                $date = date("d/m/Y", $report->start);
                $customer_id = \Stripe\Customer::retrieve($report->customer);
                $user = Illuminate\Support\Facades\DB::table('users')->where('email', '=', $customer_id->email)->first();
                $sell = $sell + (($report->plan->amount/100));
              @endphp
              <tr>
                <td>
                  {{$key+1}}
                </td>
                <td>
                  {{date('d/m/Y',$report->items->data[0]->created)}}
                </td>
                <td>
                  {{$report->items->data[0]->plan->id}}
                </td>
                <td>
                  <i class="{{$currency_symbol}}"></i> {{$report->plan->amount/100}}
                </td>
                <td>
                  Stripe
                </td>
                <td>
                  @if (isset($user))
                    {{$user->name ? $user->name : ''}}
                  @else
                    User Removed
                  @endif
                </td>
              </tr>
            @endforeach
          @endif
          @if (isset($paypal_subscriptions) && count($paypal_subscriptions) > 0)
          @php
              $sell = null;
            @endphp
            @foreach ($paypal_subscriptions as $key => $item)
              @php
                $date = $item->created_at->toDateString();
                $sell = $sell + $item->price;
              @endphp
              <tr>
                <td>
                  {{$key+1}}
                </td>
                <td>
                  {{$date}}
                </td>
                <td>
                  {{$item->plan ? $item->plan->name : 'N/A'}}
                </td>
                <td>
                  <i class="{{$currency_symbol}}"></i> {{$item->price}}
                </td>
                <td>
                  Paypal
                </td>
                <td>
                  {{$item->user ? $item->user->name : 'N/A'}}
                </td>
              </tr>
            @endforeach
          @endif
        </tbody>
      </table>
      <div class="total-sell" style="margin-top: 20px">
        <h5>Total Sells <i class="{{$currency_symbol}}"></i>{{isset($sell) ? $sell : ''}}</h5>
      </div>
    </div>
  </div>
@endsection
