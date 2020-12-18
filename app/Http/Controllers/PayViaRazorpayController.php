<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Razorpay\Api\Api;
use Session;
use Auth;
use App\Multiplescreen;
use App\Menu;
use App\Package;
use App\PaypalSubscription;
use Illuminate\Support\Carbon;


class PayViaRazorpayController extends Controller
{



	public function success(Request $request,$planid)
	{

		$menus= Menu::all();
        $plan = Package::findorFail($planid);
		$input = $request->all();
        //get API Configuration
        $api = new Api(env('RAZOR_PAY_KEY') , env('RAZOR_PAY_SECRET'));
        //Fetch payment information by razorpay_payment_id
        $payment = $api
            ->payment
            ->fetch($input['razorpay_payment_id']);

            //dd($payment);
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
                'payment_id' => $payment->id,
                'user_name' => $auth->name,
                'package_id' => $plan->id,
                'price' => $payment->amount/100,
                'status' => 1,
                'method' => 'razorpay',
                'subscription_from' => $current_date,
                'subscription_to' => $end_date
            ]);
            if(isset($created_subscription)){
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
            }

             if (isset($menus) && count($menus) > 0)
              {
              return redirect()->route('home', $menus[0]->slug)->with('added', 'Your are now a subscriber !');
            }
       
		return redirect('/')->with('deleted', 'Payment failed');
	}

}
