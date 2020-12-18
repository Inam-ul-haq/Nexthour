<?php

namespace App\Http\Controllers;


//use App\Movie;
use App\Comment;
use App\Subcomment;
use Auth;
use Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ImageOptimizer;

class CommentController extends Controller
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

        $request->validate([
          'name' => 'required',
         
          'comment' => 'required',
          
        ]);
        if (!is_null($request->email)) {
          $email=$request->email;
        }
        else{
       $email=Auth::user()->email;
        }
       

          $input = $request->all();
          $input['blog_id']=$id;
           $input['email']=$email;
          $data = Comment::create($input);

       return back()->with('added', 'Your Comment has been added');
         
       }

      public function reply(Request $request,$id,$bid){

        $request->validate([

          'reply' =>'required',

        ]);
        $user_id= Auth::user()->id;
        $input = $request->all();
        $input['comment_id']=$id;
        $input['blog_id']=$bid;
        $input['user_id']=$user_id;
        $data = Subcomment::create($input);
         return back()->with('added', 'Your reply has been added');
      }
  
}