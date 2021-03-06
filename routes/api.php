<?php

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

//Auth
Route::group([ 'prefix' => 'auth' ], function () {
    Route::post('login', 'AuthController@login');
});

//User
Route::group([ 'prefix' => 'user', 'middleware' => 'auth' ], function () {
    Route::post('profile', 'UserController@profile');
});

//Article
Route::resource('article','ArticleController');
