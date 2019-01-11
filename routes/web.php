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

//Route::get('/login', 'AdminController@login');


