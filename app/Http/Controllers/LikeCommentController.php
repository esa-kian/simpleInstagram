<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\LikeComment;
use Illuminate\Support\Facades\DB;

class LikeCommentController extends Controller
{
  public function like(Request $request)
  {
      $liked = LikeComment::where('comment_id', $request->commentId)->where('account_id', $request->accountId)->get();
      $comment = DB::table('comments')->select('comment')->where('id', $request->commentId)->get();

      if(count($comment) != 0)
      {
        if (count($liked) == 0)
        {
            $like = new LikeComment;
            $like->comment_id = $request->commentId;
            $like->account_id = $request->accountId;
            $like->save();
            return response()->json([
                'You Liked: ' => $comment,
            ]);
        }
        else
        {
            return response()->json([
                'You Liked the comment before: ' => $comment,
            ]);
        }
      }
      else
      {
        return response()->json([
            'The comment is not available: ' => $comment,
        ]);
      }
  }

  public function unlike(Request $request)
  {
        $liked = LikeComment::where('comment_id', $request->commentId)->where('account_id', $request->accountId)->get();
        $comment = DB::table('comments')->select('comment')->where('id', $request->commentId)->get();

        if(count($comment) != 0)
        {
            if(count($liked) != 0)
            {
                LikeComment::where('comment_id', $request->commentId)->Where('account_id', $request->accountId)->delete();
                
                return response()->json([
                    'You Unliked: ' => $comment,
                ]);
            }
            else
            {
                return response()->json([
                    'You unliked the comment before: ' => $comment,
                ]);
            }
        }
        else
        {
            return response()->json([
                'The comment is not available: ' => $comment,
            ]);
        }
  }
}
