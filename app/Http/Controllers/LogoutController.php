<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\PaypalSubscription;
use App\Multiplescreen;

class LogoutController extends Controller
{
    public function logout(){

    	if(Auth::user()['is_admin'] == 1){
    		//In case user is admin
    		Auth::logout();
    		Session::flush();
    		return redirect('/')->with('success','Logged out !');
    	}elseif(isset(Auth::user()->subscriptions)){

    		 $activesubsription = PaypalSubscription::where('user_id',Auth::user()->id)->where('status','=',1)->orderBy('created_at','desc')->first(); 

    		 if(isset($activesubsription)){

    		 	$getscreens = Multiplescreen::where('user_id','=',Auth::user()->id)->first();

    		 	if(isset($getscreens)){

                    $macaddress = $_SERVER['REMOTE_ADDR']; 

    		 		if($getscreens->device_mac_1 == $macaddress){

    		 			$getscreens->device_mac_1 = NULL;
    		 			$getscreens->screen_1_used = 'NO';

    		 		}elseif($getscreens->device_mac_2 == $macaddress){

    		 			$getscreens->device_mac_2 = NULL;
    		 			$getscreens->screen_2_used = 'NO';

    		 		}elseif($getscreens->device_mac_3 == $macaddress){

    		 			$getscreens->device_mac_3 = NULL;
    		 			$getscreens->screen_3_used = 'NO';

    		 		}elseif($getscreens->device_mac_4 == $macaddress){

  		
 			$getscreens->device_mac_4 = NULL;
    		 			$getscreens->screen_4_used = 'NO';

    		 		}

    		 		$getscreens->save();
    		 		Session::flush();
    		 		Auth::logout();
    		 		return redirect('/')->with('success','Logged out !');

    		 	}else{
    		 		//In case screen not found
    		 		Auth::logout();
    		 		Session::flush();
    		 		return redirect('/')->with('success','Logged out !');
    		 	}

    		 }else{
    		 	//In case user is not subscribed 
    		 	Auth::logout();
    		 	Session::flush();
    		 	return redirect('/')->with('success','Logged out !');
    		 }
    	}

    }	
}
