<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\Season;
use App\WatchHistory;
use App\Episode;
use App\Menu;
use App\TvSeries;
use Auth;
use Illuminate\Pagination\LengthAwarePaginator;


class WatchController extends Controller
{
    public function watch($id)
    {
    	$movie = Movie::findorfail($id);
    	return view('watch',compact('movie'));
    }

    public function watchTV($id)
    {
    	$season = Season::find($id);
        
    	return view('watchTvShow',compact('season'));
    }

    public function watchMovie($id)
    {
        $movie = Movie::findorfail($id);
        return view('watchMovie',compact('movie'));
    }

    public function watchEpisode($id)
    {  
        $episode = Episode::find($id);
        $season  = Season::find($episode->seasons_id);
        return view('episodeplayer',compact('episode','season'));
    }



    public function watchhistory(){
     
         $auth=Auth::user()->id;
        $watchistory=WatchHistory::where('user_id',$auth)->get();
        $items = collect();

        foreach ($watchistory as $value) {
            if ($value->movie_id != '') {

                $items->push(Movie::find($value->movie_id));

            } else {

                $ts = TvSeries::find($value->tv_id);

                if(isset($ts)){
                    $x = count($ts->seasons);

                    if ($x == 0) {

                    } else {
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
        $paginatedItems = new LengthAwarePaginator($currentPageItems, count($itemCollection), $perPage);

        // set url path for generted links
        // $paginatedItems->setPath($request->url());
        // return $paginatedItems;
       
         $menu = Menu::first();

         
        return view('watchhistory', ['pusheditems' => $paginatedItems, 'menuu' => $menu]);
       
     
    
    }

    public function watchistorydelete(){

        $auth=Auth::user()->id;
        $history=WatchHistory::where('user_id',$auth)->delete();
        return redirect('/')->with('updated','Your Watch History Has Been Deleted');

    }
        public function showdestroy($id)
    {
       
        $auth=Auth::user()->id;
          $show = WatchHistory::where('tv_id', $id)->where('user_id',$auth)->first();
          $show->delete();
          return back();
    }

    public function moviedestroy($id)
    {
        $auth=Auth::user()->id;
          $movie = WatchHistory::where('movie_id', $id)->where('user_id',$auth)->first();
          $movie->delete();
          return back();
    }
}
