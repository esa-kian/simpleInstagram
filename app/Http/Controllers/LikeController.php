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
        $like = new Like;
        $like->post_id = $request->postId;
        $like->account_id = $request->accountId;
        $like->save();
        $post = DB::table('posts')->select('title')->where('id', $request->postId)->get();
        return response()->json([
            'You Liked: ' => $post,
        ]);
    }

    public function unlike(Request $request)
    {
        Like::where('post_id', $request->postId)->Where('account_id', $request->accountId)->delete();
        $post = DB::table('posts')->select('title')->where('id', $request->postId)->get();
        return response()->json([
            'You Unliked: ' => $post,
        ]);
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