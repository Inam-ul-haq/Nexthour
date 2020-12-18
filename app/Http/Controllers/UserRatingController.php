<?php

namespace App\Http\Controllers;

use App\Actor;
use App\UserRating;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserRatingController extends Controller
{
   
    public function store(Request $request)
    {
      
        $input = $request->all();
           $uid=Auth::user()->id;
           $rating=UserRating::where('user_id',$uid)->
                where('movie_id',$request->movie_id)->delete();
            UserRating::create($input);
      return 1;
           
    }

    public function tvstore(Request $request)
    {
      
        $input = $request->all();
           $uid=Auth::user()->id;
     
            $rating=UserRating::where('user_id',$uid)->
                where('tv_id',$request->tv_id)->delete();
           UserRating::create($input);
           return 1;
             
    }

 

 

}
