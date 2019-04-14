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

}
