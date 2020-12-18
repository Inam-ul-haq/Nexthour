<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use DB;
use App\MovieComment;
use App\MovieSubcomment;
use App\Comment;
use App\Subcomment;
use App\UserRating;
use App\Movie;
use App\TvSeries;
use App\Blog;

class RatingCommentController extends Controller
{ 
  public function checkrating($type,$id)
  {      
    $uid = Auth::user()->id;
    if($type == 'M'){
      $exists = UserRating::where('user_id',$uid)->
          where('movie_id',$id)->first();
    }
    elseif($type == 'T'){
      $exists = UserRating::where('user_id',$uid)->
          where('tv_id',$id)->first();
    }
    if(isset($exists)){
      return response()->json(array($exists->rating), 200); 
    }
    else{
      return response()->json(array('0'), 401);  
    }
  }
  public function rating(Request $request)
  {      
    $input = $request->all();
    $uid = Auth::user()->id;
    if($request->type == 'M'){
      $exists = UserRating::where('user_id',$uid)->
          where('movie_id',$request->id)->delete();
      $movie = Movie::find($request->id);
      if($movie){
          $rating = UserRating::create([
            'user_id' => $uid,
            'movie_id' => $request->id,
            'rating' => $request->rating
          ]);
      }
    }
    elseif($request->type == 'T'){
      $exists = UserRating::where('user_id',$uid)->
          where('tv_id',$request->id)->delete();
      $tv = TvSeries::find($request->id);
      if($tv){
          $rating = UserRating::create([
            'user_id' => $uid,
            'tv_id' => $request->id,
            'rating' => $request->rating
          ]);
      }
    }
    if(isset($rating)){
      return response()->json(array('1'), 200); 
    }
    else{
      return response()->json(array('error'), 401);  
    }
  }
  
  public function comment_store(Request $request)
  {
    $user = Auth::user();
    if(!isset($user)){
      $request->validate([
        'name' => 'required',  
        'email' =>'required',   
        'comment' => 'required',      
      ]);
    }
    else{
      $request->validate([
        'comment' => 'required',      
      ]);
    }

    $name = isset($request->name) && $request->name != null ? $request->name : $user->name; 
    $email = isset($request->email) && $request->email != null ? $request->email : $user->email; 
    if($request->type == 'B'){
       $blog = Blog::find($request->id);
        if($blog){
            $data = Comment::create([
            'name' => $name,
            'email' => $email,
            'blog_id' => $request->id,
            'comment' => $request->comment   
          ]);
        }
    }
    elseif($request->type == 'M'){
      $movie = Movie::find($request->id);
      if($movie){
          $data = MovieComment::create([
            'name' => $name,
            'email' => $email,
            'movie_id' => $request->id,
            'comment' => $request->comment   
          ]);
      }
    }    
    elseif($request->type == 'T'){
        $tv = TvSeries::find($request->id);
        if($tv){
          $data = MovieComment::create([
            'name' => $name,
            'email' => $email,
            'tv_series_id' => $request->id,
            'comment' => $request->comment   
          ]);
        }
    }    
    if(isset($data)){
      return response()->json(array('1'), 200); 
    }
    else{
      return response()->json(array('error'), 401);  
    }   
  }
  public function reply(Request $request){
    $request->validate([
      'reply' =>'required',
    ]);    
    $user = Auth::user();
    $input = $request->all();
    if($request->type == 'B'){
      $data = Subcomment::create([
        'user_id' => $user->id,
        'blog_id' => $request->id,
        'comment_id' => $request->reply_id,
        'reply' => $request->reply   
      ]);
    }
    elseif($request->type == 'M'){
      $data = MovieSubcomment::create([
        'user_id' => $user->id,
        'movie_id' => $request->id,
        'movie_comment_id' => $request->reply_id,
        'reply' => $request->reply 
      ]);
    }    
    elseif($request->type == 'T'){
      $data = MovieComment::create([
        'user_id' => $user->id,
        'tv_series_id' => $request->id,
        'movie_comment_id' => $request->reply_id,
        'reply' => $request->reply   
      ]);
    }    
    if(isset($data)){
      return response()->json(array('1'), 200); 
    }
    else{
      return response()->json(array('error'), 401);  
    }   
  }
}