<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Admin;
use Auth;
use Hash;
use Validator;


class AdminController extends Controller
{

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

    public function landing()
    {
        return view('admin');
    }

    public function index() {
      $admins = Admin::get();
    	return view('admin.list-admin', compact('admins'));
    }

    public function add_admin_form() {
      return view('admin.add-admin');
    }

    public function add_admin(Request $request) {
      $this->validate($request, [
          'add-admin-name' => 'required|max:255',
          'add-admin-email' => 'required|email|unique:admins,email|max:255',
          'add-admin-password' => 'required|min:8',
          'add-admin-password-confirm' => 'same:add-admin-password'
          ],

         [
          'add-admin-name.required' => 'Input name',
          'add-admin-email.required' => 'Input email',
          'add-admin-email.email' => 'Input correct email',
          'add-admin-email.unique' => 'Email has been registered',
          'add-admin-password.required' => 'Input passsword',
          'add-admin-password.min' => 'Input at least 8 characters',
          'add-admin-password-confirm.same' => 'Input same password'
          ]);

          $admin = new Admin();
          $admin->name = $request->input('add-admin-name');
          $admin->email = $request->input('add-admin-email');
          $admin->password = Hash::make($request->input('password'));
          $admin->is_deleted = 0;
          $admin->save();

      return view('admin.add-admin-success');
    }

    public function delete($delete_id, Request $request) {
    //dd($request);
      $admin= Admin::where('id', $delete_id)->first();
      $admin->is_deleted = 1;
      $admin->save();

      return back();
    }
}
