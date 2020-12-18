<?php

namespace App\Http\Controllers;

use App\AuthCustomize;
use Illuminate\Http\Request;

class AuthCustomizeController extends Controller
{
    public function index()
    {
    	$auth_customize = AuthCustomize::first();
    	return view('admin.auth_customize.index', compact('auth_customize'));
    }

    public function store(Request $request)
    {
    	$input = $request->all();

    	$old = AuthCustomize::first();

    	if ($file = $request->file('image')) {
          $name = 'auth_page'.time().$file->getClientOriginalName();
    	  $content = @file_get_contents(public_path().'/images/login/'.$old->image);
          if ($content) { 
            unlink(public_path()."/images/login/".$old->image);
          }
          $file->move('images/login', $name);
          $input['image'] = $name;
        }

        $old->update($input);

        return back()->with('updated', 'Customization has been saved');
    }
}
