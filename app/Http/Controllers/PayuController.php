<?php

namespace App\Http\Controllers;

use App\Config;
use App\Menu;
use App\Package;
use App\Multiplescreen;
use App\PaypalSubscription;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Tzsk\Payu\Facade\Payment;

class PayuController extends Controller
{
    public function payment(Request $request)
    {
    	$plan = Package::findOrFail($request->plan_id);
    	$currency_code = Config::first()->currency_code;
    	$auth = Auth::user();

    	$amount = $plan->amount;

    	if ($currency_code != 'INR') {
    		return back()->with('deleted', 'Currency is in '.strtoupper($currency_code).' so payumoney only support INR currency.');
    	}

    	$attributes = [
		    'txnid' => strtoupper(str_random(8)), # Transaction ID.
		    'amount' => $plan->amount, # Amount to be charged.
		    'productinfo' => $plan->name,
		    'firstname' => $auth->name, # Payee Name.
		    'email' => $auth->email, # Payee Email Address.
		    'phone' => '1234567890', # Payee Phone Number.
		];

		Session::put('plan', $plan);
		return Payment::make($attributes, function ($then) {
		    $then->redirectTo('payment/status');
		});
    }

    public function status()
    {
    	$payment = Payment::capture();
    	$menus = Menu::all();
    	$plan = Session::get('plan');
    	$user_email = Auth::user()->email;
        $com_email = Config::findOrFail(1)->w_email;

        Session::put('user_email', $user_email);
        Session::put('com_email', $com_email);

    	Session::forget('plan');

		// Get the payment status.
		$payment->isCaptured(); # Returns boolean - true / false

		if ($payment->isCaptured() == true) {
			
			$current_date = Carbon::now();
            $end_date = null;

            if ($plan->interval == 'month') {
                $end_date = Carbon::now()->addMonths($plan->interval_count);
            } else if ($plan->interval == 'year') {
                $end_date = Carbon::now()->addYears($plan->interval_count);
            } else if ($plan->interval == 'week') {
                $end_date = Carbon::now()->addWeeks($plan->interval_count);
            } else if ($plan->interval == 'day') {
                $end_date = Carbon::now()->addDays($plan->interval_count);
            }

            $auth = Auth::user();

            $created_subscription = PaypalSubscription::create([
                'user_id' => $auth->id,
                'payment_id' => $payment->txnid,
                'user_name' => $auth->name,
                'package_id' => $plan->id,
                'price' => $plan->amount,
                'status' => 1,
                'method' => 'payumoney',
                'subscription_from' => $current_date,
                'subscription_to' => $end_date
            ]);

            if ($created_subscription) {
            $auth = Auth::user();
             $screen = $plan->screens;
              if($screen > 0){
                $multiplescreen = Multiplescreen::where('user_id',$auth->id)->first();
                if(isset($multiplescreen)){
                    $multiplescreen->update([
                      'pkg_id' => $plan->id,
                      'user_id' => $auth->id,
                      'screen1' => $screen >= 1 ? $auth->name :  null,
                      'screen2' => $screen >= 2 ? 'Screen2' :  null,
                      'screen3' => $screen >= 3 ? 'Screen3' :  null,
                      'screen4' => $screen >= 4 ? 'Screen4' :  null
                    ]);
                }
                else{
                    $multiplescreen = Multiplescreen::create([
                      'pkg_id' => $plan->id,
                      'user_id' => $auth->id,
                      'screen1' => $screen >= 1 ? $auth->name :  null,
                      'screen2' => $screen >= 2 ? 'Screen2' :  null,
                      'screen3' => $screen >= 3 ? 'Screen3' :  null,
                      'screen4' => $screen >= 4 ? 'Screen4' :  null
                    ]);
                 }
              }
            

                try{
                Mail::send('user.invoice', ['paypal_sub' => $created_subscription, 'invoice' => null], function($message) {
                    $message->from(Session::get('com_email'))->to(Session::get('user_email'))->subject('Invoice');
                });
                Session::forget('user_email');
                Session::forget('com_email');
                }catch(\Swift_TransportException $e){
                    header( "refresh:5;url=./" );
                    dd("Payment Successfully ! but Invoice will not sent because admin not updated the mail setting in admin dashboard ! Redirecting you to homepage... !");
                 }
            }

            if (isset($menus) && count($menus) > 0) {
              return redirect()->route('home', $menus[0]->slug)->with('added', 'Your are now a subscriber !');
            }
            return redirect('/')->with('added', 'Your are now a subscriber !');

		} else {

            return redirect('/')->with('deleted', 'Payment not done due to some payumoney server issue !');
			
		}


    }
}
