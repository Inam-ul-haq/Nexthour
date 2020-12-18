<?php

namespace App\Http\Middleware;

use App\Package;
use App\Config;
use App;
use Session;

use Closure;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Stripe\Customer;
use Stripe\Stripe;
use App\Menu;

use App\HomeTranslation;
use App\Actor;
use App\AudioLanguage;
use App\Director;
use App\PricingText;
use App\Genre;

use App\HomeSlider;
use App\LandingPage;

use App\MenuVideo;
use App\PaypalSubscription;
use App\Movie;

use App\Season;
use App\TvSeries;
use Illuminate\Http\Response;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\FrontSliderUpdate;
use Illuminate\Pagination\LengthAwarePaginator;

class IsSubscription
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
		$current_date = Carbon::now()->toDateString();
		Stripe::setApiKey(env('STRIPE_SECRET'));
		 App::setLocale(Session::get('changed_language'));
		if (Auth::check()) {			
			$auth = Auth::user();
			$catlog= Config::findOrFail(1)->catlog;
			$withlogin= Config::findOrFail(1)->withlogin;          
			if ($auth->is_admin == 1) {
				return $next($request);                
			}
			elseif($catlog==0){
			 
				if ($auth->stripe_id != null) {
					$customer = Customer::retrieve($auth->stripe_id);
				}
				$paypal = $auth->paypal_subscriptions->sortBy('created_at'); 
				if (isset($customer)) {         
					$alldata = $auth->subscriptions;
					$data = $alldata->last();      
				} 
				if (isset($paypal) && $paypal != null && count($paypal)>0) {
					$last = $paypal->last();
				} 
				$stripedate = isset($data) ? $data->created_at : null;
				$paydate = isset($last) ? $last->created_at : null;
				if($stripedate > $paydate){
					if($auth->subscribed($data->name) && date($current_date) <= date($data->subscription_to)){
						if($data->ends_at == null || $request->is('resumesubscription/*')){
							return $next($request);  
						}
						else{
							return redirect('/')->with('deleted', 'Please resume your subscription!');
						}                       
					} else {
						return redirect('/')->with('deleted', 'Your subscription has been expired!');
					}
				}
				elseif($stripedate < $paydate){
					if (date($current_date) <= date($last->subscription_to)){
						if($last->status == 1) {
							return $next($request);    
						}
						else{
							return redirect('/')->with('deleted', 'Please resume your subscription!');
						}                    
					} else {
						$last->status = 0;
						$last->save();
						return redirect('/')->with('deleted', 'Your subscription has been expired!');
					}
				}
				else{
					return redirect('account/purchaseplan')->with('deleted', 'You have no subscription please subscribe');

				}
			}
			else{
			 $navmenh = $request->route()->parameter('menu');
			 if (isset($navmenh)) {
				 # code...
			 
			 	$sliderview = FrontSliderUpdate::all();
				$home_slides = HomeSlider::orderBy('position', 'asc')->get();
				$menu= Menu::whereSlug($navmenh)->first();
			 	$withlogin= Config::findOrFail(1)->withlogin;
					//Slider get limit here and Front Slider order
		   	$catlog= Config::findOrFail(1)->catlog;
				$limit = FrontSliderUpdate::where('id', 1)->first();

				if (!isset($menu)) {
					return redirect('/');
				}

				$movies = collect();
				$fil_movies = $menu->menu_data;
				if (count($fil_movies) > 0) {
					foreach ($fil_movies as $key => $value) {
						$movies->push($value->movie);
					}
				}

				$movies = $movies->flatten();
				$movies = $movies->filter(function ($value, $key) {
					return $value != null;
				});

				$tvserieses = array();
				// $tvserieses = collect();
				$fil_tvserieses = $menu->menu_data;


				//for desc order Movies

				$limit2 = FrontSliderUpdate::where('id', 2)->first();


				//for desc tvseries

				$limit3 = FrontSliderUpdate::where('id', 3)->first();


				if (count($fil_tvserieses) > 0) {

					foreach ($fil_tvserieses as $key => $value) {

						array_push($tvserieses, $value->tvseries);

					}
				}


				$tvserieses = array_values(array_filter($tvserieses));


				$genres = Genre::all();
				$a_languages = AudioLanguage::all();
				$all_mix = collect();

				if (count($movies)) {
					$mCount = 0;
					foreach ($movies as $key => $value) {
						if ($mCount < $limit->item_show) {
							$all_mix->push($value);
							$mCount++;
						} else {
							break;
						}

					}
				}
				// return $tvserieses;
				if (count($tvserieses) > 0) {
					$tCount = 0;
					foreach ($tvserieses as $value) {
						if ($value->type == 'T') {


							if ($tCount < $limit->item_show) {
								$all_mix->push($value);
								$tCount++;
							} else {
								break;
							}


						}
					}
				}


				// Featured Movies Array
				$featured_movies = collect();
				if (count($movies) > 0) {
					foreach ($movies as $key => $movie) {
						if ($movie->featured == 1) {
							$featured_movies->push($movie);
						}
					}
				}

				// Featured Tvserieses
				$featured_seasons = collect();
				if (count($tvserieses) > 0) {
					foreach ($tvserieses as $key => $series) {
						if ($series->featured == 1) {
							$featured_seasons->push($series);
						}
					}
				}
				$featured_seasons = $featured_seasons->flatten()->shuffle();

				$recent_added_movies = Movie::orderBy('id', 'desc')->get();
				$recent_added_seasons = Season::orderBy('id', 'desc')->get();
				$all_mix = $all_mix->shuffle();


				if ($limit2->orderby == 0) {
					$movies = $recent_added_movies;
				}

				if ($limit3->orderby == 0) {
					arsort($tvserieses);
				}

				//limit for first section

				$limitformix = FrontSliderUpdate::where('id', 1)->first();

				$all_mix = $all_mix->chunk($limitformix->item_show);

				if (count($all_mix) > 0) {
					$all_mix = $all_mix[0];
				}
		 $menuh=Menu::all();
		 $auth=Auth::user();
		 $subscribed = null;
				   
			if (isset($auth)) {
			   if ($auth->is_admin == 1) {
				$subscribed = 1;
				  
			  }
			  else{
					if ($auth->stripe_id != null) {
		        $customer = Customer::retrieve($auth->stripe_id);
		      }
		      $paypal = $auth->paypal_subscriptions->sortBy('created_at'); 
		      $plans = Package::all();
		      if (isset($customer)) {         
		       //return $alldata = $user->asStripeCustomer()->subscriptions->data;
			       $alldata = $auth->subscriptions;
			       $data = $alldata->last();      
		      } 
		      if (isset($paypal) && $paypal != null && count($paypal)>0) {
		        $last = $paypal->last();
		      } 
		      $stripedate = isset($data) ? $data->created_at : null;
		      $paydate = isset($last) ? $last->created_at : null;
		      if($stripedate > $paydate){
		        if($auth->subscribed($data->name)){
		          $subscribed= 1;
		        }
		      }
		      elseif($stripedate < $paydate){
		        if (date($current_date) <= date($last->subscription_to)) {
		          $subscribed= 1;
		        }
		      } 
			  }
		  }
		   
			 return  Response(view('home', compact('home_slides', 'recent_added_seasons',
			'movies', 'tvserieses', 'a_languages', 'all_mix', 'sliderview', 'recent_added_movies',
			'genres', 'featured_movies', 'featured_seasons', 'menuh','catlog','withlogin','subscribed','menu')));
	   }

		}
	   return $next($request);
		   
		} else {
			 $withlogin= Config::findOrFail(1)->withlogin;

			if ($withlogin==1) {
				 $navmenh = $request->route()->parameter('menu');
 if (isset($navmenh)) {
	 # code...
 
 $sliderview = FrontSliderUpdate::all();

		$home_slides = HomeSlider::orderBy('position', 'asc')->get();

		$menu= Menu::whereSlug($navmenh)->first();
 $withlogin= Config::findOrFail(1)->withlogin;
		//Slider get limit here and Front Slider order
   $catlog= Config::findOrFail(1)->catlog;
		$limit = FrontSliderUpdate::where('id', 1)->first();

		if (!isset($menu)) {

			return redirect('/');
		}

		$movies = collect();
		$fil_movies = $menu->menu_data;
		if (count($fil_movies) > 0) {
			foreach ($fil_movies as $key => $value) {


				$movies->push($value->movie);


			}
		}

		$movies = $movies->flatten();
		$movies = $movies->filter(function ($value, $key) {
			return $value != null;
		});

		$tvserieses = array();
		// $tvserieses = collect();
		$fil_tvserieses = $menu->menu_data;


		//for desc order Movies

		$limit2 = FrontSliderUpdate::where('id', 2)->first();


		//for desc tvseries

		$limit3 = FrontSliderUpdate::where('id', 3)->first();


		if (count($fil_tvserieses) > 0) {

			foreach ($fil_tvserieses as $key => $value) {

				array_push($tvserieses, $value->tvseries);

			}
		}


		$tvserieses = array_values(array_filter($tvserieses));


		$genres = Genre::all();
		$a_languages = AudioLanguage::all();
		$all_mix = collect();

		if (count($movies)) {
			$mCount = 0;
			foreach ($movies as $key => $value) {
				if ($mCount < $limit->item_show) {
					$all_mix->push($value);
					$mCount++;
				} else {
					break;
				}

			}
		}
		// return $tvserieses;
		if (count($tvserieses) > 0) {
			$tCount = 0;
			foreach ($tvserieses as $value) {
				if ($value->type == 'T') {


					if ($tCount < $limit->item_show) {
						$all_mix->push($value);
						$tCount++;
					} else {
						break;
					}


				}
			}
		}


		// Featured Movies Array
		$featured_movies = collect();
		if (count($movies) > 0) {
			foreach ($movies as $key => $movie) {
				if ($movie->featured == 1) {
					$featured_movies->push($movie);
				}
			}
		}

		// Featured Tvserieses
		$featured_seasons = collect();
		if (count($tvserieses) > 0) {
			foreach ($tvserieses as $key => $series) {
				if ($series->featured == 1) {
					$featured_seasons->push($series);
				}
			}
		}
		$featured_seasons = $featured_seasons->flatten()->shuffle();

		$recent_added_movies = Movie::orderBy('id', 'desc')->get();
		$recent_added_seasons = Season::orderBy('id', 'desc')->get();
		$all_mix = $all_mix->shuffle();


		if ($limit2->orderby == 0) {
			$movies = $recent_added_movies;
		}

		if ($limit3->orderby == 0) {
			arsort($tvserieses);
		}

		//limit for first section

		$limitformix = FrontSliderUpdate::where('id', 1)->first();

		$all_mix = $all_mix->chunk($limitformix->item_show);

		if (count($all_mix) > 0) {
			$all_mix = $all_mix[0];
		}
 $menuh=Menu::all();
 $auth=Auth::user();
		 $subscribed = null;
				   
			if (isset($auth)) {
				  
			  $auth = Auth::user();
			   if ($auth->is_admin == 1) {
				$subscribed = 1;
				  
			  }
			  else{
					if ($auth->stripe_id != null) {
		        $customer = Customer::retrieve($auth->stripe_id);
		      }
		      $paypal = $auth->paypal_subscriptions->sortBy('created_at'); 
		      $plans = Package::all();
		      if (isset($customer)) {         
		       //return $alldata = $user->asStripeCustomer()->subscriptions->data;
			       $alldata = $auth->subscriptions;
			       $data = $alldata->last();      
		      } 
		      if (isset($paypal) && $paypal != null && count($paypal)>0) {
		        $last = $paypal->last();
		      } 
		      $stripedate = isset($data) ? $data->created_at : null;
		      $paydate = isset($last) ? $last->created_at : null;
		      if($stripedate > $paydate){
		        if($auth->subscribed($data->name)){
		          $subscribed= 1;
		        }
		      }
		      elseif($stripedate < $paydate){
		        if (date($current_date) <= date($last->subscription_to)) {
		          $subscribed= 1;
		        }
		      } 
			  }
		  }
			   
			 return  Response(view('home', compact('home_slides', 'recent_added_seasons',
			'movies', 'tvserieses', 'a_languages', 'all_mix', 'sliderview', 'recent_added_movies',
			'genres', 'featured_movies', 'featured_seasons', 'menuh','catlog','withlogin','subscribed','menu')));
	   }
			}else{
			   
			   return redirect('login')->with('updated', 'Please login first!');
			}
		  

		}
	}
}
