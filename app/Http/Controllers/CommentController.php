<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
      $post = DB::table('posts')->select('title')->where('id', $request->postId)->get();

      if(count($post) != 0)
      {
          $comment = new Comment;
          $comment->post_id = $request->postId;
          $comment->account_id = $request->accountId;
          $comment->comment = $request->comment;
          $comment->save();

          return response()->json([
              'Your Comment Sent: ' => $post,
          ]);
      }
      else
      {
        return response()->json([
            'The post is not available: ' => $post,
        ]);
      }
    }
}
