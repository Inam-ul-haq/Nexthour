<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WatchHistory extends Model
{

    protected $fillable = [
      'user_id',
      'movie_id',
      'tv_id',
    ];

    public function movies()
		{
		    return $this->belongsTo('App\Movie','movie_id');
		}
		public function tvseries()
		{
		    return $this->belongsTo('App\TvSeries','tv_id');
		}
		public function user()
		{
		    return $this->belongsTo('App\User','user_id');
		}
}
