<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $fillable = ['follower_id', 'following_id'];

    public function account()
    {
      return $this->belongsToMany('App\Account');
    }
}
