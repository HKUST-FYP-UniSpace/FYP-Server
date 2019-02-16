<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    //
    public function list_all_user() {
    	$users = array();
    	$stacks = User::get();
    	foreach($stacks as $stack) {
    		$user = array();
    		$user['id'] = $stack->id;
    		$user['username'] = $stack->username;
    		$user['name'] = $stack->name;
    		$user['email'] = $stack->email;
    	}
    	return $users;
    }
}
