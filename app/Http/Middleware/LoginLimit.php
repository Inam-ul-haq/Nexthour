<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use App\Multiplescreen;
use Session;
use App\PaypalSubscription;
use App\Config;
use Stripe\Customer;
use Stripe\Subscription;
use \Stripe\Stripe;
use Illuminate\Support\Carbon;

class LoginLimit
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $auth = Auth::user();

        $getscreen = Multiplescreen::where('user_id',Auth::user()->id)->first();

        if ($auth->stripe_id != null) {
            if(Auth::user()->subscriptions){
              $data = $auth->subscriptions->last();
              $stripedate = isset($data) ? $data->created_at : null;
              $current_date = Carbon::now();
              if($auth->subscribed($data->name) && date($current_date) <= date($data->subscription_to) && $data->ends_at == null){
                \Session::put('nickname',Auth::user()->name);
                return $next($request);
              }
            }
         }


          $config=Config::first();
         if ($config->free_sub==1) {
            $ps=PaypalSubscription::where('user_id',$auth->id)->first();

            if(isset($ps)){
              if($ps->method == 'free')
              {
                \Session::put('nickname',Auth::user()->name);
                return $next($request);
              }
            }
        }


        
        if(!empty(Session::get('nickname'))){

            return $next($request);

        }

        elseif($auth->is_admin == 1){
             
             return $next($request);

        }elseif(!isset($getscreen)){  
            return redirect()->route('manageprofile',$auth->id);
        }else{
            return redirect()->route('manageprofile',$auth->id);
        }
   
    }
}
