<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\House;
use App\HousePostBookmark;
use App\HousePostGroup;
use App\HouseImage;
use App\Group;
use App\GroupDetail; // to be removed
use App\User;
use App\Profile;
use App\Tenant;
use App\Owner;
use App\OwnerComment;
use App\HouseComment;
use App\TenantRating;
use App\Review;
// use App\Preference;
// use App\PreferenceItem;
// use App\PreferenceItemCategory;

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
    public function show_house($id){
      $house = House::where("id", $id)->first();

      if($house == null){
        return "House with respective ID numebr does not exist";
      }

      // $result_all = array();
      // $result_all['status'] = 0;
      //$result = array();
      //$result['errors'] = array();

      $result_house = [
        'id' => $house->id,
        //'title' => $house->title, // to be added to the ERD
        'price' => $house->price,
        'size' => $house->size,
        'starRating' => $house->starRating,
        //'subtitle' => $house->subtitle, // refering to the description in the DB maybe?
        'address' => $house->address,
        'isBookmarked' => (HousePostBookmark::where('house_id', $house->id)->where('tenant_id', $userId)->get()->exists())?true:false,
        'PhotoURL' => HouseImage::where('house_id', $house->id)->first()->image_url
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


    public function index_house($userId){
      // $result_all = array();
      // $result_all['status'] = 0;
      // $result = array();
      //$errors = array();

      $result_houses = array();
      $houses = House::get();
      foreach ($houses as $house) {
        $result_house = [
          'id' => $house->id,
          //'title' => $house->title, // to be added to the ERD
          'price' => $house->price,
          'size' => $house->size,
          'starRating' => $house->starRating,
          //'subtitle' => $house->subtitle, // refering to the description in the DB maybe?
          'address' => $house->address,
          'isBookmarked' => (HousePostBookmark::where('house_id', $house->id)->where('tenant_id', $userId)->get()->exists())?true:false,
          'PhotoURL' => HouseImage::where('house_id', $house->id)->first()->image_url
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

      //$result['houses'] = $result_houses;
      //$result['errors'] = $errors;
      //$result_all['result'] = $result;
      //$result_all['status'] = '1';

      //return $result_all;
      return $result_houses;
    }

    public function show_houseView($id){
      $result_titleView = show_house($id); // may include some extra info

      $result_teams = array();
      $groups = Group::where('house_id', $id)->get();
      foreach ($groups as $group) {
        array_push($teams, get_teamView($group->id));
      }

      $result_reviews = get_reviews($id);

      $response = [
        'titleView' => $result_titleView,
        'teams' => $result_teams,
        'reviews' => $result_reviews
      ];

      return $response;
    }

    // Retrieve list of houses saved by a tenant
    public function index_houseSaved($id){
      $bookmarks = HousePostBookmark::where('tenant_id', $id)->get();
      if($bookmarks == null){
        return "No Bookedmark house can be displayed by this user!";
      }

      $result_savedHouses = array();
      foreach($bookmarks as $bookmark){
        $savedHouse = House::where('id', $bookmark->$houseid)->first();
        if($savedHouse == null){
          return "Saved house does not exist!";
        }

        $result_savedHouse = [
          'id' => $savedHouse->id,
          //'title' => $savedHouse->title, //to be added to the ERD
          'price' => $savedHouse->price,
          'size' => $savedHouse->size,
          //'starRating' => $savedHouse->starRating, //to be added to the ERD
          //'subtitle' => $savedHouse->subtitle, //refering to the "description" in the db maybe?
          'PhotoURL' => HouseImage::where('house_id', $house->id)->first()->image_url
        ];

        array_push($result_savedHouses, $result_savedHouse);
      }

      return $result_savedHouses;
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
    // param: id: teamId
    public function show_housePostGroup($id){
      $housePostGroup = HousePostGroup::where("id", $id)->first();
      $group = Group::where("id", $id)->first();

      if($housePostGroup == null){
        return "HousePostGroup with respective ID numebr does not exist";
      }

      // id
      $result_id = $housePostGroup->house_id;

      // teamView
      $result_teamView = get_teamView($id);

      //teamMembers
      $result_teamMembers = get_teamMembers($id);


      $response = [
        'id' => $result_id,
        'teamView'=> $result_teamView,
        'teamMembers' => $result_teamMembers
      ];

      return $response;
    }


    // Create Team
    // param:
    // $request should include $userId and houseId
    public function store_housePostGroup(Request $request){
      $housePostGroup = new HousePostGroup();

      $housePostGroup->title = $request->input('title');
      $housePostGroup->description = $request->input('description');
      $housePostGroup->max_ppl = $request->input('groupSize');
      $housePostGroup->save();

      //$housePostGroup->preference = $request->input('preference'); // to be added to the ERD
      // $preferences = $request->input('preference'); // should have just get the id?
      // foreach($preferences as $preference){
      //   $house_preference = new Preference();
      //   $house_preference->item_id = $preference;
      //   $house_preference->group_id = $housePostGroup->id;
      //   $house_preference->save();
      // }

      $preferenceModel = $request->input('preferenceModel');
      foreach ($preferenceModel as $modelDetail) {
        $preference_category_id = PreferenceItemCategory::where('category', key($modelDetail))->get()->id;
        $preference_item_id = PreferenceItem::where('name', $modelDetail)->where('category_id', $preference_category_id)->id;

        $preference = new Preference();
        $preference->item_id = $preference_item_id;
        $preference->group->id = $request->user_id;
        $preference->save();

      }



      // $success_msg = "New house stored Successfully! (House ID = {$house->id})";
      // return $success_msg;

      $response = ['teamId' => $housePostGroup->id];
      return $response;
    }


    // House Group PhotoURL table to be created in the ERD
    // public function store_housePostGroupImage($id){
    //   $housePostGroupImage = GroupImage();
    // }


    // param:
    // $id: teamId
    // $request should include userId
    public function join_housePostGroup($id, Request $request){
      $groupDetail = new GroupDetail();

      $groupDetail->member_user_id = $request->input('userId');
      $groupDetail->status = 0; // Status == 0 represent pending to be accepted by group leader (Accepted: 1, Rejected: -1)
      $groupDetail->group_id = $id;

      $groupDetail->save();

      $response = ['isSuccess' => true];
      return $response;
    }

    // ------------------------------------------------------------------------------------------
    // -----------------------------Helper functions---------------------------------------------
    // ------------------------------------------------------------------------------------------

    // helper function that retrieve the team view (For retreving team veiw and house view), given housePostGroup/ groupDetail id
    public function get_teamView($id){
      $housePostGroup = HousePostGroup::where("id", $id)->first();
      $group = Group::where("id", $id)->first();

      if($housePostGroup == null){
        return "HousePostGroup with respective ID numebr does not exist";
      }

      HousePostGroup::where('id', $id)->get();
      $team_view = [
        'id' => $housePostGroup->id,
        //'title' => $housePostGroup->title, // to be added to the ERD
        //'price' => $housePostGroup->price,// This is prob. not the hosue prize right?
        //'duration' => $housePostGroup->duration, // to be added to thte ERD
        //'preferencec' => ,// to be added to the ERD
        //'description' => $housePostGroup->description,// should be the house group description, to be added to the ERD
        'groupSize' => $group->max_ppl,
        'occupiedCount' => GroupDetail::where('group_id', $id)->count()
      ];

      return $teamView;
    }


    // helper function that retrieve an array of team members given housePostGroup/GroupDetail id
    public function get_teamMembers($id){
        $result_teamMembers = array();
        $teamMembers = GroupDetail::where('group_id', $id)->get();
        foreach($teamMembers as $teamMember){
          $user_id = Tenant::where('id', $teamMember->tenant_id)->first()->user_id;
          $result_teamMember = [
            'id' => $teamMember->tenant_id,
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
      $owner= Owner::where('id', $house->owner_id)->first();
      $reviews = Reviews::where('house_id', $id)->get();

      foreach($reviews as $review){
        $tenant = Tenant::where('id', $review->tenant_id)->first();
        $user = User::where('id', $tenant->user_id)->first();
        $house_comment = HouseComment::where('house_id', $id)->where('tenant_id', $review->tenant_id)->get();
        $overall_rating = ( ($review->value) + ($review->cleaniness) + ($review->accuracy) + ($review->communication) )/4;
        $tenant_rating = OwnerComment::where('owner_id'->$house->owner_id)->where('tenant_id', $tenant->$id)->first();

        $result_review = [
          'id' => $review->tenant_id,
          'username' => $user->username,
          //'title' => ,
          'date' => $review->created_at,
          //'detail' => $house_comment->detail, // to be added to the ERD
          'starRating' => $overall_rating,
          'ownerId' => $house->owner_id,
          'OwnerComment' => $tenant_rating->review,
          //'phototURL' =>
        ];
        array_push($result_reviews, $result_review);
      }

      return $result_reviews;
    }

    //temporary function for mathching house preference to the user profiled preference
    // public function match_house($userId){
    //   $hosue_bookmarkedId = HousePostBookmark::where('tenant_id', $userId)->get();
    //   $house_notBookmarked = House::whereNotIn('id', $hosue_bookmarkedId->house_id);
    //   $user_profile = Profile::get('user_id',$id)->first();
    //   $profile_details = ProfileDetail::get('profile_id', $user_profile->id)->get();
    //
    //   $house_filtered = $house_notBookmarked;
    //   foreach($profile_details as $profile_detail){
    //     $house_filtered = $house_filtered
    //   }
    //
    //
    //
    // }

    // public function testData(Request $request){
    //   //form preference model
    //   dd($request->input('preferenceModel')['gender'][1]);
    //   //$input = $request->all();
    //   //dd($input['preferenceModel']['gender']);
    // }

}
