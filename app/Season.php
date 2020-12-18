<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use CyrildeWit\EloquentViewable\Viewable;
use CyrildeWit\EloquentViewable\Contracts\Viewable as ViewableContract;

class Season extends Model implements ViewableContract
{
    use HasTranslations;
    use Viewable;

    public $translatable = ['detail'];

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
      $attributes = parent::toArray();
      
      foreach ($this->getTranslatableAttributes() as $name) {
          $attributes[$name] = $this->getTranslation($name, app()->getLocale());
      }
      
      return $attributes;
    }

    protected $fillable = [
      'tv_series_id',
      'season_no',
      'publish_year',
      'a_language',
      'subtitle',
      'subtitle_list',
      'type',
      'thumbnail',
      'poster',
      'tmdb_id',
      'tmdb',
      'detail',
      'actor_id'
    ];

    public function episodes() {
      return $this->hasMany('App\Episode', 'seasons_id');
    }

    public function tvseries() {
      return $this->belongsTo('App\TvSeries', 'tv_series_id');
    }

    public function wishlist()
    {
      return $this->hasMany('App\Wishlist');
    }
}
