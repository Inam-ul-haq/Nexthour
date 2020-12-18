<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\HomeTranslation;
use Session;
use App\FrontSliderUpdate;
use App\Movie;
use App\Season;

class SlideUpdateController extends Controller
{
    public function get()
    {   
        $movie_max= count(Movie::all());
        $season_max = count(Season::all());
    	return view('admin.sliderlimit.index',compact('movie_max','season_max'));
    }

    public function update(Request $request,$id)
    {  
        $find = FrontSliderUpdate::findorfail($id);

        $request->validate([
            'item_show' => 'min:1'
        ]);

        $find->item_show = $request->item_show;
       
            
        if(isset($request->order)){
            $find->orderby = 1;
        }else{
            
            $find->orderby = 0;
        }
         if(isset($request->slider)){
            $find->sliderview = 1;
        }else{
            
            $find->sliderview = 0;
        }

        $find->save();

        return redirect()->route('front.slider.limit')->with('updated','Slider Limit Updated !');

    }
}
