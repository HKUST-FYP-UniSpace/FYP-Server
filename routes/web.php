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
    Route::name('admin-list')->get('/', 'AdminController@index');
});

//Trade
Route::prefix('trade')->group(function(){
  Route::name('search')->get('/search','TradeController@search');
	Route::name('trade-list')->get('/', 'TradeController@show_trade');
	Route::name('trade-view')->get('/{id}/view-trade','TradeController@show_trade_details');
	Route::name('trade-edit')->get('/{id}/edit-trade', 'TradeController@edit_trade_form'); //click edit
	Route::name('trade-edit-form')->post('/{id}/edit-trade/update', 'TradeController@update_trade');//do

	Route::name('trade-add')->get('/new', 'TradeController@add_trade_form');
	Route::name('addtrade-form')->post('/new/add','TradeController@add_trade');// submit add
});


// House
Route::prefix('house')->group(function(){
  Route::name('search')->get('/search','HouseController@search');
	Route::name('house-list')->get('/', 'HouseController@show_house');
	Route::name('house-view')->get('/{id}/view-house','HouseController@show_house_details');
  Route::name('house-group')->get('/{id}/group-house','HouseController@show_group_details'); //check group details
	Route::name('house-edit')->get('/{id}/edit-house', 'HouseController@edit_house_form'); //click edit
	Route::name('house-edit-form')->post('/{id}/edit-house/update', 'HouseController@update_house');//do edit

	Route::name('house-add')->get('/new', 'HouseController@add_house_form');
	Route::name('house-add-form')->post('/new/add','HouseController@add_house');// submit add
  Route::name('house-comment')->get('/{id}/comment-house', 'HouseController@show_comments'); //house comments

});


//Message

Route::prefix('message')->group(function(){
  Route::name('search')->get('/search','MessageController@search');
	Route::name('message-list')->get('/', 'MessageController@show_message');

});



// Blog
Route::prefix('blog')->group(function(){
  Route::name('search')->get('/search','BlogController@search');
	Route::name('blog-list')->get('/', 'BlogController@show_blog');
	Route::name('blog-view')->get('/{id}/view-blog','BlogController@show_blog_details');
	Route::name('blog-edit')->get('/{id}/edit-blog', 'BlogController@edit_blog_form'); //click edit
	Route::name('blog-edit-form')->post('/{id}/edit-blog/update', 'BlogController@update_blog');//do edit

  Route::name('blog-add')->get('/new', 'BlogController@add_blog_form');
  Route::name('addblog-form')->post('/new/add','BlogController@add_blog');// submit add

  Route::name('blog-comment')->get('/{id}/comment-blog', 'BlogController@show_comments'); //blog comments
});


//User
Route::prefix('user')->group(function(){
  Route::name('search')->get('/search','UserController@search');
	Route::name('tenant-list')->get('/tenant', 'UserController@show_tenant');//tenants
  Route::name('owner-list')->get('/owner', 'UserController@show_owner');//tenants
  Route::name('user-list')->get('/', 'UserController@show_user');//all
	Route::name('user-view')->get('/{id}/view-user','ProfileController@view_user_profile');
	Route::name('user-edit')->get('/{id}/edit-user', 'ProfileController@edit_user_form'); //click edit
	Route::name('user-edit-form')->post('/{id}/edit-user/update', 'ProfileController@update_user');//do edit
});

//statistics
Route::prefix('statistics')->group(function(){
	Route::name('statistics-view')->get('/','StatisticsController@show_popularity');
  Route::name('statistics-excel')->get('/excel','StatisticsController@export_excel');
});

// put all the routes inside at last
// only for those who have logged in can access these pages
Route::group(['middleware' => 'auth:admin'], function(){

});//end middleware auth:admin


// ======================================================================================
// Web API
Route::name('user.list')->get('/show_profile/{id}', 'Web\UserController@list_all_user');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
