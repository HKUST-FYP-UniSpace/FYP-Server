<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\House;
use App\Trade;
use App\District;

use Validator;
use Carbon\Carbon;

class SearchEngineController extends Controller
{
    // Search Trade (Item)
    //
    // Search Criteria:
    // Title, Seller, Category, Item Condition, Price (Max/Min)
    //
    // Sort Criteria:
    // Created At, Updated At, Price, Title
    // public function searchTrade(Request $request){
    //   $trades = Trade::all();
    //   //return $trades = DB::table('trade');
    //
    //   if((double)($request->input('title') != null)){
    //     $trades = $trades->where("title", $request->input("title"));
    //   }
    //
    //   // missing seller id for seller search?
    //
    //   if((double)($request->input('trade_category_id') != null)){
    //     $trades = $trades->where("trade_category_id", $request->input("trade_category_id"));
    //   }
    //
    //   if((double)($request->input('trade_condition_type_id') != null)){
    //     $trades = $trades->where("trade_condition_type_id", $request->input("trade_condition_type_id"));
    //   }
    //
    //   if((double)($request->input('price_max') != null)){
    //     $trades = $trades->where("price", '<=' , $request->input("price_max"));
    //   }
    //
    //   if((double)($request->input('price_min') != null)){
    //     $trades = $trades->where("price", '>=', $request->input("price_min"));
    //   }
    //
    //   // Order (asc/desc)
    //   if($request->input('orderBy') == 'created_at'){
    //     $trades = $trades->sortBy('created_at');
    //   }
    //   else if($request->input('orderBy') == 'updated_at'){
    //     $trades = $trades->sortBy('updated_at');
    //   }
    //   else if($request->input('orderBy') == 'price'){
    //     $trades = $trades->sortBy('price');
    //   }
    //   else if($request->input('orderBy') == 'title'){
    //     $trades = $trades->sortBy('title');
    //   }
    //
    //   $trades = $trades->values()->all();
    //   return $trades;
    // }


//---------------------------------------------------------------------------------------------------


    // Search Apartment
    //
    // Search Criteria:
    // District ID, Type, Price (Max/Min), Size (Max/Min), Facilities, Team Formed
    // University? Travelling Time? Max ppl?
    // public function searchHouse(Request $request){
    //   $houses = House::all();
    //
    //   if((double)($request->input('title') != null)){
    //     $houses = $houses->where("title", $request->input("title"));
    //   }
    //
    //   // missing seller id for seller search?
    //
    //   if((double)($request->input('district_id') != null)){
    //     $houses = $houses->where("district_id", $request->input("district_id"));
    //   }
    //
    //   if((double)($request->input('type') != null)){
    //     $houses = $houses->where("type", $request->input("type"));
    //   }
    //
    //   if((double)($request->input('price_max') != null)){
    //     $houses = $houses->where("price", '<=' , $request->input("price_max"));
    //   }
    //
    //   if((double)($request->input('price_min') != null)){
    //     $houses = $houses->where("price", '>=', $request->input("price_min"));
    //   }
    //
    //   if((double)($request->input('size_max') != null)){
    //     $houses = $houses->where("size", '<=' , $request->input("size_max"));
    //   }
    //
    //   if($request->input('size_min') != null){
    //     $houses = $houses->where("size", '>=', $request->input("size_min"));
    //   }
    //
    //   // Facilities? Team Formed?
    //
    //   // Order (asc/desc)
    //   // This part may not be needed in the aportment search
    //   if($request->input('orderBy') == 'created_at'){
    //     $houses = $houses->sortBy('created_at', 'asc');
    //   }else if($request->input('orderBy') == 'updated_at'){
    //     $houses = $houses->sortBy('updated_at', 'asc');
    //   }else if($request->input('orderBy') == 'price'){
    //     $houses = $houses->sortBy('price', 'asc');
    //   }else if($request->input('orderBy') == 'size'){
    //     $houses = $houses->sortBy('size', 'asc');
    //   }else if($request->input('orderBy') == 'title'){
    //     $houses = $houses->sortBy('title', 'asc');
    //   }
    //
    //   $houses = $houses->values()->all();
    //   return $houses;
    // }

// ------------------------------ helper function-------------------------------
  // Get the district that a origin address can travel to within a limited time
  // using Google Distance Matrix API
  // return an array of district id(s) that are within the time range
  public function get_districtsInDistance($origin, $time){
    $MAP_KEY = 'AIzaSyB5dp-i_61Req52RUXJmFJ1-UXaateg0qw';
    $districts_in_range = array();
    $adjusted_origin = $origin.',HK';
    $time_inSec = $time * 60; // convert time into seconds

    $districts = District::get();
    foreach($districts as $district){
      $district_name = $district->name;
      $adjusted_district = $district_name.',HK';
      $distance_data = file_get_contents('https://maps.googleapis.com/maps/api/distancematrix/json?language=en&origins='.urlencode($adjusted_origin).'&destinations='.urlencode($adjusted_district).'&key='.$MAP_KEY);
      $distance_arr = json_decode($distance_data);
      if($distance_arr->status == 'OK'){
        if(!empty($distance_arr->destination_addresses[0])){
          $elements = $distance_arr->rows[0]->elements;
          // $distance = $elements[0]->distance->value;
          $duration = $elements[0]->duration->value;

          if($duration <= $time_inSec){
            $district_id = app('App\Http\Controllers\API\HouseController')->convertDistrictEnumToId($district_name);
            array_push($districts_in_range, $district_id);
          }
        }
      }
    }

    return $districts_in_range;
  }

  // for testing purpose only
  public function test_distanceMatrix(Request $request){
    $origin = $request->input('origin');
    $travelTime = $request->input('travelTime');

    return self::get_districtsInDistance($origin, $travelTime);
  }

}
