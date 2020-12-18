<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Mail;
use Session;
use App\Mail\verifyEmail;
use Illuminate\Support\Str;
use App\Mail\WelcomeUser;
use App\Config;
use Carbon\Carbon;
use Notification;
use App\HeaderTranslation;
use App\Notifications\MyNotification;
use App\PaypalSubscription;


class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'Please Choose a name',
            'email.required' => 'Email is required !',
            'email.email' => 'Email must be in valid format',
            'email.unique' => 'This email is already taken, Please choose another',
            'password.required' => 'Password cannot be empty',
            'password.confirmed' => "Password doesn't match",
            'password.min' => 'Password length must be greater than 6'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'is_admin' => 0,
            'status' => 1,
            'password' => bcrypt($data['password']),
            'verifyToken' => Str::random(40),
        ]);
        $config = Config::first();
        if($config->free_sub==1){
          $thisuser=User::findOrfail($user->id);
          $this->freesubscribe($thisuser);
      }

      if($config->verify_email == 1){

        $thisuser=User::findOrfail($user->id);
        $thisuser->status = 0;
        $thisuser->save();
        $this->sendEmail($thisuser);

        return $user;
    }


    if($config->wel_eml == 1){
      try{
        Mail::to($data['email'])->send(new WelcomeUser($user));

    }

    catch(\Swift_TransportException $e){



        header( "refresh:5;url=./login" );

        dd("Your Registration is successfull ! but email is not sent because your webmaster not updated the mail settings in admin dashboard ! Kindly go back and login");


    }

}
} 
public function freesubscribe($thisuser){
     $header_translations = HeaderTranslation::all(); 
    $config=Config::first();
    $start=Carbon::now();
    $end=$start->addDays($config->free_days);
    $payment_id=mt_rand(10000000000000, 99999999999999);
    $created_subscription = PaypalSubscription::create([
        'user_id' => $thisuser->id,
        'payment_id' => $payment_id,
        'user_name' => $thisuser->name,
        'package_id' => 0,
        'price' => 0,
        'status' => 1,
        'method' => 'free',
        'subscription_from' => Carbon::now(),
        'subscription_to' => $end
    ]);
    $ps=PaypalSubscription::where('user_id',$thisuser->id)->first();
   $to= Str::substr($ps->subscription_to,0, 10);
   $from= Str::substr($ps->subscription_from,0, 10);
    $title=$config->free_days.' Days '.$header_translations->where('key', 'Free Trial')->first->value->value;
$desc=$header_translations->where('key', 'Free Trial Text')->first->value->value.' '.$from.' to '.$to;
$movie_id=NULL;
$tvid=NULL;
$user=$thisuser->id;
       User::findOrFail($thisuser->id)->notify(new MyNotification($title,$desc,$movie_id,$tvid,$user));


}
public function sendEmail($thisUser){
    Mail::to($thisUser['email'])->send(new verifyEmail($thisUser));
}

public function verifyEmailFirst(){
  Session::flash('added', 'Verification Email has been sent to your email');
  return redirect()->route('login');
}

public function sendEmailDone($email, $verifyToken){
    $user = User::where(['email' => $email, 'verifyToken' => $verifyToken])->first();

    if($user){
        User::where(['email' => $email, 'verifyToken' => $verifyToken])->update(['status'=>'1','verifyToken'=>NULL]);
        Session::flash('success', 'Email Verification Successfull');

        Mail :: to($user->email)->send(new WelcomeUser($user));
        return redirect()->route('login',$user);
    }else{
        return 'user not found';
    }
}

}

