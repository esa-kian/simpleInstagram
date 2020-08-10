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
      $save = new SavePost;
      $save->post_id = $request->postId;
      $save->account_id = $request->accountId;
      $save->save();
      $post = DB::table('posts')->select('title')->where('id', $request->postId)->get();
      return response()->json([
          'You Saved: ' => $post,
      ]);
    }

    public function unsave(Request $request)
    {
      SavePost::where('post_id', $request->postId)->Where('account_id', $request->accountId)->delete();
      $post = DB::table('posts')->select('title')->where('id', $request->postId)->get();
      return response()->json([
          'You Unsaved: ' => $post,
      ]);
    }

    public function search(Request $request)
    {
      $post = Post::where('title', 'like', '%' . $request->title . '%')->get();
      return response()->json([
          'Result: ' => $post,
      ]);
    }
}
