<?php

namespace App\Http\Controllers;

use App\Mail\SendInvoiceMailable;
use App\Package;
use App\Menu;
use App\Multiplescreen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Paystack;
use App\PaypalSubscription;
use App\Config;
use Illuminate\Support\Carbon;

class PaystackController extends Controller
{
  public function paystackgateway()
  {
      return Paystack::getAuthorizationUrl()->redirectNow();
  }

  public function paystackcallback()
  {
    $auth = Auth::user();
    $payment = Paystack::getPaymentData();
    if($payment['data']['status'] == 'success' && $payment['status'] == 'true'){
      $plan = Package::wherePlanId($payment['data']['metadata']['plan_id'])->first();
      $menus = Menu::all();
      $user_email = $auth->email;
      $com_email = Config::findOrFail(1)->w_email;
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

      $created_subscription = PaypalSubscription::create([
        'user_id'    => $auth->id,
        'payment_id' => $payment['data']['reference'],
        'user_name' => $auth->name,
        'package_id' => $plan->id,
        'price'      => $payment['data']['amount'],
        'status'     => '1',
        'method'     => 'paystack',
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
        Mail::send('user.invoice', ['paypal_sub' => $created_subscription, 'invoice' => null], function($message) use ($com_email, $user_email) {
          $message->from($com_email)->to($user_email)->subject('Invoice');
        });
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
      return redirect('/')->with('error', 'Payment error occured. Please try again !');
    }
  }
}