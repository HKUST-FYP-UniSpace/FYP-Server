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
use App\Calendar;
use App\Mail\UserVerification;

use Validator;
use Carbon\Carbon;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Mail;

use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

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

    // POST: user registration/register
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
        // $new_user->is_verified = 1;    // hard code first
        // $new_is_deleted = 0;

        // generate a random verification code
        $number1 = (string) mt_rand(0, 9);
        $number2 = (string) mt_rand(0, 9);
        $number3 = (string) mt_rand(0, 9);
        $number4 = (string) mt_rand(0, 9);
        $number5 = (string) mt_rand(0, 9);
        $number6 = (string) mt_rand(0, 9);

        $new_user->verification_code = $number1.$number2.$number3.$number4.$number5.$number6;
        // dd($new_user->verification_code);

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
            $preferenceModel = array();

            if(isset($input['preference']['gender'])) {
            $preference_id = PreferenceItem::where('category_id', 1)->where('name', $input['preference']['gender'])->first()->id;

            $new_preference_detail = new ProfileDetail();
            $new_preference_detail->profile_id = $new_profile->id;
            $new_preference_detail->item_id = intval($preference_id);
            $new_preference_detail->save();

            $preferenceModel['gender'] = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
            }
            else {  // null means no preference
                $new_preference_detail = new ProfileDetail();
                $new_preference_detail->profile_id = $profile->id;
                $new_preference_detail->item_id = 3;
                $new_preference_detail->save();

                $preferenceModel['gender'] = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
            }

            if(isset($input['petFree'])) {
                if($input['preference']['petFree'] == true) {
                    $petfree = "true";
                }
                elseif($input['preference']['petFree'] == false) {
                    $petfree = "false";
                }
                $preference_id = PreferenceItem::where('category_id', 2)->where('name', $petfree)->first()->id;

                $new_preference_detail = new ProfileDetail();
                $new_preference_detail->profile_id = $profile->id;
                $new_preference_detail->item_id = intval($preference_id);
                $new_preference_detail->save();

                $preferenceModel['petFree'] = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
            }

            if(isset($input['preference']['timeInHouse'])) {
                $preference_id = PreferenceItem::where('category_id', 3)->where('name', $input['preference']['timeInHouse'])->first()->id;

                $new_preference_detail = new ProfileDetail();
                $new_preference_detail->profile_id = $new_profile->id;
                $new_preference_detail->item_id = intval($preference_id);
                $new_preference_detail->save();

                $preferenceModel['timeInHouse'] = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
            }

            if(isset($input['preference']['personalities'])) {
                $preferenceModel['personalities'] = array();
                foreach($input['preference']['personalities'] as $personalities) {
                    $preference_id = PreferenceItem::where('category_id', 4)->where('name', $personalities)->first()->id;

                    $new_preference_detail = new ProfileDetail();
                    $new_preference_detail->profile_id = $new_profile->id;
                    $new_preference_detail->item_id = intval($preference_id);
                    $new_preference_detail->save();

                    $temp = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
                    array_push($preferenceModel['personalities'], $temp);
                }
            }

            if(isset($input['preference']['interests'])) {
                $preferenceModel['interests'] = array();
                foreach($input['preference']['interests'] as $interests) {
                    $preference_id = PreferenceItem::where('category_id', 5)->where('name', $interests)->first()->id;

                    $new_preference_detail = new ProfileDetail();
                    $new_preference_detail->profile_id = $new_profile->id;
                    $new_preference_detail->item_id = intval($preference_id);
                    $new_preference_detail->save();

                    $temp = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
                    array_push($preferenceModel['interests'], $temp);
                }
            }
        }
        else {
            $preferenceModel = null;
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

    // POST: send verification email/verify
    public function send_verification_code($id, Request $request) {
        $user = User::where('id', $id)->first();
        $email = $user->email;

        $result = array();
        $is_success = false;

        // send email with code
        $mail = Mail::to($email)->send(new UserVerification($user));
        // dd($mail);
        $is_success = true;

        $result['isSuccess'] = $is_success;

        return $result;
    }

    // POST: verify
    public function verify_code($id, Request $request) {
        $user = User::where('id', $id)->first();
        $code_db = $user->verification_code;

        $result = array();
        $is_success = false;

        // grab all the input
        $input = $request->input();
        $code_input = $input['code'];

        if($code_db == $code_input) {
            $user->is_verified = 1;
            $user->save();
            $is_success = true;
        }

        $result['isSuccess'] = $is_success;

        return $result;
    }

    // POST: user login
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
                $preferenceModel = array();
                foreach($profile_details as $profile_detail) {
                    $preference_name = PreferenceItem::where('id', $profile_detail->item_id)->first()->name;
                    $category_id = PreferenceItem::where('id', $profile_detail->item_id)->first()->category_id;
                    $category_name = PreferenceItemCategory::where('id', $category_id)->first()->category;
                    if($category_name == "gender" || $category_name == "petFree" || $category_name == "timeInHouse") {
                        $preferenceModel[$category_name] = $preference_name;
                    }
                    elseif($category_name == "personalities" || $category_name == "interests") {
                        if(!isset($preferenceModel['personalities'])) {
                        $preferenceModel['personalities'] = array();
                        }
                        if(!isset($preferenceModel['interests'])) {
                            $preferenceModel['interests'] = array();
                        }
                        $temp = $preference_name;
                        array_push($preferenceModel[$category_name], $temp);
                    }
                }
                $profile['preference'] = $preferenceModel;
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

    // GET: display user profile
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
            $preferenceModel = null;
        }
        else {
            // get preference model
                $profile_details = $stack->profile_detail()->get();
                $preferenceModel = array();
                foreach($profile_details as $profile_detail) {
                    $preference_name = PreferenceItem::where('id', $profile_detail->item_id)->first()->name;
                    $category_id = PreferenceItem::where('id', $profile_detail->item_id)->first()->category_id;
                    $category_name = PreferenceItemCategory::where('id', $category_id)->first()->category;
                    if($category_name == "gender" || $category_name == "petFree" || $category_name == "timeInHouse") {
                        $preferenceModel[$category_name] = $preference_name;
                    }
                    elseif($category_name == "personalities" || $category_name == "interests") {
                        if(!isset($preferenceModel['personalities'])) {
                        $preferenceModel['personalities'] = array();
                        }
                        if(!isset($preferenceModel['interests'])) {
                            $preferenceModel['interests'] = array();
                        }
                        $temp = $preference_name;
                        array_push($preferenceModel[$category_name], $temp);
                    }
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
        $profile['preference'] = $preferenceModel;
        $profile['photoURL'] = $stack->icon_url;

        $profile['email'] = $user->email;
        $profile['name'] = $user->name;
        $profile['gender'] = $stack->gender;
        $profile['contact'] = $stack->contact;
        $profile['selfIntro'] = $stack->self_intro;
        $profile['userType'] = $user_type;
        $profile['isActive'] = $is_active;
        $profile['createTime'] = strtotime($stack->created_at);
        $profile['verified'] = $user->is_verified;
        
        return $profile;
    }

    // POST: edit user profile
    public function edit_profile($id, Request $request) {
        // profiles: [id], gender, contact, self_intro, icon_url, [user_id]
        $input = $request->input();
        $user = User::where('id', $id)->first();
        $user_profile = Profile::where('user_id', $id)->first();
        $user = $user_profile->user()->first();
        if(isset($input['name'])) {
            $user->name = $input['name'];
        }
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

        $user->save();
        $user_profile->save();

        $profile = array();
        $profile['id'] = $id;
        $profile['name'] = $user->name;
        $profile['gender'] = $user_profile->gender;
        $profile['contact'] = $user_profile->contact;
        $profile['selfIntro'] = $user_profile->self_intro;
        $profile['photoURL'] = $user_profile->icon_url;
        $profile['userId'] = $id;
        $profile['createTime'] = strtotime($user_profile->created_at);

        return $profile;
    }

    // POST: edit user preference model
    public function edit_preference($id, Request $request) {
        // profile_details: [id], profile_id, item_id <--> preference_items: id
        $input = $request->input();
        $result = array();
        $result['id'] = $id;

        $profile = Profile::where('user_id', $id)->first();

        // delete all the current records in profile_details
        $profile_details = ProfileDetail::where('profile_id', $profile->id)->get();
        foreach($profile_details as $profile_detail) {
            $profile_detail->delete();
        }

        if(isset($input['gender'])) {
            $preference_id = PreferenceItem::where('category_id', 1)->where('name', $input['gender'])->first()->id;

            $new_preference_detail = new ProfileDetail();
            $new_preference_detail->profile_id = $profile->id;
            $new_preference_detail->item_id = intval($preference_id);
            $new_preference_detail->save();

            $result['gender'] = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
        }
        else {  // null means no preference
            $new_preference_detail = new ProfileDetail();
            $new_preference_detail->profile_id = $profile->id;
            $new_preference_detail->item_id = 3;
            $new_preference_detail->save();

            $result['gender'] = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
        }

        if(isset($input['petFree'])) {
            if($input['petFree'] == true) {
                $petfree = "true";
            }
            elseif($input['petFree'] == false) {
                $petfree = "false";
            }
            $preference_id = PreferenceItem::where('category_id', 2)->where('name', $petfree)->first()->id;

            $new_preference_detail = new ProfileDetail();
            $new_preference_detail->profile_id = $profile->id;
            $new_preference_detail->item_id = intval($preference_id);
            $new_preference_detail->save();

            $result['petFree'] = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
        }

        if(isset($input['timeInHouse'])) {
            $preference_id = PreferenceItem::where('category_id', 3)->where('name', $input['timeInHouse'])->first()->id;

            $new_preference_detail = new ProfileDetail();
            $new_preference_detail->profile_id = $profile->id;
            $new_preference_detail->item_id = intval($preference_id);
            $new_preference_detail->save();

            $result['timeInHouse'] = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
        }

        if(isset($input['personalities'])) {
            $result['personalities'] = array();
            foreach($input['personalities'] as $personalities) {
                $preference_id = PreferenceItem::where('category_id', 4)->where('name', $personalities)->first()->id;

                $new_preference_detail = new ProfileDetail();
                $new_preference_detail->profile_id = $profile->id;
                $new_preference_detail->item_id = intval($preference_id);
                $new_preference_detail->save();

                $temp = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
                array_push($result['personalities'], $temp);
            }
        }

        if(isset($input['interests'])) {
            $result['interests'] = array();
            foreach($input['interests'] as $interests) {
                $preference_id = PreferenceItem::where('category_id', 5)->where('name', $interests)->first()->id;

                $new_preference_detail = new ProfileDetail();
                $new_preference_detail->profile_id = $profile->id;
                $new_preference_detail->item_id = intval($preference_id);
                $new_preference_detail->save();

                $temp = PreferenceItem::where('id', $new_preference_detail->item_id)->first()->name;
                array_push($result['interests'], $temp);
            }
        }

        return $result;
    }

    // POST: check existence of username
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

    // GET: Calendar
    public function calendar($id, $year, $month) {
        $result = array();

        $year = (int) $year;
        $month = (int) $month;
        $user = User::where('id', $id)->first();
        $events = $user->calendar()->where('year', $year)->where('month', $month)->orderBy('date')->orderBy('start_time')->get();
        $first_day = 1;
        // $first_day = (int) $events[0]->day;

        if(empty($events)) {
            $result = null;
        }
        else {
            for($i = $first_day; $i <= 31; $i++) {
                $day_events = $user->calendar()->where('year', $year)->where('month', $month)->where('day', $i)->orderBy('date')->orderBy('start_time')->get();
                if(!($day_events->isEmpty())) {
                    $temp_date = array();
                    $temp_date['date'] = $i;
                    $temp_date['data'] = array();

                    foreach($day_events as $day_event) {
                        $temp_event = array();
                        $temp_event['startTime'] = $day_event->start_time;
                        $temp_event['endTime'] = $day_event->end_time;
                        $temp_event['appointment'] = $day_event->event;
                        array_push($temp_date['data'], $temp_event);
                    }

                    array_push($result, $temp_date);
                }

            }
        }


        return $result;
    }

    // POST: Create Calendar Event
    public function new_event($id, Request $request) {
        $event = new Calendar();
        $event->event = $request['event'];
        $event->date = date('Y-m-d', strtotime($request['date']));
        $event->year = (int) date('Y', strtotime($event->date));
        $event->month = (int) date('m', strtotime($event->date));;
        $event->day = (int) date('d', strtotime($event->date));;
        $event->start_time = date('h:i:s', strtotime($request['startTime']));
        $event->end_time = date('h:i:s', strtotime($request['endTime']));
        $event->venue = $request['venue'];
        $event->user_id = $id;

        $event->save();
        $result['isSuccess'] = true;

        return $result;
    }


}
