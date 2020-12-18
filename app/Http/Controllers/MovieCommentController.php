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

class MovieCommentController extends Controller
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
      
        // return $request;
        if (!is_null($request->email)) {
          $email=$request->email;
        }
        else{
       $email=Auth::user()->email;
        }
       

          $input = $request->all();
           $input['movie_id']=$id;
         
           $input['email']=$email;
          $data = MovieComment::create($input);

       return back()->with('added', 'Your Movie Comment has been added');
         
       }

      public function reply(Request $request,$id){

        $user_id= Auth::user()->id;
        $input = $request->all();
        $input['comment_id']=$id;
        $input['user_id']=$user_id;
        $data = MovieSubcomment::create($input);
         return back()->with('added', 'Your reply has been added');
      }
  
}