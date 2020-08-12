<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('accounts/{id}', 'AccountController@read');
Route::post('accounts', 'AccountController@create');// Parameters: all
Route::put('accounts/{id}', 'AccountController@update');// Parameters: all
Route::delete('accounts/{id}', 'AccountController@delete');
Route::get('accounts', 'AccountController@search');// Parameters: username

Route::post('accounts/follows', 'FollowerController@follow');// Parameters: follower_id, following_id
Route::delete('accounts/{id}/follows', 'FollowerController@unfollow');// Parameters: follower_id
Route::get('accounts/{id}/followers', 'FollowerController@followers');
Route::get('accounts/{id}/followings', 'FollowerController@followings');

Route::get('posts/{id}', 'PostController@read');
Route::post('posts', 'PostController@create');// Parameters: all
Route::put('posts/{id}', 'PostController@update');// Parameters: all
Route::delete('posts/{id}', 'PostController@delete');
Route::get('posts/accounts/{id}', 'PostController@showAllPost');

Route::post('posts/{id}/likes', 'LikeController@like');// Parameters: account_id
Route::delete('posts/{id}/likes', 'LikeController@unlike');// Parameters: account_id
Route::get('posts', 'LikeController@popular');

Route::post('posts/{id}/comments', 'CommentController@comment');// Parameters: account_id, comment
Route::post('posts/comments/{id}/likes', 'LikeCommentController@like');// Parameters: account_id
Route::delete('posts/comments/{id}/likes', 'LikeCommentController@unlike');// Parameters: account_id

Route::post('posts/{id}/saves', 'SavePostController@save');// Parameters: account_id
Route::delete('posts/{id}/saves', 'SavePostController@unsave');// Parameters: account_id
Route::get('posts/saves', 'SavePostController@search');/// Parameters: title

Route::post('hashtags/posts/{id}', 'HashtagController@insert');// Parameters: tag
Route::delete('hashtags/posts/{id}', 'HashtagController@remove');// Parameters: tag_id
Route::get('hashtags/posts/{id}', 'HashtagController@show');
Route::get('hashtags/posts', 'HashtagController@search');// Parameters: tag
Route::get('hashtags', 'HashtagController@trends');
Route::delete('hashtags', 'HashtagController@postDelete');// Parameters: tag_id
