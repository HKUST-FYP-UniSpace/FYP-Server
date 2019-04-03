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
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
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

      // $success_msg = "Successfully deleted house with ID = {$id}";
      // return $success_msg;

      $response = ['isSuccess' => true];
      return $response;
    }


    //Hide house as soft delete
    public function hide_house($id){
      $house = House::where('id', $id)->first();

      if($house == null){
        return "House with respective ID numebr does not exist";
      }

      $house->status = 0; // currently set "0" as "hide" status
      $house->save();

      // $success_msg = "House hidden Successfully (House ID = {$id})";
      // return $success_msg;

      $response = ['isSuccess' => true];
      return $response;
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

      // $success_msg = "New house stored Successfully! (House ID = {$house->id})";
      // return $success_msg;

      $response = ['isSuccess' => true];
      return $response;
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

      // $success_msg = "House Updated Successfully (ID = {$id})";
      // return $success_msg;

      $response = ['isSuccess' => true];
      return $response;
    }

    //should have included team information as well
    public function show_house($id, $userId){
      $house = House::where("id", $id)->first();

      if($house == null){
        return "House with respective ID numebr does not exist";
      }

      // $result_all = array();
      // $result_all['status'] = 0;
      //$result = array();
      //$result['errors'] = array();

      $house_id = $house->id;
      $house_img = HouseImage::where('house_id', $house_id);

      $result_house = [
        'id' => $house->id,
        'title' => $house->title,
        'price' => $house->price,
        'size' => $house->size,
        'starRating' => self::get_averageHouseOverallRating($id),
        'subtitle' => $house->subtitle, // refering to the description in the DB maybe?
        'address' => $house->address,
        'isBookmarked' => (HousePostBookmark::where('house_id', $house_id)->where('tenant_id', $userId)->count()>0)?true:false,
        'PhotoURL' => ($house_img->count()>0)?$house_img->first()->image_url:null
        // 'district_id' => $house->district_id,
        // 'description' => $house->description,
        // 'max_ppl' => $house->max_ppl,
        // 'status' => $house->status,
        // 'owner_id' => $house->owner_id,
        // 'is_deleted' => $house->is_deleted,
        // 'created_at' => $house->created_at,
        // 'updated_at' => $house->updated_at
      ];

      //$result['house'] = $result_house;
      //$result['errors'] = $errors;
      // $result_all['result'] = $result;
      // $result_all['status'] = '1';

      //return $result_all;
      return $result_house;
    }


    //Get House List
    public function index_house($userId){
      $result_houses = array();
      $houses = House::get();

      foreach ($houses as $house) {
        $house_id = $house->id;
        $house_img = HouseImage::where('house_id', $house_id);

        $result_house = [
          'id' => $house_id,
          'title' => $house->title,
          'price' => $house->price,
          'size' => $house->size,
          'starRating' => self::get_averageHouseOverallRating($house_id),
          'subtitle' => $house->subtitle, // refering to the description in the DB maybe?
          'address' => $house->address,
          'isBookmarked' => (HousePostBookmark::where('house_id', $house->id)->where('tenant_id', $userId)->count()>0)?true:false,
          'PhotoURL' => ($house_img->count()>0)?$house_img->first()->image_url:null
          // 'district_id' => $house->district_id,
          // 'description' => $house->description,
          // 'max_ppl' => $house->max_ppl,
          // 'status' => $house->status,
          // 'owner_id' => $house->owner_id,
          // 'is_deleted' => $house->is_deleted,
          // 'created_at' => $house->created_at,
          // 'updated_at' => $house->updated_at
        ];
        array_push($result_houses, $result_house);
      }

      return $result_houses;
    }

    // Get House View
    public function show_houseView($userId, $houseId){
      $result_titleView = self::show_house($houseId, $userId); // may include some extra info

      $result_teams = array();
      $groups = Group::where('house_id', $houseId)->get();
      foreach ($groups as $group) {
        array_push($result_teams, self::get_teamView($group->id));
      }

      $result_reviews = self::get_reviews($houseId);

      $response = [
        'titleView' => $result_titleView,
        'teams' => $result_teams,
        'reviews' => $result_reviews
      ];

      // create house visit record
      self::count_visitor($userId, $houseId);

      return $response;
    }

    // Retrieve list of houses saved by a tenant (Get House Saved)
    //param: userId
    public function index_houseSaved($userId){
      $bookmarks = HousePostBookmark::where('tenant_id', $userId)->get();
      if($bookmarks == null){
        return "No Bookedmark house can be displayed by this user!";
      }

      $result_savedHouses = array();
      foreach($bookmarks as $bookmark){
        $savedHouse = House::where('id', $bookmark->house_id)->first();
        $savedHouse_id = $savedHouse->id;
        $savedHouse_img = HouseImage::where('house_id', $savedHouse_id);

        if($savedHouse == null){
          return "Saved house does not exist!";
        }

        $result_savedHouse = [
          'id' => $savedHouse_id,
          'title' => $savedHouse->title,
          'price' => $savedHouse->price,
          'size' => $savedHouse->size,
          'starRating' => self::get_averageHouseOverallRating($savedHouse_id),
          'subtitle' => $savedHouse->subtitle, //refering to the "description" in the db maybe?
          'PhotoURL' => ($savedHouse_img->count()>0)?$savedHouse_img->first()->img_url:null
        ];

        array_push($result_savedHouses, $result_savedHouse);
      }

      return $result_savedHouses;
    }


    // Get House History
    // Show the list of apartment that are renting in/out by the user
    public function index_houseHistory($userId){
      $result = array();
      // Check if user is a owner
      // return rent out record if true
      if(Owner::where('user_id',$userId)->count()>0){
        $houses = House::where('owner_id', $userId)->get();
        foreach ($houses as $house) {
          $house_id = $house->id;
          $house_img = HouseImage::where('house_id', $house_id)->first();
          $house_datail = [
            'transactionType' => 'out',
            'id' => $house_id,
            'title' => $house->title,
            'price' => $house->price,
            'size' => $house->size,
            'starRating' => self::get_averageHouseOverallRating($house_id),
            'subtitle' => $house->subtitle,
            'photoURL' =>$house_img
          ];

          array_push($result, $house_datail);
        }

        return $result;
      }

      //Not owner, return tenant rental record
      $joint_groups = GroupDetail::where('member_user_id', $userId)->get();
      foreach($joint_groups as $joint_group){
        $house_id = Group::where('id', $joint_group->group_id)->first()->house_id;
        $house = House::where('id', $house_id)->first();
        $house_img = HouseImage::where('house_id', $house_id)->first();
        $house_datail = [
          'trasactionType' => 'in',
          'id' => $house_id,
          'title' => $house->title,
          'price' => $house->price,
          'size' => $house->size,
          'starRating' => self::get_averageHouseOverallRating($house_id),
          'subtitle' => $house->subtitle,
          'photoURL' =>$house_img
        ];

        array_push($result, $house_datail);
      }

      return $result;
    }


    public function archive_house($id){
      $house = House::where('id', $id)->first();

      if($house == null){
        return "House with respective ID numebr does not exist";
      }

      $house->status = 2; // currently set "2" as "archive" status
      $house->save();

      // $success_msg = "House archived Successfully (House ID = {$id})";
      // return $success_msg;

      $response = ['isSuccess' => true];
      return $response;
    }


    public function reveal_house($id){
      $house = House::where('id', $id)->first();

      if($house == null){
        return "House with respective ID numebr does not exist";
      }

      $house->status = 1; // currently set "1" as "reveal" status
      $house->save();

      // $success_msg = "House revealed Successfully (House ID = {$id})";
      // return $success_msg;

      $response = ['isSuccess' => true];
      return $response;
    }

    // Trending itme retrieval
    // input parameter: screening duration(most recent records only)
    // This function requires a extra table that stored the ppopularity score of the post
    // public function index_trending_item(){
    //   // retrieve the number of bookmarks saved by tenants (house_post_bookmark)
    //
    //   // retrieve the total number of users joining the team (house_post_group)
    //
    //   // popularity score calculation (bookmark: 1 pt, team members: 5)
    //
    //   // final data list ouput
    //
    // }

    //-----------------------------------------------------------------------------------------------
    //------------------------------ HousePostGroup (House Team) ------------------------------------
    //-----------------------------------------------------------------------------------------------

    // Get team view
    // param: teamId
    public function show_group($teamId){
      $group = Group::where("id", $teamId)->first();

      if($group == null){
        return null;
      }

      // id
      $result_id = $group->house_id;

      // teamView
      $result_teamView = self::get_teamView($teamId);

      //teamMembers
      $result_teamMembers = self::get_teamMembers($teamId);


      $response = [
        'id' => $result_id,
        'teamView'=> $result_teamView,
        'teamMembers' => $result_teamMembers
      ];

      return $response;
    }


    // Create Team
    // param:
    // $request should include $userId(as leader_user_id) and houseId
    public function store_group(Request $request){
      $group = new Group();

      $group->title = $request->input('title');
      $group->description = $request->input('description');
      $group->max_ppl = $request->input('groupSize');

      $group->image_url = $request->input('image_url'); //extra
      $group->leader_user_id = $request->input('userId');
      $group->duration = $request->input('duration');//extra
      $group->is_rent = 0;
      $group->house_id = $request->input('houseId');
      $group->save();

      // Put the leader information into group detail
      $group_detail = new GroupDetail();
      $group_detail->member_user_id = $request->input('userId');
      $group_detail->status = 2; //Default to be "accepted" status
      $group_detail->group_id = $group->id;
      $group_detail->save();

      //save preference model
      $preferenceModel = $request->input('preferenceModel');
      foreach ($preferenceModel as $modelDetail) {
        $preference_category_id = PreferenceItemCategory::where('category', key($modelDetail))->first()->id;
        $preference_item_id = PreferenceItem::where('category_id', $preference_category_id)->where('name', $modelDetail)->first()->id;

        $preference = new Preference();
        $preference->item_id = $preference_item_id;
        $preference->group_id = $group->id;
        $preference->save();

      }



      // $success_msg = "New house stored Successfully! (House ID = {$house->id})";
      // return $success_msg;

      $response = ['teamId' => $group->id];
      return $response;
    }


    // House Group PhotoURL table to be created in the ERD
    // public function store_housePostGroupImage($id){
    //   $housePostGroupImage = GroupImage();
    // }


    // Join Team
    // param:
    // $id: teamId
    // $request should include userId
    public function join_group($teamId, Request $request){
      $groupDetail = new GroupDetail();

      $groupDetail->member_user_id = $request->input('userId');
      $groupDetail->status = 1; // Status == 1 represent pending to be accepted by group leader (Accepted: 2, Rejected: 3)
      $groupDetail->group_id = $teamId;

      $groupDetail->save();

      $response = ['isSuccess' => true];
      return $response;
    }


    // Update Preference
    // param:
    // ------ $id: 'groupId',
    // ------ $request: 'preferenceModel'
    //
    // First delete all preference connected to the group
    // Then re-insert new preference data
    public function update_preference($teamId, Request $request){
      $old_preference = Preference::where('group_id', $teamId)->delete();

      $preferenceModel = $request->input('preferenceModel');
      foreach ($preferenceModel as $modelDetail) {
        $preference_category_id = PreferenceItemCategory::where('category', key($modelDetail))->first()->id;
        $preference_item_id = PreferenceItem::where('category_id', $preference_category_id)->where('name', $modelDetail)->first()->id;

        $preference = new Preference();
        $preference->item_id = $preference_item_id;
        $preference->group_id = $teamId;
        $preference->save();
      }

      $response = ['isSuccess' => true];
      return $response;
    }


    // Create Team:[Image]
    public function upload_teamPhoto(Request $request){
      $group_id = $request->input('groupId');

      if(!empty($request->file('photoURL'))) {
        $image = $request->file('photoURL');
        $extension = $image->getClientOriginalExtension();

        $now = strtotime(Carbon::now());
        $url = 'team' . '.' . $group_id . '_' . $now . '.' . $extension;
        Storage::disk('public')->put($url,  File::get($image));


        $response = ['isSuccess' => true];

      }else{
        $response = ['isSuccess' => false];
      }

      return $response;
    }


    // ------------------------------------------------------------------------------------------
    // -----------------------------Helper functions---------------------------------------------
    // ------------------------------------------------------------------------------------------

    // helper function that retrieve the team view (For retreving team veiw and house view), given Group id
    public function get_teamView($id){
      //$housePostGroup = HousePostGroup::where("id", $id)->first();
      $group = Group::where("id", $id)->first();

      if($group == null){
        return null;
      }

      $occupiedCount = GroupDetail::where('group_id', $id)->count();
      $original_price = House::where('id', $group->house_id)->first()->price;
      $preference_model = self::create_preferenceModelByPreference($id);

      //HousePostGroup::where('id', $id)->get();
      $team_view = [
        'id' => $group->id,
        'title' => $group->title, // to be added to the ERD
        'price' => $original_price/($occupiedCount+1),// Average price for each tenant
        'duration' => $group->duration, // to be added to thte ERD
        'preference' => $preference_model,// to be added to the ERD
        'description' => $group->description,// should be the house group description, to be added to the ERD
        'groupSize' => $group->max_ppl,
        'occupiedCount' => $occupiedCount
      ];

      return $team_view;
    }


    // helper function that retrieve an array of team members given housePostGroup/GroupDetail id
    public function get_teamMembers($id){
        $result_teamMembers = array();
        $teamMembers = GroupDetail::where('group_id', $id)->get();
        foreach($teamMembers as $teamMember){
          //$user_id = Tenant::where('id', $teamMember->tenant_id)->first()->user_id;
          $user_id = $teamMember->member_user_id;
          $result_teamMember = [
            'id' => $user_id,
            'name' => User::where('id',$user_id)->first()->username,
            'role' => ((Group::where('id', $id)->first()->leader_user_id==$teamMember->tenant_id)?1:0), // 1 represent "leaders" when 0 represnet "regular members"
            'photoURL' => Profile::where('user_id', $user_id)->first()->icon_url //to be added to the ERD
          ];
          array_push($result_teamMembers, $result_teamMember);
        }

        return $result_teamMembers;
    }


    // helper function that retrieve an array of reviews given house id
    public function get_reviews($id){
      $result_reviews = array();
      $house = House::where('id', $id)->first();
      $owner_id = $house->owner_id;
      $owner= Owner::where('id', $owner_id)->first();
      $reviews = Review::where('house_id', $id)->get();

      foreach($reviews as $review){
        // $tenant = Tenant::where('id', $review->tenant_id)->first();
        // $user = User::where('id', $tenant->user_id)->first();
        $user = User::where('id', $review->tenant_id)->first();
        $user_icon = Profile::where('user_id', $user->id)->first()->icon_url;
        $overall_rating = ( ($review->value) + ($review->cleaniness) + ($review->accuracy) + ($review->communication) )/4;
        $owner_comment = ReviewReply::where('review_id', $review->id)->where('owner_id', $owner_id)->first();

        $result_review = [
          'id' => $review->tenant_id,
          'username' => $user->username,
          //'title' => ,
          'date' => $review->created_at,
          'detail' => $review->details,
          'starRating' => $overall_rating,
          'ownerId' => $house->owner_id,
          'OwnerComment' => (($owner_comment!=null) ? $owner_comment->details : null),
          'phototURL' => $user_icon
        ];
        array_push($result_reviews, $result_review);
      }

      return $result_reviews;
    }


    // Helper function that calculate the average of overall star rating (using the average star rating of all related reviews) of a house
    // param: $id: houseId
    public function get_averageHouseOverallRating($id){
      $reviews = Review::where('house_id', $id)->get();

      $numOfReviews = $reviews->count();
      $total_score = 0;

      foreach($reviews as $review){
        $overall = ( ($review->value) + ($review->cleaniness) + ($review->accuracy) + ($review->communication) )/4;
        $total_score += $overall;
      }

      return ($total_score/$numOfReviews);
    }


    // helper function that create preference model (from Preference table data)
    //param: $id (groupId)
    public function create_preferenceModelByPreference($id){
      $preferences = Preference::where('group_id', $id)->get();
      if($preferences == null){
        return null;
      }

      $result_preferences = array();
      // $gender = '';
      // $petFree = '';
      // $timeInHouse = '';
      $personalities = array();
      $interests = array();

      foreach ($preferences as $preference) {
        //$preference_category_id = PreferenceItemCategory::where('category', key($modelDetail))->get()->id;
        //$preference_item_id = PreferenceItem::where('category_id', $preference_category_id)->where('name', $modelDetail)->get()->id;
        $item_id = $preference->item_id;
        $preference_item = PreferenceItem::where('id',$item_id)->first();
        $category_id = $preference_item->category_id;

        // if($category_id == 1){
        //   $gender = $preference_item->name;
        // }elseif($category_id == 2){
        //   $petFree = $preference_item->name;
        // }elseif($category_id == 3){
        //   $timeInHouse = $preference_item->name;
        // }elseif($category_id == 4){
        //   array_push($personalities, $preference_item->name);
        // }elseif($category_id ==5){
        //   array_push($interests, $preference_item->name);
        // }

        //more dynamic
        $category_name = PreferenceItemCategory::where('id', $category_id)->first()->category;

        // push one object at a time
        // but hardcode on items of category = 4,5, as they return diffferent object structures (array)
        if($category_id == 4){
          array_push($personalities, $preference_item->name);
        }elseif($category_id ==5){
          array_push($interests, $preference_item->name);
        }else{
          $preference_object =["$category_name"=>$preference_item->name];
          array_push($result_preferences, $preference_object);
        }

      }

      // $preference_model=[
      //   'id'=>$id, // should be an alternative id, currently using group id which may be conflict to profile detail
      //   'gender'=>$gender,
      //   'petFree'=>$petFree,
      //   'timeInHouse'=>$timeInHouse,
      //   'personalities'=>$personalities,
      //   'interests'=>$interests
      // ];

      if(count($personalities)>0){
        array_push($result_preferences, ["personalities"=>$personalities]);
      }
      if(count($interests)>0){
        array_push($result_preferences, ["interests"=>$interests]);
      }

      //return $preference_model;
      return $result_preferences;
    }


    // Helper function that record the visitor data on 'get' page request
    public function count_visitor($userId, $houseId){
      $visitor_count = new HouseVisitor();

      //Should only accept a duplicated visit request made by the same user only after an hour maybe?

      $visitor_count->user_id = $userId;
      $visitor_count->house_id = $houseId;

      $visitor_count->save();

      //return true;
    }


    // helper function for mathching houses with reference to users group formation history
    // return an list of houses?
    public function match_houses($userId, $required_match_houses){
      // analyse past rental records first
      $avereage_price = 0; // first level indicator
      $average_size = 0; // second level indicator
      $house_count = 0;
      $past_groupDetail_history = GroupDetail::where('member_user_id', $userId)->get();
      foreach ($past_groupDetail_history as $temp_history) {
        $past_group = Group::where('id', $temp_history->group_id)->first();
        $past_house = House::where('id', $past_group->house_id)->first();

        // cumulate price, size data
        $avereage_price += $past_house->price;
        $average_size += $past_house->size;
        $house_count += 1;
      }

      $avereage_price /= $house_count;
      $average_size /= $house_count;

      // Look for houses (that are not bookmarked) with lower price than average but bigger size than average
      $hosue_bookmarkedId = HousePostBookmark::where('tenant_id', $userId)->get();
      $matchHouses = House::whereNotIn('id', $hosue_bookmarkedId->house_id)->where('price', '<=', $avereage_price)->where('size', '>=', $average_size)->get();

      $price_step = 500;
      $size_step = 50;
      for($range_tolerated = 1; $matchHouses->count() < $required_match_houses && $range_tolerated < 3; $range_tolerated++){
        $price_steps = $price_step * $range_tolerated;
        $size_steps = $size_step * $range_tolerated;
        $matchHouses = House::whereNotIn('id', $hosue_bookmarkedId->house_id)->where('price', '<=', $avereage_price + $price_steps)->where('size', '>=', $average_size + $size_steps)->get();
      }

      // first sort the list by size-to-price ratio
      $matchHouses = $matchHouses->sortBy(function($value, $key){
        return ($value['size'] / $value['price']);
      });

      // return mathed houses if the number found exceed the number required
      if($matchHouses->count() > $required_match_houses){
        return $matchHouses->take(4)->get();
      }

      return $matchHouses;
    }


    public function match_group($userId){
      $mathch_houses = match_houses($userID);

      // retrieve preference records for houses that are not bookmarked (pool for recommentdation)
      $hosue_bookmarkedId = HousePostBookmark::where('tenant_id', $userId)->get();
      $house_prefereces = Preference::whereNotIn('id', $hosue_bookmarkedId->house_id);
      //$house_notBookmarked = House::whereNotIn('id', $hosue_bookmarkedId->house_id);

      // retrieve user preferences (profile detail)
      $user_profile = Profile::where('user_id',$id)->first();
      $profile_details = ProfileDetail::where('profile_id', $user_profile->id)->get();

      $house_filtered = $house_notBookmarked;
      foreach($profile_details as $profile_detail){
        $house_filtered = $house_filtered;
      }

    }

    // helper funcion that can the trending houses (popularity by bookmark/visitor number)
    // return array of houseId of the popular houses ($required_num)
    public function get_trendingHouses($required_num){
      $popularity_score = array();
      // get all common house_id in housePostBookmark table
      // then distribute score by the number of records they have (Default 10 points per each record)
      $popular_house_byBookmarkCount = HousePostBookmark::select('house_id')->groupBy('house_id')->get();
      foreach ($popular_house_byBookmarkCount as $temp_houseId) {
        if(isset($popularity_score[$temp_houseId])){
          $popularity_score[$temp_houseId] += HousePostBookmark::where('house_id', $temp_houseId)->count() * 10;
        }else{
          $popularity_score[$temp_houseId] = HousePostBookmark::where('house_id', $temp_houseId)->count() * 10;
        }
      }

      // get all house_id in houseVisitor table
      // then distribute score by the number of records they have (Default 2 points per each record)
      $popular_house_byVisitCount = HouseVisitor::select('house_id')->groupBy('house_id')->get();
      foreach ($popular_house_byVisitCount as $temp_houseId) {
        if(isset($popularity_score[$temp_houseId])){
          $popularity_score[$temp_houseId] += HouseVisitor::where('house_id', $temp_houseId)->count() * 2;
        }else{
          $popularity_score[$temp_houseId] = HouseVisitor::where('house_id', $temp_houseId)->count() * 2;
        }
      }

      arsort($popularity_score);
      $result = array_slice($popularity_score, 0, 5);

      return array_keys($result);

    }

    // This function is not used in the app but only kept here for testing data structure
    // public function testData(Request $request){
    //   //form preference model
    //   dd($request->input('preferenceModel')['gender'][1]);
    //   //$input = $request->all();
    //   //dd($input['preferenceModel']['gender']);
    // }

}
