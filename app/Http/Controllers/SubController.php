<?php

namespace App\Http\Controllers;

use App\sub;
use App\Package;
use Illuminate\Http\Request;

class SubController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sub = Sub::all();
        return view('admin.Seo', compact('sub'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
          $package = Package::pluck('name', 'id')->all();
          return view('admin.userplan.create'compact('package'));
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
          'name' => 'required',
          'email' => 'required|email|unique:users',
        
        ]);

        $input = $request->all();
        
        Sub::create($input);
        return redirect('admin/users')->with('added', 'Active Plan has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\sub  $sub
     * @return \Illuminate\Http\Response
     */
    public function show(sub $sub)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\sub  $sub
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $sub = Sub::findOrFail($id);
        return view('admin.users.edit', compact('sub'));  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\sub  $sub
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $request->validate([
          'name' => 'required',
          'email' => 'required|email|unique:users',
         'plan'=>'required'
        ]);

        $input = $request->all();
        
        $sub->update($input);
        return redirect('admin/users')->with('added', 'Active Plan has been created');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\sub  $sub
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         $sub = Sub::findOrFail($id);
         $input = $request->all();
         $sub->update($input);
         return back()->with('updated', 'Active Plan has been updated');
    }
}
