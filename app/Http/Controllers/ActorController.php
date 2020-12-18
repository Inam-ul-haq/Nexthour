<?php

namespace App\Http\Controllers;

use App\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ActorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     
        
        
         $actors = \DB::table('actors')->select('id','name','image','biography','place_of_birth')->get();

        if($request->ajax()){
             return \Datatables::of($actors)
              ->addIndexColumn()
              ->addColumn('checkbox',function($actor){
                $html = '<div class="inline">
                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="'.$actor->id.'" id="checkbox'.$actor->id.'">
                    <label for="checkbox'.$actor->id.'" class="material-checkbox"></label>
                  </div>';

                  return $html;
              })
            
               ->addColumn('biography',function($actor){
                    return strip_tags(html_entity_decode(str_limit($actor->biography,50)));
                 
              })
                  ->addColumn('image',function($actor){
                if ($actor->image) {
                 $image= '<img src="'.asset('/images/actors/' . $actor->image).'" alt="Pic" width="70px" class="img-responsive">';
                }else{
                    $image= '<img  src="http://via.placeholder.com/70x70" alt="Pic" width="70px" class="img-responsive">';
                }
               
                   return $image;

              })
              ->addColumn('action',function($actor){
                $btn = ' <div class="admin-table-action-block">
                  
                    <a href="'.route('actors.edit', $actor->id).'" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a><button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#deleteModal'.$actor->id.'"><i class="material-icons">delete</i> </button></div>';
                   
                   

                   $btn.='<div id="deleteModal'.$actor->id.'" class="delete-modal modal fade" role="dialog">
                <div class="modal-dialog modal-sm">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">&times;</button>
                      <div class="delete-icon"></div>
                    </div>
                    <div class="modal-body text-center">
                      <h4 class="modal-heading">Are You Sure ?</h4>
                      <p>Do you really want to delete these records? This process cannot be undone.</p>
                    </div>
                    <div class="modal-footer">
                      <form method="POST" action="'.route("actors.destroy",$actor->id).'">
                        '.method_field("DELETE").'
                        '.csrf_field().'
                          <button type="reset" class="btn btn-gray translate-y-3" data-dismiss="modal">No</button>
                          <button type="submit" class="btn btn-danger">Yes</button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>';
                    
                return $btn;
              })
              ->rawColumns(['checkbox','biography','image','action'])
              ->make(true);
        }

    
        return view('admin.actor.index', compact('actors'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.actor.create');
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
          'image' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        $input = $request->all();

        if ($file = $request->file('image')) {
          $name = "actor_".time().$file->getClientOriginalName();
          $file->move('images/actors', $name);
          $input['image'] = $name;
        }

        Actor::create($input);
        return back()->with('added', 'Actor has been created');
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
    public function edit($id)
    {
        $actor = Actor::findOrFail($id);
        return view('admin.actor.edit', compact('actor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $actor = Actor::findOrFail($id);

        $request->validate([
          'name' => 'required',
          'image' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);
        
        $input = $request->all();

        if ($file = $request->file('image')) {
          $name = "actor_".time().$file->getClientOriginalName();
          if ($actor->image != null) {
              $content = @file_get_contents(public_path().'/images/actors/'.$actor->image);
              if ($content) { 
                unlink(public_path()."/images/actors/".$actor->image);
              }
          }
          $file->move('images/actors', $name);
          $input['image'] = $name;
        }

        $actor->update($input);
        return redirect('admin/actors')->with('updated', 'Actor has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $actor = Actor::findOrFail($id);

        if ($actor->image != null) {
          $content = @file_get_contents(public_path().'/images/actors/'.$actor->image);
          if ($content) { 
            unlink(public_path()."/images/actors/".$actor->image);
          }
        }

        $actor->delete();
        return redirect('admin/actors')->with('deleted', 'Actor has been deleted');
    }

    public function bulk_delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->with('deleted', 'Please select one of them to delete');
        }

        foreach ($request->checked as $checked) {

            $actor = Actor::findOrFail($checked);
            
            if ($actor->image != null) {
              $content = @file_get_contents(public_path().'/images/actors/'.$actor->image);
              if ($content) { 
                unlink(public_path()."/images/actors/".$actor->image);
              }
            }

            Actor::destroy($checked);
        }

        return back()->with('deleted', 'Actors has been deleted');   
    }
}
