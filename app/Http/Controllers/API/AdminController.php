<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Admin;
use Validator;
use Carbon\Carbon;

class AdminController extends Controller
{
    //
    public function show_all_admin() {
    	$result_all = array();
        $result_all['status'] = "0";
        $result = array();
        $errors = array();

        // validation is not necessary for GET request
        // $validator = Validator::make($request->all(), [
        //     'token' => 'required|string',
        //     'position_id' => 'required|integer|min:1|max:3',
        // ]);
        // if ($validator->fails()){
        //     $errors = $validator->errors()->all();
        //     $result["message"] = 'error occurred during api call.';
        //     $result["errors"] = $errors;
        //     $result_all["result"] = $result;
        //     return $result_all;
        // }
        
        // prepare array
        $admins = array();
        $stacks = Admin::get();	// retrieve all records from Admin
        foreach($stacks as $stack) {
        	$admin = array();
        	$admin['id'] = $stack->id;
        	$admin['name'] = $stack->name;
        	$admin['password'] = $stack->password;
        	$admin['email'] = $stack->email;
        	array_push($admins, $admin);
        }

        $result['admins'] = $admins;
        $result['errors'] = $errors;
        $result_all['result'] = $result;
        $result_all['status'] = "1";	// success
        return $result_all;
    }
    
}
