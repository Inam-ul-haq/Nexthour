<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Newsletter;

class emailSubscribe extends Controller
{


    public function subscribe(Request $request)
    {	    
    	$check = Newsletter::isSubscribed($request->email);

    	if ($check == 1) {

    		return back()->with('updated', 'Your email already has been subscribed');

    	} else {

	    	$subscribe_email = Newsletter::subscribe($request->email);

	    	if (isset($subscribe_email)) {
		    	return back()->with('added', 'Email has been subscribe successfully');
	    	} else {
		    	return back()->with('deleted', 'Please check your email');
	    	}

    	}

    }

}
