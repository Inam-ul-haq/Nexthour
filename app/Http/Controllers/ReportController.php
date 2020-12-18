<?php

namespace App\Http\Controllers;

use App\PaypalSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Stripe\Customer;
use Stripe\Invoice;
use Stripe\Subscription;
use \Stripe\Stripe;

class ReportController extends Controller
{
    public function get_report()
    {
      // Set your secret key: remember to change this to your live secret key in production
      Stripe::setApiKey(env('STRIPE_SECRET'));
      $all_reports = Subscription::all();
      $paypal_subscriptions = PaypalSubscription::all();
      return view('admin.report.index', compact('all_reports', 'paypal_subscriptions'));
    }
}
