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


// House
// Route::get('/house/create', 'API\HouseController@create_house');
// Route::get('/house/{id}/edit', 'API\HouseController@edit_house');
Route::get('/house/{id}', 'API\HouseController@show_house'); //tested
Route::get('/house', 'API\HouseController@index_house'); //tested
Route::post('/house', 'API\HouseController@store_house'); //tested
Route::post('/house/{id}/delete', 'API\HouseController@delete_house'); //tested
Route::put('/house/{id}', 'API\HouseController@update_house'); //tested
Route::put('/house/{id}/archive', 'API\HouseController@archive_house'); //tested
Route::put('/house/{id}/hide', 'API\HouseController@hide_house'); //tested
Route::put('/house/{id}/reveal', 'API\HouseController@reveal_house'); //tested

// HouseBookmark
// Route::get('/houseBookmark/create', 'API\HouseBookmarkController@create_houseBookmark');
// Route::get('/houseBookmark/{id}/edit', 'API\HouseBookmarkController@edit_houseBookmark');
Route::get('/houseBookmark/{id}', 'API\HouseBookmarkController@show_houseBookmark'); //tested
Route::get('/houseBookmark', 'API\HouseBookmarkController@index_houseBookmark'); //tested
Route::post('/houseBookmark', 'API\HouseBookmarkController@store_houseBookmark'); //tested
Route::post('/houseBookmark/{id}/delete', 'API\HouseBookmarkController@delete_houseBookmark'); //tested
//Route::put('/houseBookmark/{id}', 'API\HouseBookmarkController@update_houseBookmark');

// Trade
// Route::get('/trade/create', 'API\TradeController@create_trade');
// Route::get('/trade/{id}/edit', 'API\TradeController@edit_trade');
Route::get('/trade/{id}', 'API\TradeController@show_trade'); //tested
Route::get('/trade', 'API\TradeController@index_trade'); //tested
Route::post('/trade', 'API\TradeController@store_trade'); //tested
Route::post('/trade/{id}/delete', 'API\TradeController@delete_trade'); //tested
Route::put('/trade/{id}', 'API\TradeController@update_trade'); //tested
Route::put('/trade/{id}/archive', 'API\TradeController@archive_trade'); //tested
Route::put('/trade/{id}/hide', 'API\TradeController@hide_trade'); //tested
Route::put('/trade/{id}/reveal', 'API\TradeController@reveal_trade'); //tested

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
Route::get('/tradeBookmark/{id}', 'API\TradeBookmarkController@show_tradeBookmark'); //tested
Route::get('/tradeBookmark', 'API\TradeBookmarkController@index_tradeBookmark'); //tested
Route::post('/tradeBookmark', 'API\TradeBookmarkController@store_tradeBookmark'); //tested
Route::post('/tradeBookmark/{id}/delete', 'API\TradeBookmarkController@delete_tradeBookmark'); //tested
//Route::put('/tradeBookmark/{id}', 'API\TradeBookmarkController@update_tradeBookmark');

// Blog
//Route::get('/blog/create', 'API\BlogController@create_blog');
//Route::get('/blog/{id}/edit', 'API\BlogController@edit_blog');

//Route::delete('/blog/{id}', 'API\BlogController@delete_blog');
Route::post('/blog/{id}/delete', 'API\BlogController@delete_blog'); //Why not delete request
Route::post('/blog/{id}/delete/{comment_id}', 'API\BlogController@delete_blog_comment');

Route::post('/blog/{id}/comment', 'API\BlogController@comment_blog');
Route::get('/blog/{id}', 'API\BlogController@show_blog'); //tested
Route::post('/blog', 'API\BlogController@store_blog'); //tested
Route::put('/blog/{id}', 'API\BlogController@update_blog'); //?? (dealing with null->0 problem)
Route::get('/blog', 'API\BlogController@index_blog'); //tested

// Search Engine
Route::post('/search/trade', 'API\SearchEngineController@searchTrade');
Route::post('/search/house', 'API\SearchEngineController@searchHouse');
