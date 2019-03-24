<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function show_user() {
    	return view('user.list-user');
    }

    //show user profile
    public function show_user_profile() {
    	return view('user.view-user');
    }
}
