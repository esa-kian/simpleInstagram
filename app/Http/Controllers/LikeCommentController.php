<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LikeComment;
use Illuminate\Support\Facades\DB;

class LikeCommentController extends Controller
{
  public function like(Request $request)
  {
      $like = new LikeComment;
      $like->comment_id = $request->commentId;
      $like->account_id = $request->accountId;
      $like->save();
      $comment = DB::table('comments')->select('comment')->where('id', $request->commentId)->get();
      return response()->json([
          'You Liked: ' => $comment,
      ]);
  }

  public function unlike(Request $request)
  {
      LikeComment::where('comment_id', $request->commentId)->Where('account_id', $request->accountId)->delete();
      $comment = DB::table('comments')->select('comment')->where('id', $request->commentId)->get();
      return response()->json([
          'You Unliked: ' => $comment,
      ]);
  }
}
