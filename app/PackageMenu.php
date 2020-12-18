<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PackageMenu extends Model
{
   
  protected $table = 'package_menu';

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
  protected $fillable = [
    'menu_id',
    'package_id',
    'updated_at' 
  ];
}
