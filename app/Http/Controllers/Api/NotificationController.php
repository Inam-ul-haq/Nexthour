<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Notification;
use Auth;

class NotificationController extends Controller
{

    public function allnotification()
    {
        $user = Auth::user();
        $notifications = $user->unreadnotifications;

        if($notifications){
            return response()->json(array('notifications' => $notifications), 200);
        }else {
            return response()->json(array('error'), 401);
        }
    }

    
    public function notificationread($id)
    {        
        $userunreadnotification=Auth::user()->unreadNotifications->where('id',$id)->first();
         
        if ($userunreadnotification) {
           $userunreadnotification->markAsRead();
            return response()->json(array('1'), 200);
        }
        else{
            return response()->json(array('error'), 401);            
        }
    }
}
