<?php

namespace App\Http\Controllers;

use App\CouponCode;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use \Stripe\Coupon;
use \Stripe\Stripe;
use App\Config;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $coupons = CouponCode::all();
        return view('admin.coupon.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.coupon.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $stripe_payment = Config::findOrFail(1)->stripe_payment;
      if ($stripe_payment==1) {
          Stripe::setApiKey(config('services.stripe.secret'));
        $request->validate([
          'coupon_code' => 'required',
          'duration' => 'required',
          'max_redemptions' => 'required|integer|min:0'
        ]);

        $input = $request->all();
        $redeem_by = Carbon::parse($input['redeem_by']);
        $redeem_by = strtotime($redeem_by->format('Y/m/d H:i'));

        if (!isset($input['percent_check']))
        {
            $input['amount_off'] = $input['amount'];
            $input['percent_off'] = null;
        } elseif ($input['percent_check'] == 1) {
            $input['percent_off'] = $input['amount'];
            $input['amount_off'] = null;
        }

        try {
          $coupon = $coupon_generate = Coupon::create(array(
              "percent_off" => $input['percent_off'],
              "duration" => $input['duration'],
              "duration_in_months" => $input['duration_in_months'],
              "id" => $input['coupon_code'],
              "currency" => $input['currency'],
              "amount_off" => $input['amount_off'],
              "max_redemptions" => $input['max_redemptions'],
              "redeem_by" => $redeem_by
            )
          );

          CouponCode::create([
              "percent_off" => $input['percent_off'],
              "duration" => $input['duration'],
              "duration_in_months" => $input['duration_in_months'],
              "coupon_code" => $input['coupon_code'],
              "currency" => $input['currency'],
              "amount_off" => $input['amount_off'],
              "max_redemptions" => $input['max_redemptions'],
              "redeem_by" => $redeem_by
          ]);
        } catch (\Stripe\Error\InvalidRequest $e) {
          return back()->with('deleted', 'Coupon code id already exists ion stripe');
        }

       
      }else{
         return back()->with('deleted', 'Please Enable Stripe Payment Method');
      }
       
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
			Stripe::setApiKey(config('services.stripe.secret'));
			$coupon = CouponCode::findORFail($id);

      try {
        $stripe_coupon = Coupon::retrieve($coupon->coupon_code);
        $stripe_coupon->delete();
      } catch (\Stripe\Error\InvalidRequest $e) {

      }
      $coupon->delete();
			return back()->with('deleted', 'Coupon has been deleted');
    }

    public function bulk_delete(Request $request)
    {
        Stripe::setApiKey(config('services.stripe.secret'));
        $validator = Validator::make($request->all(), [
            'checked' => 'required',
        ]);

        if ($validator->fails()) {
            return back()->with('deleted', 'Please select one of them to delete');
        }

        foreach ($request->checked as $checked) {
          $coupon = CouponCode::findORFail($checked);

          try {
            $stripe_coupon = Coupon::retrieve($coupon->coupon_code);
            $stripe_coupon->delete();
          } catch (\Stripe\Error\InvalidRequest $e) {

          }
          $coupon->delete();
        }

        return back()->with('deleted', 'Coupons has been deleted');   
    }
}
