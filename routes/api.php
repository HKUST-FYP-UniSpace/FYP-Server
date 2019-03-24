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

// testing
Route::post('/test', function (Request $request) {
	$input = $request->input();
	$var = $input['var'];
	return $var;
});


Route::group(['middleware' => ['api','cors']], function () {
    Route::post('users/register', 'API\UserController@register');     // 注册
    Route::post('users/login', 'API\UserController@login');           // 登陆
    Route::group(['middleware' => 'jwt.auth'], function () {
        Route::post('users/get_user_details', 'API\UserController@get_user_details');  // 获取用户详情
    });
});


Route::post('/testData', 'API\HouseController@testData');

// User
Route::get('/users/profile/{id}', 'API\UserController@show_profile');
Route::post('/users/profile/{id}/create', 'API\UserController@create_profile');
// Route::post('/users/profile/{id}/edit', 'API\UserController@edit_profile');


// House
// Route::get('/house/create', 'API\HouseController@create_house');
// Route::get('/house/{id}/edit', 'API\HouseController@edit_house');
Route::get('/house/{id}', 'API\HouseController@show_house'); //
Route::get('/house/{id}/index', 'API\HouseController@index_house'); //Get House List //tested
Route::get('/house/{userId}/houseView/{id}', 'API\HouseController@show_houseView'); //Get House View // review component cannot be tested yet as review_replies has not been added yet
Route::get('/house/{id}/saved', 'API\HouseController@index_houseSaved'); //Get House Saved //tested
Route::post('/house', 'API\HouseController@store_house'); //
Route::post('/house/{id}/delete', 'API\HouseController@delete_house'); //
Route::put('/house/{id}', 'API\HouseController@update_house'); //
Route::put('/house/{id}/archive', 'API\HouseController@archive_house'); //
Route::put('/house/{id}/hide', 'API\HouseController@hide_house'); //
Route::put('/house/{id}/reveal', 'API\HouseController@reveal_house'); //
//Route::put('')

// Group (House Team/ House Post Group)
Route::get('/housePostGroup/{id}', 'API\HouseController@show_group');
Route::get('/housePostGroup', 'API\HouseController@index_housePostGroup');
Route::post('/housePostGroup', 'API\HouseController@store_group');
Route::post('/housePostGroup/{id}/join', 'API\HouseController@join_housePostGroup');
Route::post('/housePostGroup/{id}/delete', 'API\HouseController@delete_housePostGroup'); //
Route::put('/housePostGroup/{id}', 'API\HouseController@update_housePostGroup'); //

// HouseBookmark
// Route::get('/houseBookmark/create', 'API\HouseBookmarkController@create_houseBookmark');
// Route::get('/houseBookmark/{id}/edit', 'API\HouseBookmarkController@edit_houseBookmark');
Route::get('/houseBookmark/{id}', 'API\HouseBookmarkController@show_houseBookmark'); //tested
Route::get('/houseBookmark', 'API\HouseBookmarkController@index_houseBookmark'); //tested
Route::get('/houseBookmark/{id}/saved', 'API\HouseBookmarkController@get_houseBookmarkSaved'); //tested
Route::post('/houseBookmark', 'API\HouseBookmarkController@store_houseBookmark'); //tested
Route::post('/houseBookmark/{id}/delete', 'API\HouseBookmarkController@delete_houseBookmark'); //tested
//Route::put('/houseBookmark/{id}', 'API\HouseBookmarkController@update_houseBookmark');

// Trade
// Route::get('/trade/create', 'API\TradeController@create_trade');
// Route::get('/trade/{id}/edit', 'API\TradeController@edit_trade');
Route::get('/trade/{userId}/{id}/show', 'API\TradeController@show_trade'); // Get Trade Detail //tested
Route::get('/trade/{userId}/index', 'API\TradeController@index_trade'); // Get Trade List // filter to be added
Route::get('/trade/{userId}/selling', 'API\TradeController@show_sellingTrade'); // Get Trade Selling Items // 'Views' to be added to the response
Route::get('/trade/{userId}/bookmarked', 'API\TradeController@index_bookmarkedTrade'); // Get Trade Saved // Tested
//Route::get('/trade/{userId}/history', 'API\TradeController@index_tradeHistory'); // Get Past Trade //
Route::post('/trade', 'API\TradeController@store_trade'); // Create Trade Item //tested
Route::post('/trade/{id}/delete', 'API\TradeController@delete_trade'); //
Route::put('/trade/{id}', 'API\TradeController@update_trade'); // Edit Trade Item //PhotoURL handling to be added
Route::put('/trade/{id}/archive', 'API\TradeController@archive_trade'); //
Route::put('/trade/{id}/hide', 'API\TradeController@hide_trade'); //
Route::put('/trade/{id}/reveal', 'API\TradeController@reveal_trade'); //

// TradeCategory
Route::get('/tradeCategory/{id}', 'API\TradeController@show_trade_category'); //tested
Route::get('/tradeCategory', 'API\TradeController@index_trade_category'); //tested
Route::post('/tradeCategory', 'API\TradeController@store_trade_category'); //tested
Route::post('/tradeCategory/{id}/delete', 'API\TradeController@delete_trade_category'); //tested

// TradeTransaction
Route::get('/tradeTransaction/{id}', 'API\TradeController@show_trade_transaction'); //tested
Route::get('/tradeTransaction', 'API\TradeController@index_trade_transaction'); //tested
Route::post('/tradeTransaction', 'API\TradeController@store_trade_transaction'); //tested

// TradeBookmark
// Route::get('/tradeBookmark/create', 'API\TradeBookmarkController@create_tradeBookmark');
// Route::get('/tradeBookmark/{id}/edit', 'API\TradeBookmarkController@edit_tradeBookmark');
Route::get('/tradeBookmark/{id}', 'API\TradeBookmarkController@show_tradeBookmark'); //
Route::get('/tradeBookmark', 'API\TradeBookmarkController@index_tradeBookmark'); //
Route::post('/tradeBookmark', 'API\TradeBookmarkController@store_tradeBookmark'); //
Route::post('/tradeBookmark/{id}/delete', 'API\TradeBookmarkController@delete_tradeBookmark'); //
//Route::put('/tradeBookmark/{id}', 'API\TradeBookmarkController@update_tradeBookmark');

// Blog
//Route::get('/blog/create', 'API\BlogController@create_blog');
//Route::get('/blog/{id}/edit', 'API\BlogController@edit_blog');

//Route::delete('/blog/{id}', 'API\BlogController@delete_blog');
Route::post('/blog/{id}/delete', 'API\BlogController@delete_blog'); //Why not delete request
Route::post('/blog/{id}/delete/{comment_id}', 'API\BlogController@delete_blog_comment');

Route::post('/blog/{id}/comment', 'API\BlogController@comment_blog');
Route::get('/blog/{id}/detail', 'API\BlogController@show_blog'); //Get Blog Detail //tested
Route::post('/blog', 'API\BlogController@store_blog'); //tested
Route::put('/blog/{id}', 'API\BlogController@update_blog'); //?? (dealing with null->0 problem)
Route::get('/blog', 'API\BlogController@index_blog'); //tested
Route::get('/blog/summary', 'API\BlogController@index_blogSummary'); // Get Blog Summaries //tested
Route::get('/blog/{id}/comment', 'API\BlogController@show_blogComments');

// Search Engine
Route::post('/search/trade', 'API\SearchEngineController@searchTrade');
Route::post('/search/house', 'API\SearchEngineController@searchHouse');

// Test
Route::get('/test', 'TestController@index');
Route::get('/test/{id}', 'TestController@show');

// Test API
Route::get('/test', 'API\TestController@index');
Route::get('/test/{id}', 'API\TestController@show');

// Admin
Route::get('/show_all_admin', 'API\AdminController@show_all_admin');

// User
Route::get('/show_profile/{id}', 'API\UserController@show_profile');
Route::post('/create_profile/{id}', 'API\UserController@create_profile');
Route::post('/edit_profile/{id}', 'API\UserController@edit_profile');
