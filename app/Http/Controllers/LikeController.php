<?php

namespace App\Http\Controllers;
use App\Blog;
use App\Like;
use Auth;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LikeController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{        
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function add(Request $request)
	{
		//return "helllloo";
		$item = $request->item;
		$userid = Auth::user()->id;

		$like = like::where('user_id',$userid)->where('blog_id',$item)->first();
		if(isset($like)){
			return response()->json('exist');
		}
		else{
			// return "hello";
			$input = $request->all();
			$input['added']=1;
			$input['blog_id']=$item;
			$input['user_id']= $userid;
			like::create($input);

			return response()->json('success');
		}

		//return "hello";
		
	}


	public function unlike(Request $request)
	{
		//return "helllloo";
		$item = $request->item;
		$userid = Auth::user()->id;
		$unlike = like::where('user_id',$userid)->where('blog_id',$item)->get();
		if(isset($unlike) && count($unlike)>0){
			return "exist";
		}
		else{
			// return "hello";
			$input = $request->all();
			$input['added']=-1;
			$input['blog_id']=$item;
			$input['user_id']= $userid;
			like::create($input);
		}

		//return "hello";
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  \App\Category  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  \App\Category  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
	  
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \App\Category  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		
		
		
	}


	
	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  \App\Category  $id
	 * @return \Illuminate\Http\Response
	 */
	
	
}

