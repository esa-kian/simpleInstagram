<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Hashtag;
use App\HashtagPost;
use App\Post;
use Illuminate\Support\Facades\DB;

class HashtagController extends Controller
{
    public function insert(Request $request)
    {
        $post = DB::table('posts')->select('title')
                ->where('id', $request->postId)
                ->whereNull('deleted_at')->get();
      
        if(count($post) != 0)
        {
          $hashtag = DB::table('hashtags')->where('tag', $request->tag)->get()->toArray();

          if (count($hashtag) == 0)
          {
            $hashtag = new Hashtag;
            $hashtag->tag = $request->tag;
            $hashtag->save();
          }

          $hashtagPost = Post::find($request->postId);
          
          $hashtag2 = DB::table('hashtags')->where('tag', $request->tag)->get()->toArray();
          foreach($hashtag2 as $iter)
          {
            $hashtagFind = DB::table('hashtag_post')->where('hashtag_id', $iter->id)->where('post_id', $request->postId)->get();
              
            if(count($hashtagFind) == 0)
            {
              $tag = Hashtag::where('tag', $request->tag)->get();
              $hashtagPost->hashtags()->attach($tag);
              
              return response()->json([
                'Inserted: ' => $request->tag,
                ]);
            }
            else
            {
              return response()->json([
                'You have used this hashtag in the psot: ' => $request->tag,
                ]);
            }
          }
        }
        else
        {
          return response()->json([
              'The post is not available: ' => $post,
          ]);
        }
    }

    public function remove(Request $request)
    {
      $post = DB::table('posts')->select('title')
                ->where('id', $request->postId)
                ->whereNull('deleted_at')->get();
                
      if(count($post) != 0)
      {                
        $hashtagPost = Post::find($request->postId);
        $postHasHashtag = DB::table('hashtag_post')->where('post_id', $request->postId)->where('hashtag_id', $request->tagId)->get();
        
        if(count($postHasHashtag) != 0)
        {
          $hashtagPost->hashtags()->detach($request->tagId);

          return response()->json([
              'Removed: ' => $postHasHashtag,
          ]);
        }
        else
        {
          return response()->json([
              'The post has not the hashtag: ' => $postHasHashtag,
          ]);
        }
      }
      else
      {
        return response()->json([
            'The post is not available: ' => $post,
        ]);
      }
    }

    public function post($postId)
    {
      $post = Post::find($postId);
      $hashtags = $post->hashtags()->get();

      return response()->json([
          'Hashtags: ' => $hashtags,
      ]);
    }

    public function search(Request $request)
    {
      $posts = Hashtag::with('posts')->where('tag', 'like', '%' . $request->tag . '%')->get();

      return response()->json([
          'Posts: ' => $posts,
      ]);
    }

    public function trends()
    {
      $hashtag = DB::table('hashtag_post')
                      ->where('created_at', '>=', now()->subDays(1)->toDateTimeString())
                      ->groupBy('hashtag_id')
                      ->having('hashtag_id', '>', 0)
                      ->orderBy(DB::raw('count(hashtag_id)'), 'DESC')
                      ->take(3)->get()->toArray();

      return response()->json([
          'Treds: ' => $hashtag,
      ]);
    }

    public function postDelete(Request $request)
    {
      $hashtags = Hashtag::find($request->tagId);
      $posts = $hashtags->posts()->get();
      $hashtags->posts()->delete();

      return response()->json([
          'Deleted Posts: ' => $posts,
      ]);
    }
}
