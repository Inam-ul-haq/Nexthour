<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;


class Menu extends Model
{
    use HasTranslations;

    public $translatable = ['name'];
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
   		'name',
      'slug',
      'position'
   	];

    public function menu_data()
    {
      return $this->hasMany('App\MenuVideo', 'menu_id');
    }
}
