<?php
namespace App\Http\Controllers;

use App\HomeTranslation;
use App\HeaderTranslation;
use App\Actor;
use App\AudioLanguage;
use App\Director;
use App\PricingText;
use App\Genre;
use App\Config;
use App\Adsense;
use App\User;
use Illuminate\Support\Carbon;
use Auth;
use App\HomeSlider;
use Stripe\Customer;
use Stripe\Stripe;
use App\LandingPage;
use App\Menu;
use App\MenuVideo;
use App\PaypalSubscription;
use App\Movie;
use App\Package;
use App\Season;
use App\TvSeries;

use Notification;

use App\Notifications\MyNotification;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\FrontSliderUpdate;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }
    public function showall(Request $request, $menuid, $menuname)
    {

        $menu = Menu::findOrFail($menuid);

        $menu_items = $menu->menu_data;

        $menu_items = collect($menu_items)->sortByDesc('id');

        $items = collect();

        foreach ($menu_items as $value)
        {
            if ($value->movie_id != null)
            {

                $items->push(Movie::where('id',$value->movie_id)->where('status',1)->first());

            }
            else
            {

                $ts = TvSeries::where('id',$value->tv_series_id)->where('status',1)->first();
                if(isset($ts)){
                     $x = count($ts->seasons);

                    if ($x == 0)
                    {

                    }
                    else
                    {
                        $items->push($ts->seasons[0]);
                    }

                }
               
            }
        }

        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $itemCollection = collect($items);

        // Define how many items we want to be visible in each page
        $perPage = 30;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection) , $perPage);

        // set url path for generted links
        $paginatedItems->setPath($request->url());
        // return $paginatedItems;
        $ad = Adsense::first();

        return view('viewall', ['pusheditems' => $paginatedItems, 'menuu' => $menu, 'ad' => $ad]);

        // return view('viewall',compact('movies'));
        
    }

    public function showallsinglemovies()
    {

        $movies = Movie::orderBy('id', 'DESC')->where('status','=',1)->paginate(30);
        $ad = Adsense::first();
        return view('viewall2', compact('movies', 'ad'));

        // return view('viewall',compact('movies'));
        
    }

    public function showallsingletvseries(Request $request)
    {

        $items = collect();

        $all_tvseries = TvSeries::where('status','=',1)->get();

        foreach ($all_tvseries as $series)
        {

            $x = count($series->seasons);

            if ($x == 0)
            {

            }
            else
            {
                $items->push($series->seasons[0]);
            }

        }

        $items = collect($items)->sortByDesc('id');

        // Get current page form url e.x. &page=1
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        $itemCollection = collect($items);

        // Define how many items we want to be visible in each page
        $perPage = 30;

        // Slice the collection to get the items to display in current page
        $currentPageItems = $itemCollection->slice(($currentPage * $perPage) - $perPage, $perPage)->all();

        // Create our paginator and pass it to the view
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection) , $perPage);

        // set url path for generted links
        $movies = $paginatedItems->setPath($request->url());

        $ad = Adsense::first();
        return view('viewall2', compact('movies', 'ad'));
    }

    public function guestindex($menu_slug)
    {

        $sliderview = FrontSliderUpdate::all();

        $home_slides = HomeSlider::orderBy('position', 'asc')->get();

        $menu = Menu::whereSlug($menu_slug)->first();
        $withlogin = Config::findOrFail(1)->withlogin;
        //Slider get limit here and Front Slider order
        $catlog = Config::findOrFail(1)->catlog;
        $limit = FrontSliderUpdate::where('id', 1)->first();

        if (!isset($menu))
        {
            return redirect('/');
        }

        $movies = collect();
        $fil_movies = $menu->menu_data;
        if (count($fil_movies) > 0)
        {
            foreach ($fil_movies as $key => $value)
            {

                $movies->push($value->movie);

            }
        }

        $movies = $movies->flatten();
        $movies = $movies->filter(function ($value, $key)
        {
            return $value != null;
        });

        $tvserieses = array();
        // $tvserieses = collect();
        $fil_tvserieses = $menu->menu_data;

        //for desc order Movies
        $limit2 = FrontSliderUpdate::where('id', 2)->first();

        //for desc tvseries
        $limit3 = FrontSliderUpdate::where('id', 3)->first();

        if (count($fil_tvserieses) > 0)
        {

            foreach ($fil_tvserieses as $key => $value)
            {

                array_push($tvserieses, $value->tvseries);

            }
        }

        $tvserieses = array_values(array_filter($tvserieses));

        $genres = Genre::all();
        $a_languages = AudioLanguage::all();
        $all_mix = collect();

        if (count($movies))
        {
            $mCount = 0;
            foreach ($movies as $key => $value)
            {
                if ($mCount < $limit->item_show)
                {
                    $all_mix->push($value);
                    $mCount++;
                }
                else
                {
                    break;
                }

            }
        }
        // return $tvserieses;
        if (count($tvserieses) > 0)
        {
            $tCount = 0;
            foreach ($tvserieses as $value)
            {
                if ($value->type == 'T')
                {

                    if ($tCount < $limit->item_show)
                    {
                        $all_mix->push($value);
                        $tCount++;
                    }
                    else
                    {
                        break;
                    }

                }
            }
        }

        // Featured Movies Array
        $featured_movies = collect();
        if (count($movies) > 0)
        {
            foreach ($movies as $key => $movie)
            {
                if ($movie->featured == 1)
                {
                    $featured_movies->push($movie);
                }
            }
        }

        // Featured Tvserieses
        $featured_seasons = collect();
        if (count($tvserieses) > 0)
        {
            foreach ($tvserieses as $key => $series)
            {
                if ($series->featured == 1)
                {
                    $featured_seasons->push($series);
                }
            }
        }
        $featured_seasons = $featured_seasons->flatten()
            ->shuffle();

        $recent_added_movies = Movie::orderBy('id', 'desc')->get();
        $recent_added_seasons = Season::orderBy('id', 'desc')->get();
        $all_mix = $all_mix->shuffle();

        if ($limit2->orderby == 0)
        {
            $movies = $recent_added_movies;
        }

        if ($limit3->orderby == 0)
        {
            arsort($tvserieses);
        }

        //limit for first section
        $limitformix = FrontSliderUpdate::where('id', 1)->first();

        $all_mix = $all_mix->chunk($limitformix->item_show);

        if (count($all_mix) > 0)
        {
            $all_mix = $all_mix[0];
        }
        $menuh = Menu::all();
        $subscribed = null;

        $ad = Adsense::first();
        $age = 0;
        return view('home', compact('home_slides', 'recent_added_seasons', 'movies', 'tvserieses', 'ad', 'a_languages', 'all_mix', 'sliderview', 'recent_added_movies', 'age', 'genres', 'featured_movies', 'featured_seasons', 'menuh', 'catlog', 'withlogin', 'menu', 'subscribed'));
    }

    public function mainPage()
    {

        $plans = Package::all();
        $pricingTexts = PricingText::all();
        $blocks = LandingPage::orderBy('position', 'asc')->get();
        $catlog = Config::findOrFail(1)->catlog;
        $removelanding = Config::findOrFail(1)->remove_landing_page;
        $withlogin = Config::findOrFail(1)->withlogin;
        $menufirst = Menu::first();
        if ($removelanding == 1 && $catlog == 1)
        {
            if (isset($menufirst->slug))
            {
                return $this->index($menufirst->slug);
            }
            else
            {
                return view('auth.login');
            }

        }
        else if ($removelanding == 1 && $catlog == 0)
        {
            return view('auth.login');
        }
        else
        {
            if ($catlog == 1 && $withlogin == 0)
            {

                $menuh = Menu::all();
                return view('main', compact('pricingTexts', 'plans', 'blocks', 'menuh', 'catlog', 'withlogin'));
            }
            else if ($catlog == 1 && $withlogin == 1)
            {

                $menuh = Menu::all();
                return view('main', compact('pricingTexts', 'plans', 'blocks', 'menuh', 'catlog', 'withlogin'));
            }
            else
            {

                return view('main', compact('pricingTexts', 'plans', 'blocks', 'catlog', 'withlogin'));

            }
        }

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($menu_slug)
    {
        $auth = Auth::user();
        $subscribed = null;

        if (isset($auth))
        {
            $current_date = date("d/m/y");
            if ($auth->is_admin == 1)
            {
                $subscribed = 1;

            }
            else
            {
                if ($auth->stripe_id != null)
                {
                    $customer = Customer::retrieve($auth->stripe_id);
                }
                $paypal = $auth
                    ->paypal_subscriptions
                    ->sortBy('created_at');
                $plans = Package::all();
                $current_date = Carbon::now()->toDateString();
                if (isset($customer))
                {
                    //return $alldata = $user->asStripeCustomer()->subscriptions->data;
                    $alldata = $auth->subscriptions;
                    $data = $alldata->last();
                }
                if (isset($paypal) && $paypal != null && count($paypal) > 0)
                {
                    $last = $paypal->last();
                }
                $stripedate = isset($data) ? $data->created_at : null;
                $paydate = isset($last) ? $last->created_at : null;
                if ($stripedate > $paydate)
                {
                    if ($auth->subscribed($data->name))
                    {
                        $subscribed = 1;
                    }
                }
                elseif ($stripedate < $paydate)
                {
                    if (date($current_date) <= date($last->subscription_to))
                    {
                        $subscribed = 1;
                    }
                }
            }
        }

        $sliderview = FrontSliderUpdate::all();

        $home_slides = HomeSlider::orderBy('position', 'asc')->get();
        $subscribe = $menu = Menu::whereSlug($menu_slug)->first();
        $withlogin = Config::findOrFail(1)->withlogin;
        //Slider get limit here and Front Slider order
        $catlog = Config::findOrFail(1)->catlog;
        $limit = FrontSliderUpdate::where('id', 1)->first();

        if (!isset($menu))
        {
            return redirect('/');
        }

        $movies = collect();
        $fil_movies = $menu->menu_data;
        if (count($fil_movies) > 0)
        {
            foreach ($fil_movies as $key => $value)
            {

                $movies->push($value->movie);

            }
        }

        $movies = $movies->flatten();
        $movies = $movies->filter(function ($value, $key)
        {
            return $value != null;
        });

        $tvserieses = array();
        // $tvserieses = collect();
        $fil_tvserieses = $menu->menu_data;

        //for desc order Movies
        $limit2 = FrontSliderUpdate::where('id', 2)->first();

        //for desc tvseries
        $limit3 = FrontSliderUpdate::where('id', 3)->first();

        if (count($fil_tvserieses) > 0)
        {

            foreach ($fil_tvserieses as $key => $value)
            {

                array_push($tvserieses, $value->tvseries);

            }
        }

        $tvserieses = array_values(array_filter($tvserieses));

        $genres = Genre::all();
        $a_languages = AudioLanguage::all();
        $all_mix = collect();

        if (count($movies))
        {
            $mCount = 0;
            foreach ($movies as $key => $value)
            {
                if ($mCount < $limit->item_show)
                {
                    $all_mix->push($value);
                    $mCount++;
                }
                else
                {
                    break;
                }

            }
        }
        // return $tvserieses;
        if (count($tvserieses) > 0)
        {
            $tCount = 0;
            foreach ($tvserieses as $value)
            {
                if ($value->type == 'T')
                {

                    if ($tCount < $limit->item_show)
                    {
                        $all_mix->push($value);
                        $tCount++;
                    }
                    else
                    {
                        break;
                    }

                }
            }
        }

        // Featured Movies Array
        $featured_movies = collect();
        if (count($movies) > 0)
        {
            foreach ($movies as $key => $movie)
            {
                if ($movie->featured == 1)
                {
                    $featured_movies->push($movie);
                }
            }
        }

        // Featured Tvserieses
        $featured_seasons = collect();
        if (count($tvserieses) > 0)
        {
            foreach ($tvserieses as $key => $series)
            {
                if ($series->featured == 1)
                {
                    $featured_seasons->push($series);
                }
            }
        }
        $featured_seasons = $featured_seasons->flatten()
            ->shuffle();

        $recent_added_movies = Movie::orderBy('id', 'desc')->where('status','=',1)->get();
        $recent_added_seasons = Season::orderBy('id', 'desc')->get();
        $all_mix = $all_mix->shuffle();

        if ($limit2->orderby == 0)
        {
            $movies = $recent_added_movies;
        }

        if ($limit3->orderby == 0)
        {
            arsort($tvserieses);
        }

        //limit for first section
        $limitformix = FrontSliderUpdate::where('id', 1)->first();

        $all_mix = $all_mix->chunk($limitformix->item_show);

        if (count($all_mix) > 0)
        {
            $all_mix = $all_mix[0];
        }
        $menuh = Menu::all();

        $ad = Adsense::first();

        $age = 0;
        $config = Config::first();
        if ($config->age_restriction == 1)
        {
            if (Auth::user())
            {
                # code...
                $user_id = Auth::user()->id;
                $user = User::findOrfail($user_id);
                $age = $user->age;
            }
            else
            {
                $age = 100;
            }
        }
        return view('home', compact('home_slides', 'recent_added_seasons', 'movies', 'tvserieses', 'ad', 'a_languages', 'all_mix', 'sliderview', 'recent_added_movies', 'age', 'genres', 'featured_movies', 'featured_seasons', 'menuh', 'catlog', 'withlogin', 'menu', 'subscribed'));
    }

    public function search(Request $searchKey)
    {

        $auth = Auth::user();
        $userid = $auth->id;

        if ($auth->is_admin)
        {
            $nav = Menu::all();
            foreach ($nav as $key => $value)
            {
                $menus[] = $value->id;
            }

        }
        else
        {
            $packageid = PaypalSubscription::select('package_id')->where('user_id', $auth->id)
                ->get();
                if(isset($packageid) && count($packageid)>0)
                {
                    foreach ($packageid as $package)
                    {
                        $packagename = Package::select('plan_id')->where('id', $package->package_id)
                            ->get();
                    }
                }
                if(isset($packagename) && count($packagename)>0)
                {
                    foreach ($packagename as $pn)
                    {
                        $planmenus = DB::table('package_menu')->where('package_id', $pn->plan_id)
                            ->get();

                    }
                }
                if(isset($planmenus) && count($planmenus)>0)
                {
                    foreach ($planmenus as $key => $value)
                    {
                        $menus[] = $value->menu_id;
                    }
                }
           
        }

        $all_movies = Movie::all();
        $all_tvseries = TvSeries::all();
        $searchKey = $searchKey->search;

        $tvseries = TvSeries::where('title', 'LIKE', "%$searchKey%")->where('status',1)->get();
        $filter_video = collect();

        $tvseries = TvSeries::where('title', 'LIKE', "%$searchKey%")->where('status',1)->get();

        foreach ($tvseries as $series)
        {
            $menuid = MenuVideo::where('tv_series_id', $series->id)
                ->get();

            if(isset($menus) && count($menus)>0)
            {
                foreach ($menuid as $key => $value)
                {
                    for ($i = 0;$i < sizeof($menus);$i++)
                    {
                        if ($value->menu_id == $menus[$i])
                        {
                            $season = Season::where('tv_series_id', $series->id)
                                ->get();
                            if (isset($season))
                            {
                                $filter_video->push($season[0]);
                            }
                        }
                    }

                }
            }
            else
            {
                $season = Season::where('tv_series_id', $series->id)->get();
                if (isset($season))
                {
                    $filter_video->push($season[0]);
                }
            }
            

        }

        $movies = Movie::where('title', 'LIKE', "%$searchKey%")->where('status','=',1)->get();

        if (isset($movies) && count($movies) > 0)
        {
            foreach ($movies as $key => $movie)
            {
                $menuid = MenuVideo::where('movie_id', $movie->id)
                    ->get();
                if(isset($menus) && count($menus)>0)
                {
                   foreach ($menuid as $key => $value)
                    {
                        for ($i = 0;$i < sizeof($menus);$i++)
                        {
                            if ($value->menu_id == $menus[$i])
                            {
                                $filter_video->push($movies);
                            }
                        }

                    } 
                }
                else
                {
                    $filter_video->push($movies);
                }
                
            }

        }

        // if search key is actor
        $actor = Actor::where('name', 'LIKE', "%$searchKey%")->first();
        if (isset($actor) && $actor != null)
        {
            foreach ($all_movies as $key => $item)
            {
                if ($item->actor_id != null && $item->actor_id != '')
                {
                    $movie_actor_list = explode(',', $item->actor_id);
                    for ($i = 0;$i < count($movie_actor_list);$i++)
                    {
                        $check = DB::table('actors')->where('id', '=', trim($movie_actor_list[$i]))->get();
                        if (isset($check[0]) && $check[0]->name == $actor->name)
                        {
                            $filter_video->push($item);
                        }
                    }
                }
            }
            foreach ($all_tvseries as $key => $tv)
            {
                foreach ($tv->seasons as $key => $item)
                {
                    if ($item->actor_id != null && $item->actor_id != '')
                    {
                        $season_actor_list = explode(',', $item->actor_id);
                        for ($i = 0;$i < count($season_actor_list);$i++)
                        {
                            $check = DB::table('actors')->where('id', '=', trim($season_actor_list[$i]))->get();
                            if (isset($check[0]) && $check[0]->name == $actor->name)
                            {
                                $filter_video->push($item);
                            }
                        }
                    }
                }
            }
        }

        // if search key is director
        $director = Director::where('name', 'LIKE', "%$searchKey%")->first();
        if (isset($director) && $director != null)
        {
            foreach ($all_movies as $key => $item)
            {
                if ($item->director_id != null && $item->director_id != '')
                {
                    $movie_director_list = explode(',', $item->director_id);
                    for ($i = 0;$i < count($movie_director_list);$i++)
                    {
                        $check = DB::table('directors')->where('id', '=', trim($movie_director_list[$i]))->get();
                        if (isset($check[0]) && $check[0]->name == $director->name)
                        {
                            $filter_video->push($item);
                        }
                    }
                }
            }
        }

        // if search key is genre
        $all_genres = Genre::all();
        if (isset($all_genres) && count($all_genres) > 0)
        {
            foreach ($all_genres as $key => $value)
            {
                if (trim($value->name) == trim($searchKey))
                {
                    $genre = $value;
                }
            }
        }

        if (isset($genre) && $genre != null)
        {
            foreach ($all_movies as $key => $item)
            {
                if ($item->genre_id != null && $item->genre_id != '')
                {
                    $movie_genre_list = explode(',', $item->genre_id);
                    for ($i = 0;$i < count($movie_genre_list);$i++)
                    {
                        $check = Genre::where('id', '=', trim($movie_genre_list[$i]))->get();
                        if (isset($check[0]) && $check[0]->name == $genre->name)
                        {
                            $filter_video->push($item);
                        }
                    }
                }
            }

            foreach ($all_tvseries as $key => $item)
            {
                if ($item->genre_id != null && $item->genre_id != '')
                {
                    $tv_genre_list = explode(',', $item->genre_id);
                    for ($i = 0;$i < count($tv_genre_list);$i++)
                    {
                        $check = Genre::where('id', '=', trim($tv_genre_list[$i]))->get();
                        if (isset($check[0]) && $check[0]->name == $actor->name)
                        {
                            $filter_video->push($item);
                        }
                    }
                }
            }
        }

        $filter_video = $filter_video->flatten();

        return view('search', compact('filter_video', 'searchKey'));
    }

    public function director_search($director_search)
    {
        $filter_video = collect();
        $all_movies = Movie::all();
        $tvseries = TvSeries::all();
        $searchKey = $director_search;
        $director = Director::where('name', 'LIKE', "%$director_search%")->first();

        if ($searchKey != null || $searchKey != '')
        {
            foreach ($all_movies as $item)
            {
                if ($item->director_id != null && $item->director_id != '')
                {
                    $movie_director_list = explode(',', $item->director_id);
                    for ($i = 0;$i < count($movie_director_list);$i++)
                    {
                        $check = DB::table('directors')->where('id', '=', trim($movie_director_list[$i]))->get();
                        if (isset($check[0]) && $check[0]->name == $director->name)
                        {
                            $filter_video->push($item);
                        }
                    }
                }
            }
        }

        $filter_video = $filter_video->filter(function ($value, $key)
        {
            return $value != null;
        });

        $filter_video = $filter_video->flatten();
        return view('search', compact('filter_video', 'searchKey'));
    }

    public function actor_search($actor_search)
    {
        $filter_video = collect();
        $all_movies = Movie::all();
        $tvseries = TvSeries::all();
        $searchKey = $actor_search;
        $actor = Actor::where('name', 'LIKE', "%$actor_search%")->first();

        if ($searchKey != null || $searchKey != '')
        {
            foreach ($all_movies as $item)
            {
                if ($item->actor_id != null && $item->actor_id != '')
                {
                    $movie_actor_list = explode(',', $item->actor_id);
                    for ($i = 0;$i < count($movie_actor_list);$i++)
                    {
                        $check = DB::table('actors')->where('id', '=', trim($movie_actor_list[$i]))->get();
                        if (isset($check[0]) && $check[0]->name == $actor->name)
                        {
                            $filter_video->push($item);
                        }
                    }
                }
            }
            if (isset($tvseries) && count($tvseries) > 0)
            {
                foreach ($tvseries as $series)
                {
                    if (isset($series->seasons) && count($series->seasons) > 0)
                    {
                        foreach ($series->seasons as $item)
                        {
                            if ($item->actor_id != null && $item->actor_id != '')
                            {
                                $season_actor_list = explode(',', $item->actor_id);
                                for ($i = 0;$i < count($season_actor_list);$i++)
                                {
                                    $check = DB::table('actors')->where('id', '=', trim($season_actor_list[$i]))->get();
                                    if (isset($check[0]) && $check[0]->name == $actor->name)
                                    {
                                        $filter_video->push($item);
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

        $filter_video = $filter_video->filter(function ($value, $key)
        {
            return $value != null;
        });

        $filter_video = $filter_video->flatten();
        return view('search', compact('filter_video', 'searchKey', 'actor'));
    }

    public function genre_search($genre_search)
    {
        $all_genres = Genre::all();
        $all_movies = Movie::all();
        $all_tvseries = TvSeries::all();
        $filter_video = collect();

        if (isset($all_genres) && count($all_genres) > 0)
        {
            foreach ($all_genres as $key => $value)
            {
                if (trim($value->name) == trim($genre_search))
                {
                    $genre = $value;
                }
            }
        }

        $searchKey = $genre_search;
        if ($genre != null)
        {
            foreach ($all_movies as $item)
            {
                if ($item->genre_id != null && $item->genre_id != '')
                {
                    $movie_genre_list = explode(',', $item->genre_id);
                    for ($i = 0;$i < count($movie_genre_list);$i++)
                    {
                        $check = Genre::where('id', '=', trim($movie_genre_list[$i]))->get();
                        if (isset($check[0]) && $check[0]->name == $genre->name)
                        {
                            $filter_video->push($item);
                        }
                    }
                }
            }

            if (isset($all_tvseries) && count($all_tvseries) > 0)
            {
                foreach ($all_tvseries as $series)
                {
                    if (isset($series->seasons) && count($series->seasons) > 0)
                    {
                        if ($series->genre_id != null && $series->genre_id != '')
                        {
                            $tvseries_genre_list = explode(',', $series->genre_id);
                            for ($i = 0;$i < count($tvseries_genre_list);$i++)
                            {
                                $check = Genre::where('id', '=', trim($tvseries_genre_list[$i]))->get();
                                if (isset($check[0]) && $check[0]->name == $genre->name)
                                {
                                    $filter_video->push($series->seasons);
                                }
                            }
                        }
                    }
                }
            }
        }

        $filter_video = $filter_video->filter(function ($value, $key)
        {
            return $value != null;
        });

        $filter_video = $filter_video->flatten();

        return view('search', compact('filter_video', 'searchKey'));
    }

    public function movie_genre($id)
    {
        $all_movies = Movie::all();
        $movies = collect();
        $genre = Genre::find($id);
        $searchKey = $genre->name;
        foreach ($all_movies as $item)
        {
            if ($item->imdb != 'Y')
            {
                if ($item->genre_id != null && $item->genre_id != '')
                {
                    $movie_genre_list = explode(',', $item->genre_id);
                    for ($i = 0;$i < count($movie_genre_list);$i++)
                    {
                        $check = Genre::find(trim($movie_genre_list[$i]));
                        if (isset($check) && $check->id == $genre->id)
                        {
                            $movies->push($item);
                        }
                    }
                }
            }
            else
            {
                if ($item->genre_id != null && $item->genre_id != '')
                {
                    $movie_genre_list = explode(',', $item->genre_id);
                    for ($i = 0;$i < count($movie_genre_list);$i++)
                    {
                        $check = Genre::where('id', '=', trim($movie_genre_list[$i]))->get();
                        if (isset($check[0]) && $check[0]->name == $genre->name)
                        {
                            $movies->push($item);
                        }
                    }
                }
            }
        }

        $filter_video = $movies;

        return view('search', compact('filter_video', 'searchKey'));
    }

    public function tvseries_genre($id)
    {
        $all_tvseries = TvSeries::all();
        $genre = Genre::find($id);
        $searchKey = $genre->name;
        $seasons = collect();
        foreach ($all_tvseries as $item)
        {
            if ($item->imdb != 'Y')
            {
                if ($item->genre_id != null && $item->genre_id != '')
                {
                    $tvseries_genre_list = explode(',', $item->genre_id);
                    for ($i = 0;$i < count($tvseries_genre_list);$i++)
                    {
                        $check = Genre::find(trim($tvseries_genre_list[$i]));
                        if (isset($check) && $check->id == $genre->id)
                        {
                            $seasons->push($item->seasons);
                        }
                    }
                }
            }
            else
            {
                if ($item->genre_id != null && $item->genre_id != '')
                {
                    $tvseries_genre_list = explode(',', $item->genre_id);
                    for ($i = 0;$i < count($tvseries_genre_list);$i++)
                    {
                        $check = Genre::where('id', '=', trim($tvseries_genre_list[$i]))->get();
                        if (isset($check[0]) && $check[0]->name == $genre->name)
                        {
                            $seasons->push($item->seasons);
                        }
                    }
                }
            }
        }

        $filter_video = $seasons->shuffle()
            ->flatten();
        return view('search', compact('filter_video', 'searchKey'));
    }

    public function movie_language($language_id)
    {
        $lang = AudioLanguage::findOrFail($language_id);
        $searchKey = $lang->language;
        $all_movies = Movie::all();
        $filter_video = collect();
        foreach ($all_movies as $item)
        {
            if ($item->a_language != null && $item->a_language != '')
            {
                $movie_lang_list = explode(',', $item->a_language);
                for ($i = 0;$i < count($movie_lang_list);$i++)
                {
                    $check = \App\Genre::find(trim($movie_lang_list[$i]));
                    if (isset($check) && $check->id == $lang->id)
                    {
                        $filter_video->push($item);
                    }
                }
            }
        }

        return view('search', compact('filter_video', 'searchKey'));
    }

    public function tvseries_language($language_id)
    {
        $lang = AudioLanguage::findOrFail($language_id);
        $searchKey = $lang->language;
        $all_seasons = Season::all();
        $filter_video = collect();
        foreach ($all_seasons as $item)
        {
            if ($item->a_language != null && $item->a_language != '')
            {
                $season_lang_list = explode(',', $item->a_language);
                for ($i = 0;$i < count($season_lang_list);$i++)
                {
                    $check = \App\Genre::find(trim($season_lang_list[$i]));
                    if (isset($check) && $check->id == $lang->id)
                    {
                        $filter_video->push($item);
                    }
                }
            }
        }

        return view('search', compact('filter_video', 'searchKey'));
    }

}

