<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;
use App\TvSeries;

class QuickUpdateController extends Controller
{
    public function change($id){
    	
    	$movie = Movie::findorfail($id);

    	if($movie->status == 1){
    		$movie->status = 0;
    	}else{
    		$movie->status = 1;
    	}

    	$movie->save();
    	return back()->with('updated','Movie Status changed !');
    }

    public function changetvstatus($id){
        
        $tv = TvSeries::findorfail($id);

        if($tv->status == 1){
            $tv->status = 0;
        }else{
            $tv->status = 1;
        }

        $tv->save();
        return back()->with('updated','TvSeries Status changed !');
    }
}
