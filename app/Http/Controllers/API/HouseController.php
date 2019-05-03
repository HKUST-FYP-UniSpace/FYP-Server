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
use App\District;
use App\Chatroom;
use App\ChatroomParticipant;
use App\Message;
use App\HouseDetail;

use Validator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
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
      //$house_img = HouseImage::where('house_id', $house_id);
      $house_imgList = HouseImage::where('house_id', $house_id);
      $house_imgArray = array();
      if($house_imgList->count()>0){
        $house_imgs = $house_imgList->get();
        foreach($house_imgs as $house_img){
          array_push($house_imgArray, $house_img->img_url);
        }
      }

      $house_detail = HouseDetail::where('house_id', $house_id)->first();

      $result_house = [
        'id' => $house->id,
        'title' => $house->title,
        'price' => $house->price,
        'size' => $house->size,
        'starRating' => self::get_averageHouseOverallRating($id),
        'subtitle' => $house->subtitle, // refering to the description in the DB maybe?
        // 'address' => $house->address,
        'address' => self::convertDistrictIdToEnum($house->district_id),
        'isBookmarked' => (HousePostBookmark::where('house_id', $house_id)->where('tenant_id', $userId)->count()>0)?true:false,
        'photoURLs' => $house_imgArray,
        'rooms' => $house_detail!=null?$house_detail->room:null,
        'beds' => $house_detail!=null?$house_detail->bed:null,
        'toilets' => $house_detail!=null?$house_detail->toilet:null
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


    //Get House List (Search House)
    // Filter to be added
    public function index_house($userId, Request $request){
      $result_houses = array();
      // $houses = House::get();
      $houses = DB::table('houses');

      $keyword = $request->input('keyword');
      $origin = $request->input('origin'); //required for the distance matrix api
      $travelTime = $request ->input('travelTime'); //required for the distance matrix api
      $type = self::convertHouseTypeEnumtoId($request->input('type'));
      $minPrice = $request->input('minPrice');
      $maxPrice = $request->input('maxPrice');
      $minSize = $request->input('minSize');
      $maxSize = $request->input('maxSize');

      if(isset($keyword)){
        $houses = $houses->where(function ($query) use ($keyword){
          $query->where('title', 'LIKE', "%{$keyword}%")->orWhere('subtitle', 'LIKE', "%{$keyword}%")
          ->orWhere('description', 'LIKE', "%{$keyword}%")->orWhere('address', 'LIKE', "%{$keyword}%");
        });
      }
      if(isset($travelTime) && isset($origin)){
        $districts_in_range = app('App\Http\Controllers\API\SearchEngineController')->get_districtsInDistance($origin, $travelTime);
        $houses = $houses->whereIn("district_id", $districts_in_range);
      }
      if(isset($type)){
        $houses = $houses->where("type", $type);
      }
      if(isset($minPrice)){
        $houses = $houses->where("price", '>=' , $minPrice);
      }
      if(isset($maxPrice)){
        $houses = $houses->where("price", '<=', $maxPrice);
      }
      if(isset($minSize)){
        $houses = $houses->where("size", '>=' , $minSize);
      }
      if(isset($maxSize)){
        $houses = $houses->where("size", '<=', $maxSize);
      }

      $houses = $houses->where('is_deleted', 0)->get(); // get houses that are not deleted only

      foreach ($houses as $house) {
        $house_id = $house->id;

        $house_imgList = HouseImage::where('house_id', $house_id);
        $house_imgArray = array();
        if($house_imgList->count()>0){
          $house_imgs = $house_imgList->get();
          foreach($house_imgs as $house_img){
            array_push($house_imgArray, $house_img->img_url);
          }
        }

        $result_house = [
          'id' => $house_id,
          'title' => $house->title,
          'price' => $house->price,
          'size' => $house->size,
          'starRating' => self::get_averageHouseOverallRating($house_id),
          'subtitle' => $house->subtitle, // refering to the description in the DB maybe?
          // 'address' => $house->address,
          'address' => self::convertDistrictIdToEnum($house->district_id),
          'isBookmarked' => (HousePostBookmark::where('house_id', $house->id)->where('tenant_id', $userId)->count()>0)?true:false,
          'photoURLs' => $house_imgArray
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


    // Get House Suggestion (suggest group)
    public function index_houseSuggestion($userId){
      $required_num = 8; // Default set the number of suggested group to 8
      $groups = self::match_group($userId, $required_num);
      $result = array();
      if(!isset($groups)){
        return null;
      }
      foreach($groups as $group){
        $group_id = $group->id;
        $house_id = $group->house_id;
        //$house = House::where('id', $house_id)->first();
        $occupiedCount = GroupDetail::where('group_id', $group_id)->count();
        $preference_model = self::create_preferenceModelByPreference($group_id);

        // $house_imgList = HouseImage::where('house_id', $house_id);
        // $house_imgArray = array();
        // if($house_imgList->count()>0){
        //   $house_imgs = $house_imgList->get();
        //   foreach($house_imgs as $house_img){
        //     array_push($house_imgArray, $house_img->img_url);
        //   }
        // }
        $house_img = HouseImage::where('house_id', $house_id)->first();

        $result_group = [
          'houseId'=>$house_id,
          'teamId'=>$group_id,
          'title'=>$group->title,
          'preference'=>$preference_model,
          'duration'=>$group->duration,
          'groupSize'=>$group->max_ppl,
          'occupiedCount'=>$occupiedCount,
          'photoURL'=>$house_img==null?null:$house_img->img_url
        ];

        array_push($result, $result_group);
      }

      return $result;
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
        $savedHouse = House::where('id', $bookmark->house_id)->where('is_deleted', 0)->first();
        if($savedHouse != null){
          $savedHouse_id = $savedHouse->id;

          //$savedHouse_img = HouseImage::where('house_id', $savedHouse_id);
          $house_imgList = HouseImage::where('house_id', $savedHouse_id);
          $savedHouse_img = array();
          if($house_imgList->count()>0){
            $house_imgs = $house_imgList->get();
            foreach($house_imgs as $house_img){
              array_push($savedHouse_img, $house_img->img_url);
            }
          }


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
            'photoURLs' => $savedHouse_img
          ];

          array_push($result_savedHouses, $result_savedHouse);
        }
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

          //$house_img = HouseImage::where('house_id', $house_id)->first();
          $house_imgList = HouseImage::where('house_id', $house_id);
          $house_imgArray = array();
          if($house_imgList->count()>0){
            $house_imgs = $house_imgList->get();
            foreach($house_imgs as $house_img){
              array_push($house_imgArray, $house_img->img_url);
            }
          }

          $house_datail = [
            'transactionType' => 'out',
            'id' => $house_id,
            'title' => $house->title,
            'price' => $house->price,
            'size' => $house->size,
            'starRating' => self::get_averageHouseOverallRating($house_id),
            'subtitle' => $house->subtitle,
            'photoURLs' =>$house_imgArray
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

        //$house_img = HouseImage::where('house_id', $house_id)->first();
        $house_imgList = HouseImage::where('house_id', $house_id);
        $house_imgArray = array();
        if($house_imgList->count()>0){
          $house_imgs = $house_imgList->get();
          foreach($house_imgs as $house_img){
            array_push($house_imgArray, $house_img->img_url);
          }
        }

        $house_datail = [
          'trasactionType' => 'in',
          'id' => $house_id,
          'title' => $house->title,
          'price' => $house->price,
          'size' => $house->size,
          'starRating' => self::get_averageHouseOverallRating($house_id),
          'subtitle' => $house->subtitle,
          'photoURLs' =>$house_imgArray
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
      $user_id = $request->input('userId');
      $house_id = $request->input('houseId');

      $past_group = Group::where('leader_user_id', $user_id)->where('house_id', $house_id)->first();
      if($past_group != null){
        return ['isSuccess'=>false];
      }

      $group = new Group();

      $group->title = $request->input('title');
      $group->description = $request->input('description');
      $group->max_ppl = $request->input('groupSize');

      $group->image_url = "www.google.com"; //$request->input('image_url'); //extra
      $group->leader_user_id = $user_id;
      $group->duration = $request->input('duration');//extra
      $group->is_rent = 0;
      $group->house_id = $house_id;
      $group->save();

      // Put the leader information into group detail
      $team_id = $group->id;

      $group_detail = new GroupDetail();
      $group_detail->member_user_id = $user_id;
      $group_detail->status = 1; //Default to be "accepted" status
      $group_detail->group_id = $team_id;
      $group_detail->save();

      //save preference model
      $preferenceModel = $request->input('preference');
      // foreach ($preferenceModel as $modelDetail) {
      //   $preference_category_id = PreferenceItemCategory::where('category', key($modelDetail))->first()->id;
      //   $preference_item_id = PreferenceItem::where('category_id', $preference_category_id)->where('name', $modelDetail)->first()->id;
      //
      //   $preference = new Preference();
      //   $preference->item_id = $preference_item_id;
      //   $preference->group_id = $group->id;
      //   $preference->save();
      //
      // }
      self::regenerate_preference($team_id, $preferenceModel);

      app('App\Http\Controllers\API\ChatroomController')->create_chatroom_team($user_id, $team_id);

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
      $user_id = $request->input('userId');

      $groupDetail = new GroupDetail();
      $groupDetail->member_user_id = $user_id;
      $groupDetail->status = 0; //*!!Test: 1 for accpeted // Status == 0 represent pending to be accepted by group leader (Accepted: 2, Rejected: 3)
      $groupDetail->group_id = $teamId;
      $groupDetail->save();

      $message = $request->input('message');
      app('App\Http\Controllers\API\ChatroomController')->create_chatroom_request($user_id, $teamId, $message);

      $response = ['isSuccess' => true];
      return $response;
    }


    // Approve Join Team request
    public function approve_groupMember($request_chatroomId, Request $request){
      $leader_id = $request->input('leaderId');
      $acceptance = $request->input('acceptance');
      $group_id = Chatroom::where('id', $request_chatroomId)->first()->type_identifier;
      $member_id = ChatroomParticipant::where('chatroom_id', $request_chatroomId)->where('user_id', '!=', $leader_id)->first()->user_id;

      $response = [];

      if($acceptance == true){
        //create new chatroom participant linked to the requested group
        $joint_chatroom = Chatroom::where('chatroom_type_id', 2)->where('type_identifier', $group_id)->first();
        $joint_chatroom_id = $joint_chatroom->id;
        $joint_chatroom->total_message = Message::where('chatroom_id', $joint_chatroom_id)->count() + 1;
        $joint_chatroom->save();

        $new_participant = new ChatroomParticipant();
        $new_participant->chatroom_id = $joint_chatroom_id;
      	$new_participant->user_id = $member_id;
      	$new_participant->save();

        $username = User::where('id', $member_id)->first()->username;

        $message = new Message();
        $message->message = "{$username} has been added to the group";
      	$message->sender = $leader_id;
      	$message->deleted = 0;
      	$message->chatroom_id = $joint_chatroom_id;
      	$message->save();

        $group_detail = GroupDetail::where('group_id', $group_id)->where('member_user_id',$member_id)->first();
        $group_detail->status = 1; // accept status
        $group_detail->save();
      }else{
        $group_detail = GroupDetail::where('group_id', $group_id)->where('member_user_id',$member_id)->first();
        $group_detail->status = 2; //deny status
        $group_detail->save();
      }

      //delete request related records
      Message::where('chatroom_id', $request_chatroomId)->delete();
      ChatroomParticipant::where('chatroom_id', $request_chatroomId)->delete();
      Chatroom::where('id', $request_chatroomId)->delete();

      $response = ['isSuccess'=>true];
      return $response;
    }

    // Update Preference
    //
    // param:
    // ------ $id: 'groupId',
    // ------ $request: 'preferenceModel'
    //
    // First delete all preference connected to the group (if exist)
    // Then re-insert new preference data
    public function update_preference($teamId, Request $request){
      // $preferenceModel = $request->input('preferenceModel');
      // if(!isset($preferenceModel)){
      //   $response = ['isSuccess' => false];
      //   return $response;
      // }
      //
      // $gender = $request->input('gender');
      // $petFree = $request->input('petFree');
      // $timeInHouse = $request->input('timeInHouse');
      // $personalities = $request->input('personalities');
      // $interests = $request->input('interests');

      $preferenceModel=[
        'gender'=>$request->input('gender'),
        'petFree'=>$request->input('petFree'),
        'timeInHouse'=>$request->input('timeInHouse'),
        'personalities'=>$request->input('personalities'),
        'interests'=>$request->input('interests')
      ];

      // $old_preferences = Preference::where('group_id', $teamId);
      // if($old_preferences->count() > 0){
      //   $old_preferences->delete();
      // }
      //
      // foreach ($preferenceModel as $modelDetail) {
      //   $preference_category_id = PreferenceItemCategory::where('category', key($modelDetail))->first()->id;
      //
      //   // Cases for array object (personalities / interests)
      //   if($preference_category_id == 4 || $preference_category_id == 5){
      //     foreach($modelDetail as $detailItem){
      //       $preference_item_id = PreferenceItem::where('category_id', $preference_category_id)->where('name', $detailItem)->first()->id;
      //
      //       $preference = new Preference();
      //       $preference->item_id = $preference_item_id;
      //       $preference->group_id = $teamId;
      //       $preference->save();
      //     }
      //   }
      //
      //   // Otherwise (not personalities / interests), objects should not be array
      //   $preference_item_id = PreferenceItem::where('category_id', $preference_category_id)->where('name', $modelDetail)->first()->id;
      //
      //   $preference = new Preference();
      //   $preference->item_id = $preference_item_id;
      //   $preference->group_id = $teamId;
      //   $preference->save();
      // }
      $response = self::regenerate_preference($teamId, $preferenceModel);

      //$response = ['isSuccess' => true];
      return $response;
    }


    // Create Team:[Image]
    public function upload_teamPhoto(Request $request){
      $group_id = $request->input('teamId');

      $team = Group::where('id', $group_id)->first();

      if(!empty($request->file('photoURL'))) {
        $image = $request->file('photoURL');
        $extension = $image->getClientOriginalExtension();

        $now = strtotime(Carbon::now());
        $url = 'team' . '.' . $group_id . '_' . $now . '.' . $extension;
        Storage::disk('public')->put($url,  File::get($image));

        $team->image_url = url('uploads/'.$url);
        $team->save();

        $response = ['isSuccess' => true];

      }else{
        $response = ['isSuccess' => false];
      }

      return $response;
    }


    //Add Review
    public function review_house($houseId, Request $request){
      $user_id = $request->input('userId');
      $review_checker = Review::where('tenant_id', $user_id)->where('house_id', $houseId)->first();
      if($review_checker != null){
        return ['error'=> 'Review on the apartment has been created by the user!'];
      }

      $review = new Review();

      $review->house_id = $houseId;
      //$review->tenant_id = $user_id; //better send userId instead in the request
      $review->tenant_id = $user_id;
      //$review->tenant_id = $request->input('title'); //obsoleted
      //$review->tenant_id = $request->input('date'); // should just use creation date by default
      $review->details = $request->input('detail');
      //$review->tenant_id = $request->input('starRating'); // should be divided into the following
      $review->value = $request->input('value');
      $review->cleaniness = $request->input('cleanliness'); //typo in migration
      $review->accuracy = $request->input('accuracy');
      $review->communication = $request->input('communication');

      $review->save();

      $response=[
        'isSuccess'=>true,
        'id'=>$review->id,
        'detail'=>$review->details,
        'username'=>$review->tenant_id,
        'value'=>$review->value,
        'cleanliness'=>$review->cleaniness,
        'accuracy'=>$review->accuracy,
        'communication'=>$review->communication,
        'house_id'=>$review->house_id,
        'date'=>strtotime($review->created_at)
      ];

      return $response;
    }


    // ------------------------------------------------------------------------------------------
    // -----------------------------Helper functions---------------------------------------------
    // ------------------------------------------------------------------------------------------

    // helper function that retrieve the team view (For retreving team veiw and house view), given Group id
    public function get_teamView($id){
      //$housePostGroup = HousePostGroup::where("id", $id)->first();
      $group = Group::where("id", $id)->first();
      $house_id = $group->house_id;

      if($group == null){
        return null;
      }

      $occupiedCount = GroupDetail::where('group_id', $id)->count();
      $original_price = House::where('id', $house_id)->first()->price;
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
        'occupiedCount' => $occupiedCount,
        'photoURL' => $group->image_url
      ];

      return $team_view;
    }


    // helper function that retrieve an array of team members given housePostGroup/GroupDetail id
    public function get_teamMembers($id){
        $result_teamMembers = array();
        $teamMembers = GroupDetail::where('group_id', $id)->get();
        foreach($teamMembers as $teamMember){
          //$user_id = Tenant::where('id', $teamMember->tenant_id)->first()->user_id;
          $user_id = (int)$teamMember->member_user_id;
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
        $profile = Profile::where('user_id', $user->id)->first();
        $user_icon = $profile!=null ? $profile->icon_url : null;
        $overall_rating = ( ($review->value) + ($review->cleaniness) + ($review->accuracy) + ($review->communication) )/4;
        $owner_comment = ReviewReply::where('review_id', $review->id)->where('owner_id', $owner_id)->first();

        $result_review = [
          'id' => $review->tenant_id,
          'username' => $user->username,
          //'title' => ,
          'date' => $review->created_at!=null ? date($review->created_at): null,
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

      if($numOfReviews == 0){
        return null;
      }

      $total_score = 0;

      foreach($reviews as $review){
        $overall = ( ($review->value) + ($review->cleaniness) + ($review->accuracy) + ($review->communication) )/4;
        $total_score += $overall;
      }

      return ($total_score/$numOfReviews);
    }


    // helper function that regenerate (delete and store) data in preference table
    // given teamId and preferenceModel
    //
    // First delete all preference connected to the group (if exist)
    // Then re-insert new preference data
    public function regenerate_preference($teamId, $preferenceModel){
      $old_preferences = Preference::where('group_id', $teamId);
      if($old_preferences->count() > 0){
        $old_preferences->delete();
      }

      $input = $preferenceModel;
      // //$preferenceModel = $request->input('preferenceModel');
      // foreach ($preferenceModel as $modelDetail) {
      //   $preference_category_id = PreferenceItemCategory::where('category', key($modelDetail))->first()->id;

      //   // Cases for array object (personalities / interests)
      //   if($preference_category_id == 4 || $preference_category_id == 5){
      //     foreach($modelDetail as $detailItem){
      //       $preference_item_id = PreferenceItem::where('category_id', $preference_category_id)->where('name', $detailItem)->first()->id;

      //       $preference = new Preference();
      //       $preference->item_id = $preference_item_id;
      //       $preference->group_id = $teamId;
      //       $preference->save();
      //     }
      //   }

      //   // Otherwise (not personalities / interests), objects should not be array
      //   $preference_item_id = PreferenceItem::where('category_id', $preference_category_id)->where('name', $modelDetail)->first()->id;

      //   $preference = new Preference();
      //   $preference->item_id = $preference_item_id;
      //   $preference->group_id = $teamId;
      //   $preference->save();
      // }
      // dd($preferenceModel);
      if(isset($input['gender'])) {
            $preference_id = PreferenceItem::where('category_id', 1)->where('name', $input['gender'])->first()->id;

            $new_preference_detail = new Preference();
            $new_preference_detail->group_id = $teamId;
            $new_preference_detail->item_id = intval($preference_id);
            $new_preference_detail->save();
        }
        else {  // null means no preference
            $new_preference_detail = new Preference();
            $new_preference_detail->group_id = $teamId;
            $new_preference_detail->item_id = 3;
            $new_preference_detail->save();
        }

        if(isset($input['petFree'])) {
            if($input['petFree'] == true) {
                $petfree = "true";
            }
            elseif($input['petFree'] == false) {
                $petfree = "false";
            }
            $preference_id = PreferenceItem::where('category_id', 2)->where('name', $petfree)->first()->id;

            $new_preference_detail = new Preference();
            $new_preference_detail->group_id = $teamId;
            $new_preference_detail->item_id = intval($preference_id);
            $new_preference_detail->save();
        }

        if(isset($input['timeInHouse'])) {
            $preference_id = PreferenceItem::where('category_id', 3)->where('name', $input['timeInHouse'])->first()->id;

            $new_preference_detail = new Preference();
            $new_preference_detail->group_id = $teamId;
            $new_preference_detail->item_id = intval($preference_id);
            $new_preference_detail->save();
        }

        if(isset($input['personalities'])) {
            $result['personalities'] = array();
            foreach($input['personalities'] as $personalities) {
                $preference_id = PreferenceItem::where('category_id', 4)->where('name', $personalities)->first()->id;

                $new_preference_detail = new Preference();
                $new_preference_detail->group_id = $teamId;
                $new_preference_detail->item_id = intval($preference_id);
                $new_preference_detail->save();
            }
        }

        if(isset($input['interests'])) {
            $result['interests'] = array();
            foreach($input['interests'] as $interests) {
                $preference_id = PreferenceItem::where('category_id', 5)->where('name', $interests)->first()->id;

                $new_preference_detail = new Preference();
                $new_preference_detail->group_id = $teamId;
                $new_preference_detail->item_id = intval($preference_id);
                $new_preference_detail->save();
            }
        }

      $response = ['isSuccess' => true];
      return $response;
    }


    // helper function that create preference model (from Preference table data)
    //param: $id (groupId)
    public function create_preferenceModelByPreference($id){
      $preferences = Preference::where('group_id', $id)->get();
      if($preferences == null){
        return null;
      }

      $result_preferences = array();
      $gender = '';
      $petFree = '';
      $timeInHouse = '';
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
        }elseif($category_id == 5){
          array_push($interests, $preference_item->name);
        // }else{
        //   $preference_object =["$category_name"=>$preference_item->name];
        //   array_push($result_preferences, $preference_object);
        // }
        }elseif($category_id == 1){
          $gender = $preference_item->name;
        }elseif ($category_id == 2) {
          $petFree = (bool)$preference_item->name;
        }elseif($category_id == 3){
          $timeInHouse = $preference_item->name;
        }

      }


      if(count($personalities)>0){
        array_push($result_preferences, ["personalities"=>$personalities]);
      }
      if(count($interests)>0){
        array_push($result_preferences, ["interests"=>$interests]);
      }

      $preference_model=[
        'id'=>(int)$id, // should be an alternative id, currently using group id which may be conflict to profile detail
        'gender'=>$gender,
        'petFree'=>$petFree,
        'timeInHouse'=>$timeInHouse,
        'personalities'=>$personalities,
        'interests'=>$interests
      ];

      return $preference_model;
      //return $result_preferences;
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
    // return an collection of matched houses (size depends in $required_match_houses)
    public function match_houses($userId, $required_match_houses){
      // analyse past rental records first
      $avereage_price = 0; // first level indicator
      $average_size = 0; // second level indicator
      $house_count = 0;
      $past_groupDetail_history = GroupDetail::where('member_user_id', $userId)->get();
      foreach ($past_groupDetail_history as $temp_history) {
        $past_group = Group::where('id', $temp_history->group_id)->first();

        if($past_group != null){
          $past_house = House::where('id', $past_group->house_id)->first();

          // cumulate price, size data
          $avereage_price += $past_house->price;
          $average_size += $past_house->size;
          $house_count += 1;
        }

      }

      if($house_count == 0){
        return null;
      }

      $avereage_price /= $house_count;
      $average_size /= $house_count;

      // Look for houses (that are not bookmarked) with lower price than average but bigger size than average
      //$hosue_bookmarkedId = HousePostBookmark::where('tenant_id', $userId)->get();
      $hosue_bookmarkedId = HousePostBookmark::where('tenant_id', $userId)->select('tenant_id')->groupBy('tenant_id')->get();
      $matchHouses = House::whereNotIn('id', $hosue_bookmarkedId)->where('price', '<=', $avereage_price)->where('size', '>=', $average_size)->get();

      $price_step = 500;
      $size_step = 50;
      for($range_tolerated = 1; $matchHouses->count() < $required_match_houses && $range_tolerated < 3; $range_tolerated++){
        $price_steps = $price_step * $range_tolerated;
        $size_steps = $size_step * $range_tolerated;
        $matchHouses = House::whereNotIn('id', $hosue_bookmarkedId)->where('price', '<=', $avereage_price + $price_steps)->where('size', '>=', $average_size + $size_steps)->get();
      }

      // first sort the list by size-to-price ratio
      $matchHouses = $matchHouses->sortBy(function($value, $key){
        return ($value['size'] / $value['price']);
      });

      // return matched houses if the number found exceed the number required
      if($matchHouses->count() > $required_match_houses){
        return $matchHouses->take($required_match_houses)->get();
      }

      return $matchHouses;
    }

    // helper function that return matched group according to user/house preference and
    // given userId, required_num
    // return an array of groups of size = required_num
    public function match_group($userId, $required_num){
      // retrieve user preferences (profile detail)
      $user_profile = Profile::where('user_id',$userId)->first();
      $profile_details = ProfileDetail::where('profile_id', $user_profile->id);
      $user_profileItems = $profile_details->select('item_id')->groupBy('item_id')->get();

      $matched_group = array();

      // look for matched group in matched houses
      $match_houses = self::match_houses($userId, $required_num*2); // get a collection of matched house (default: search double quantity of house by required no. of groups)
      if($match_houses!=null && $match_houses->count() > 0){
        foreach($match_houses as $match_house){
          $house_id = $match_house->id;
          $groups = Group::where('house_id', $house_id)->get();
          foreach($groups as $group){
            $group_id = $group->id;
            $house_preferecesCount = Preference::where('group_id', $group_id)->whereIn('item_id', $user_profileItems)->count();

            if($house_preferecesCount > 0){
              $matched_group[$group_id]=$house_preferecesCount;
            }
          }
        }
      }

      if(sizeof($matched_group) >= $required_num){
        arsort($matched_group);
        $result = array_slice($matched_group, 0, $required_num, $preserve_keys = TRUE);

        return Group::whereIn('id', array_keys($result))->get();
      }

      // look for matched group in trending houses
      $trending_houses = self::get_trendingHouses($required_num*2); //get a colection of trending houses
      if($trending_houses->count() > 0){
        foreach($trending_houses as $trending_house){
          $house_id = $trending_house->id;
          $groups = Group::where('house_id', $house_id)->get();
          foreach($groups as $group){
            $group_id = $group->id;
            $house_preferecesCount = Preference::where('group_id', $group_id)->whereIn('item_id', $user_profileItems)->count();

            if($house_preferecesCount > 0){
              $matched_group[$group_id]=$house_preferecesCount;
            }
          }
        }
      }

      arsort($matched_group);
      // dd($matched_group);
      $result = array_slice($matched_group, 0, $required_num, $preserve_keys = TRUE);

      return Group::whereIn('id', array_keys($result))->get();
    }

    // Only for inserting test data
    public function add_profileDetail($id, $itemId){
      $profileDetail = new ProfileDetail();

      $profileDetail->profile_id = $id;
      $profileDetail->item_id = $itemId;

      $profileDetail->save();

      return "saved";
    }


    // helper funcion that can get the trending houses (popularity by bookmark/visitor number)
    // return a collection of the popular houses ($required_num)
    public function get_trendingHouses($required_num){
      $popularity_score = array();
      // get all common house_id in housePostBookmark table
      // then distribute score by the number of records they have (Default 10 points per each record)
      $popular_house_byBookmarkCount = HousePostBookmark::select('house_id')->groupBy('house_id')->get();
      foreach ($popular_house_byBookmarkCount as $popular_houseId) {
        $temp_houseId = $popular_houseId->house_id;
        if(Arr::exists($popularity_score, $temp_houseId)){
          $popularity_score[$temp_houseId] += HousePostBookmark::where('house_id', $temp_houseId)->count() * 10;
        }else{
          $popularity_score[$temp_houseId] = HousePostBookmark::where('house_id', $temp_houseId)->count() * 10;
        }
      }

      // get all house_id in houseVisitor table
      // then distribute score by the number of records they have (Default 2 points per each record)
      $popular_house_byVisitCount = HouseVisitor::select('house_id')->groupBy('house_id')->get();
      foreach ($popular_house_byVisitCount as $popular_houseId) {
        $temp_houseId = $popular_houseId->house_id;
        if(Arr::exists($popularity_score, $temp_houseId)){
          $popularity_score[$temp_houseId] += HouseVisitor::where('house_id', $temp_houseId)->count() * 2;
        }else{
          $popularity_score[$temp_houseId] = HouseVisitor::where('house_id', $temp_houseId)->count() * 2;
        }
      }

      // return $popularity_score;
      arsort($popularity_score);
      // dd($popularity_score);

      $result = array_slice($popularity_score, 0, $required_num, $preserve_keys = TRUE);
      // dd($result);
      // $houses = array();
      // foreach($result as $key => $value) {
      //   $house = House::where('id', $key)->first();
      //   array_push($houses, $house);
      // }
      // dd($result);
      // $result = array();
      // $i = 0;
      // foreach($popularity_score as $temp){
      //   if($i < $required_num){
      //     array_push($result, $temp);
      //     $i++;
      //   }else{
      //     break;
      //   }
      // }
      // return $result;
      // return array_keys($result);

      return House::whereIn('id', array_keys($result))->get();
      // return $houses;
    }


    //This is a helper function that convert district_id to their enum name value
    public function convertDistrictIdToEnum($id){
      $enum = District::where('id', $id)->first();

      if($enum != null){
        return $enum->name;
      }

      return null;
    }


    //This is a helper function that convert district name to their enum id value
    public function convertDistrictEnumToId($name){
      $enum = District::where('name', $name)->first();

      if($enum != null){
        return $enum->id;
      }

      return null;
    }


    // This is a helper function that convert house type to their enum name value
    public function convertHouseTypeIdToEnum($id){
      if($id == 0){
        return 'Flat';
      }elseif($id == 1){
        return 'Cottage';
      }elseif($id == 2){
        return 'Detached';
      }elseif($id == 3){
        return 'Sub-divided';
      }

      return null;
    }


    // This is helper function that convert house type enum string to their id value
    public function convertHouseTypeEnumtoId($type){
      if($type == 'Flat'){
        return 0;
      }elseif($type == 'Cottage'){
        return 1;
      }elseif($type == 'Detached'){
        return 2;
      }elseif($type == 'Sub-divided'){
        return 3;
      }

      return null;
    }

    // This function is not used in the app but only kept here for testing data structure
    // public function testData(Request $request){
    //   //form preference model
    //   dd($request->input('preferenceModel')['gender'][1]);
    //   //$input = $request->all();
    //   //dd($input['preferenceModel']['gender']);
    // }

}
