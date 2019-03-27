<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\DB;
use App\House;
use App\Trade;

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
    public function searchTrade(Request $request){
      $trades = Trade::all();
      //return $trades = DB::table('trade');

      if((double)($request->input('title') != null)){
        $trades = $trades->where("title", $request->input("title"));
      }

      // missing seller id for seller search?

      if((double)($request->input('trade_category_id') != null)){
        $trades = $trades->where("trade_category_id", $request->input("trade_category_id"));
      }

      if((double)($request->input('trade_condition_type_id') != null)){
        $trades = $trades->where("trade_condition_type_id", $request->input("trade_condition_type_id"));
      }

      if((double)($request->input('price_max') != null)){
        $trades = $trades->where("price", '<=' , $request->input("price_max"));
      }

      if((double)($request->input('price_min') != null)){
        $trades = $trades->where("price", '>=', $request->input("price_min"));
      }

      // Order (asc/desc)
      if($request->input('orderBy') == 'created_at'){
        $trades = $trades->sortBy('created_at');
      }
      else if($request->input('orderBy') == 'updated_at'){
        $trades = $trades->sortBy('updated_at');
      }
      else if($request->input('orderBy') == 'price'){
        $trades = $trades->sortBy('price');
      }
      else if($request->input('orderBy') == 'title'){
        $trades = $trades->sortBy('title');
      }

      $trades = $trades->values()->all();
      return $trades;
    }


//---------------------------------------------------------------------------------------------------


    // Search Apartment
    //
    // Search Criteria:
    // District ID, Type, Price (Max/Min), Size (Max/Min), Facilities, Team Formed
    // University? Travelling Time? Max ppl?
    public function searchHouse(Request $request){
      $houses = House::all();

      if((double)($request->input('title') != null)){
        $houses = $houses->where("title", $request->input("title"));
      }

      // missing seller id for seller search?

      if((double)($request->input('district_id') != null)){
        $houses = $houses->where("district_id", $request->input("district_id"));
      }

      if((double)($request->input('type') != null)){
        $houses = $houses->where("type", $request->input("type"));
      }

      if((double)($request->input('price_max') != null)){
        $houses = $houses->where("price", '<=' , $request->input("price_max"));
      }

      if((double)($request->input('price_min') != null)){
        $houses = $houses->where("price", '>=', $request->input("price_min"));
      }

      if((double)($request->input('size_max') != null)){
        $houses = $houses->where("size", '<=' , $request->input("size_max"));
      }

      if($request->input('size_min') != null){
        $houses = $houses->where("size", '>=', $request->input("size_min"));
      }

      // Facilities? Team Formed?

      // Order (asc/desc)
      // This part may not be needed in the aportment search
      if($request->input('orderBy') == 'created_at'){
        $houses = $houses->sortBy('created_at', 'asc');
      }else if($request->input('orderBy') == 'updated_at'){
        $houses = $houses->sortBy('updated_at', 'asc');
      }else if($request->input('orderBy') == 'price'){
        $houses = $houses->sortBy('price', 'asc');
      }else if($request->input('orderBy') == 'size'){
        $houses = $houses->sortBy('size', 'asc');
      }else if($request->input('orderBy') == 'title'){
        $houses = $houses->sortBy('title', 'asc');
      }

      $houses = $houses->values()->all();
      return $houses;
    }


}
