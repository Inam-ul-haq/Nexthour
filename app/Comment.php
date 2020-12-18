<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{

    protected $fillable = [
      'name',
      'email',
      'comment',
      'blog_id',
      	
    ];

    public function blogs()
    {
      return $this->belongsTo('App\Blog');
    }
    public function subcomments()
    {
      return $this->hasmany('App\Subcomment');
    }

    public function users(){

      return $this->hasmany('App\User');
    }
}
