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

// Admin
Route::prefix('admin')->group(function() {
	// admin login blank page
    Route::name('admin.login')->get('/login', 'Auth\AdminLoginController@show_login_form');
    // submit admin login
    Route::name('admin.login.submit')->post('/login', 'Auth\AdminLoginController@login');
    // index page after logged in
    Route::name('admin.dashboard')->get('/', 'Web\AdminController@index');
});

//Trade
Route::prefix('trade')->group(function(){
	Route::name('trade-list')->get('/', 'Web\TradeController@show_trade');
	Route::name('trade-view')->get('/view-trade','Web\TradeController@view_trade_detail');
});


// House
Route::prefix('house')->group(function(){
	Route::name('blog-list')->get('/', 'Web\HouseController@show_house');
	Route::name('blog-view')->get('/view-house','Web\HouseController@show_house_details');
	
});


//Message
Route::get('/message', 'MessageController@show_message');


// Blog
Route::prefix('blog')->group(function(){
	Route::name('blog-list')->get('/', 'Web\BlogController@show_blog');
	Route::name('blog-view')->get('/view-blog','Web\BlogController@show_blog_details');
	Route::name('blog-add')->get('/add-blog','Web\BlogController@add_blog');
});



//User
Route::prefix('user')->group(function(){
	Route::name('user-list')->get('/', 'Web\UserController@show_user');
	Route::name('user-view')->get('/view-user','Web\UserController@show_user_profile');
});

// put all the routes inside at last
// only for those who have logged in can access these pages
Route::group(['middleware' => 'auth:admin'], function(){

});//end middleware auth:admin


// ======================================================================================
// Web API
Route::name('user.list')->get('/show_profile/{id}', 'Web\UserController@list_all_user');

