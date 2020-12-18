<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{

    protected $fillable = [
      'title',
      'image',
      'detail',
      'slug',
      'is_active',
      'user_id' 	
    ];

    public function users()
    {
      return $this->belongsTo('App\User');
    }
    public function comments(){

      return $this->hasMany('App\Comment');
    }

    public function subcomments(){

      return $this->hasMany('App\Subcomment');
    }
}
