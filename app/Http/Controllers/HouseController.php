<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\House;


class HouseController extends Controller
{
    //
    public function list_all_house() {
    	$houses = array();
    	$stacks = House::get();

    	foreach($stacks as $stack) {
    		$house = array();
    		$house['id'] = $stack->id;
    		$house['type'] = $stack->type;
    		$house['size'] = $stack->size;
    		$house['address'] = $stack->address;
    		$house['district_id'] = $stack->district_id;
    		$house['description'] = $stack->description;
    		$house['max_ppl'] = $stack->max_ppl;
    		$house['price'] = $stack->price; 
    		$house['status'] = $stack->status;
    		$house['owner_id'] = $stack->owner_id;
    		$house['is_deleted'] = $stack->is_deleted;
    		$house['created_at'] = $stack->created_at;  
    	}
    	return $houses;
    }

    public function show_house() {
        $houses = House::get();

        return view('house.list-house', compact('houses'));
    }

	public function show_house_details($id) {
        $house = House::where('id', $id)->first();

		return view('house.view-house',compact('house'));
	}

    public function edit_house_form($id) { // $id is user id
        $house = House::where('id', $id)->first();
          
        return view('house.edit-house', compact('house'));
                
    }


    public function update_house($id, Request $request) {
        
        $this->validate($request, [
            'edit-house-address' => 'required|max:255',
            'edit-house-size' => 'required|max:255',
            'edit-house-type' => 'required|max:255',
            'edit-house-price' => 'required|max:255',
            'edit-house-status' => 'required|max:255',
            'edit-house-owner_id' => 'required|max:255',
            'edit-house-max_ppl'  => 'required|max:255',
            'edit-house-description' => 'nullable|max:255'
            ], 

           [
            'edit-house-address' => 'Input Address',
            'edit-house-size' => 'Input Apartment Size',
            'edit-house-type' => 'Select Apartment Type',
            'edit-house-price' => 'Input Price',
            'edit-house-status' => 'Input Status',
            'edit-house-owner_id' => 'Input Owner ID',
            'edit-house-max_ppl'  => 'Input Maximum No. People',
            'edit-house-description' => 'Input Description'
            ]);

        // get targeted data
        $house = House::where('id', $id)->first();
        

        $house->address = $request->input('edit-house-address');
        $house->size = $request->input('edit-house-size');
        $house->type = $request->input('edit-house-type');
        $house->price = $request->input('edit-house-price');
        $house->status = $request->input('edit-house-status');
        $house->owner_id = $request->input('edit-house-owner_id');
        $house->max_ppl= $request->input('edit-house-max_ppl');
        $house->description = $request->input('edit-house-description');

        $house->save();


        // redirect to edit success page
        return view('house.edit-house-success', ['id'=> $id]);
    }
	
}

