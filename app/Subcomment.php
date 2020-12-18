<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subcomment extends Model
{

    protected $fillable = [
      'user_id',
      'comment_id',
      'reply',
      'blog_id',
      	
    ];

    public function blogs()
    {
      return $this->belongsTo('App\Blog');
    }
    public function comments()
    {
      return $this->belongsTo('App\Comment');
    }
}
