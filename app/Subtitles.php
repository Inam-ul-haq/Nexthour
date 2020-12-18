<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subtitles extends Model
{
    protected $fillable = ['sub_lang','sub_t'];

    public function movies()
    {
    	return $this->belongsTo('App\Movie','m_t_id','id');
    }

    public function episodes()
    {
      return $this->hasMany('App\Subtitles','m_t_id');
    }
}
