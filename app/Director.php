<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{

	
    protected $fillable = [
      'name', 'image', 'detail','biography', 'place_of_birth', 'DOB',
    ];
}
