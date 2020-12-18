<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuVideo extends Model
{
    protected $fillable = [
    	'menu_id',
    	'movie_id',
    	'tv_series_id'
    ];

    public function movie()
    {
    	return $this->belongsTo('App\Movie', 'movie_id');
    }

    public function tvseries()
    {
    	return $this->belongsTo('App\TvSeries', 'tv_series_id');
    }
}
