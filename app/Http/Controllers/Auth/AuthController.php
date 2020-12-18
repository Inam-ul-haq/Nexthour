<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use Auth;
use App\User;

use App\PaypalSubscription;
use App\Package;
use App\Menu;
use App\Config;
use App\Multiplescreen;

use Notification;
use App\Notifications\MyNotification;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str as Str;
use App\HeaderTranslation;


class AuthController extends Controller
{
   /**
     * Redirect the user to the OAuth Provider.
     *
     * @return Response
     */
    

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try{
            $user = Socialite::driver($provider)->user();
        }
        catch(\Exception $e){
            $user = Socialite::driver($provider)->stateless()->user();
        }
        

        $authUser = $this->findOrCreateUser($user, $provider);
        $auth_user = $authUser;
         $ps=PaypalSubscription::where('user_id',$auth_user->id)->first();
         
         if(isset($ps)){
            Auth::login($authUser, true);
         }
         else{
            
            $auth_user = $this->socialuser($auth_user);
            Auth::login($authUser, true);

         }

        
        return redirect()->intended('/');
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, create a new user object.
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        if($user->email == Null){
            $user->email = $user->id.'@facebook.com';
        }
        $authUser = User::where('email', $user->email)->first();
        $providerField = "{$provider}_id";
        if($authUser){
            if ($authUser->{$providerField} == $user->id) {
                $authUser->save();
                return $authUser;
            }
            else{
                $authUser->{$providerField} = $user->id;
                $authUser->save();
                return $authUser;
            }
        }
        $auth_user = User::create([
            'name'     => $user->name,
            'email'    => $user->email,
            'status' => 1,  
            $providerField => $user->id,
        ]);

        return $auth_user = $this->socialuser($auth_user);

    }

    public function socialuser($auth_user){

        $config=Config::first();
        if ($config->free_sub==1) {
        $ps=PaypalSubscription::where('user_id',$auth_user->id)->first();
        if ($auth_user->is_admin != 1) {          
          if (!isset($ps) ) {
           
            $config=Config::first();
            $start=Carbon::now();
            $end=$start->addDays($config->free_days);
            $payment_id=mt_rand(10000000000000, 99999999999999);
            $subscribed = 1;
            $created_subscription = PaypalSubscription::create([
              'user_id' => $auth_user->id,
              'payment_id' => $payment_id,
              'user_name' => $auth_user->name,
              'package_id' => 0,
              'price' => 0,
              'status' => 1,
              'method' => 'free',
              'subscription_from' => Carbon::now(),
              'subscription_to' => $end
            ]);
             $to= Str::substr($ps['subscription_to'],0, 10);
            $from= Str::substr($ps['subscription_from'],0, 10);
            
            $desc=HeaderTranslation::where('key', 'Free Trial Text')->first()->value.' '.$from.' to '.$to;
            $title=$config->free_days.' Days '.HeaderTranslation::where('key', 'Free Trial')->first()->value;
          
            $movie_id=NULL;
            $tvid=NULL;
            $user=$auth_user->id;
            User::findOrFail($auth_user->id)->notify(new MyNotification($title,$desc,$movie_id,$tvid,$user));
          }
        }
      }
      return $auth_user;
    }

}
