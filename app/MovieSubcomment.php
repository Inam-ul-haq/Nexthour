<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieSubcomment extends Model
{

    protected $fillable = [
      'user_id',
      'comment_id',
      'reply'    
        
    ];

    public function movies()
    {
      return $this->belongsTo('App\Movie');
    }
     public function tvseries()
    {
      return $this->belongsTo('App\TvSeries');
    }
    public function comments()
    {
      return $this->belongsTo('App\MovieComment','comment_id','id');
    }
}