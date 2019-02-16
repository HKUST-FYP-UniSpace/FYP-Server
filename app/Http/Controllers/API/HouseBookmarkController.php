<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\HousePostBookmark;
use Validator;
use Carbon\Carbon;

class HouseBookmarkController extends Controller
{
    // public function create_houseBookmark(){
    //
    // }
    //
    // public function edit_houseBookmark(){
    //
    // }


    public function show_houseBookmark($id){
      $bookmark = HousePostBookmark::where("id", $id)->first();

      if($bookmark == null){
        return "HouseBookmark with respective ID numebr does not exist";
      }

      $result_all = array();
      $result_all['status'] = 0;
      $result = array();
      //$result['errors'] = array();

      $result_bookmark = array();
      $result_bookmark['house_id'] = $bookmark->house_id;
      $result_bookmark['tenant_id'] = $bookmark->tenant_id;
      $result_bookmark['created_at'] = $bookmark->created_at;
      $result_bookmark['updated_at'] = $bookmark->updated_at;

      $result['bookmark'] = $result_bookmark;
      //$result['errors'] = $errors;
      $result_all['result'] = $result;
      $result_all['status'] = '1';

      return $result_all;
    }


    public function index_houseBookmark(){
      $result_all = array();
      $result_all['status'] = 0;
      $result = array();
      //$errors = array();

      $result_bookmarks = array();
      $bookmarks = HousePostBookmark::get();
      foreach ($bookmarks as $bookmark) {
        $result_bookmark = array();
        $result_bookmark['id'] = $bookmark->id;
        $result_bookmark['house_id'] = $bookmark->house_id;
        $result_bookmark['tenant_id'] = $bookmark->tenant_id;
        $result_bookmark['created_at'] = $bookmark->created_at;
        $result_bookmark['updated_at'] = $bookmark->updated_at;
        array_push($result_bookmarks, $result_bookmark);
      }

      $result['bookmarks'] = $result_bookmarks;
      //$result['errors'] = $errors;
      $result_all['result'] = $result;
      $result_all['status'] = '1';

      return $result_all;
    }


    public function store_houseBookmark(Request $request){
      $bookmark = new HousePostBookmark();

      $bookmark->house_id = $request->input('house_id');
      $bookmark->tenant_id = $request->input('tenant_id');

      $bookmark->save();

      $success_msg = "New houseBookmark stored Successfully! (House ID = {$bookmark->id})";
      return $success_msg;
    }


    public function delete_houseBookmark($id){
      $bookmark = HousePostBookmark::where('id', $id)->first();
      if($bookmark == null){
        return "HouseBookmark with respective ID number does not exist.";
      }

      $bookmark->delete();

      $success_msg = "Successfully deleted houseBookmark with ID = {$id}";
      return $success_msg;
    }

    // This function may only be needed when "name" attribut is given to bookmarks
    // public function update_houseBookmark($id, Request $request){
    //
    // }
}
