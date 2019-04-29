<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Profile;
use App\Tenant;
use App\Owner;


class UserController extends Controller
{

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

    public function show_user() {
        $users = User::paginate(5);

        return view('user.list-user', compact('users','tenants', 'owners'));
    }

    public function show_tenant() {
        $tenants = User::join('tenants','users.id','=','tenants.user_id')->paginate(5);
        $users = $tenants;

      return view('user.list-user', compact('users','tenants'));
    }

    public function show_owner() {
        $owners = User::join('owners','users.id','=','owners.user_id')->paginate(5);
        $users = $owners;

      return view('user.list-user', compact('users','owners'));
    }

    public function search(Request $request){
    if ( $request->has('search') ){
        // get profiles
        $user_ids = Profile::where('id', "LIKE", "%".$request->search."%")
                            ->orWhere('self_intro', "LIKE", "%".$request->search."%")
                            ->orWhere('contact', "LIKE", "%".$request->search."%")
                            ->orWhere('gender', "LIKE", "%".$request->search."%")
                            ->pluck('user_id')->toArray();
        $users = User::where('email', "LIKE", "%".$request->search."%")
                        ->orWhere('username', "LIKE", "%".$request->search."%")
                        ->orWhere('name', "LIKE", "%".$request->search."%")
                        ->orWhereIn('id',$user_ids)
                        ->latest()
                        ->paginate(5)
                        ->appends('search', $request->search);

    }else{
      $users = User::latest()->paginate(5);
    }
    $searchPhrase = $request->search;
    return view('user.list-user', compact('users','searchPhrase'));
   }
}
