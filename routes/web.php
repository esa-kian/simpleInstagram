<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(array('prefix'=>'accounts'),function(){
	Route::post('/create','AccountController@create');
	Route::get('/read/{username}','AccountController@read');
	Route::post('/delete','AccountController@delete');
	Route::post('/update','AccountController@update');
	Route::get('/search','AccountController@search');
	Route::get('/followers','FollowerController@followers');
	Route::get('/followings','FollowerController@followings');
	Route::post('/follow','FollowerController@follow');
	Route::post('/unfollow','FollowerController@unfollow');
});

Route::group(array('prefix'=>'post'),function(){
	Route::post('/create','PostController@create');
	Route::get('/read/{title}','PostController@read');
	Route::post('/delete','PostController@delete');
	Route::post('/update','PostController@update');
	Route::get('/showAllPost/{accountId}','PostController@showAllPost');
	Route::post('/like', 'LikeController@like');
	Route::post('/unlike', 'LikeController@unlike');
	Route::get('/mostPopular', 'LikeController@mostPopular');
});
