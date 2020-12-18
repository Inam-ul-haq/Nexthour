<?php

namespace App\Http\Controllers;
use Session;
use App\WatchHistory;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;

class TimeHistoryController extends Controller
{
    public function watchhistory($movie_id,$type){
        $user_id=Auth::user()->id;
        if($type=='movie'){
        $exists=WatchHistory::where('movie_id',$movie_id)->where('user_id',$user_id)->first();
         if (!isset($exists)) {
          
        WatchHistory::create([
       'movie_id'=>$movie_id,
       'user_id'=>$user_id,
         ]);
        }
    }else if($type=='tv'){   
 $exists=WatchHistory::where('tv_id',$movie_id)->where('user_id',$user_id)->first();

  if (!isset($exists) ) {
        
        WatchHistory::create([
       'tv_id'=>$movie_id,
       'user_id'=>$user_id,
         ]);
        }
    }
       
        
    }

    public function movie_time($endtime,$movie_id,$user_id)
    {
        $exists=WatchHistory::where('movie_id',$movie_id)->where('user_id',$user_id)->first();
        if (!isset($exists)) {
          
        WatchHistory::create([
       'movie_id'=>$movie_id,
       'user_id'=>$user_id,
         ]);
        }
        


         $timeold=$endtime;
         if (strlen($endtime)<=5) {

         $endtime='00:'. $endtime;
     }
  
      
       $times= Session::get('time_'.$movie_id);
       
       if (isset($times) && !is_null($times)) {

           foreach ($times as $key => $value) {
           $v[]=$value;
           }
          
    $coll=collect($v)->unique()->flatten();
      

     if ($coll->contains($movie_id) && strtotime($times['endtime'])<=strtotime($timeold)) {

        session()->put('time_'.$movie_id,[
            'endtime' => $endtime,
            'movie' => $movie_id,
            'user' => $user_id,
        ]);
     
     }else
     {
        if (strtotime($times['endtime'])<=strtotime($timeold)) {
            session()->push('time_'.$movie_id,[
        'endtime' => $endtime,
        'movie' => $movie_id,
        'user' => $user_id,
    ]);
        }
        
     
     }
  
}else{
     if (strtotime($times['endtime'])<=strtotime($timeold)) {
            session()->put('time_'.$movie_id,[
        'endtime' => $endtime,
        'movie' => $movie_id,
        'user' => $user_id,
    ]);
        }
        
     return 'put';
}
 
}    

public function tv_time($endtime,$tv_id,$user_id)
    {
 $exists=WatchHistory::where('tv_id',$tv_id)->where('user_id',$user_id)->first();
        if (!isset($exists)) {
          
         WatchHistory::create([
       'tv_id'=>$tv_id,
       'user_id'=>$user_id,
         ]);
        }
        

        
         
       
         $timeold=$endtime;
         if (strlen($endtime)<=5) {

         $endtime='00:'. $endtime;
     }

       $times= Session::get('time_'.$tv_id);


       
       if (isset($times) && !is_null($times)) {

           foreach ($times as $key => $value) {
           $v[]=$value;
           }
          
    $coll=collect($v)->unique()->flatten();
      

     if ($coll->contains($tv_id) && strtotime($times['endtime'])<=strtotime($timeold)) {

        session()->put('time_'.$tv_id,[
            'endtime' => $endtime,
            'tv_id' => $tv_id,
            'user' => $user_id,
        ]);
     
     }else
     {
        if (strtotime($times['endtime'])<=strtotime($timeold)) {
            session()->push('time_'.$tv_id,[
        'endtime' => $endtime,
        'tv_id' => $tv_id,
        'user' => $user_id,
    ]);
        }
        
     
     }
  
}else{
     if (strtotime($times['endtime'])<=strtotime($timeold)) {
            session()->put('time_'.$tv_id,[
        'endtime' => $endtime,
        'tv_id' => $tv_id,
        'user' => $user_id,
    ]);
        }
        
     return 'put';
}
   return $times['endtime'];
}


public function episode_time($endtime,$episode_id,$user_id,$tv_id)
    {

       $exists=WatchHistory::where('tv_id',$tv_id)->where('user_id',$user_id)->first();
        if (!isset($exists) && is_null($exists)) {
         WatchHistory::create([
       'tv_id'=>$tv_id,
       'user_id'=>$user_id,
         ]);
        }
       
       
         $timeold=$endtime;
         if (strlen($endtime)<=5) {

         $endtime='00:'. $endtime;
     }

       $times= Session::get('time_'.$tv_id.$episode_id);


       
       if (isset($times) && !is_null($times)) {

           foreach ($times as $key => $value) {
           $v[]=$value;
           }
          
    $coll=collect($v)->unique()->flatten();
      

     if ($coll->contains($episode_id) && strtotime($times['endtime'])<=strtotime($timeold)) {

        session()->put('time_'.$tv_id.$episode_id,[
            'endtime' => $endtime,
            'episode_id' => $episode_id,
            'user' => $user_id,
        ]);
     
     }else
     {
        if (strtotime($times['endtime'])<=strtotime($timeold)) {
            session()->push('time_'.$tv_id.$episode_id,[
        'endtime' => $endtime,
        'episode_id' => $episode_id,
        'user' => $user_id,
    ]);
        }
        
     
     }
  
}else{
     if (strtotime($times['endtime'])<=strtotime($timeold)) {
            session()->put('time_'.$tv_id.$episode_id,[
        'endtime' => $endtime,
        'episode_id' => $episode_id,
        'user' => $user_id,
    ]);
        }
        
     return 'put';
}
   return $times['endtime'];
}


}
