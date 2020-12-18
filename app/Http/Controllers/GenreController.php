<?php

namespace App\Http\Controllers;

use App\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use DB;
use Carbon\Carbon;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

         $genres = \DB::table('genres')->select('id','name','created_at','updated_at')->get();

        if($request->ajax()){
             return \Datatables::of($genres)
              ->addIndexColumn()
              ->addColumn('checkbox',function($genre){
                $html = '<div class="inline">
                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="'.$genre->id.'" id="checkbox'.$genre->id.'">
                    <label for="checkbox'.$genre->id.'" class="material-checkbox"></label>
                  </div>';

                  return $html;
              })
               ->addColumn('name',function($genre){
                   
                   return substr($genre->name, 7,-2);
                    
                })
            
               ->addColumn('created_at',function($genre){
                  $datetime = Carbon::parse($genre->created_at);
                    return $datetime->diffForHumans();
                 
              })
                 ->addColumn('updated_at',function($genre){
                  $datetime = Carbon::parse($genre->updated_at);
                    return $datetime->diffForHumans();
                 
              })
                 
              ->addColumn('action',function($genre){
                $btn = ' <div class="admin-table-action-block">
                  
                    <a href="'.route('genres.edit', $genre->id).'" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a><button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#deleteModal'.$genre->id.'"><i class="material-icons">delete</i> </button></div>';
                   
                   

                   $btn.='<div id="deleteModal'.$genre->id.'" class="delete-modal modal fade" role="dialog">
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
                      <form method="POST" action="'.route("genres.destroy",$genre->id).'">
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
              ->rawColumns(['checkbox','name','created_at','action','updated_at'])
              ->make(true);
        }

        $genres = Genre::all();
        $uname  = Genre::distinct()->get(['id','name','created_at','updated_at']);
        //$genres =  DB::table('genres')->select('id','name','created_at','updated_at')->distinct()->get();
        return view('admin.genre.index', compact('genres','uname'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.genre.create');
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
          'name' => 'required'
        ]);
        $input = $request->all();
        Genre::create($input);
        return back()->with('added', 'Genre has been created');
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
        $genre = Genre::findOrFail($id);
        return view('admin.genre.edit', compact('genre'));
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
        $genre = Genre::findOrFail($id);
        $input = $request->all();

        $genre->update($input);
        return redirect('admin/genres')->with('updated', 'Genre has been updated');
    }

    public function updateAll()
    {
        if (Session::has('genre_changed')) {
            return back();
        }
        $all = DB::table('genres')->get();
        foreach ($all as $key => $value) {
            $get_genre = Genre::findOrFail($value->id);
            $get_genre->update([
                'name' => $value->name
            ]);
        }
        Session::put('genre_changed', 'changed');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);

        $genre->delete();
        return redirect('admin/genres')->with('deleted', 'Genre has been deleted');
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

            $genre = Genre::findOrFail($checked);

            Genre::destroy($checked);
        }

        return back()->with('deleted', 'Genres has been deleted');
    }
}
