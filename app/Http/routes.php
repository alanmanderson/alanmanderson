<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'PostController@index');

Route::get('home', 'HomeController@index');

//Route::get('auth/login', 'Auth\AuthController@getLogin');
//Route::get('auth/{provider}', 'Auth\AuthController@redirectToProvider')->where('provider', '!(login)');
//Route::get('auth/{provider}/callback', 'Auth\AuthController@handleProviderCallback')->where('provider', '!(login)');

Route::get('auth/github', 'Auth\AuthController@login');

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

Route::get('posts', 'PostController@index');
Route::get('posts/{slug}', 'PostController@show');

Route::group(['middleware' => ['auth']], function(){
    Route::resource('posts','PostController', ['except' => ['index', 'show']]);

});
