<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;

class AdminController extends Controller
{
    //
    public function list_all_admin() {
    	$admins = array();
    	$stacks = Admin::get();

    	foreach($stacks as $stack) {
    		$admin = array();
    		$admin['id'] = $stack->id;
        $admin['name'] = $stack->name;
        $admin['email'] = $stack->email;
    	}
    	return $admins;
    }
    public function index() {
      $admins = Admin::get();
    	return view('admin.list-admin', compact('admins'));
    }
}
