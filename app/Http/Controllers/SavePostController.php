<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SavePost;
use App\Post;
use Illuminate\Support\Facades\DB;

class SavePostController extends Controller
{
    public function save(Request $request)
    {
      $saved = SavePost::where('post_id', $request->postId)
                      ->where('account_id', $request->accountId)->get();
      $post = DB::table('posts')->select('title')->where('id', $request->postId)
                      ->whereNull('deleted_at')->get();
      if(count($post) != 0)
      {
        if(count($saved) == 0)
        {
          $save = new SavePost;
          $save->post_id = $request->postId;
          $save->account_id = $request->accountId;
          $save->save();
          
          return response()->json([
              'You saved: ' => $post,
          ]);
        }
        else
        {
          return response()->json([
            'You saved the post before: ' => $post,
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

    public function unsave(Request $request)
    {
      $saved = SavePost::where('post_id', $request->postId)
                      ->where('account_id', $request->accountId)->get();
      $post = DB::table('posts')->select('title')->where('id', $request->postId)
                      ->whereNull('deleted_at')->get();
      if(count($post) != 0)
      {
        if(count($saved) != 0)
        {              
          SavePost::where('post_id', $request->postId)->Where('account_id', $request->accountId)->delete();
          $post = DB::table('posts')->select('title')->where('id', $request->postId)->get();
          return response()->json([
              'You unsaved: ' => $post,
          ]);
        }
        else
        {
          return response()->json([
            'You unsaved the post before: ' => $post,
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

    public function search(Request $request)
    {
      $post = Post::where('title', 'like', '%' . $request->title . '%')->get();
      return response()->json([
          'Result: ' => $post,
      ]);
    }
}
