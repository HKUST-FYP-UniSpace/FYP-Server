<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\House;
use App\District;


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
        $houses = House::paginate(2);

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


    public function add_house_form() { // $id is user id
        $house = House::get();
        $house_districts = District::get();
      
        return view('house.add-house', compact('house_districts','house'));
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


    // process POST request
    public function add_house(Request $request) {
        // validation
        //dd($request);
        $this->validate($request, [
                'add-house-address' => 'required|max:255',
                'add-house-price' => 'required|max:255',
                'add-house-size' => 'required|max:255',
                'add-house-max_ppl' => 'required|integer',
                'add-house-description' => 'required|max:255',
                // 'add-house-post_date' => 'required',
                'add-house-owner_id' => 'required|max:255',
                'add-house-type' => 'required',
                'add-house-district_id' => 'required',
                // 'add-house-house_category_id' => 'required'
            ], 
            [
 
                'add-house-address.required' => 'Input house address',
                'add-house-address.max' => 'Address cannot be too long',

                'add-house-price.required' => 'Input price',
                'add-house-size.required' => 'Input size',

                'add-house-max_ppl.required' => 'Input Maximum No. People',
                'add-house-max_ppl.integer' => 'Input integer only',

                'add-house-description.required' => 'Input description',
                'add-house-description.max' => 'Description cannot be too long',

                // 'add-house-post_date.required' => 'Input Post Date in YYYY-MM-DD',

                'add-house-owner_id.required' => 'Input house owner_id',
                'add-house-owner_id.max' => 'Owner ID cannot be too long',

                'add-house-type.required' => 'Select Apartment Type', //hard code slect

                'add-house-district_id.required' => 'Select District ID', //select from database

                // 'add-house-house_category_id' => 'Select house Category'
            ]
        );

        // form information filled by users
        $house= new house();

        $house->status = "1";
        $house->is_deleted = "1";


        // address
        $house->address = $request->input('add-house-address');
        // description
        $house->description = $request->input('add-house-description');
        // max_ppl
        $house->max_ppl = $request->input('add-house-max_ppl');
        // price
        $house->price = $request->input('add-house-price');
        // size
        $house->size = $request->input('add-house-size');
        // // post-date
        // $house->post_date = $request->input('add-house-post_date');
        // owner_id   
        $house->owner_id = $request->input('add-house-owner_id');
        // house type
        $house->type = (intval($request->input('add-house-type')));
        // district_id
        $house->district_id = intval($request->input('add-house-district_id'));


        // save in database
        $house->save();
        // redirect to add success page
        return view('house.add-house-success', ['id'=> $house->id]);
    }
	
}

