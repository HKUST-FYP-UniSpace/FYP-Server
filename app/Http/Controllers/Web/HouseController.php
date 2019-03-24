<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HouseController extends Controller
{
    //
     public function show_house() {
    	return view('house.list-house');
    }

	public function show_house_details() {
		return view('hosue.view-house');
	}
	
}
