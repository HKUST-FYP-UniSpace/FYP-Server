<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestController extends Controller
{
    //
    public function index() {
    	return Admin::get();
    }

    public function show($id) {
    	return Admin::find($id);
    }
}
