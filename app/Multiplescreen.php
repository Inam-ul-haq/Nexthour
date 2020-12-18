<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Multiplescreen extends Model
{
     protected $fillable = [
        'pkg_id','screen1','screen2','screen3','screen4','screen5','screen6','activescreen','user_id','screen_1_used','screen_2_used','screen_3_used','screen_4_used','device_mac_1','device_mac_2','device_mac_3','device_mac_4','download_1','download_2','download_3','download_4'
    ];
    public function users(){
    	return $this->hasMany('App\User','id');
    }

    
    public function package(){
      return $this->belongsTo('App\Package','pkg_id','id');
    }
}
