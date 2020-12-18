<?php

namespace App\Http\Controllers;

use App\Director;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Datatables;
use Carbon\Carbon;

class DirectorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
 
    public function index(Request $request)
    {
     
        
        
         $directors = \DB::table('directors')->select('id','name','image','biography','place_of_birth')->get();

        if($request->ajax()){
             return \Datatables::of($directors)
              ->addIndexColumn()
              ->addColumn('checkbox',function($director){
                $html = '<div class="inline">
                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="'.$director->id.'" id="checkbox'.$director->id.'">
                    <label for="checkbox'.$director->id.'" class="material-checkbox"></label>
                  </div>';

                  return $html;
              })
            
               ->addColumn('biography',function($director){
                    return strip_tags(html_entity_decode(str_limit($director->biography,50)));
                 
              })
                  ->addColumn('image',function($director){
                if ($director->image) {
                 $image= '<img src="'.asset('/images/directors/' . $director->image).'" alt="Pic" width="70px" class="img-responsive">';
                }else{
                    $image= '<img  src="http://via.placeholder.com/70x70" alt="Pic" width="70px" class="img-responsive">';
                }
               
                   return $image;

              })
              ->addColumn('action',function($director){
                $btn = ' <div class="admin-table-action-block">
                  
                    <a href="'.route('directors.edit', $director->id).'" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a><button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#deleteModal'.$director->id.'"><i class="material-icons">delete</i> </button></div>';
                   
                   

                   $btn.='<div id="deleteModal'.$director->id.'" class="delete-modal modal fade" role="dialog">
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
                      <form method="POST" action="'.route("directors.destroy",$director->id).'">
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

    
        return view('admin.director.index', compact('directors'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.director.create');
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
          $name = "director_".time().$file->getClientOriginalName();
          $file->move('images/directors', $name);
          $input['image'] = $name;
        }

        Director::create($input);
        return back()->with('added', 'Director has been created');
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
        $director = Director::findOrFail($id);
        return view('admin.director.edit', compact('director'));
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
        $director = Director::findOrFail($id);

        $request->validate([
          'name' => 'required',
          'image' => 'nullable|image|mimes:jpeg,png,jpg'
        ]);

        $input = $request->all();

        if ($file = $request->file('image')) {
          $name = "director_".time().$file->getClientOriginalName();
          if ($director->image != null) {
              $content = @file_get_contents(public_path().'/images/directors/'.$director->image);
              if ($content) { 
                unlink(public_path()."/images/directors/".$director->image);
              }
          }
          $file->move('images/directors', $name);
          $input['image'] = $name;
        }

        $director->update($input);
        return redirect('admin/directors')->with('updated', 'Director has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $director = Director::findOrFail($id);

        if ($director->image != null) {
              $content = @file_get_contents(public_path().'/images/directors/'.$director->image);
              if ($content) { 
                unlink(public_path()."/images/directors/".$director->image);
              }
        }
        $director->delete();
        return redirect('admin/directors')->with('deleted', 'Director has been deleted');
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

            $director = Director::findOrFail($checked);

            if ($director->image != null) {
              $content = @file_get_contents(public_path().'/images/directors/'.$director->image);
              if ($content) { 
                unlink(public_path()."/images/directors/".$director->image);
              }
            }

            Director::destroy($checked);
        }

        return back()->with('deleted', 'Directors has been deleted');   
    }
}
