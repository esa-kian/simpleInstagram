<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    protected $fillable = ['post_id', 'account_id'];

    public function account()
    {
      return $this->blongsTo('App\Account');
    }

    public function post()
    {
      return $this->blongsTo('App\Post');
    }
}
