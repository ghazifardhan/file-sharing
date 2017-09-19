<?php

use Illuminate\Http\Request;

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

Route::post('login', 'AuthController@login');
Route::post('register', 'UserController@create');
Route::post('searchfriend', 'UserController@search');
Route::post('upload', 'UploadMediaController@create');
Route::get('my_media', 'UploadMediaController@index');
Route::post('group_media', 'UploadMediaController@group_media');
Route::post('group', 'GroupController@create');
Route::get('group', 'GroupController@index');
