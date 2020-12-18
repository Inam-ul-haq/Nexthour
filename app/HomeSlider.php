<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomeSlider extends Model
{
    protected $fillable = [
      'movie_id',
      'tv_series_id',
      'slide_image',
      'active',
      'position'
    ];

    public function movie()
    {
      return $this->belongsTo('App\Movie');
    }
    public function tvseries()
    {
      return $this->belongsTo('App\TvSeries', 'tv_series_id');
    }
}
