<?php

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
Auth::routes();

Route::get('blog/{slug}', ['uses' => 'BlogController@getSingle', 'as' => 'blog.single'])->where('slug', '[\w\d\-\_]+');

Route::get('blog', ['uses' => 'BlogController@getIndex', 'as' => 'blog.index']);

Route::get('contact', 'PagesController@getContact');

Route::post('contact', 'PagesController@postContact');

Route::get('about', 'PagesController@getAbout');

Route::get('home', 'HomeController@index');

Route::get('/', 'PagesController@getIndex');
//Posts
Route::resource('posts', 'PostController');

//Categories
Route::resource('categories', 'CategoryController', ['except'=>['create']]);
//Tags
Route::resource('tags', 'TagController', ['except'=>['create']]);

//Comments
//Route::resource('comments', 'CommentController', ['except'=>['create']]);
Route::post('comments/{id}', ['uses' => 'CommentsController@store', 'as' => 'comments.store']);
Route::get('comments/{id}/edit', ['uses' => 'CommentsController@edit', 'as' => 'comments.edit']);
Route::put('comments/{id}', ['uses' => 'CommentsController@update', 'as' => 'comments.update']);
Route::delete('comments/{id}/{post_id}', ['uses' => 'CommentsController@destroy', 'as' => 'comments.destroy']);
Route::get('comments/{id}/confirmDestroy', ['uses' => 'CommentsController@confirmDestroy', 'as' => 'comments.confirmDestroy']);

/*
Route::get('/', function () {
    return view('welcome');
});
*/
