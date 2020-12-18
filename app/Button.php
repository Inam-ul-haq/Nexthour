<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Button extends Model
{
	 protected $fillable = [
      'inspect',
      'rightclick',
      'goto',
      'color'
    ];
}


