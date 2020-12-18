<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponCode extends Model
{
    protected $fillable = [
        'coupon_code',
        'percent_off',
        'currency', 
        'amount_off',
        'duration',
        'max_redemptions',
        'redeem_by' 
    ];

    protected $dates = [
        'redeem_by'
    ];
}
