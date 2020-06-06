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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/threads', 'ThreadsController')->except(['show','update','destroy']);
Route::get('/threads/{channel_id}/{thread}', 'ThreadsController@show')->name('thread.show');
Route::delete('/threads/{channel_id}/{thread}', 'ThreadsController@destroy')->name('thread.destroy');
Route::get('/threads/{channel}' , 'ThreadsController@index');
Route::get('/threads/{channel_id}/{thread}/replies' , 'RepliesController@index');
Route::post('/threads/{channel_id}/{thread}/replies' , 'RepliesController@store');
Route::patch('/reply/{reply}','RepliesController@update');
Route::delete('/reply/{reply}','RepliesController@destroy');

Route::post('/replies/{reply}/favorites' , 'FavoriteController@store');
Route::delete('/replies/{reply}/favorites' , 'FavoriteController@destroy');

Route::post('/threads/{channel_id}/{thread}/subscriptions' , 'ThreadsSubscriptionsController@store');
Route::delete('/threads/{channel_id}/{thread}/subscriptions' , 'ThreadsSubscriptionsController@destroy');

Route::get('/profile/{user}' , 'ProfilesController@show')->name('profile.show');
Route::get('/profile/{user}/notifications' , 'UserNotificationsController@index');
Route::delete('/profile/{user}/notifications/{notifications}' , 'UserNotificationsController@destroy');

Route::get('api/users','Api\UsersController@index');
Route::post('api/users/{user}/avatar','Api\UserAfatarController@store')->name('avatar');

Route::get('/musab' , function (){
  return view('musab');
});