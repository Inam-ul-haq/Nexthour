<?php

namespace App\Http\Controllers;

use App\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Stripe\Plan;
use \Stripe\Stripe;
use App\Menu;
use DB;
use App\PaypalSubscription;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function pkgstatus(Request $request, $id)
    {
        $pkg = Package::findOrFail($id);
        $pkg->status = $request->status;
        $pkg->save();

        if($request->status ==1)
        {
            return back()->with('updated','Status has been to active!');
        }else{
            return back()->with('updated','Status has been to deactive!');
        }
        

    }

    public function index()
    {
        $packages = Package::all();
        return view('admin.package.index', compact('packages'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = Menu::all();
        return view('admin.package.create',compact('menus'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (config('services.stripe.secret') != null && config('services.stripe.key') != null) {
            Stripe::setApiKey(config('services.stripe.secret'));
        }

        $input = $request->all();

         if($request->screens !=null){
            $input['screens'] =$request->screens;
        }
        else{
            $input['screens'] = 1;
        }


        $request->validate([
            'plan_id' => 'required',
            'amount' => 'required',
            'interval' => 'required',
            'interval_count' => 'required',
            'currency_symbol' => 'required',
        ],[ 'plan_id.required'=> 'Plan ID Should Be Unique']);
        $all_package =  Package::where('delete_status',0)->get();;
        foreach($all_package as $ap){
            if($ap->plan_id == $request->plan_id){
                return back()->withInput();
                break;
            }
        }

        $input['plan_id'] = strtolower($input['plan_id']);

       if ($request->interval == 'year') {
            $request->validate([
                'interval_count' => 'required|max:1|numeric'
            ], ['interval_count.max'=> 'Max value 1 Allowed']);
        }
          if ($request->interval == 'week') {
            $request->validate([
                'interval_count' => 'required|max:52|numeric'
            ], ['interval_count.max'=> 'Max value 52 Allowed']);
        }
        if ($request->interval == 'month') {
            $request->validate([
                'interval_count' => 'required|max:12|numeric'
            ], ['interval_count.max'=> 'Max value 12 Allowed']);
        }
// package_menu

        if(isset($request->download)){
             $request->validate([
                'downloadlimit' => 'required|numeric'
            ], ['downloadlimit.required'=> 'Please enter download limit']);

            $input['download'] = '1';

            $input['downloadlimit'] = $request->screens * $request->downloadlimit;
          
        }
        else{
            $input['download'] = '0';
            $input['downloadlimit'] = NULL;
        }


         $menus = null;

        if (isset($request->menu) && count($request->menu) > 0) {
          $menus = $request->menu;
          for ($i=0; $i < sizeof($menus) ; $i++) { 
            if($menus[$i]==100){
                unset($menus); 
                $men=Menu::all();
                foreach ($men as $key => $value) {
                    # code...
                     $menus[]=$value->id;
                }
                  DB::table('package_menu')->insert(
                         array(
                                'menu_id'     =>    $menus[$i], 
                                'package_id'   =>   $input['plan_id'],
                                'created_at' => date('Y-m-d h:i:s'),
                                'updated_at' => date('Y-m-d h:i:s'),
                         )
                    );

            }else{

               DB::table('package_menu')->insert(
                     array(
                            'menu_id'     =>    $menus[$i], 
                            'package_id'   =>   $input['plan_id'],
                            'created_at' => date('Y-m-d h:i:s'),
                            'updated_at' => date('Y-m-d h:i:s'),
                     )
                );
            }
              


          }
        
        }
        try{
            if (config('services.stripe.secret') != null && config('services.stripe.key') != null) {
                Plan::create(array(
                    "id" => $input['plan_id'],
                    "currency" => $input['currency'],
                    "product" => [
                        "name" => $input['name'],
                    ],
                    "amount" => ($input['amount']*100),
                    "interval" => $input['interval'],
                    "interval_count" => $input['interval_count'],
                    "trial_period_days" => $input['trial_period_days'],
                ));
            }
        }
        catch(\Exception $e){
         return back()->with('deleted',$e->getMessage());
     }

        Package::create($input);
        return redirect('admin/packages')->with('added', 'Package has been created');
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
        $package = Package::findOrFail($id);
         $menus = Menu::all();
        return view('admin.package.edit', compact('package','menus'));
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

        $package = Package::findOrFail($id);

        if (config('services.stripe.secret') != null && config('services.stripe.key') != null) {
            // Set your secret key: remember to change this to your live secret key in production
            Stripe::setApiKey(config('services.stripe.secret'));
        }

        $input = $request->all();

        if (config('services.stripe.secret') != null && config('services.stripe.key') != null) {
            $stripe_plan = Plan::retrieve($package->plan_id);

            $stripe_plan->nickname = $input['name'];

            $stripe_plan->save();
        }
        $deletemenu= DB::table('package_menu')->where('package_id',$input['plan_id'])->delete();

         if(isset($request->download)){
             $request->validate([
                'downloadlimit' => 'required|numeric'
            ], ['downloadlimit.required'=> 'Please enter download limit']);

            $input['download'] = '1';

            $input['downloadlimit'] = $package->screens * $request->downloadlimit;
          
        }
        else{
            $input['download'] = '0';
            $input['downloadlimit'] = NULL;
        }

        // package_menu
         $menus = null;

        if (isset($request->menu) && count($request->menu) > 0) {
          $menus = $request->menu;
          for ($i=0; $i < sizeof($menus) ; $i++) { 
            if($menus[$i]==100){
                unset($menus); 
                $men=Menu::all();
                foreach ($men as $key => $value) {
                    # code...
                     $menus[]=$value->id;
                }
                  DB::table('package_menu')->insert(
                         array(
                                'menu_id'     =>    $menus[$i], 
                                'package_id'   =>   $input['plan_id'],
                                'updated_at'  => date('Y-m-d h:i:s'),
                         )
                    );

            }else{

               DB::table('package_menu')->insert(
                     array(
                            'menu_id'     =>    $menus[$i], 
                            'package_id'   =>   $input['plan_id'],
                            'updated_at'  => date('Y-m-d h:i:s'),
                     )
                );
            }
              


          }
        
        }

        $package->update($input);
        return redirect('admin/packages')->with('updated', 'Package has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (config('services.stripe.secret') != null && config('services.stripe.key') != null) {
            // Set your secret key: remember to change this to your live secret key in production
            Stripe::setApiKey(config('services.stripe.secret'));
        }

        $package = Package::findOrFail($id);
        if (config('services.stripe.secret') != null && config('services.stripe.key') != null) {
                $stripe_plan = Plan::retrieve($package->plan_id);
                $stripe_plan->delete();
        }
        $package->delete();
        return redirect('admin/packages')->with('deleted', 'Package has been deleted');
    }

    public function softDelete(Request $request, $id)
    {
        $package = Package::findOrFail($id);
        //$paypalsub = PaypalSubscription::findOrFail($id);
        $package->delete_status = 0;

        $package->save();
        return redirect('admin/packages')->with('deleted', 'Package has been deleted');
    }

    public function bulk_delete(Request $request)
    {
        if (config('services.stripe.secret') != null) {
            // Set your secret key: remember to change this to your live secret key in production
            Stripe::setApiKey(config('services.stripe.secret'));
        }

        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);

        if ($validator->fails()) {

            return back()->with('deleted', 'Please select one of them to delete');
        }

        foreach ($request->checked as $checked) {

            $package = Package::findOrFail($checked);
            if (config('services.stripe.secret') != null) {
                $stripe_plan = Plan::retrieve($package->plan_id);
                $stripe_plan->delete();
            }
            $package->delete_status = 0;
            $package->save();

        }

        return back()->with('deleted', 'Plans has been deleted');
    }
}
