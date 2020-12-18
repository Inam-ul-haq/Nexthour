<?php

namespace App\Http\Controllers;

use App\seo;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $seo = Seo::whereId(1)->first();
        return view('admin.seo', compact('seo'));
    }

    
    public function update(Request $request, $id)
    {
         $seo = Seo::findOrFail($id);
         $input = $request->all();
         $seo->update($input);
         return back()->with('updated', 'seo has been updated');
    }

    
}
