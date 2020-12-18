<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\User;
use DB;
use App\Season;
use App\Episode;
use Illuminate\Support\Carbon;
use Stripe\Stripe;

class WatchApiController extends Controller
{
	public function watch_trailer($user, $code, $id)
	{
		$data = DB::table('oauth_access_tokens')
            ->where('user_id', $user)
            ->where('revoked', 0)
            ->where('id', $code)->get();
		if (isset($data) && count($data)>0) {
			$movie = Movie::findorfail($id);
		 	return view('watch',compact('movie'));
		}
		else{			
      abort(404);
		}
	}

	public function watch_tv($user, $code, $id)
	{
		$data = DB::table('oauth_access_tokens')
            ->where('user_id', $user)
            ->where('revoked', 0)
            ->where('id', $code)->get();
    $user = $user;
		if (isset($data) && count($data)>0) {
			$season = Season::find($id);
			if(isset($season->episodes[0]) && $season->episodes[0]->video_link->iframeurl != null){
				$link = $season->episodes[0]->video_link->iframeurl;
				return view('iframe',compact('season','link'));
			}
			return view('watchTvShow',compact('season','user'));
		}
		else{			
      abort(404);
		}
	}

	public function watch_movie($user, $code, $id)
	{
		$data = DB::table('oauth_access_tokens')
            ->where('user_id', $user)
            ->where('revoked', 0)
            ->where('id', $code)->get();
    $user = $user;
		if (isset($data) && count($data)>0) {
			$movie = Movie::findorfail($id);
			if($movie->video_link->iframeurl != null){
				$link = $movie->video_link->iframeurl;
				return view('iframe',compact('movie','link'));
			}
			else{
				return view('watchMovie',compact('movie','user'));
			}
		}
	}

	public function watch_episode($user, $code, $id)
	{  
		$data = DB::table('oauth_access_tokens')
            ->where('user_id', $user)
            ->where('revoked', 0)
            ->where('id', $code)->get();
    $user = $user;
		if (isset($data) && count($data)>0) {
			$episode = Episode::find($id);
			$season  = Season::find($episode->seasons_id);
			if($episode->video_link->iframeurl != null){
				$link = $episode->video_link->iframeurl;
				return view('iframe',compact('season','link'));
			}
			return view('episodeplayer',compact('episode','season','user'));
		}
	}
}
