<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LikeComment extends Model
{
  protected $fillable = ['comment_id', 'account_id'];

  public function account()
  {
    return $this->blongsTo('App\Account');
  }

  public function comment()
  {
    return $this->blongsTo('App\Comment');
  }
  
}
