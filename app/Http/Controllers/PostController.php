<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
  public function create(Request $request)
  {
      $post = new Post;
      $post->photo = $request->photo;
      $post->title = $request->title;
      $post->account_id = $request->accountId;
      $post->save();

      // $account->password = $request->password;
      return response()->json([
          'Post Created: ' => $request->title,
      ]);
  }

  public function read($title)
  {
      $post = Post::where('title', $title)->get();
      return response()->json([
          'Account: ' => $post,
      ]);
  }

  public function delete(Request $request)
  {
      Post::where('id', $request->id)->delete();
      return response()->json([
          'Deleted: ' => $request->id,
      ]);
  }

  public function update(Request $request)
  {
      DB::table('posts')
          ->where('id', $request->id)
          ->update(['title' => $request->title, 'photo' => $request->photo]);
      return response()->json([
          'Title changed to: ' => $request->title,
      ]);
  }

  public function showAllPost($accountId)
  {
      $post = Post::where('account_id', $accountId)->get();
      return response()->json([
          'Account: ' => $post,
      ]);
  }
}
