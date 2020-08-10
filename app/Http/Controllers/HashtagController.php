<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hashtag;
use App\HashtagPost;
use App\Post;

class HashtagController extends Controller
{
    public function insert(Request $requset)
    {
        $hashtag = Hashtag::where('tag', $requset->tag)->get();
        if (count($hashtag) == 0)
        {
          $hashtag = new Hashtag;
          $hashtag->tag = $requset->tag;
          $hashtag->save();
        }

      $hashtagPost = Post::find($requset->postId);
      // $hashtagPost->posts()->attach($requset->postId);
      $hashtagPost->hashtags()->attach($hashtag);
      return response()->json([
          'Inserted: ' => $requset->tag,
      ]);
    }

    public function remove()
    {

    }

}
