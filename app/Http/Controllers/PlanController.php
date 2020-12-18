<?php

namespace App\Http\Controllers;

use App\Plan;
use App\User;
use App\Package;
use App\PaypalSubscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Auth;

class PlanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        // $data = \DB::table('users')->leftJoin('paypal_subscriptions', 'users.id', '=', 'paypal_subscriptions.user_id')->innerJoin('packages', 'paypal_subscriptions.package_id', '=', 'packages.id')->select('users.name as username', 'users.email as useremail', 'users.id as userid','paypal_subscriptions.subscription_to as subscription_to', 'packages.name as planname')->get();
            
        $data= \DB::table('paypal_subscriptions')
              ->select('paypal_subscriptions.user_id','paypal_subscriptions.package_id','paypal_subscriptions.subscription_to')
              ->join('users','users.id','=','paypal_subscriptions.user_id')
              ->join('packages','packages.id','=','paypal_subscriptions.package_id')->get();
        //$data=PaypalSubscription::all();
        $x = count($data);
        
        if($request->ajax()){
             return \Datatables::of($data)
                ->addIndexColumn()
               
                ->addColumn('useremail',function($row){
                      $usee=User::where('id',$row->user_id)->first();
                   return $usee->email;
                    
                })

                ->addColumn('username',function($row){
                    $usename=User::where('id',$row->user_id)->first();
                   return $usename->name;
                    
                })
                
                 ->addColumn('planname',function($row){
                     
                   $packagename=Package::where('id',$row->package_id)->first();
                   if (isset($packagename)) {
                  
                       return $packagename->name;
                    
                   }else{
                    return 'free';
                   }
                  
                })
                  ->addColumn('subscription_to',function($row){
                   
                   $datetime = Carbon::parse($row->subscription_to);
                    return $datetime->diffForHumans();
                    
                })
                ->editColumn('action',function($row){
                      $usename=User::where('id',$row->user_id)->first();
                $html = '<div class="admin-table-action-block">
                      <a href="'.route('change_subscription_show', $usename->id).'" data-toggle="tooltip" data-original-title="Change Subscription" class="btn-default btn-floating"><i class="material-icons">compare_arrows</i></a>
                    </div>';

                    return $html;
             })

             ->rawColumns(['planname','action','subscription_to','useremail','username'])
             ->make(true);
        }
        
        return view('admin.plan.index');
    }

  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $plan = Plan::findOrFail($id);
        return view('admin.users_plan.edit', compact('plan'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $plan = Plan::findOrFail($id);

        $request->validate([
          'name' => 'required',
          'image' => 'nullable|image|mimes:jpeg,png,jpg',
          'email' => 'required|email',
          'role' => 'nullable',
          'confirm_password' => 'same:password'
        ]);

        $input = $request->except('confirm_password');

        if ($request->password !== '' || $request->password != null)
        {
          $input['password'] = bcrypt($request->password);
        }

        if(!isset($input['is_admin']))
        {
            $input['is_admin'] = 0;
        }

        if ($file = $request->file('image')) {
          $name = 'user_'.$file->getClientOriginalName();
          if($plan->image != '') {
            unlink(public_path() . '/images/users/' . $plan->image);
          }
          $file->move('images/plan', $name);
          $input['image'] = $name;
        }

        $plan->update($input);
        return redirect('admin/plan')->with('updated', 'User has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\plan  $plan
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $plan = Plan::findOrFail($id);
        $plan->delete();
        return back()->with('deleted', 'plan has been deleted');
    }




    }
