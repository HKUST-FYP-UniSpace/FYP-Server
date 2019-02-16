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

// Admin
Route::prefix('admin')->group(function() {
	// admin login blank page
    Route::name('admin.login')->get('/login', 'Auth\AdminLoginController@show_login_form');
    // submit admin login
    Route::name('admin.login.submit')->post('/login', 'Auth\AdminLoginController@login');
    // index page after logged in
    Route::name('admin.dashboard')->get('/', 'AdminController@index');
});

//Trade
Route::prefix('trade')->group(function(){
	Route::name('trade-list')->get('/', 'TradeController@show_trade');
	Route::name('trade-view')->get('/view-trade','TradeController@view_trade_detail');
});


// House
Route::prefix('house')->group(function(){
	Route::name('blog-list')->get('/', 'HouseController@show_house');
	Route::name('blog-view')->get('/view-house','HouseController@show_house_details');
	
});


//Message
Route::get('/message', 'MessageController@show_message');

// Blog
Route::prefix('blog')->group(function(){
	Route::name('blog-list')->get('/', 'BlogController@show_blog');
	Route::name('blog-view')->get('/view-blog','BlogController@show_blog_details');
	Route::name('blog-add')->get('/add-blog','BlogController@add_blog');
});



//User
Route::prefix('user')->group(function(){
	Route::name('user-list')->get('/', 'UserController@show_user');
	Route::name('user-view')->get('/view-user','UserController@show_user_profile');
});
