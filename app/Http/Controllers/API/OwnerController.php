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
use \Datetime;
use \DateTimeZone;

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
  public function get_houseData($userId, $houseId, $chartFilterOptions){
    // $user_id = $request->input('userId');
    // $houseId = $request->input('houseId');
    // $chartFilterOptions = $request->input('chartFilterOptions');

    // get today's date
    // date_default_timezone_set('Asia/Hong_Kong');
    // $date = date('Y-m-d H:i:s');

    $views = HouseVisitor::where('house_id', $houseId);
    // dd($views->whereDate('created_at' , '=', '2019-04-04 00:00:00')->get());
    $notViews = HouseVisitor::where('house_id', '!=', $houseId);
    $bookmarks = HousePostBookmark::where('house_id', $houseId);
    $notBookmarks = HousePostBookmark::where('house_id', '!=', $houseId);

    $targetViews = array();
    $otherViews = array();
    $targetBookmarks = array();
    $otherBookmarks = array();

    if($chartFilterOptions == "Week"){
      for($i = 8, $order = 1; $i >= 0; $i--){
        // $day_before = date( 'Y-m-d H:i:s', strtotime( $date . ' -'.$i. ' day' ) );
        // $day_before_end = date( 'Y-m-d H:i:s', strtotime( $day_before . ' +1 day' ) );

        // $day_before = new DateTime( strtotime( $date . ' -'.$i. ' day' ) );
        // $day_before_end = new DateTime( strtotime( $day_before . ' +1 day' ) );
        // $day_before = new DateTime('-' . $i . ' day', new DateTimeZone('Asia/Hong_Kong'));
        // $day_before->format('Y-m-d H:i:s');
        // $day_before_end = new DateTime('-' . ($i-1) . ' day', new DateTimeZone('Asia/Hong_Kong'));
        // if($i == 1){
        //   dd($day_before_end->format('Y-m-d H:i:s'));
        // }

        $day_before = Carbon::today()->subDays($i);
        $day_before_end = Carbon::today()->subDays($i-1);

        // $viewCount = $views->where('created_at', '>=', $day_before)->where('created_at', '<', $day_before_end)->count();
        $viewCount = $views;
        $viewCount = $viewCount->where('created_at', '>=', $day_before)->count();
        // $viewFirst = $views->where('created_at', '>=', $day_before)->where('created_at', '<', '2019-04-23 00:00:00')->first();
        // $viewFirst = $views->where('created_at', '>=', $day_before->format('Y-m-d H:i:s'))->first();
        // $viewFirst = $views->where('created_at', '<=', $day_before_end->format('Y-m-d H:i:s'))->first();
$viewFirst = $views->whereBetween('created_at', array($day_before->toDateString(), $day_before_end->toDateString()))->first();
        // $date = $day_before_end->format('Y-m-d H:i:s');
        $date = $day_before_end->toDateTimeString();
        // dd($date);
        // dd('2019-04-15 00:00:00');
        // $viewFirst = $views->where('created_at', '<=', $date)->first();
        // if($viewFirst!=null){
        //   dd($viewFirst);
        // }
        $targetView = ['order' => $order,
                        'time' => $day_before->format('Y-m-d H:i:s'),
                        'x' => $order,
                        'y' => $viewCount,
                        'end_time' => $date,
                        'viewFirst' =>$viewFirst
                      ];
        array_push($targetViews, $targetView);

        $notViewAtDate = $notViews->where('created_at', '>=', $day_before)->where('created_at', '<', $day_before_end);
        $notViewCount = $notViewAtDate->count();
        $viewHouseNum =  $notViewAtDate->select('house_id')->groupBy('house_id')->count();
        $otherView = ['order' => $order,
                        'time' => $day_before,
                        'x' => $order,
                        'y' => $viewHouseNum==0 ? 0 : $notViewCount/$viewHouseNum
                      ];
        array_push($otherViews, $otherView);

        $bookmarkCount = $bookmarks->where('created_at', '>=', $day_before)->where('created_at', '<', $day_before_end)->count();
        $targetBookmark = ['order' => $order,
                            'time' => $day_before,
                            'x' => $order,
                            'y' => $bookmarkCount
                          ];
        array_push($targetBookmarks, $targetBookmark);

        $notBookmarkAtDate = $notBookmarks->where('created_at', '>=', $day_before)->where('created_at', '<', $day_before_end);
        $notBookmarkCount = $notBookmarkAtDate->count();
        $bookmarkHouseNum =  $notBookmarkAtDate->select('house_id')->groupBy('house_id')->count();
        $otherBookmark = ['order' => $order,
                          'time' => $day_before,
                          'x' => $order,
                          'y' => $bookmarkHouseNum==0 ? 0 : $notBookmarkCount/$bookmarkHouseNum
                          ];
        array_push($otherBookmarks, $otherBookmark);

        $order++;
      }
    }else if($chartFilterOptions == "Month"){
      for($i = 30, $order = 1; $i >= 0; $i--){
        $day_before = date( 'Y-m-d h:i:s', strtotime( $date . ' -'.$i. ' day' ) );
        // $day_before = date( 'Y-m-d', strtotime( $date . ' -'.$i. ' day' ) );
// $viewCount = $views->whereDate('created_at', '=', date('2019-04-04'))->count();
// dd($viewCount);
        $viewCount = $views->whereDate('created_at', '=', $day_before)->count();
        $targetView = ['order' => $order,
                        'time' => $day_before,
                        'x' => $order,
                        'y' => $viewCount
                      ];
        array_push($targetViews, $targetView);

        $notViewAtDate = $notViews->whereDate('created_at', '=', $day_before);
        $notViewCount = $notViewAtDate->count();
        $viewHouseNum =  $notViewAtDate->select('house_id')->groupBy('house_id')->count();
        $otherView = ['order' => $order,
                        'time' => $day_before,
                        'x' => $order,
                        'y' => $viewHouseNum==0 ? 0 : $notViewCount/$viewHouseNum
                      ];
        array_push($otherViews, $otherView);

        $bookmarkCount = $bookmarks->whereDate('created_at', '=', $day_before)->count();
        $targetBookmark = ['order' => $order,
                            'time' => $day_before,
                            'x' => $order,
                            'y' => $bookmarkCount
                          ];
        array_push($targetBookmarks, $targetBookmark);

        $notBookmarkAtDate = $notBookmarks->whereDate('created_at', '=', $day_before);
        $notBookmarkCount = $notBookmarkAtDate->count();
        $bookmarkHouseNum =  $notBookmarkAtDate->select('house_id')->groupBy('house_id')->count();
        $otherBookmark = ['order' => $order,
                          'time' => $day_before,
                          'x' => $order,
                          'y' => $bookmarkHouseNum==0 ? 0 : $notBookmarkCount/$bookmarkHouseNum
                          ];
        array_push($otherBookmarks, $otherBookmark);

        $order++;
      }
    }else if ($chartFilterOptions == "Year"){
      for($i = 13, $order = 1; $i > 0; $i--){
        $month_before = date( 'Y-m-d h:i:s', strtotime( $date . ' -'.$i. ' month' ) );
        $month_before_end = date( 'Y-m-d h:i:s', strtotime( $month_before . ' +1 month' ) );

        $viewCount = $views->whereDate('created_at', '>=', $month_before)->whereDate('created_at', '<=', $month_before_end)->count();
        // if($i == 1){
        //   dd($viewCount);
        // }
        $targetView = ['order' => $order,
                        'time' => $month_before_end,
                        'x' => $order,
                        'y' => $viewCount
                      ];
        array_push($targetViews, $targetView);

        $notViewAtDate = $notViews->whereDate('created_at', '>=', $month_before)->whereDate('created_at', '<=', $month_before_end);
        $notViewCount = $notViewAtDate->count();
        $viewHouseNum =  $notViewAtDate->select('house_id')->groupBy('house_id')->count();
        $otherView = ['order' => $order,
                        'time' => $month_before_end,
                        'x' => $order,
                        'y' => $viewHouseNum==0 ? 0 : $notViewCount/$viewHouseNum
                      ];
        array_push($otherViews, $otherView);

        $bookmarkCount = $bookmarks->whereDate('created_at', '>=', $month_before)->whereDate('created_at', '<=', $month_before_end)->count();
        $targetBookmark = ['order' => $order,
                            'time' => $month_before_end,
                            'x' => $order,
                            'y' => $bookmarkCount
                          ];
        array_push($targetBookmarks, $targetBookmark);

        $notBookmarkAtDate = $notBookmarks->whereDate('created_at', '>=', $month_before)->whereDate('created_at', '<=', $month_before_end);
        $notBookmarkCount = $notBookmarkAtDate->count();
        $bookmarkHouseNum =  $notBookmarkAtDate->select('house_id')->groupBy('house_id')->count();
        $otherBookmark = ['order' => $order,
                          'time' => $month_before_end,
                          'x' => $order,
                          'y' => $bookmarkHouseNum==0 ? 0 : $notBookmarkCount/$bookmarkHouseNum
                          ];
        array_push($otherBookmarks, $otherBookmark);

        $order++;
      }
    }

    $response = [
      'targetViews' => $targetViews,
      'othersViews' => $otherViews,
      'targetBookmark' => $targetBookmarks,
      'othersBookmark' => $otherBookmarks
    ];

    return $response;
  }


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

    // $img_urls = $request->input('photoURLs');
    // if($img_urls != "NULL"){
    //   HouseImage::where('house_id', $house_id)->delete();
    //
    //   if(!empty($img_urls)){
    //     foreach($img_urls as $img_url){
    //       $house_img = new HouseImage();
    //       $house_img->img_url = $img_url;
    //       $house_img->house_id =$house_id;
    //       $house_img->save();
    //     }
    //   }
    //
    // }

    return ['houseId' => $house_id];
  }


  // Add House [Image]
  public function store_houseImage(Request $request){
    $house_id = $request->input('houseId');
    $temp = 0;
    $images = $request->file('photoURLs');
    $size = sizeof($images);

    if(!empty($images)) {
      // foreach($images as $image) {
      for($i = 0; $i < $size; $i++) {
        $extension = $images[$i]->getClientOriginalExtension();

        $now = strtotime(Carbon::now());
        $url = 'trade_' . $house_id . '_' . $now . '_' .$i .'.' . $extension;
        Storage::disk('public')->put($url,  File::get($images[$i]));

        // Save url in db
        $house_image = new HouseImage();
        $house_image->img_url = url('uploads/'.$url);
        $house_image->house_id = $house_id;
        $house_image->save();

        $temp++;
      }
      $response = ['isSuccess' => true, 'counter' => $temp];

    }
    else{
      $response = ['isSuccess' => false];
    }

    return $response;
  }

  // Edit House
  public function update_house($houseId, Request $request){
    $houseId = $request->input('houseId');
    $house = House::where("id", $houseId)->first();

    if($house == null){
      return "House with respective ID number does not exist";
    }
    $house->title = ($request->input('title')==null ? "" : $request->input('title'));
    $house->address = ($request->input('address')==null ? "" : $request->input('address'));
    $house->subtitle = ($request->input('subtitle')==null ? "" : $request->input('subtitle'));
    $house->price = (double)($request->input('price')==null ? "" : $request->input('price'));
    $house->size = (double)($request->input('size')==null ? "" : $request->input('size'));

    // fields that may be needed
    // $house->type = ($request->input('type')==null ? "" : $request->input('type'));
    // $house->district_id = (int)($request->input('district_id')==null ? "" : app( App\Http\Controllers\API\HouseController)->convertDistrictIdToEnum($request->input('district_id')));
    // $house->description = ($request->input('description')==null ? "" : $request->input('description'));
    // $house->max_ppl = (int)($request->input('max_ppl')==null ? "" : $request->input('max_ppl'));
    // $house->status = (int)($request->input('status')==null ? "" : $request->input('status'));
    // $house->owner_id = (int)($request->input('owner_id')==null ? "" : $request->input('owner_id'));
    // $house->is_deleted = (int)($request->input('is_deleted')==null ? "" : $request->input('is_deleted'));

    $house->save();

    // $success_msg = "House Updated Successfully (ID = {$id})";
    // return $success_msg;
    HouseDetail::where('house_id', $houseId)->delete();

    $house_detail = new HouseDetail();
    $house_detail->house_id = $houseId;
    $house_detail->room = (int)($request->input('rooms')==null ? "" : $request->input('rooms'));
    $house_detail->toilet = (int)($request->input('toilets')==null ? "" : $request->input('toilets'));
    $house_detail->bed = (int)($request->input('beds')==null ? "" : $request->input('beds'));
    $house_detail->save();

    $response = ['isSuccess' => true];
    return $response;
  }


  //Edit House [Image]
  public function update_houseImage(Request $request){
    $house_id = $request->input('houseId');
    $temp = 0;
    $images = $request->file('photoURLs');
    $size = sizeof($images);

    HouseImage::where('house_id', $house_id)->delete(); // first delete old images

    if(!empty($images)) {
      // foreach($images as $image) {
      for($i = 0; $i < $size; $i++) {
        $extension = $images[$i]->getClientOriginalExtension();

        $now = strtotime(Carbon::now());
        $url = 'trade_' . $house_id . '_' . $now . '_' .$i .'.' . $extension;
        Storage::disk('public')->put($url,  File::get($images[$i]));

        // Save url in db
        $house_image = new HouseImage();
        $house_image->img_url = url('uploads/'.$url);
        $house_image->house_id = $house_id;
        $house_image->save();

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
