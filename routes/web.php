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

Route::get('/','PostController@index');




Route::group(['middleware' => ['auth']], function(){
  Route::get('/posts/create','PostController@create')->name('posts.create');
  Route::post('/posts','PostController@store')->name('posts.store');
  Route::post('/posts/update/{id}','PostController@update')->name('posts.update');
  Route::delete('/posts/delete/{id}','PostController@destroy')->name('posts.destroy');
  Route::get('/chat/index',"ChatController@index")->name('chat.index');
  Route::get('/chat/show/{id}',"ChatController@show")->name('chat.show');
  Route::post('/chat/chat', 'ChatController@chat')->name('chat.chat');
  Route::post('/borrow/{id}','BorrowsController@store')->name('borrow.store');
  Route::get('/borrow/{id}/request','BorrowsController@index')->name('borrow.request');
  Route::get('/user_profile/create','UserProfilesController@create')->name('profile.create');
  Route::post('/user_profile/store','UserProfilesController@store')->name('profile.store');
  Route::post('/user_profile/update','UserProfilesController@update')->name('profile.update');
  Route::resource('comments', 'CommentsController');
  Route::post('comments/{comment}/store','CommentsController@store')->name('comments.store');
  Route::get('/users/{id}/delete','UsersController@destroy')->name('user.destroy');
  Route::get('/users/{id}','UsersController@show')->name('users.show');
  Route::post('favorite/','FavoriteController@like_post')->name('favorites.favorite');
  Route::get('/favorite/show','FavoriteController@show')->name('favorite.show');
});


Route::get('/posts','PostController@index')->name('posts.index');
Route::post('posts/search','PostController@search')->name('post.search');
Route::get('/posts/{post}','PostController@show')->name('posts.show');






Route::get('signup', 'Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup', 'Auth\RegisterController@register')->name('signup.post');
Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login')->name('login.post');
Route::get('logout', 'Auth\LoginController@logout')->name('logout.get');
