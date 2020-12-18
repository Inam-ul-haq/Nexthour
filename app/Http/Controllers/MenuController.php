<?php

namespace App\Http\Controllers;

use App\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
      public function index(Request $request)
    {
         $menus = \DB::table('menus')->select('id','name','slug','created_at','updated_at')->get();

        if($request->ajax()){
             return \Datatables::of($menus)
              ->addIndexColumn()
              ->addColumn('checkbox',function($row){
                $html = '<div class="inline">
                    <input type="checkbox" form="bulk_delete_form" class="filled-in material-checkbox-input" name="checked[]" value="'.$row->id.'" id="checkbox'.$row->id.'">
                    <label for="checkbox'.$row->id.'" class="material-checkbox"></label>
                  </div>';

                  return $html;
              })
             ->addColumn('name',function($row){
                   
                   return substr($row->name, 7,-2);
                    
                })
             
               ->addColumn('created_at',function($row){
                  $datetime = Carbon::parse($row->created_at);
                    return $datetime->diffForHumans();
                 
              })
                ->addColumn('updated_at',function($row){
                  $datetime = Carbon::parse($row->updated_at);
                    return $datetime->diffForHumans();
                 
              })
            
              ->addColumn('action',function($row){
                $btn = ' <div class="admin-table-action-block">
                  
                    <a href="'.route('menu.edit', $row->id).'" data-toggle="tooltip" data-original-title="Edit" class="btn-info btn-floating"><i class="material-icons">mode_edit</i></a><button type="button" class="btn-danger btn-floating" data-toggle="modal" data-target="#deleteModal'.$row->id.'"><i class="material-icons">delete</i> </button></div>';
                   
                   

                   $btn.='<div id="deleteModal'.$row->id.'" class="delete-modal modal fade" role="dialog">
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
                      <form method="POST" action="'.route("menu.destroy",$row->id).'">
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
              ->rawColumns(['checkbox','name','action','created_at','updated_at'])
              ->make(true);
        }

    
        return view('admin.menu.index', compact('menus'));
    }

   
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.menu.create');
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
            'logo' => 'mimes:png,jpeg,bmp,jpg'
        ]);

        $input = $request->all();

        $input['position'] = (Menu::count()+1);

        $input['slug'] = str_slug(strtolower($request->name), '-');

        
        Menu::create($input);

        return back()->with('added', 'Menu has been created !');
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
        $menu = Menu::findOrFail($id);
        return view('admin.menu.edit', compact('menu'));
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
        $request->validate([
            'name' => 'required'
        ]);

        $menu = Menu::findOrFail($id);
        
        $input = $request->all();

        $menu->update($input);

        return redirect('admin/menu')->with('updated', 'Menu has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);
        $menu->delete();
        return back()->with('deleted', 'Menu has been deleted');
    }

    public function reposition(Request $request)
    {
      
      if($request->item != null)
      {
          $items = explode('&', $request->item);
          $all_ids = collect();
          foreach ($items as $key => $value) {
              $all_ids->push(substr($value, 7));
          }

          $i = 0;

          foreach($all_ids as $id)
          {
              $i++;
              $item = Menu::findOrFail($id);
              $item->position = $i;
              $item->save();
          }

          return response()->json(['success' => true]);

      }

      else
      {
          return response()->json(['success' => false]);
      }
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
            $menu = Menu::findOrFail($checked);
            $menu->delete();
          }
          return back()->with('deleted', 'Menus has been deleted');   
    }
}
