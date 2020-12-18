<?php

namespace App\Http\Controllers;

use App\order;
use Illuminate\Support\Carbon;
use App\PaypalSubscription;
use Illuminate\Http\Request;
use Auth;
use App\User;
use App\Package;
use Session;
use App\Mail\SendInvoiceMailable;
use Illuminate\Support\Facades\Mail;
use App\Config;
use App\Multiplescreen;

class PaytemController extends Controller
{
     public function index(){
        return view('paytm.index');
    }

   
    public function store(Request $request)
    {  

         
        $plan = Package::findorfail($request->plan_id);
        $config = Config::first();
        $user_id = auth()->id();
        $user = User::find( $user_id );
        $order_id = uniqid() . ( string ) $user_id;
        
        $amount =  $plan->amount;

        Session::put('amount',$plan->amount);
        Session::put('plan',$plan->id);
        $data_for_request = $this->handlePaytmRequest( $order_id, $amount );
        if ($config->paytm_test==1) {
            // for live
             $paytm_txn_url = 'https://securegw.paytm.in/theia/processTransaction';
        }else{
            // fir testing
              $paytm_txn_url = 'https://securegw-stage.paytm.in/theia/processTransaction';
        }
      
        $paramList = $data_for_request['paramList'];
        $checkSum = $data_for_request['checkSum'];
        // $paramList["TXN_AMOUNT"] = $amount;
        return view('paytm.paytemMarchant', compact('amount','paytm_txn_url', 'paramList', 'checkSum' ) );

}

    public function handlePaytmRequest() {

              
                // Load all functions of encdec_paytm.php and config-paytm.php
            $this->getAllEncdecFunc();
            $this->getConfigPaytmSettings();
   
            $checkSum = "";
            $paramList = array();
            $user_id = auth()->id();
            $amount =  Session::get('amount');
            $user = User::find( $user_id );
            $order_id = uniqid() . ( string ) $user_id;
                // Create an array having all required parameters for creating checksum.
            $paramList["MID"] = env('PAYTM_MID');
            $paramList["ORDER_ID"] = $order_id;
            $paramList["CUST_ID"] = $order_id;
            $paramList["INDUSTRY_TYPE_ID"] = 'Retail';
            $paramList["CHANNEL_ID"] = 'WEB';
            $paramList["TXN_AMOUNT"] = $amount;
            $paramList["WEBSITE"] = 'DEFAULT';
            $paramList["CALLBACK_URL"] = url( '/paytm-callback' );
            $paytm_merchant_key = env('PAYTM_MERCHANT_KEY');
 
            //Here checksum string will return by getChecksumFromArray() function.
            $checkSum = getChecksumFromArray( $paramList, $paytm_merchant_key );
            Session::forget('amount');
            return array(
                'checkSum' => $checkSum,
                    'paramList' => $paramList
            );
    }
 
/**
         * Get all the functions from encdec_paytm.php
         */
        function getAllEncdecFunc() 
        {
                function encrypt_e($input, $ky) 
                {
                        $key   = html_entity_decode($ky);
                        $iv = "@@@@&&&&####$$$$";
                        $data = openssl_encrypt ( $input , "AES-128-CBC" , $key, 0, $iv );
                        return $data;
                }
 
                function decrypt_e($crypt, $ky)
                {
                        $key   = html_entity_decode($ky);
                        $iv = "@@@@&&&&####$$$$";
                        $data = openssl_decrypt ( $crypt , "AES-128-CBC" , $key, 0, $iv );
                        return $data;
                }
 
                function pkcs5_pad_e($text, $blocksize) 
                {
                        $pad = $blocksize - (strlen($text) % $blocksize);
                        return $text . str_repeat(chr($pad), $pad);
                }
 
                function pkcs5_unpad_e($text) 
                {
                        $pad = ord($text{strlen($text) - 1});
                        if ($pad > strlen($text))
                                return false;
                        return substr($text, 0, -1 * $pad);
                }
 
                function generateSalt_e($length)
                {
                        $random = "";
                        srand((double) microtime() * 1000000);
 
                        $data = "AbcDE123IJKLMN67QRSTUVWXYZ";
                        $data .= "aBCdefghijklmn123opq45rs67tuv89wxyz";
                        $data .= "0FGH45OP89";
 
                        for ($i = 0; $i < $length; $i++) {
                                $random .= substr($data, (rand() % (strlen($data))), 1);
                        }
 
                        return $random;
                }
 
                function checkString_e($value) 
                {
                        if ($value == 'null')
                                $value = '';
                        return $value;
                }
 
                function getChecksumFromArray($arrayList, $key, $sort=1) 
                {
                        if ($sort != 0) {
                                ksort($arrayList);
                        }
                        $str = getArray2Str($arrayList);
                        $salt = generateSalt_e(4);
                        $finalString = $str . "|" . $salt;
                        $hash = hash("sha256", $finalString);
                        $hashString = $hash . $salt;
                        $checksum = encrypt_e($hashString, $key);
                        return $checksum;
                }
                function getChecksumFromString($str, $key) 
                {
 
                        $salt = generateSalt_e(4);
                        $finalString = $str . "|" . $salt;
                        $hash = hash("sha256", $finalString);
                        $hashString = $hash . $salt;
                        $checksum = encrypt_e($hashString, $key);
                        return $checksum;
                }
 
                function verifychecksum_e($arrayList, $key, $checksumvalue) 
                {
                        $arrayList = removeCheckSumParam($arrayList);
                        ksort($arrayList);
                        $str = getArray2StrForVerify($arrayList);
                        $paytm_hash = decrypt_e($checksumvalue, $key);
                        $salt = substr($paytm_hash, -4);
 
                        $finalString = $str . "|" . $salt;
 
                        $website_hash = hash("sha256", $finalString);
                        $website_hash .= $salt;
 
                        $validFlag = "FALSE";
                        if ($website_hash == $paytm_hash) {
                                $validFlag = "TRUE";
                        } else {
                                $validFlag = "FALSE";
                        }
                        return $validFlag;
                }
 
                function verifychecksum_eFromStr($str, $key, $checksumvalue) 
                {
                        $paytm_hash = decrypt_e($checksumvalue, $key);
                        $salt = substr($paytm_hash, -4);
 
                        $finalString = $str . "|" . $salt;
 
                        $website_hash = hash("sha256", $finalString);
                        $website_hash .= $salt;
 
                        $validFlag = "FALSE";
                        if ($website_hash == $paytm_hash) {
                                $validFlag = "TRUE";
                        } else {
                                $validFlag = "FALSE";
                        }
                        return $validFlag;
                }
 
                function getArray2Str($arrayList) 
                {
                        $findme   = 'REFUND';
                        $findmepipe = '|';
                        $paramStr = "";
                        $flag = 1;
                        foreach ($arrayList as $key => $value) {
                                $pos = strpos($value, $findme);
                                $pospipe = strpos($value, $findmepipe);
                                if ($pos !== false || $pospipe !== false)
                                {
                                        continue;
                                }
 
                                if ($flag) {
                                        $paramStr .= checkString_e($value);
                                        $flag = 0;
                                } else {
                                        $paramStr .= "|" . checkString_e($value);
                                }
                        }
                        return $paramStr;
                }
 
                function getArray2StrForVerify($arrayList) 
                {
                        $paramStr = "";
                        $flag = 1;
                        foreach ($arrayList as $key => $value) {
                                if ($flag) {
                                        $paramStr .= checkString_e($value);
                                        $flag = 0;
                                } else {
                                        $paramStr .= "|" . checkString_e($value);
                                }
                        }
                        return $paramStr;
                }
 
                function redirect2PG($paramList, $key) 
                {
                        $hashString = getchecksumFromArray($paramList, $key);
                        $checksum = encrypt_e($hashString, $key);
                }
 
                function removeCheckSumParam($arrayList) 
                {
                        if (isset($arrayList["CHECKSUMHASH"])) {
                                unset($arrayList["CHECKSUMHASH"]);
                        }
                        return $arrayList;
                }
 
                function getTxnStatus($requestParamList) 
                {
                        return callAPI(PAYTM_STATUS_QUERY_URL, $requestParamList);
                }
 
                function getTxnStatusNew($requestParamList) 
                {
                        return callNewAPI(PAYTM_STATUS_QUERY_NEW_URL, $requestParamList);
                }
 
                function initiateTxnRefund($requestParamList) 
                {
                        $CHECKSUM = getRefundChecksumFromArray($requestParamList,PAYTM_MERCHANT_KEY,0);
                        $requestParamList["CHECKSUM"] = $CHECKSUM;
                        return callAPI(PAYTM_REFUND_URL, $requestParamList);
                }
 
                function callAPI($apiURL, $requestParamList) 
                {
                        $jsonResponse = "";
                        $responseParamList = array();
                        $JsonData =json_encode($requestParamList);
                        $postData = 'JsonData='.urlencode($JsonData);
                        $ch = curl_init($apiURL);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                        'Content-Type: application/json',
                                        'Content-Length: ' . strlen($postData))
                        );
                        $jsonResponse = curl_exec($ch);
                        $responseParamList = json_decode($jsonResponse,true);
                        return $responseParamList;
                }
 
                function callNewAPI($apiURL, $requestParamList) 
                {
                        $jsonResponse = "";
                        $responseParamList = array();
                        $JsonData =json_encode($requestParamList);
                        $postData = 'JsonData='.urlencode($JsonData);
                        $ch = curl_init($apiURL);
                        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                                        'Content-Type: application/json',
                                        'Content-Length: ' . strlen($postData))
                        );
                        $jsonResponse = curl_exec($ch);
                        $responseParamList = json_decode($jsonResponse,true);
                        return $responseParamList;
                }
                function getRefundChecksumFromArray($arrayList, $key, $sort=1) {
                        if ($sort != 0) {
                                ksort($arrayList);
                        }
                        $str = getRefundArray2Str($arrayList);
                        $salt = generateSalt_e(4);
                        $finalString = $str . "|" . $salt;
                        $hash = hash("sha256", $finalString);
                        $hashString = $hash . $salt;
                        $checksum = encrypt_e($hashString, $key);
                        return $checksum;
                }
                function getRefundArray2Str($arrayList) 
                {
                        $findmepipe = '|';
                        $paramStr = "";
                        $flag = 1;
                        foreach ($arrayList as $key => $value) {
                                $pospipe = strpos($value, $findmepipe);
                                if ($pospipe !== false)
                                {
                                        continue;
                                }
 
                                if ($flag) {
                                        $paramStr .= checkString_e($value);
                                        $flag = 0;
                                } else {
                                        $paramStr .= "|" . checkString_e($value);
                                }
                        }
                        return $paramStr;
                }
                function callRefundAPI($refundApiURL, $requestParamList) 
                {
                        $jsonResponse = "";
                        $responseParamList = array();
                        $JsonData =json_encode($requestParamList);
                        $postData = 'JsonData='.urlencode($JsonData);
                        $ch = curl_init($apiURL);
                        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
                        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);
                        curl_setopt($ch, CURLOPT_URL, $refundApiURL);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                        $headers = array();
                        $headers[] = 'Content-Type: application/json';
                        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                        $jsonResponse = curl_exec($ch);
                        $responseParamList = json_decode($jsonResponse,true);
                        return $responseParamList;
                }
        }
 
        /**
         * Config Paytm Settings from config_paytm.php file of paytm kit
         */
        function getConfigPaytmSettings() {
                define('PAYTM_ENVIRONMENT', 'TEST'); // PROD
                define('PAYTM_MERCHANT_KEY', env('PAYTM_MERCHANT_KEY')); //Change this constant's value with Merchant key downloaded from portal
                define('PAYTM_MERCHANT_MID',  env('PAYTM_MERCHANT_MID')); //Change this constant's value with MID (Merchant ID) received from Paytm
                define('PAYTM_MERCHANT_WEBSITE', 'DEFAULT'); //Change this constant's value with Website name received from Paytm
 
                $PAYTM_STATUS_QUERY_NEW_URL='https://securegw-stage.paytm.in/merchant-status/getTxnStatus';
                $PAYTM_TXN_URL='https://securegw-stage.paytm.in/theia/processTransaction';
                if (PAYTM_ENVIRONMENT == 'PROD') {
                        $PAYTM_STATUS_QUERY_NEW_URL='https://securegw.paytm.in/merchant-status/getTxnStatus';
                        $PAYTM_TXN_URL='https://securegw.paytm.in/theia/processTransaction';
                }
                define('PAYTM_REFUND_URL', '');
                define('PAYTM_STATUS_QUERY_URL', $PAYTM_STATUS_QUERY_NEW_URL);
                define('PAYTM_STATUS_QUERY_NEW_URL', $PAYTM_STATUS_QUERY_NEW_URL);
                define('PAYTM_TXN_URL', $PAYTM_TXN_URL);
        }
    


    public function paytmCallback( Request $request ) {
        $plan_id = Session::get('plan');
        
        $order_id = $request['ORDERID'];
        $plan = Package::findorfail($plan_id);
        $user_id = auth()->id();
        $user = User::find($user_id);
        
       
       


        if ( 'TXN_SUCCESS' === $request['STATUS'] ) {

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
                        'user_id' => $user_id,
                        'payment_id' => $request['TXNID'],
                        'user_name' => $user->name,
                        'package_id' => $plan->id,
                        'price' => $plan->amount,
                        'status' => 1,
                        'method' => 'PAYTM',
                        'subscription_from' => $current_date,
                        'subscription_to' => $end_date
                ]);
                


                $transaction_id = $request['TXNID'];
                $w_email = Config::findOrFail(1)->w_email;

                Session::put('com_email',$w_email);
                Session::put('user_email',$user->email);
                
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
                                    
                                    
                         } catch(\Swift_TransportException $e){
                                header( "refresh:5;url=./" );
                                dd("Payment Successfully ! but Invoice will not sent because admin not updated the mail setting in admin dashboard ! Redirecting you to homepage... !");
                        }

                        
                    }

                                    Session::forget('user_email');
                                    Session::forget('com_email');
        

                return redirect('/')->with('added',"Payment Successfully ! You're now a subscriber ! ");
               

        } else if( 'TXN_FAILURE' === $request['STATUS'] ){
                return redirect('/')->with('delete','Payment Failed !');
        }

        Session::forget('plan');
    }
}
