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
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class UserController extends Controller
{
    // test using cookies
    public function test_cookie() {
        $user = User::first();

        $content = array();
        $content['id'] = $user->id;
        $content['username'] = $user->username;
        $content['preferenceModel'] = null;

        $token = JWTAuth::fromUser($user);

        return response($content)->cookie('token', $token, 60);
    }

    // POST
    public function register(Request $request) {
        // dd($request);
        // prepare for errors
        $errors = array();
        $error = array();

        // grab all the input
        $input = $request->input();

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
        $new_user->is_verified = 0;
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

        // create a profile
        $new_profile = new Profile();
        $new_profile->user_id = $new_user->id;
        if(isset($input['gender'])) {
            $new_profile->gender = $input['gender'];
        }
        else {
            $new_profile->gender = null;
        }
        if(isset($input['contact'])) {
            $new_profile->contact = $input['contact'];
        }
        else {
            $new_profile->contact = null;
        }
        if(isset($input['selfIntro'])) {
            $new_profile->self_intro = $input['selfIntro'];
        }
        else {
            $new_profile->self_intro = null;
        }
        if(!empty($request->file('photoURL'))) {
            $image = $request->file('photoURL');
            $extension = $image->getClientOriginalExtension();

            $now = strtotime(Carbon::now());
            $url = $new_user->username.$now.'.'.$extension;
            Storage::disk('public')->put($url,  File::get($image));
            

            $new_profile->icon_url = url('uploads/'.$url);
        }

        $new_profile->save();

        // create preference
        if(isset($input['preference'])) {
            $preferenceModel = $input['preference'];
            foreach ($preferenceModel as $modelDetail) {
                $preference_category = PreferenceItemCategory::where('category', key($modelDetail))->get()->first();
                $preference_category_id = intval($preference_category['id']);
                $preference_item = PreferenceItem::where('category_id', $preference_category_id)->where('name', $modelDetail)->first();
                $preference_item_id = $preference_item['id'];

                $preference = new ProfileDetail();
                $preference->profile_id = $new_profile->id;
                $preference->item_id = intval($preference_item_id);
                $preference->save();
            }
        }
        else {
            $preference = null;
        }
        
        // for return object
        $profile = array();
        $profile['id'] = $new_user->id;
        $profile['username'] = $new_user->username;
        $profile['preference'] = $preferenceModel;
        $profile['photoURL'] = $new_profile->icon_url;

        $profile['email'] = $new_user->email;
        $profile['name'] = $new_user->name;
        $profile['gender'] = $new_profile->gender;
        $profile['contact'] = $new_profile->contact;
        $profile['selfIntro'] = $new_profile->self_intro;
        
        // check user type
        $user_type = 0; // default is a tenant
        $tenant = Tenant::where('user_id', $new_user->id);
        if($tenant->first() == null) {  // not a tenant
            $user_type = 1;
        }
        $profile['userType'] = $user_type;

        if($new_user->is_deleted == 0) {
            $is_active = 1;
        }
        else {
            $is_active = 0;
        }
        $profile['isActive'] = $is_active;
        $profile['createTime'] = strtotime($new_user->created_at);
        $profile['verified'] = $new_user->is_verified;
        
        return response($profile)->cookie('token', $new_user->token, 1440);
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

        // grab all the input
        $input = $request->input();

        $user = User::where('username', $input['username'])->first();

        $profile = array();
        // dd($new_user);
        $profile['id'] = $user->id;
        $profile['username'] = $user->username;


        

        $has_profile = Profile::where('user_id', $user->id)->first();
        if($has_profile == null) {
            $profile['photoURL'] = null;
            $profile['gender'] = null;
            $profile['contact'] = null;
            $profile['selfIntro'] = null;
        }
        else {
            $user_profile = $user->profile()->first();
            $profile['photoURL'] = $user_profile->icon_url;
            $profile['gender'] = $user_profile->gender;
            $profile['contact'] = $user_profile->contact;
            $profile['selfIntro'] = $user_profile->self_intro;


            // check profile detail
            $hobby_model = null;
            $has_profile_detail = ProfileDetail::where('profile_id', $user->profile()->first()->id)->first();
            if($has_profile_detail == null) {
                $profile['preference'] = null;
            }
            else {
                // get preference model
                $profile_details = $user_profile->profile_detail()->get();
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
                $profile['preference'] = $hobby_model;
            }
        }

        $profile['email'] = $user->email;
        $profile['name'] = $user->name;
        
        // check user type
        $user_type = 0; // default is a tenant
        $tenant = Tenant::where('user_id', $user->id);
        if($tenant->first() == null) {  // not a tenant
            $user_type = 1;
        }
        $profile['userType'] = $user_type;

        if($user->is_deleted == 0) {
            $is_active = 1;
        }
        else {
            $is_active = 0;
        }
        $profile['isActive'] = $is_active;
        $profile['createTime'] = strtotime($user->created_at);
        $profile['verified'] = $user->is_verified;

        return response($profile)->cookie('token', $user->token, 1440);

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
        $profile['photoURL'] = $stack->icon_url;

        $profile['email'] = $user->email;
        $profile['name'] = $stack->name;
        $profile['gender'] = $stack->gender;
        $profile['contact'] = $stack->contact;
        $profile['selfIntro'] = $stack->self_intro;
        $profile['userType'] = $user_type;
        $profile['isActive'] = $is_active;
        $profile['createTime'] = strtotime($stack->created_at);
        $profile['verified'] = $stack->is_verified;
        
        return $profile;
    }

    // 
    public function edit_profile($id, Request $request) {
        // profiles: [id], gender, contact, self_intro, icon_url, [user_id]
        $input = $request->input();

        $user_profile = Profile::where('user_id', $id)->first();
        $user = $user_profile->user()->first();
        if(isset($input['gender'])) {
            $user_profile->gender = $input['gender'];
        }
        if(isset($input['contact'])) {
            $user_profile->contact = $input['contact'];
        }
        if(isset($input['selfIntro'])) {
            $user_profile->self_intro = $input['selfIntro'];
        }
        if(!empty($request->file('photoURL'))) {
            $image = $request->file('photoURL');
            $extension = $image->getClientOriginalExtension();

            $now = strtotime(Carbon::now());
            $url = $user->username.$now.'.'.$extension;
            Storage::disk('public')->put($url,  File::get($image));
            

            $user_profile->icon_url = url('uploads/'.$url);
        }

        $user_profile->save();

        return $user_profile;
    }

    // 
    public function edit_preference($id, Request $request) {
        // profile_details: [id], profile_id, item_id <--> preference_items: id
        $input = $request->input();
        $result = array();

        $profile = Profile::where('user_id', $id)->first();
        $profile_details = ProfileDetail::where('profile_id', $profile->id)->get();
        foreach($profile_details as $profile_detail) {
            $profile_detail->delete();
        }

        $preferenceModel = $input['preference'];
        foreach ($preferenceModel as $modelDetail) {
            $preference_category = PreferenceItemCategory::where('category', key($modelDetail))->get()->first();
            $preference_category_id = intval($preference_category['id']);
            $preference_item = PreferenceItem::where('category_id', $preference_category_id)->where('name', $modelDetail)->first();
            $preference_item_id = $preference_item['id'];
            $preference = new ProfileDetail();
            $preference->profile_id = $profile->id;
            $preference->item_id = intval($preference_item_id);
            $preference->save();

            array_push($result, $preference);
        }
        return $result;
    }

    // 
    public function check_username(Request $request) {
        $result = array();

        $input = $request->input();
        $user = User::where('username', $input['username'])->first();
        $is_exists = false;
        if($user) {
            $is_exists = true;
        }

        $result['isExists'] = $is_exists;

        return $result;
    }

    
}
