<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['post_id', 'account_id', 'comment'];

    public function account()
    {
      return $this->blongsTo('App\Account');
    }

    public function post()
    {
      return $this->blongsTo('App\Post');
    }

    public function likeComments()
    {
      return $this->hasMany('App\LikeComment');
    }
}
