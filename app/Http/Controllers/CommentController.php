<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Comment;
use Illuminate\Support\Facades\DB;

class CommentController extends Controller
{
    public function comment(Request $request)
    {
      $comment = new Comment;
      $comment->post_id = $request->postId;
      $comment->account_id = $request->accountId;
      $comment->comment = $request->comment;
      $comment->save();
      $post = DB::table('posts')->select('title')->where('id', $request->postId)->get();
      return response()->json([
          'Your Comment Sent: ' => $post,
      ]);
    }
}
