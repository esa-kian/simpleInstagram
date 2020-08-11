<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Like;
use App\Post;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function like(Request $request)
    {
        $liked = Like::where('post_id', $request->postId)->where('account_id', $request->accountId)->get();
        $post = DB::table('posts')->select('title')->where('id', $request->postId)->get();

        if(count($post) != 0)
        {
            if(count($liked) == 0)
            {
                $like = new Like;
                $like->post_id = $request->postId;
                $like->account_id = $request->accountId;
                echo $liked;
                $like->save();

                return response()->json([
                    'You Liked: ' => $post,
                ]);
            }
            else
            {
                return response()->json([
                    'You liked the post before: ' => $post,
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

    public function unlike(Request $request)
    {
        $liked = Like::where('post_id', $request->postId)->where('account_id', $request->accountId)->get();
        $post = DB::table('posts')->select('title')->where('id', $request->postId)->get();

        if(count($post) != 0)
        {
          if(count($liked) != 0)
          {
              Like::where('post_id', $request->postId)->Where('account_id', $request->accountId)->delete();

              return response()->json([
                  'You unliked: ' => $post,
              ]);
          }
          else
          {
            return response()->json([
                'You did not like the post: ' => $post,
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

    public function mostPopular()
    {
        $popularPosts = DB::table('likes')->groupBy('post_id')->having('post_id', '>', 0)->orderBy(DB::raw('count(post_id)'), 'DESC')->get()->toArray();
        $popPostResp = [];
        foreach($popularPosts as $post)
        {
            $popPostResp[] = ['post' => Post::where('id', $post->post_id)->get()];
        }
        return response()->json([
            'Most Popular Posts: ' => $popPostResp,
        ]);
    }
}
