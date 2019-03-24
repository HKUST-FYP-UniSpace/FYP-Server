<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Tenant;
use App\Owner;
use App\Profile;
use App\ProfileDetail;
use App\Preference;
use App\PreferenceItem;
use App\PreferenceItemCategory;
use Validator;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // POST
    // "username" : (String)    --> username
    // "name" : (String)        --> name
    // "email" : (String)       --> email
    // "password" : (String)    --> password + hash
    // "userType" : (int)       --> tenants/owners: user_id
    // 0 = tenant, 1 = owner
    public function register(Request $request) {
        // prepare for errors
        $errors = array();
        $error = array();

        // grab all the input
        $input = $request->input();

       //  $validator = Validator::make($request->all(), [
       //      'username' => 'required|unique:users,username',
       //      'name' => 'required',
       //      'email' => 'required|email|unique:users,email',
       //      'password' => 'required',
       //      'userType' => 'required|integer|between:0,1',
       // ]);
       // if ($validator->fails()) {
       //     return response()->json(['error'=>$validator->errors()], 401);            
       // }

        // chcek the existence of username
        $if_username_exists = User::where('username', $input['username'])->first();
        if($if_username_exists != null) {  // username exists
            $error['message'] = "Your username has already been registered.";
            $error['resource'] = "create()";
            array_push($errors, $error);
        }

        // check the existence of email
        $if_email_exists = User::where('email', $input['email'])->first();
        if($if_email_exists != null) {  // email exists
            $error['message'] = "Your email has already been registered.";
            $error['resource'] = "create()";
            array_push($errors, $error);
        }

        if(!empty($errors)) {
            return $errors;
        }

        $new_user =  new User();
        $new_user->username = $input['username'];
        $new_user->name = $input['name'];
        $new_user->email = $input['email'];
        $new_user->password = Hash::make($input['password']);
        // $new_user->is_verified = 0;
        // $new_is_deleted = 0;

        $new_user->save();

        $new_user->token = JWTAuth::fromUser($new_user);

        $new_user->save();

        // user type -> tenant/owner
        if($input['userType'] == 0) { 
            // tenant
            $new_user_type = new Tenant();
            $new_user_type->user_id = $new_user->id;
            $new_user_type->save();
        }
        else if($input['userType'] == 1) {    
            // owner
            $new_user_type = new Owner();
            $new_user_type->user_id = $new_user->id;
            $new_user_type->save();
        }

        // check user type
        // $user_type = 0; // default is a tenant
        // $tenant = Tenant::where('user_id', $user->id);
        // if($tenant->first() == null) {  // not a tenant
        //     $user_type = 1;
        // } return response()->json(['success'=>$success], $this->successStatus);

        // if($new_user->is_deleted == 0) {
        //     $is_active = 1;
        // }
        // else {
        //     $is_active = 0;
        // }
        
        // $user = array();
        // $user['id'] = $new_user->id;
        // $user['username'] = $new_user->username;
        // $user['name'] = $new_user->name;
        // $user['email'] = $new_user->email;
        // $user['userType'] = $user_type;
        // $user['isActive'] = $is_active;
        // $user['createTime'] = $new_user->created_at;
        // $user['verified'] = $new_user->is_verified;

        // return $user;
        
        return response()->json(['result' => $new_user->token]);
    }

    // POST
    public function login(Request $request) {
        // prepare for errors
        $errors = array();
        $error = array();

        $credentials = $request->only('username','password');
        $token = JWTAuth::attempt($credentials);

        if(!$token){
            $error['message'] = "Incorrect username or password.";
            $error['code'] = "-1000";
            $error['resource'] = "login()";
            array_push($errors, $error);
        }

        if(!empty($errors)) {
            return $errors;
        }

        return response()->json(['result' => $token]);

    }

    // GET, param: token
    public function get_user_details(Request $request) {
        $input = $request->all();
        $user = JWTAuth::toUser($input['token']);

        return response()->json(['result' => $user]);
    }

    // -------------------------------------------------------

    // GET, param: user id
    public function show_profile($id) {
        // prepare for errors
        $errors = array();
        $error = array();

        // check user
        $user = User::find($id);
        if($user == null) {
            $error['message'] = "The user id does not exist.";
            $error['resource'] = "show_profile()";
            array_push($errors, $error);
        }

        // check profile
        $has_profile = Profile::where('user_id', $id)->first();
        if($has_profile == null) {
            $error['message'] = "The user profile does not exist.";
            $error['resource'] = "show_profile()";
            array_push($errors, $error);
        }

        if(!empty($errors)) {
            return $errors;
        }

        // check user type
        $user_type = 0; // default is a tenant
        $tenant = Tenant::where('user_id', $user->id);
        if($tenant->first() == null) {  // not a tenant
            $user_type = 1;
        }

        // prepare array
        $profile = array();
        $stack = $user->profile()->first();

        // check profile detail
        $hobby_model = null;
        $has_profile_detail = ProfileDetail::where('profile_id', $user->profile()->first()->id)->first();
        if($has_profile_detail == null) {
            // $error['message'] = "The user have not created a preference model.";
            // $error['resource'] = "show_profile()";
            // array_push($errors, $error);
        }
        else {
            // get preference model
            $profile_details = $stack->profile_detail()->get();
            $hobby_model = array();
            foreach($profile_details as $profile_detail) {
                $hobby_model_record = array();
                $hobbies = $profile_detail->hobby_item()->get();
                foreach($hobbies as $hobby) {
                    $category_name = $hobby->category()->first()->category;
                    $item = $hobby->name;
                    $hobby_model_record[$category_name] = $item;
                }
                array_push($hobby_model, $hobby_model_record);
            }
            //dd($hobby_model);
        }
        
        if($stack->is_deleted == 0) {
            $is_active = 1;
        }
        else {
            $is_active = 0;
        }

        $profile['id'] = $stack->id;
        $profile['username'] = $user->username;
        $profile['preference'] = $hobby_model;
        $profile['photoUrl'] = $stack->icon_url;

        $profile['email'] = $user->email;
        $profile['name'] = $stack->name;
        $profile['gender'] = $stack->gender;
        $profile['contact'] = $stack->contact;
        $profile['selfIntro'] = $stack->self_intro;
        $profile['userType'] = $user_type;
        $profile['isActive'] = $is_active;
        $profile['createTime'] = $stack->created_at;
        $profile['verified'] = $stack->is_verified;
        
        return $profile;
    }

    // POST, param: user id
    public function create_profile($id, Request $request) {
        // create error message
        $errors = array();
        $error = array();

        // check user
        $user = User::find($id);
        if($user == null) {
            $error['message'] = "The user id does not exist.";
            $error['resource'] = "show_profile()";
            array_push($errors, $error);
        }

        // check profile
        $has_profile = Profile::where('user_id', $id)->first();
        if($has_profile == null) {
            $error['message'] = "The user profile does not exist.";
            $error['resource'] = "show_profile()";
            array_push($errors, $error);
        }

        if(!empty($errors)) {
            return $errors;
        }

        $input = $request->all();


        $profile->save();

        return "New profile stored successfully with profile id = {$profile->id}, user id = {$profile->user_id}";
        //dd($profile);
    }

    // POST, param: user id
    public function edit_profile($id,  Request $request) {
        // check user
        $user = User::find($id);
        if($user == null) {
            return "The user id does not exist.";
        }

        // check profile
        $has_profile = Profile::where('user_id', $id);
        if($has_profile->first() == null) {
            return "The user has not created a profile yet.";
        }

        $input = $request->all();

        $profile = array();


        return $profile;
           
    }

    
}
