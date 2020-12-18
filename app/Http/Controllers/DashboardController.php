<?php

namespace App\Http\Controllers;
use Charts;
use DB;
use App\CouponCode;
use App\Faq;
use App\Genre;
use App\Movie;
use App\Package;
use App\TvSeries;
use App\User;
use App\PaypalSubscription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard()
    {
    	$users_count = User::count();
    	$movies_count = Movie::count();
    	$tvseries_count = TvSeries::count();
    	$genres_count = Genre::count();	
    	$package_count = Package::where('status',1)->where('delete_status',1)->count();
    	$coupon_count = CouponCode::count();
    	$faq_count = Faq::count();
        $activeusers = PaypalSubscription::where('status','=','1')->count();
        $totalrevnue = PaypalSubscription::sum('price');
        $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))->get();
        $activesubsriber = PaypalSubscription::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))->where('status','1')->get();
        $chart = Charts::database($users, 'bar', 'highcharts')

                  ->title("Monthly new Registered Users")

                  ->elementLabel("Total Users")

                  ->dimensions(1000, 500)

                  ->responsive(true)

                  ->groupByMonth(date('Y'), true);

        $chart2 = Charts::database($activesubsriber, 'line', 'highcharts')

                  ->title("Monthly Active Subscribers")

                  ->elementLabel("Total Active Plan Users")

                  ->dimensions(1000, 500)

                  ->responsive(true)

                  ->groupByMonth(date('Y'), true);

        // $sales_chart = new SalesChart;
        // $sales_chart->labels(['One', 'Two', 'Three', 'Four', 'Five'])->dataset('Sample', 'line', [[100, 65, 84, 45, 90],'point' => ['pointStyle' => 'line']])->options(['borderColor' => '#111', 'borderWidth' => '2px', 'backgroundColor' => 'rgba(255,82,82,0.7)']);

        // $visitors_chart = new VisitorsChart;
        // $visitors_chart->labels(['One', 'Two', 'Three', 'Four', 'Five', 'six', 'ss'])->dataset('Sample', 'line', [0, 65, 84, 45, 90, 10])->options(['borderColor' => '#111', 'borderWidth' => '2px', 'backgroundColor' => 'rgba(255,82,82,0.7)']);

    	return view('admin.index', compact('genres_count','users_count', 'movies_count', 'tvseries_count', 'package_count', 'coupon_count', 'faq_count','activeusers','totalrevnue','chart','chart2'));
    }
}
