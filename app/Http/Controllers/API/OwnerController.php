<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\House;
use App\HousePostBookmark;
//use App\HousePostGroup; //obsolete, combined with "Group"
use App\HouseImage;
use App\Group;
use App\GroupDetail;
use App\User;
use App\Profile;
use App\ProfileDetail;
use App\Tenant;
use App\Owner;
use App\OwnerComment;
use App\HouseComment;
use App\TenantRating;
use App\Review;
use App\ReviewReply;
use App\Preference;
use App\PreferenceItem;
use App\PreferenceItemCategory;
use App\HouseVisitor;
use App\HouseDetail;

use Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class OwnerController extends Controller
{
  // Get Owner House Summary
  public function get_houseSummary($userId){
    // $userId = $request->input('userId');
    $result_summary = array();

    $owned_houses = House::where('owner_id', $userId)->get();

    if(!isset($owned_houses)){
      $response = ["isSuccess"=>false];
      return $response;
    }

    foreach ($owned_houses as $house) {
      $house_id = $house->id;
      $viewCount = HouseVisitor::where('house_id', $house_id)->count();
      $bookmarkCount = HousePostBookmark::where('house_id', $house_id)->count();
      $teamCount = Group::where('house_id', $house_id)->count();
      $AvgStarRating = app('App\Http\Controllers\API\HouseController')->get_averageHouseOverallRating($house_id);

      $house_summary = [
        "id"=>$house_id,
        "createTime"=>$house->created_at,
        "title"=>$house->title,
        "address"=>$house->address,
        "price"=>$house->price,
        "size"=>$house->size,
        "numberOfViews"=>$viewCount,
        "numberOfBookmarks"=>$bookmarkCount,
        "starRating"=>$AvgStarRating,
        "arrangingTeamCount"=>$teamCount,
        "houseStatus"=>$house->status
      ];

      array_push($result_summary, $house_summary);
    }

    return $result_summary;
  }


  // Get Owner Team Summary
  public function get_teamSummary($userId, $houseId){
    // $user_id = $request->input('userId');

    $house = House::where('id', $houseId)->where('owner_id', $userId)->get();
    $reviews = array();
    $teams = array();

    // foreach($houses as $house){
    // $house_id = $house->id;

    $groups = Group::where('house_id', $houseId)->get();
    foreach($groups as $group){
      $group_id = $group->id;
      $team = app('App\Http\Controllers\API\HouseController')->get_teamView($group_id);
      array_push($teams, $team);
    }

    $reviews =  app('App\Http\Controllers\API\HouseController')->get_reviews($houseId);
    //array_push($reviews, $review);
    // }


    $team_summary = [
      "teams"=>$teams,
      "reviews"=> $reviews
    ];
    return $team_summary;
  }


  // Get House Data
  // public function get_houseData(Request $request){
  //   $user_id = $request->input('userId');
  //   $house_id = $request->input('houseId');
  //   $filter_options = $request->input('chartFilterOptions');
  //
  // }


  // Add House
  public function store_house(Request $request){
    $house = new House();

    $house->title = $request->input('title');
    $house->subtitle = $request->input('subtitle');
    $house->type = $request->input('type'); //extra
    $house->size = $request->input('size');
    $house->address = $request->input('address');
    $house->district_id = $request->input('district_id');//extra
    $house->description = $request->input('description'); //extra
    $house->max_ppl = $request->input('max_ppl'); //extra
    $house->price = $request->input('price');
    $house->status = 2; //extra //set to "reveal" by default
    $house->owner_id = $request->input('ownerId'); //extra
    $house->is_deleted = 0; //extra //set to not deleted by default

    $house->save();
    $house_id = $house->id;

    $house_detail = new HouseDetail();

    $house_detail->house_id = $house_id;
    $house_detail->toilet = $request->input('toilets');
    $house_detail->bed = $request->input('rooms');
    $house_detail->room = $request->input('beds');

    $house_detail->save();

    return ['houseId' => $house_id];
  }


  // Add House [Image]
  public function store_houseImage(Request $request){
    $trade_id = $request->input('houseId');
    $temp = 0;
    $images = $request->file('photoURLs');
    $size = sizeof($images);

    if(!empty($images)) {
      // foreach($images as $image) {
      for($i = 0; $i < $size; $i++) {
        $extension = $images[$i]->getClientOriginalExtension();

        $now = strtotime(Carbon::now());
        $url = 'trade_' . $trade_id . '_' . $now . '_' .$i .'.' . $extension;
        Storage::disk('public')->put($url,  File::get($images[$i]));
        $temp++;
      }
      $response = ['isSuccess' => true, 'counter' => $temp];

    }
    else{
      $response = ['isSuccess' => false];
    }

    return $response;
  }


  // Change House Status
  public function update_houseStatus($houseId, Request $request){
    $house = House::where("id", $houseId)->first();

    if($house == null){
      return ['isSucces' => false];
    }

    $status = $request->input('status');
    if($status != null){
      $house->status = $status;
    }else{
      return ['isSucces' => false];
    }

    $house->save();
    return ['isSucces' => true];
  }


  // public function update_house($houseId, Request $request){
  //
  // }
  //
  //
  // public function update_houseImg(Request $request){
  //
  // }


  // Reply Review
  public function store_reviewReply($reviewId, Request $request){
    $owner_reply = new ReviewReply();

    //$owner_reply->review_id = $request->input('reviewId');
    $owner_reply->review_id = $reviewId;
    $owner_reply->owner_id = $request->input('userId');
    $owner_reply->details = $request->input('comment');

    $owner_reply->save();

    $response=['isSuccess'=>true];
    return $response;
  }


  //--------------------------------- helper functions ----------------------------------


}
