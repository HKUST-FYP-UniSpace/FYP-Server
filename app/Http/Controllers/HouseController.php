<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
