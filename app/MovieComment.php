<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovieComment extends Model
{

    protected $fillable = [
      'name',
      'email',
      'comment',
      'movie_id',  
      'tv_series_id',
      	
    ];

    public function movies()
    {
      return $this->belongsTo('App\Movie');
    }
       public function tvseries()
    {
      return $this->belongsTo('App\TvSeries');
    }
    public function subcomments()
    {
      return $this->hasmany('App\MovieSubcomment','comment_id');
    }
    public function users(){

      return $this->hasmany('App\User');
    } 
}
