<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\House;
use Validator;
use Carbon\Carbon;

class HouseController extends Controller
{
    //
    // public function create_house(){
    //
    // }
    //
    //
    // public function edit_house(){
    //
    // }

    // Have to delete house_post_group, group, group details,
    // house_image and house_comment together (also house_post_bookmark?)
    public function delete_house($id){
      $house = House::where('id', $id)->first();
      if($house == null){
        return "House with respective ID number does not exist.";
      }

      $house->delete();

      $success_msg = "Successfully deleted house with ID = {$id}";
      return $success_msg;
    }


    //Hide house as soft delete
    public function hide_house($id){
      $house = House::where('id', $id)->first();

      if($house == null){
        return "House with respective ID numebr does not exist";
      }

      $house->status = 0; // currently set "0" as "hide" status
      $house->save();

      $success_msg = "House hidden Successfully (House ID = {$id})";
      return $success_msg;
    }


    // The following functions are not on the api list (a good to have?)
    public function store_house(Request $request){
      $house = new House();

      $house->type = $request->input('type');
      $house->size = $request->input('size');
      $house->address = $request->input('address');
      $house->district_id = $request->input('district_id');
      $house->description = $request->input('description');
      $house->max_ppl = $request->input('max_ppl');
      $house->price = $request->input('price');
      $house->status = $request->input('status');
      $house->owner_id = $request->input('owner_id');
      $house->is_deleted = $request->input('is_deleted');

      $house->save();

      $success_msg = "New house stored Successfully! (House ID = {$house->id})";
      return $success_msg;
    }


    public function update_house($id, Request $request){
      $house = House::where("id", $id)->first();

      if($house == null){
        return "House with respective ID number does not exist";
      }

      $house->type = ($request->input('type')==null ? "" : $request->input('type'));
      $house->size = (double)($request->input('size')==null ? "" : $request->input('size'));
      $house->address = ($request->input('address')==null ? "" : $request->input('address'));
      $house->district_id = (int)($request->input('district_id')==null ? "" : $request->input('district_id'));
      $house->description = ($request->input('description')==null ? "" : $request->input('description'));
      $house->max_ppl = (int)($request->input('max_ppl')==null ? "" : $request->input('max_ppl'));
      $house->price = (double)($request->input('price')==null ? "" : $request->input('price'));
      $house->status = (int)($request->input('status')==null ? "" : $request->input('status'));
      $house->owner_id = (int)($request->input('owner_id')==null ? "" : $request->input('owner_id'));
      $house->is_deleted = (int)($request->input('is_deleted')==null ? "" : $request->input('is_deleted'));

      $house->save();

      $success_msg = "House Updated Successfully (ID = {$id})";
      return $success_msg;
    }


    public function show_house($id){
      $house = House::where("id", $id)->first();

      if($house == null){
        return "House with respective ID numebr does not exist";
      }

      $result_all = array();
      $result_all['status'] = 0;
      $result = array();
      //$result['errors'] = array();

      $result_house = array();
      $result_house['type'] = $house->type;
      $result_house['size'] = $house->size;
      $result_house['address'] = $house->address;
      $result_house['district_id'] = $house->district_id;
      $result_house['description'] = $house->description;
      $result_house['max_ppl'] = $house->max_ppl;
      $result_house['price'] = $house->price;
      $result_house['status'] = $house->status;
      $result_house['owner_id'] = $house->owner_id;
      $result_house['is_deleted'] = $house->is_deleted;
      $result_house['created_at'] = $house->created_at;
      $result_house['updated_at'] = $house->updated_at;

      $result['house'] = $result_house;
      //$result['errors'] = $errors;
      $result_all['result'] = $result;
      $result_all['status'] = '1';

      return $result_all;
    }


    public function index_house(){
      $result_all = array();
      $result_all['status'] = 0;
      $result = array();
      //$errors = array();

      $result_houses = array();
      $houses = House::get();
      foreach ($houses as $house) {
        $result_house = array();
        $result_house['id'] = $house->id;
        $result_house['type'] = $house->type;
        $result_house['size'] = $house->size;
        $result_house['address'] = $house->address;
        $result_house['district_id'] = $house->district_id;
        $result_house['description'] = $house->description;
        $result_house['max_ppl'] = $house->max_ppl;
        $result_house['price'] = $house->price;
        $result_house['status'] = $house->status;
        $result_house['owner_id'] = $house->owner_id;
        $result_house['is_deleted'] = $house->is_deleted;
        $result_house['created_at'] = $house->created_at;
        $result_house['updated_at'] = $house->updated_at;
        array_push($result_houses, $result_house);
      }

      $result['houses'] = $result_houses;
      //$result['errors'] = $errors;
      $result_all['result'] = $result;
      $result_all['status'] = '1';

      return $result_all;
    }


    public function archive_house($id){
      $house = House::where('id', $id)->first();

      if($house == null){
        return "House with respective ID numebr does not exist";
      }

      $house->status = 2; // currently set "2" as "archive" status
      $house->save();

      $success_msg = "House archived Successfully (House ID = {$id})";
      return $success_msg;
    }


    public function reveal_house($id){
      $house = House::where('id', $id)->first();

      if($house == null){
        return "House with respective ID numebr does not exist";
      }

      $house->status = 1; // currently set "1" as "reveal" status
      $house->save();

      $success_msg = "House revealed Successfully (House ID = {$id})";
      return $success_msg;
    }

}
