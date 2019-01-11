<?php

use Illuminate\Http\Request;
use App\Blog;

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

Route::get('/hi', function(){
  return "hi";
});

Route::get('/blog', function(){
  return Blog::get();
});

// Route::post('');
// Route::post();
// Route::post();
// Route::post();
