<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

 Route::post('login', 'Api\Auth\LoginController@login');
 Route::post('fblogin', 'Api\Auth\LoginController@fblogin');
 Route::get('home', 'Api\MainController@home');
 Route::post('register', 'Api\Auth\RegisterController@register');
Route::post('verifyemail', 'Api\Auth\RegisterController@verifyemail');
 Route::post('refresh', 'Api\Auth\LoginController@refresh');
Route::post('forgotpassword', 'Api\Auth\LoginController@forgotApi');
Route::post('verifycode', 'Api\Auth\LoginController@verifyApi');
Route::post('resetpassword', 'Api\Auth\LoginController@resetApi');
Route::get('faq', 'Api\MainController@faq');
Route::post('addcomment', 'Api\RatingCommentController@comment_store');

Route::group(['middleware' => ['auth:api','is_blocked']], function (){
  Route::get('menu', 'Api\MainController@menu');
  Route::get('movie', 'Api\MainController@movie');
  Route::get('tvseries', 'Api\MainController@tvseries');
  Route::get('movietv', 'Api\MainController@movietv');
  Route::get('main', 'Api\MainController@index');
  Route::post('logout','Api\Auth\LoginController@logoutApi');
  Route::get('userProfile', 'Api\MainController@userProfile');
  Route::get('package', 'Api\MainController@package');
  Route::get('slider', 'Api\MainController@slider');
  // Route::get('footer', 'Api\MainController@footer_details');
  Route::get('RecentMovies', 'Api\MainController@RecentMovies');
  Route::get('RecentTvSeries', 'Api\MainController@Recenttvseries');
  Route::get('MenuByCategory/{id}', 'Api\MainController@MovieByCategory');
  Route::get('episodes/{id}', 'Api\MainController@episodes');   
  
  Route::get('watchhistory', 'Api\MainController@watch_history');
  Route::get('addwatchhistory/{type}/{id}','Api\MainController@add_history');
  Route::get('delete_watchhistory','Api\MainController@watchistorydelete');
  Route::get('delete_watchhistory/{type}/{id}','Api\MainController@delete_history');  
  Route::get('checkwishlist/{type}/{id}', 'Api\MainController@check_wishlist');
  Route::get('showwishlist', 'Api\MainController@show_wishlist');
  Route::get('removemovie/{id}', 'Api\MainController@removemovie');
  Route::get('removeseason/{id}', 'Api\MainController@removeseason');
  Route::post('addwishlist', 'Api\MainController@add_wishlist');
  
  Route::post('rating', 'Api\RatingCommentController@rating');
  Route::get('checkrating/{type}/{id}', 'Api\RatingCommentController@checkrating');
  Route::post('addreply', 'Api\RatingCommentController@reply');

  Route::post('profileupdate', 'Api\MainController@updateprofile');

  Route::post('stripeprofile', 'Api\PaymentController@stripeprofile');
  Route::get('stripeupdate/{id}/{value}', 'Api\PaymentController@stripeupdate');
  Route::get('paypalupdate/{id}/{value}', 'Api\PaymentController@paypalupdate');
  Route::get('stripedetail', 'Api\PaymentController@stripedetail');
  Route::get('bttoken', 'Api\PaymentController@bttoken');
  Route::post('btpayment', 'Api\PaymentController@btpayment');
  Route::post('paystack', 'Api\PaymentController@paystack');
  Route::post('paystore', 'Api\PaymentController@pay_store');
  
  Route::get('showscreens', 'Api\MultipleScreenController@manageprofile');
  Route::post('changescreen', 'Api\MultipleScreenController@changescreen');
  Route::post('screenprofile', 'Api\MultipleScreenController@screenprofile');
  Route::post('updatescreen', 'Api\MultipleScreenController@newupdate');
  Route::post('downloadcounter', 'Api\MultipleScreenController@downloadcounter');
  
  Route::get('notifications', 'Api\NotificationController@allnotification');
  Route::get('readnotification/{id}', 'Api\NotificationController@notificationread');

});
