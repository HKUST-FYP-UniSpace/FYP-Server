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

// Test
Route::get('/hi', function() {
	return "hi";
});

Route::get('/test', 'TestController@index');
Route::get('/test/{id}', 'TestController@show');

// Test API
Route::get('/test', 'API\TestController@index');
Route::get('/test/{id}', 'API\TestController@show');

// Admin
Route::get('/show_all_admin', 'API\AdminController@show_all_admin');
