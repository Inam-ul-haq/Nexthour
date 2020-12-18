<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use willvincent\Rateable\Rateable;
class UserRating extends Model
{

    protected $fillable = [    
	'tv_id','movie_id','rating','user_id'
    ];
}
