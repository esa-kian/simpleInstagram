<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
  use SoftDeletes;

  protected $fillable = ['photo', 'title', 'account_id'];

  public function account()
  {
    return $this->blongsTo('App\Account');
  }

  public function likes()
  {
    return $this->hasMany('App\Like');
  }

  public function getImageAttribute()
  {
     return $this->photo;
  }
}
