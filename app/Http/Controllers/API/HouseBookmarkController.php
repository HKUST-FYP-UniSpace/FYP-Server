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

      // $result_all = array();
      // $result_all['status'] = 0;
      // $result = array();
      //$result['errors'] = array();

      $result_bookmark = [
        'house_id' => $bookmark->house_id,
        'tenant_id' => $bookmark->tenant_id,
        'created_at' => $bookmark->created_at,
        'updated_at' => $bookmark->updated_at
      ];

      // $result['bookmark'] = $result_bookmark;
      // //$result['errors'] = $errors;
      // $result_all['result'] = $result;
      // $result_all['status'] = '1';

      return $result_bookmark;
    }


    public function index_houseBookmark(){
      // $result_all = array();
      // $result_all['status'] = 0;
      // $result = array();
      //$errors = array();

      $result_bookmarks = array();
      $bookmarks = HousePostBookmark::get();
      foreach ($bookmarks as $bookmark) {
        // $result_bookmark = array();
        // $result_bookmark['id'] = $bookmark->id;
        // $result_bookmark['house_id'] = $bookmark->house_id;
        // $result_bookmark['tenant_id'] = $bookmark->tenant_id;
        // $result_bookmark['created_at'] = $bookmark->created_at;
        // $result_bookmark['updated_at'] = $bookmark->updated_at;
        // array_push($result_bookmarks, $result_bookmark);

        $result_bookmark = [
          'id' => $bookmark->id,
          'house_id' => $bookmark->house_id,
          'tenant_id' => $bookmark->tenant_id,
          'created_at' => $bookmark->created_at,
          'updated_at' => $bookmark->updated_at
        ];
        array_push($result_bookmarks, $result_bookmark);
      }

      // $result['bookmarks'] = $result_bookmarks;
      // //$result['errors'] = $errors;
      // $result_all['result'] = $result;
      // $result_all['status'] = '1';

      return $result_bookmark;
    }


    // Bookmark House
    public function store_houseBookmark(Request $request){
      $input_houseId = $request->input('houseId');
      $input_userId = $request->input('userId');

      // Just return false for not creating new bookmark record
      if($input_houseId == null || $input_userId == null){
        $response = ['isSuccess' => false];
        return $response;
      }

      // For cases where the same bookmark had previously been created
      $current_bookmark = HousePostBookmark::where('house_id', $input_houseId)->where('tenant_id', $input_userId);
      if($current_bookmark->count() > 0){
        // In case the same function may wnat to handle bookmark removal on click as well
        $current_bookmark->delete();

      }else{
        // create bookmark
        $bookmark = new HousePostBookmark();

        $bookmark->house_id = $input_houseId;
        $bookmark->tenant_id = $input_userId;

        $bookmark->save();
      }

      //$success_msg = "New houseBookmark stored Successfully! (House ID = {$bookmark->id})";
      //return $success_msg;

      $response = ['isSuccess' => true];
      return $response;
    }


    public function delete_houseBookmark($id){
      $bookmark = HousePostBookmark::where('id', $id)->first();
      if($bookmark == null){
        return "HouseBookmark with respective ID number does not exist.";
      }

      $bookmark->delete();

      // $success_msg = "Successfully deleted houseBookmark with ID = {$id}";
      // return $success_msg;

      $response = ['isSuccess' => true];
      return $response;
    }

    // This function may only be needed when "name" attribut is given to bookmarks
    // public function update_houseBookmark($id, Request $request){
    //
    // }

    // Index bookmark given a tenant's id
    // param: $id: userid
    public function get_houseBookmarkSaved($id){
      $bookmarks = HousePostBookmark::where('tenant_id', $id)->get();
      if($bookmarks == null){
        return "There is no House saved by this tenant!";
      }

      $result_bookmarks = array();
      foreach ($bookmarks as $bookmark) {
        $result_bookmark = [
          'id' => $bookmark->id,
          'house_id' => $bookmark->house_id,
          'tenant_id' => $bookmark->tenant_id,
          'created_at' => $bookmark->created_at,
          'updated_at' => $bookmark->updated_at
        ];
        array_push($result_bookmarks, $result_bookmark);
      }

      return $result_bookmarks;
    }

}
