<?php

namespace App\Http\Controllers;


//use App\Movie;
use App\MovieComment;
use App\MovieSubcomment;
use Auth;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ImageOptimizer;

class TVCommentController extends Controller
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

    public function create()
    {
      //
    }

    public function store(Request $request,$id)
    {
      
        if (!is_null($request->email)) {
          $email=$request->email;
        }
        else{
       $email=Auth::user()->email;
        }
       

          $input = $request->all();
           $input['tv_series_id']=$id;
         
           $input['email']=$email;
          $data = MovieComment::create($input);

       return back()->with('added', 'Your Comment has been added');
         
       }

      public function reply(Request $request,$id)
      {
        $user_id= Auth::user()->id;
        $input = $request->all();
        $input['comment_id']=$id;
        $input['user_id']=$user_id;
        $data = MovieSubcomment::create($input);
         return back()->with('added', 'Your reply has been added');
      }
  
}