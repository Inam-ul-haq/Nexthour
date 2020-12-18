<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movie;

class TestController extends Controller
{
    public function getVideo()
    {
    	$movies = Movie::all();
    	return view('video',compact('movies'));
    }
}
