<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Preference;

class PreferenceController extends Controller
{
    //
    public function list_all_preference() {
    	$preferences = array();
    	$stacks = Admin::get();

    	foreach($stacks as $stack) {
    		$preference = array();
    		$preference['id'] = $stack->id;
        $preference['item_id'] = $stack->item_id;
        $preference['group_id'] = $stack->group_id;
    	}
    	return $preferences;
    }
}
