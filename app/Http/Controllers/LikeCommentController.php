<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use App\LikeComment;
use Illuminate\Support\Facades\DB;

class LikeCommentController extends Controller
{
    public function like(Request $request, $id)
    {
        $liked = LikeComment::where('comment_id', $id)->where('account_id', $request->account_id)->get();
        $comment = DB::table('comments')->where('id', $id)->get();

        if (count($comment) != 0) {
            if (count($liked) == 0) {
                $like = new LikeComment;
                $like->comment_id = $id;
                $like->account_id = $request->account_id;
                $like->save();
                return response()->json([
                    'You Liked: ' => $comment,
                ]);
            } else {
                return response()->json([
                    'You Liked the comment before: ' => $comment,
                ]);
            }
        } else {
            return response()->json([
                'The comment is not available: ' => $comment,
            ]);
        }
    }

    public function unlike(Request $request, $id)
    {
        $liked = LikeComment::where('comment_id', $id)->where('account_id', $request->account_id)->get();
        $comment = DB::table('comments')->where('id', $id)->get();

        if (count($comment) != 0) {
            if (count($liked) != 0) {
                LikeComment::where('comment_id', $id)->Where('account_id', $request->account_id)->delete();

                return response()->json([
                    'You Unliked: ' => $comment,
                ]);
            } else {
                return response()->json([
                    'You unliked the comment before: ' => $comment,
                ]);
            }
        } else {
            return response()->json([
                'The comment is not available: ' => $comment,
            ]);
        }
    }
}
