<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;



class AdminLoginController extends Controller
{
    //
    public function __construct() {
    	$this->middleware('guest:admin');
    }

    public function show_login_form() {
    	return view('auth.login');
    }

    public function login(Request $request) {
    	// validate form data
      // dd($request);
    	$this->validate($request, [
    		'email' => 'required|email',
    		'password' => 'required|min:8'
    	]);

    	// // attempt to log the user in
    	// if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password])) {
      //       // if successful, then redirect to their intended location
      //       // return redirect()->intended(route('admin.dashboard'));
      //       return view('admin');
    	// }
      // // if unsuccessful, then redirect back to the login with the form data
      // return redirect()->back()->withInput($request->only('email'));
      // // return redirect()->back();

      return view('admin');

    }

}
