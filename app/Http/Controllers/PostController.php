<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
  public function create(Request $request)
  {
     return Post::create($request->all());
  }

  public function read($id)
  {
    return Post::find($id);
  }

  public function delete($id)
  {
    $post = Post::findOrFail($id);
    $post->delete();

    return 204;
  }

  public function update(Request $request, $id)
  {
    $post = Post::findOrFail($id);
    $post->update($request->all());

    return $post;
  }

  public function showAllPost($id)
  {
      $post = Post::where('account_id', $id)->get();
      
      return $post;
  }
}
