<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use App\Mail\Contactus;
use App\Config;
class ContactController extends Controller
{
    public function contact()
    {
    	return view('contact');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|regex:/^.+@.+$/i',
            'subj' => 'required',
            'msg' => 'required'
        ],
        [
            'name.required' => 'Name cannot be empty',
            'email.required' => 'Email cannot be empty',
            'subj.required' => 'Please choose a subject',
            'msg.required' => 'Message caanot be empty'
        ]);

    	$contact = array(
    	    'name' => $request->name,
    	    'email' => $request->email,
    	    'subj' => $request->subj,
    	    'msg' => $request->msg
    	);

    	$defaultemail = Config::findOrFail(1)->w_email;

        Mail::to($defaultemail)->send(new Contactus($contact));

        return back()->with('success','Sent Succesfully, Thanks for contacting us!');
    }
}
