<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Profile;

class ProfileController extends Controller
{
    //
    public function view_user_profile($id) {
         // get targeted data
        $user = User::where('id', $id)->first();
        $profile = $user->profile()->first();

    	return view('user.view-user', compact('user','profile'));
    }

     public function edit_user_form($id) { // $id is user id
    	$user = User::where('id', $id)->first();
		  
    	return view('user.edit-user', compact('user'));
    	    	
    }


    public function update_user($id, Request $request) {
        
        $this->validate($request, [
        	'edit-profile-name' => 'required|max:255',
			'edit-profile-username' => 'required|max:255',
			'edit-profile-contact' => 'required|max:255',
			'edit-profile-email' => 'email',
			'edit-profile-gender'  => 'required|max:255',
			'edit-profile-selfIntroduction' => 'nullable|max:255'
        	], 

           ['edit-profile-name.required' => 'Input Name',
        	'edit-profile-username.required' => 'Input Username',
        	'edit-profile-contact' => 'Input Contact',
			'edit-profile-email' => 'Input Email',
			'edit-profile-gender'  => 'Input Gender',
			'edit-profile-selfIntroduction' => 'Input Self Introduction'

        	]);

    	// get targeted data
    	$user = User::where('id', $id)->first();
    	$profile = $user->profile()->first();

    	$profile->name = $request->input('edit-profile-name');
    	$user->username = $request->input('edit-profile-username');
    	$profile->contact = $request->input('edit-profile-contact');
    	$user->email = $request->input('edit-profile-email');
     	$profile->gender = $request->input('edit-profile-gender');   	
    	$profile->self_intro = $request->input('edit-profile-selfIntroduction');

    	$profile->save();
    	$user->save();

        // redirect to edit success page
    	return view('user.edit-user-success', ['id'=> $id]);
    }
}


  