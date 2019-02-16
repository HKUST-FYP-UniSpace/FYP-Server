<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use Validator;

class UserController extends Controller
{
    // GET, param: user id
    public function show_profile($id) {
        $result_all = array();
        $result_all['status'] = "0";
        $result = array();
        $errors = array();

        // prepare array
        $profile = array();
        $stack = User::find($id)->profile()->first();
        $profile['id'] = $stack->id;
        $profile['gender'] = $stack->gender;
        $profile['name'] = $stack->name;
        $profile['contact'] = $stack->contact;
        $profile['self_intro'] = $stack->self_intro;
        $profile['icon_url'] = $stack->icon_url;
        $profile['user_id'] = $stack->user_id;

        $result['profile'] = $profile;
        $result['errors'] = $errors;
        $result_all['result'] = $result;
        $result_all['status'] = "1";    // success
        
        return $result_all;
    }

    public function create_profile(Request $request) {
        $result_all = array();
        $result_all['status'] = "0";
        $result = array();
        $errors = array();
        $input = $request->all();

        // validation
        // $validator = Validator::make($request->all(), [
        //     'icon_url' => 'image|mimes:jpeg,png,jpg|max:2048', //KB
        // ]);
        
        // if ($validator->fails()){
        //     $errors = $validator->errors()->all();
        //     $result['message'] = 'Error found when handling profile_pic.';
        //     $result_all['status'] = "0";
        //     $result['errors'] = $errors;
        //     $result_all['result'] = $result;
        //     return $result_all;
        // }

        // terminate the function if there's any error found
        // if(!empty($errors)) {
        //     $result['errors'] = $errors;
        //     $result_all['result'] = $result;
        //     return $result_all;
        // }

        if(isset($input['gender']) && (!empty($input['gender']))) {
            array_push($errors, 'Email format is not correct.');
        }

    }

    public function edit_profile(Request $request) {

    }

    
}
