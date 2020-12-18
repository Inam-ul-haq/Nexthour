<?php

namespace App\Http\Controllers;

use App\Config;
use App\Http\Requests;
use App\Menu;
use App\Package;
use App\PaypalSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\URL;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\ExecutePayment;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use Validator;
use App\Mail\SendInvoiceMailable;
use Illuminate\Support\Facades\Mail;
use App\Multiplescreen;

class PaypalController extends Controller
{
    private $_api_context;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /** setup PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }
	/**
     * Store a details of payment with paypal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postPaymentWithpaypal(Request $request)
    {
    	$plan = Package::findOrFail($request->plan_id);
    	$currency_code = Config::first()->currency_code;
        $currency_code = strtoupper($currency_code);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

    	$item_1 = new Item();

        $item_1->setName($plan->name) /** item name **/
            ->setCurrency($currency_code)
            ->setQuantity(1)
            ->setPrice($plan->amount); /** unit price **/

        $item_list = new ItemList();
        $item_list->setItems(array($item_1));

        $amount = new Amount();
        $amount->setCurrency($currency_code)
            ->setTotal($plan->amount);

        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list)
            ->setDescription('Subscription');

        $redirect_urls = new RedirectUrls();
        $redirect_urls->setReturnUrl(route('getPaymentStatus')) /** Specify return URL **/
            ->setCancelUrl(route('getPaymentFailed'));

        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
            /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                return back()->with('deleted', 'Connection timeout');
                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                /** $err_data = json_decode($ex->getData(), true); **/
                /** exit; **/
            } else {
                return back()->with('deleted', 'Some error occur, sorry for inconvenient');
                /** die('Some error occur, sorry for inconvenient'); **/
            }
        }

        foreach($payment->getLinks() as $link) {
            if($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        Session::put('plan', $plan);

        if(isset($redirect_url)) {
            /** redirect to paypal **/
            return redirect($redirect_url);
        }

    	return back()->with('deleted', 'Unknown error occurred');
    }

    public function getPaymentStatus()
    {
        $menus = Menu::all();
        $user_email = Auth::user()->email;
        $com_email = Config::findOrFail(1)->w_email;

        Session::put('user_email', $user_email);
        Session::put('com_email', $com_email);

        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        $plan = Session::get('plan');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        Session::forget('plan');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            return back()->with('deleted', 'Payment failed');
        }

        $payment = Payment::get($payment_id, $this->_api_context);
        /** PaymentExecution object includes information necessary **/
        /** to execute a PayPal account payment. **/
        /** The payer_id is added to the request query parameters **/
        /** when the user is redirected from paypal back to your site **/
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        /** dd($result);exit; /** DEBUG RESULT, remove it later **/
        if ($result->getState() == 'approved') { 
            /** it's all right **/
            /** Here Write your database logic like that insert record or value in database if you want **/
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
                'payment_id' => $payment_id,
                'user_name' => $auth->name,
                'package_id' => $plan->id,
                'price' => $plan->amount,
                'status' => 1,
                'method' => 'paypal',
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
                }
                       catch(\Swift_TransportException $e){
                           header( "refresh:5;url=./" );
                           dd("Payment Successfully ! but Invoice will not sent because admin not updated the mail setting in admin dashboard ! Redirecting you to homepage... !");
                       }
               
            }

            if (isset($menus) && count($menus) > 0) {
              return redirect()->route('home', $menus[0]->slug)->with('added', 'Your are now a subscriber !');
            }
            return redirect('/')->with('added', 'Your are now a subscriber !');
        }

		return redirect('/')->with('deleted', 'Payment failed');
    }

    public function getPaymentFailed()
    {
        return redirect('/')->with('deleted', 'Payment failed');
    }

}
