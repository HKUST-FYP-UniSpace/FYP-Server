<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Admin;

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
