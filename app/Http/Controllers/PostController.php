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

  public function read($id)
  {
    $post = Post::where('id', $id)->get();

    if(count($post) != 0)
    {
      return response()->json([
          'Post: ' => $post,
      ]);
    }
    else
    {
        return response()->json([
            'The post is not available: ' => $post,
        ]);
    }
  }

  public function delete(Request $request)
  {
    $post = DB::table('posts')->select('title')->where('id', $request->id)->whereNull('deleted_at')->get();
    
    if(count($post) != 0)
    {
      Post::where('id', $request->id)->delete();
      
      return response()->json([
          'Deleted: ' => $post,
      ]);
    }
    else
    {
        return response()->json([
            'The post is not available: ' => $post,
        ]);
    }
  }

  public function update(Request $request)
  {
    $post = DB::table('posts')->select('title')->where('id', $request->id)->get();
    
    if(count($post) != 0)
    {
        DB::table('posts')
            ->where('id', $request->id)
            ->update(['title' => $request->title, 'photo' => $request->photo]);
        
        return response()->json([
            'Title changed to: ' => $request->title,
        ]);
    }
    else
    {
        return response()->json([
            'The post is not available: ' => $post,
        ]);
    }
  }

  public function showAllPost($accountId)
  {
      $post = Post::where('account_id', $accountId)->get();
      
      return response()->json([
          'Account: ' => $post,
      ]);
  }
}
