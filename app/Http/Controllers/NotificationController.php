<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\User;
use App\Director;
use Notification;
use Auth;
use App\Notifications\MyNotification;
  
class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
  

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $directors = Director::all();
        return view('admin.director.index', compact('directors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.notification.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function store(Request $request)
    {
         
        $request->validate([
          'title' => 'required',
        ]);
        
        $user=User::all();
        $input = $request->all();
       
       $title = $request->title;
       $desc = $request->description;
       $movie_id = $request->movie_id;
       $tvid =  $request->tv_id;

        $alluser[]=$input['user_id'];
        
          if (in_array("0", $input['user_id'])) {
// return $input['user_id'];
            foreach ($user as $key => $value) {
                $alluser[]=$value->id;
                 User::find($value->id)->notify(new MyNotification($title,$desc,$movie_id,$tvid,$alluser));
            
            }
             array_shift($alluser);
             $input['user_id'] = $alluser;
            
          }else{
           
              foreach ($input['user_id'] as $singleuser) {
                  User::find($singleuser)->notify(new MyNotification($title,$desc,$movie_id,$tvid,$alluser));
              }
               $input['user_id'] = $alluser;
          }
          
        
        return back()->with('added', 'Notification has been Sent');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
  
    public function sendNotification()
    {
        $user = User::first();
  
        $details = [
            'title' => 'title',
        'description' =>'description',
            
        ];
  
        Notification::send($user, new MyNotification($details));
   return back()->with('added','Notification is Sent');
       
    }

     public function notificationread($id)
    {
        
        $userunreadnotification=auth()->
        user()->unreadNotifications->
        where('id',$id)->first();
         
        if ($userunreadnotification) {
           $userunreadnotification->markAsRead();
        }

        return 'Done';
       
    }
  
}