<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;

    protected $fillable = ['userName','email', 'name', 'password'];

    public function posts()
    {
      return $this->hasMany('App\Post');
    }

    public function likes()
    {
      return $this->hasMany('App\Like');
    }

    public function followers()
    {
      return $this->belongsToMany('App\Follower');
    }
    // protected $guarded = ['password',];
}
