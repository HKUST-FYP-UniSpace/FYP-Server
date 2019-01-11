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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Test
Route::get('/hi', function() {
	return "hi";
});




// put all the routes inside at last
// only for those who have logged in can access these pages
Route::group(['middleware' => 'auth:admin'], function(){

});//end middleware auth:admin

