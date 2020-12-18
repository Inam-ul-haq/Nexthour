<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Config;
use App\Button;
use App;
use Auth;

class ConfigController extends Controller
{

  public function getset()
  {
    $config = Config::first();

    $env_files = [
      'MAIL_FROM_NAME' => env('MAIL_FROM_NAME'),
      'MAIL_FROM_ADDRESS' => env('MAIL_FROM_ADDRESS'),
      'MAIL_DRIVER' => env('MAIL_DRIVER'),
      'MAIL_HOST' => env('MAIL_HOST'),
      'MAIL_PORT' => env('MAIL_PORT'),
      'MAIL_USERNAME' => env('MAIL_USERNAME'),
      'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
      'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION')

    ];
    return view('admin.mailsetting.mailset', compact('config', 'env_files'));

  }
  public function index()
  {
    $config = Config::whereId(1)->first();
    $button = Button::whereId(1)->first();
    $configs = Config::first();

    $env_files = [
      'APP_NAME' => env('APP_NAME'),
      'APP_URL' => env('APP_URL')
    ];

    return view('admin.config.settings', compact('config','button','env_files'));
  }


  public function update(Request $request, $id)
  {

    $config = Config::findOrFail($id);
    $button = Button::findOrFail($id);

    $request->validate([
      'logo' => 'nullable|image|mimes:jpg,jpeg,png',
      'favicon' => 'image|mimes:png',
      'w_email' => 'nullable|email',
      'paypal_mar_email' => 'nullable|email'
    ]);



    $input = $request->all();



    $env_update = $this->changeEnv([
      'APP_NAME'=> preg_replace('/\s+/','',$request->title),
      'APP_URL' => preg_replace('/\s+/','',$request->APP_URL)
    ]);


    if ($file = $request->file('logo')) {
      $name = 'logo_' . time() . $file->getClientOriginalName();
      if($config->logo != null) {
        $content = @file_get_contents(public_path().'/images/logo/'.$config->logo);
        if ($content) {
          unlink(public_path().'/images/logo/'.$config->logo);
        }
      }
      $file->move('images/logo', $name);
      $input['logo'] = $name;
      $config->update([
        'logo' => $input['logo']
      ]);
    }

    if ($file2 = $request->file('favicon')) {
      $name = 'favicon.png';
      if ($config->favicon != null) {
        $content = @file_get_contents(public_path().'favicon/favicon.ico');
        if ($content) {
          unlink(public_path().'favicon/favicon.ico');
        }
      }
      $file2->move('images/favicon', $name);
      $input['favicon'] = $name;
      $config->update([
        'favicon' => $input['favicon']
      ]);
    }
    if(!isset($input['age_restriction']))
    {
      $input['age_restriction'] = 0;
    }

    // if(!isset($input['blog']))
    // {
    //   $input['blog'] = 0;
    // }
    if(!isset($input['prime_main_slider']))
    {
      $input['prime_main_slider'] = 0;
    }
    if(!isset($input['prime_genre_slider']))
    {
      $input['prime_genre_slider'] = 0;
    }
    if(!isset($input['donation']))
    {
      $input['donation'] = 0;
    }
    if(!isset($input['prime_footer']))
    {
      $input['prime_footer'] = 0;
    }
    if(!isset($input['prime_movie_single']))
    {
      $input['prime_movie_single'] = 0;
    }

    if(!isset($input['stripe_payment']))
    {
      $input['stripe_payment'] = 0;
    }

    if(!isset($input['paypal_payment']))
    {
      $input['paypal_payment'] = 0;
    }

    if(!isset($input['payu_payment']))
    {
      $input['payu_payment'] = 0;
    }

    if(!isset($input['paytm_payment']))
    {

      $input['paytm_payment'] = 0;
    }

    if(!isset($input['paytm_test']))
    {

      $input['paytm_test'] = 0;
    }


    if(!isset($input['preloader']))
    {
      $input['preloader'] = 0;
    }
    if(!isset($input['catlog']))
    {
      $input['catlog'] = 0;
    }
    if(!isset($input['withlogin']))
    {
      $input['withlogin'] = 0;
    }
    if(!isset($input['inspect']))
    {
      $input['inspect'] = 0;
    }
    if(!isset($input['rightclick']))
    {
      $input['rightclick'] = 0;
    }
    if(!isset($input['goto']))
    {
      $input['goto'] = 0;
    }
    if(!isset($input['color']))
    {
      $input['color'] = 0;
    }

    if(isset($request->wel_eml)){

      $input['wel_eml'] = 1;
    }else{
      $input['wel_eml'] = 0;
    }
     if(isset($request->blog)){

      $input['blog'] = 1;
    }else{
      $input['blog'] = 0;
    }
    if (isset($request->free_sub)) {
          # code...
      $input['free_sub']=1;
    }else{
      $input['free_sub']=0;
    }

    if(isset($request->verify_email)){

      $input['verify_email'] = 1;
    }else{
      $input['verify_email'] = 0;
    }
    if(isset($request->download)){

      $input['download'] = 1;
    }else{
      $input['download'] = 0;
    }
    if(isset($request->is_playstore)){

      $input['is_playstore'] = 1;
    }else{
      $input['is_playstore'] = 0;
    }
    if(isset($request->is_appstore)){

      $input['is_appstore'] = 1;
    }else{
      $input['is_appstore'] = 0;
    }
    if(isset($request->color_dark)){

      $input['color_dark'] = 1;
    }else{
      $input['color_dark'] = 0;
    }
    if(isset($request->user_rating)){

      $input['user_rating'] = 1;
    }else{
      $input['user_rating'] = 0;
    }
    if(isset($request->comments)){

      $input['comments'] = 1;
    }else{
      $input['comments'] = 0;
    }
    if (isset($request->remove_landing_page)) {
      $input['remove_landing_page']=1;
    }else{
      $input['remove_landing_page']=0;
    }
    if (isset($request->coinpay)) {
      $input['coinpay']=1;
    }else{
      $input['coinpay']=0;
    }
    if (isset($request->aws)) {
      $input['aws']=1;
    }else{
      $input['aws']=0;
    }


    $config->update([
      'prime_main_slider' => $input['prime_main_slider'],
      'prime_genre_slider' => $input['prime_genre_slider'],
      'prime_footer' => $input['prime_footer'],
      'prime_movie_single' => $input['prime_movie_single'],
      'title' => $input['title'],
      'w_email' => $input['w_email'],
      'blog' => $input['blog'],
      'currency_code' => $input['currency_code'],
      'currency_symbol' => $input['currency_symbol'],
      'prime_footer' => $input['prime_footer'],
      'preloader' => $input['preloader'],
      'catlog' => $input['catlog'],
      'withlogin' => $input['withlogin'],
      'stripe_payment' => $input['stripe_payment'],
      'invoice_add' => $input['invoice_add'],
      'wel_eml'   => $input['wel_eml'],
      'paytm_test' => $input['paytm_test'],
      'verify_email'   => $input['verify_email'],
      'download'   => $input['download'],
      'donation'=>$input['donation'],
      'free_sub'=>$input['free_sub'],
      'free_days'=>$input['free_days'],
      'donation_link'=>$input['donation_link'],
      'age_restriction'=>$input['age_restriction'],
      'is_playstore'=>$input['is_playstore'],
      'is_appstore'=>$input['is_appstore'],
      'playstore'=>$input['playstore'],
      'appstore'=>$input['appstore'],
      'color_dark'=>$input['color_dark'],
      'color'=>$input['color'],
      'remove_landing_page'=>$input['remove_landing_page'],
      'user_rating'=>$input['user_rating'],
      'comments'=>$input['comments'],
      'coinpay'=>$input['coinpay'],
      'aws'=>$input['aws'],

    ]);
    $button->update([
      'rightclick' => $input['rightclick'],
      'goto' => $input['goto'],
      
      'inspect' => $input['inspect'],
    ]);



    return back()->with('updated', 'Settings has been updated');
  }

  public function setApiView()
  {
    $config = Config::first();
    $env_files = [
      'STRIPE_KEY' => env('STRIPE_KEY'),
      'STRIPE_SECRET' => env('STRIPE_SECRET'),
      'RAZOR_PAY_KEY' => env('RAZOR_PAY_KEY'),
      'RAZOR_PAY_SECRET' => env('RAZOR_PAY_SECRET'),
      'MAILCHIMP_APIKEY' => env('MAILCHIMP_APIKEY'),
      'MAILCHIMP_LIST_ID' => env('MAILCHIMP_LIST_ID'),
      'TMDB_API_KEY' => env('TMDB_API_KEY'),
      'PAYPAL_CLIENT_ID' => env('PAYPAL_CLIENT_ID'),
      'PAYPAL_SECRET_ID' => env('PAYPAL_SECRET_ID'),
      'PAYPAL_MODE' => env('PAYPAL_MODE'),
      'PAYU_METHOD' => env('PAYU_METHOD'),
      'PAYU_DEFAULT' => env('PAYU_DEFAULT'),
      'PAYU_MERCHANT_KEY' => env('PAYU_MERCHANT_KEY'),
      'PAYU_MERCHANT_SALT' => env('PAYU_MERCHANT_SALT'),
      'PAYTM_MID'         => env('PAYTM_MID'),
      'PAYTM_MERCHANT_KEY' => env('PAYTM_MERCHANT_KEY'),
      'BTREE_ENVIRONMENT'=>env('BTREE_ENVIRONMENT'),
      'BTREE_MERCHANT_ID'=>env('BTREE_MERCHANT_ID'),
      'BTREE_PUBLIC_KEY'=>env('BTREE_PUBLIC_KEY'),
      'BTREE_PRIVATE_KEY'=>env('BTREE_PRIVATE_KEY'),
      'PAYSTACK_PUBLIC_KEY'=>env('PAYSTACK_PUBLIC_KEY'),
      'PAYSTACK_SECRET_KEY'=>env('PAYSTACK_SECRET_KEY'),
      'PAYSTACK_PAYMENT_URL'=>env('PAYSTACK_PAYMENT_URL'),
      'MERCHANT_EMAIL'=>env('MERCHANT_EMAIL'),
      'BTREE_MERCHANT_ACCOUNT_ID'=>env('BTREE_MERCHANT_ACCOUNT_ID'),
      'COINPAYMENTS_MERCHANT_ID'=>env('COINPAYMENTS_MERCHANT_ID'),
      'COINPAYMENTS_PUBLIC_KEY'=>env('COINPAYMENTS_PUBLIC_KEY'),
      'COINPAYMENTS_PRIVATE_KEY'=>env('COINPAYMENTS_PRIVATE_KEY'),
      'VIMEO_ACCESS'=>env('VIMEO_ACCESS'),
      'YOUTUBE_API_KEY'=>env('YOUTUBE_API_KEY'),
      'key'=>env('key'),
      'secret'=>env('secret'),
      'region'=>env('region'),
      'bucket'=>env('bucket'),




    ];
    return view('admin.config.api', compact('config', 'env_files'));
  }

  public function changeEnvKeys(Request $request)
  {
    $input = $request->all();
        // some code
    $env_update = $this->changeEnv([
      'STRIPE_KEY' => $request->STRIPE_KEY,
      'STRIPE_SECRET' => $request->STRIPE_SECRET,
      'RAZOR_PAY_KEY' => $request->RAZOR_PAY_KEY,
      'RAZOR_PAY_SECRET' => $request->RAZOR_PAY_SECRET,
      'MAILCHIMP_APIKEY' => $request->MAILCHIMP_APIKEY,
      'MAILCHIMP_LIST_ID' => $request->MAILCHIMP_LIST_ID,
      'TMDB_API_KEY' => $request->TMDB_API_KEY,
      'PAYPAL_CLIENT_ID' => $request->PAYPAL_CLIENT_ID,
      'PAYPAL_SECRET_ID' => $request->PAYPAL_SECRET_ID,
      'PAYPAL_MODE' => $request->PAYPAL_MODE,
      'PAYU_METHOD' => $request->PAYU_METHOD,
      'PAYU_DEFAULT' => $request->PAYU_DEFAULT,
      'PAYU_MERCHANT_KEY' => $request->PAYU_MERCHANT_KEY,
      'PAYU_MERCHANT_SALT' => $request->PAYU_MERCHANT_SALT,
      'PAYTM_MID' => $request->PAYTM_MID,
      'PAYTM_MERCHANT_KEY' => $request->PAYTM_MERCHANT_KEY,
      'YOUTUBE_API_KEY'=>$request->YOUTUBE_API_KEY,
      'BTREE_ENVIRONMENT'=>$request->BTREE_ENVIRONMENT,
      'BTREE_MERCHANT_ID'=>$request->BTREE_MERCHANT_ID,
      'BTREE_PUBLIC_KEY'=>$request->BTREE_PUBLIC_KEY,
      'BTREE_PRIVATE_KEY'=>$request->BTREE_PRIVATE_KEY,
      'PAYSTACK_PUBLIC_KEY'=>$request->PAYSTACK_PUBLIC_KEY,
      'PAYSTACK_SECRET_KEY'=>$request->PAYSTACK_SECRET_KEY,
      'PAYSTACK_PAYMENT_URL'=>$request->PAYSTACK_PAYMENT_URL,
      'MERCHANT_EMAIL'=>$request->MERCHANT_EMAIL,
      'BTREE_MERCHANT_ACCOUNT_ID'=>$request->BTREE_MERCHANT_ACCOUNT_ID,
      'COINPAYMENTS_MERCHANT_ID'=>$request->COINPAYMENTS_MERCHANT_ID,
      'COINPAYMENTS_PUBLIC_KEY'=>$request->COINPAYMENTS_PUBLIC_KEY,
      'COINPAYMENTS_PRIVATE_KEY'=>$request->COINPAYMENTS_PRIVATE_KEY,
      'VIMEO_ACCESS'=>$request->VIMEO_ACCESS,
        'key'=>$request->key,
      'secret'=>$request->secret,
      'region'=>$request->region,
      'bucket'=>$request->bucket,
    ]);

    if(!isset($input['stripe_payment']))
    {
      $input['stripe_payment'] = 0;
    }

    if(!isset($input['razorpay_payment']))
    {
      $input['razorpay_payment'] = 0;
    }

    if(!isset($input['paypal_payment']))
    {
      $input['paypal_payment'] = 0;
    }

    if(!isset($input['payu_payment']))
    {
      $input['payu_payment'] = 0;
    }

    if(!isset($input['paytm_payment']))
    {
      $input['paytm_payment'] = 0;
    }
    if(!isset($input['bankdetails']))
    {
      $input['bankdetails'] = 0;
    }
    if(!isset($input['braintree']))
    {
      $input['braintree'] = 0;
    }
    if(!isset($input['paystack']))
    {
      $input['paystack'] = 0;
    }
    if(!isset($input['coinpay']))
    {
      $input['coinpay'] = 0;
    }
    if(!isset($input['aws']))
    {
      $input['aws'] = 0;
    }


    $config = Config::first();

    $config->update($input);

    if($env_update) {
      return back()->with('updated', 'Api settings has been saved');
    } else {
      return back()->with('deleted', 'Api settings could not be saved');
    }

  }


  public function changeMailEnvKeys(Request $request)
  {
    $input = $request->all();
        // some code
    $env_update = $this->changeEnv([
      'MAIL_FROM_NAME' => $request->MAIL_FROM_NAME,
      'MAIL_DRIVER' => $request->MAIL_DRIVER,
      'MAIL_HOST' => $request->MAIL_HOST,
      'MAIL_PORT' => $request->MAIL_PORT,
      'MAIL_USERNAME' => $request->MAIL_USERNAME,
      'MAIL_FROM_ADDRESS' => $string = preg_replace('/\s+/', '', $request->MAIL_FROM_ADDRESS),
      'MAIL_PASSWORD' => $request->MAIL_PASSWORD,
      'MAIL_ENCRYPTION' => $request->MAIL_ENCRYPTION,
    ]);



    $config = Config::first();

    $config->update($input);

    if($env_update) {
      return back()->with('updated', 'Mail settings has been saved');
    } else {
      return back()->with('deleted', 'Mail settings could not be saved');
    }

  }

  protected function changeEnv($data = array()){
    {
      if ( count($data) > 0 ) {

            // Read .env-file
        $env = file_get_contents(base_path() . '/.env');

            // Split string on every " " and write into array
        $env = preg_split('/\s+/', $env);;

            // Loop through given data
        foreach((array)$data as $key => $value){
              // Loop through .env-data
          foreach($env as $env_key => $env_value){
                // Turn the value into an array and stop after the first split
                // So it's not possible to split e.g. the App-Key by accident
            $entry = explode("=", $env_value, 2);

                // Check, if new key fits the actual .env-key
            if($entry[0] == $key){
                    // If yes, overwrite it with the new one
              $env[$env_key] = $key . "=" . $value;
            } else {
                    // If not, keep the old one
              $env[$env_key] = $env_value;
            }
          }
        }

            // Turn the array back to an String
        $env = implode("\n\n", $env);

            // And overwrite the .env with the new data
        file_put_contents(base_path() . '/.env', $env);

        return true;

      } else {

        return false;
      }
    }
  }
}
