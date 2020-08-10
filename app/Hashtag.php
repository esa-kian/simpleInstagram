<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hashtag extends Model
{
    protected $fillable = ['post_id', 'tag'];

    public function posts()
    {
      return $this->belongsToMany('App\Post');
    }
}
