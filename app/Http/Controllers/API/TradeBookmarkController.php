<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\TradeBookmark;
use Validator;
use Carbon\Carbon;

class TradeBookmarkController extends Controller
{
  // public function create_tradeBookmark(){
  //
  // }
  //
  // public function edit_tradeBookmark(){
  //
  // }

  //
  public function show_tradeBookmark($id){
    $bookmark = TradeBookmark::where("id", $id)->first();

    if($bookmark == null){
      return "TradeBookmark with respective ID numebr does not exist";
    }

    $result_all = array();
    $result_all['status'] = 0;
    $result = array();
    //$result['errors'] = array();

    $result_bookmark = array();
    $result_bookmark['trade_id'] = $bookmark->trade_id;
    $result_bookmark['user_id'] = $bookmark->user_id;
    $result_bookmark['created_at'] = $bookmark->created_at;
    $result_bookmark['updated_at'] = $bookmark->updated_at;

    $result['bookmark'] = $result_bookmark;
    //$result['errors'] = $errors;
    $result_all['result'] = $result;
    $result_all['status'] = '1';

    return $result_all;
  }


  public function index_tradeBookmark(){
    $result_all = array();
    $result_all['status'] = 0;
    $result = array();
    //$errors = array();

    $result_bookmarks = array();
    $bookmarks = TradeBookmark::get();
    foreach ($bookmarks as $bookmark) {
      $result_bookmark = array();
      $result_bookmark['id'] = $bookmark->id;
      $result_bookmark['trade_id'] = $bookmark->trade_id;
      $result_bookmark['user_id'] = $bookmark->user_id;
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


  // Bookmark Item
  public function store_tradeBookmark(Request $request){
    $input_tradeId = $request->input('tradeId');
    $input_userId = $request->input('userId');

    // Just return false for not creating new bookmark record
    if($input_tradeId == null || $input_userId == null){
      $response = ['isSuccess' => false];
      return $response;
    }

    // For cases where the same bookmark had previously been created
    $current_bookmark = TradeBookmark::where('trade_id', $input_tradeId)->where('user_id', $input_userId);
    if($current_bookmark->count() > 0){
      // In case the same function may wnat to handle bookmark removal on click as well
      $current_bookmark->delete();

    }else{
      // create bookmark
      $bookmark = new TradeBookmark();

      $bookmark->trade_id = $input_tradeId;
      $bookmark->user_id = $input_userId;

      $bookmark->save();
    }

    //$success_msg = "New tradeBookmark stored Successfully! (Bookmark ID = {$bookmark->id})";
    //return $success_msg;

    $response = ['isSuccess' => true];
    return $response;
  }


  public function delete_tradeBookmark($id){
    $bookmark = TradeBookmark::where('id', $id)->first();
    if($bookmark == null){
      return "TradeBookmark with respective ID number does not exist.";
    }

    $bookmark->delete();

    $success_msg = "Successfully deleted tradeBookmark with ID = {$id}";
    return $success_msg;
  }

  // This function may only be needed when "name" attribut is given to bookmarks
  // public function update_tradeBookmark($id, Request $request){
  //
  // }
}
