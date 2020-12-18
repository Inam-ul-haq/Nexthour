<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Client;
use App\Config;
use App\PaypalSubscription;
use Illuminate\Support\Carbon;
use Mail;
use Illuminate\Support\Str;
use App\Mail\verifyEmail;
use App\Mail\WelcomeUser;

class RegisterController extends Controller
{
    use IssueTokenTrait;

	private $client;

	public function __construct(){
		$this->client = Client::find(2);
	}

    public function register(Request $request){

    	$this->validate($request, [
    		'name' => 'required',
    		'email' => 'required|email|unique:users,email',
    		'password' => 'required|min:6'
    	]);

    	$user = User::create([
    		'name' => request('name'),
    		'email' => request('email'),
    		'password' => bcrypt(request('password')),
            'is_blocked' => '0',
            'verifyToken' => Str::random(5),
    	]);

        $config = Config::first();
        if($config->free_sub==1){
          $this->freesubscribe($user);
        }
        if($config->verify_email == 1){        
            try{
                Mail::to($user->email)->send(new verifyEmail($user));
                return response()->json('ok', 200);
            }
            catch(\Swift_TransportException $e){
                return response()->json('Mail Sending Error', 400);
            }
        }

        if($config->wel_eml == 1){
          try{
                Mail::to(request('email'))->send(new WelcomeUser($user));
            }
            catch(\Swift_TransportException $e){
                return response()->json('Registration done. Mail Sending Error', 200);
            }
            return $this->issueToken($request, 'password');
        }
    }

    public function freesubscribe($thisuser){
  
        $config=Config::first();
        $start=Carbon::now();
        $end=$start->addDays($config->free_days);
        $payment_id=mt_rand(10000000000000, 99999999999999);
        $created_subscription = PaypalSubscription::create([
            'user_id' => $thisuser->id,
            'payment_id' => $payment_id,
            'user_name' => $thisuser->name,
            'package_id' => 100,
            'price' => 0,
            'status' => 1,
            'method' => 'free',
            'subscription_from' => Carbon::now(),
            'subscription_to' => $end
        ]);
    
    }

    public function verifyemail(Request $request){
        $user = User::where(['email' => $request->email, 'verifyToken' => $request->token])->first();
        if($user){
            $user->status=1; 
            $user->verifyToken=NULL;
            $user->save();
            Mail::to($user->email)->send(new WelcomeUser($user));
            return $this->issueToken($request, 'password');
        }else{
            return response()->json('user not found', 401);
        }
    }

}
