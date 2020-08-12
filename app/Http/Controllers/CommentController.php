<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function comment(Request $request, $id)
    {
      $post = DB::table('posts')->select('title')->where('id', $id)->get();

      if(count($post) != 0)
      {
          $comment = new Comment;
          $comment->post_id = $id;
          $comment->account_id = $request->account_id;
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
