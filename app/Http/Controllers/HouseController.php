<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\House;
use App\District;
use App\HouseStatus;
use App\HouseComment;
use App\Group;
use App\Preference;
use App\GroupDetail;
use App\HouseImage;
use App\HouseVisitor;
use App\Owner;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Validator;


class HouseController extends Controller
{
    //
    public function list_all_house() {
    	$houses = array();
    	$stacks = House::get();

    	foreach($stacks as $stack) {
    		$house = array();
    		$house['id'] = $stack->id;
        $house['title'] = $stack->title;
        $house['subtitle'] = $stack->subtitle;
    		$house['type'] = $stack->type;
    		$house['size'] = $stack->size;
    		$house['address'] = $stack->address;
    		$house['district_id'] = $stack->district_id;
    		$house['description'] = $stack->description;
    		$house['max_ppl'] = $stack->max_ppl;
    		$house['price'] = $stack->price;
    		$house['status'] = $stack->status;
    		$house['owner_id'] = $stack->owner_id;
    		$house['is_deleted'] = $stack->is_deleted;
    		$house['created_at'] = $stack->created_at;
    	}
    	return $houses;
    }


    public function show_house() {
        $houses = House::paginate(5);

        return view('house.list-house', compact('houses'));
    }

	public function show_house_details($id) {
        $groups = Group::where('house_id', $id)->latest()->get();
        $house = HouseImage::join('houses','house_images.house_id','=','houses.id')->where('houses.id', $id)->first();
        $house_urls = $house->where('house_id', $id)->get();
        $house_visitors = HouseVisitor::join('houses','house_visitors.house_id','=','houses.id')->where('houses.id', $id)->get()->count();
        $owner = Owner::join('houses','owners.id','=','houses.owner_id')
                ->join('users','owners.user_id','=','users.id')
                ->where('houses.id', $id)->first();

        $status = HouseStatus::join('houses','house_statuses.id','=','houses.status')->where('houses.id', $id)->first();
        $house_type = House::where('id',$id)->first();

        $district = District::join('houses','houses.district_id','=','districts.id')->where('houses.id',$id)->first();

        if ($house_type->type == "0")
          $type = "Flat";
        elseif ($house_type->type == "1")
          $type = "Cottage";
        elseif ($house_type->type == "2")
          $type = "Detached";
        else
          $type = "Sub-divided";

		return view('house.view-house',compact('house','groups','house_urls','house_visitors','owner','status','house_type','type','district'));
	}

  public function show_group_details($id) {
        $group = Group::where('id', $id)->first();
        // $preferences = Preference::where('group_id', $id)->latest()->get();
        $group_details = GroupDetail::where('group_id', $id)->latest()->get();
        $house = House::where('id', $group->house_id)->first();

    return view('house.group-house',compact('group','group_details','house'));
  }


    // show list of comments according to the house_id
  public function show_comments($id){
    // get targeted data
    $house = House::where('id', $id)->first();
    $house_comments = HouseComment::where('house_id', $id)->latest()->get();
    return view('house.comment-house', compact('house_comments'));
  }


    public function edit_house_form($id) { // $id is user id
        $house = House::where('id', $id)->first();
        $house_districts = District::get();
        $house_statuses = HouseStatus::get();

        $house_imgList = HouseImage::where('house_id', $id)->get();
        $house_imgArrays = array();
        $house_imgIDs = array();
        if($house_imgList->count()>0){
          $house_imgs = $house_imgList;
          foreach($house_imgs as $house_img){
            array_push($house_imgArrays, $house_img->img_url);
            array_push($house_imgIDs, $house_img);
          }
        }

        return view('house.edit-house', compact('house','house_districts','house_statuses','house_imgArrays','house_imgIDs'));
    }

    public function add_house_form() { // $id is user id
        $house = House::get();
        $house_districts = District::get();
        $house_statuses = HouseStatus::get();

        return view('house.add-house', compact('house_districts','house','house_statuses'));
    }


    public function update_house($id, Request $request) {

        $this->validate($request, [
            'edit-house-address' => 'required|max:255',
            'edit-house-title' => 'required|max:255',
            'edit-house-subtitle' => 'required|max:255',
            'edit-house-district_id'=> 'required',
            'edit-house-size' => 'required|max:255',
            'edit-house-type' => 'required|max:255',
            'edit-house-price' => 'required|max:255',
            'edit-house-status' => 'required',
            'edit-house-owner_id' => 'required|max:255',
            'edit-house-max_ppl'  => 'required|max:255',
            'edit-house-description' => 'nullable|max:255'
            ],

           [
            'edit-house-address' => 'Input Address',
            'edit-house-title' => 'Input Title',
            'edit-house-subtitle' => 'Input Subtitle',
            'edit-house-district_id.required' => 'Select District ID', //select from database
            'edit-house-size' => 'Input Apartment Size',
            'edit-house-type' => 'Select Apartment Type',
            'edit-house-price' => 'Input Price',
            'edit-house-status.required' => 'Select Apartment Status', //select from database
            'edit-house-owner_id' => 'Input Owner ID',
            'edit-house-max_ppl'  => 'Input Maximum No. People',
            'edit-house-description' => 'Input Description'
            ]);

        // get targeted data
        $house = House::where('id', $id)->first();


        $house->address = $request->input('edit-house-address');
        $house->title = $request->input('edit-house-title');
        $house->subtitle  = $request->input('edit-house-subtitle');
        $house->size = $request->input('edit-house-size');
        $house->type = (intval($request->input('edit-house-type')));
        $house->district_id = intval($request->input('edit-house-district_id'));
        $house->price = $request->input('edit-house-price');
        $house->status = intval($request->input('edit-house-status'));
        $house->owner_id = $request->input('edit-house-owner_id');
        $house->max_ppl= $request->input('edit-house-max_ppl');
        $house->description = $request->input('edit-house-description');

        $house->save();

        $house->save();

        $images = $request->file('filename');

        if(!empty($images)) {
          $size = sizeof($images);
          $last_image = HouseImage::where('house_id',$id)->get()->count();
          // foreach($images as $image) {
           $j = $last_image;
          for($i = 0; $i < $size; $i++) {
            $extension = $images[$i]->getClientOriginalExtension();

            $now = strtotime(Carbon::now());
            $url = 'house_' . $house->id . '_' . $now . '_' .$j .'.' . $extension;
            Storage::disk('public')->put($url,  File::get($images[$i]));
            $j++;
            //store
            $house_image= new HouseImage();
            $house_image->house_id = $house->id;
            $house_image->img_url = url('uploads/'.$url);
            $house_image->save();
          }
        }

        // redirect to edit success page
        return view('house.edit-house-success', ['id'=> $id]);
    }


    // process POST request
    public function add_house(Request $request) {
        // validation
        //dd($request);
        $this->validate($request, [
                'add-house-address' => 'required|max:255',
                'add-house-title' => 'required|max:255',
                'add-house-subtitle' => 'required|max:255',
                'add-house-price' => 'required|max:255',
                'add-house-size' => 'required|max:255',
                'add-house-max_ppl' => 'required|integer',
                'add-house-description' => 'required|max:255',
                // 'add-house-post_date' => 'required',
                'add-house-owner_id' => 'required|max:255',
                'add-house-type' => 'required',
                'add-house-district_id' => 'required',
                'add-house-status' => 'required',
                'filename' => 'required',
                'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ],
            [

                'add-house-address.required' => 'Input house address',
                'add-house-address.max' => 'Address cannot be too long',

                'add-house-title.required' => 'Input house title',
                'add-house-title.max' => 'Title cannot be too long',

                'add-house-subtitle.required' => 'Input house subtitle',
                'add-house-subtitle.max' => 'Subtitle cannot be too long',

                'add-house-price.required' => 'Input price',
                'add-house-size.required' => 'Input size',

                'add-house-max_ppl.required' => 'Input Maximum No. People',
                'add-house-max_ppl.integer' => 'Input integer only',

                'add-house-description.required' => 'Input description',
                'add-house-description.max' => 'Description cannot be too long',

                // 'add-house-post_date.required' => 'Input Post Date in YYYY-MM-DD',

                'add-house-owner_id.required' => 'Input house owner_id',
                'add-house-owner_id.max' => 'Owner ID cannot be too long',

                'add-house-type.required' => 'Select Apartment Type', //hard code slect

                'add-house-district_id.required' => 'Select District ID', //select from database

                'add-house-status.required' => 'Select Apartment Status' //select from database

                // 'add-house-house_category_id' => 'Select house Category'
            ]
        );

        // form information filled by users
        $house= new House();


        $house->is_deleted = "0";


        // address
        $house->address = $request->input('add-house-address');
        // Title
        $house->title = $request->input('add-house-title');
        // subtitle
        $house->subtitle = $request->input('add-house-subtitle');
        // description
        $house->description = $request->input('add-house-description');
        // max_ppl
        $house->max_ppl = $request->input('add-house-max_ppl');
        // price
        $house->price = $request->input('add-house-price');
        // size
        $house->size = $request->input('add-house-size');
        // // post-date
        // $house->post_date = $request->input('add-house-post_date');
        // owner_id
        $house->owner_id = $request->input('add-house-owner_id');
        // house type
        $house->type = (intval($request->input('add-house-type')));
        // district_id
        $house->district_id = intval($request->input('add-house-district_id'));
        //house status
        $house->status = intval($request->input('add-house-status'));

        $house->save();

        $images = $request->file('filename');
        $size = sizeof($images);

        if(!empty($images)) {
          // foreach($images as $image) {
          for($i = 0; $i < $size; $i++) {
            $extension = $images[$i]->getClientOriginalExtension();
            $now = strtotime(Carbon::now());
            $url = 'house_' . $house->id . '_' . $now . '_' .$i .'.' . $extension;
            Storage::disk('public')->put($url,  File::get($images[$i]));
            //store
            $house_image= new HouseImage();
            $house_image->house_id = $house->id;
            $house_image->img_url = url('uploads/'.$url);
            $house_image->save();
          }
        }

        // redirect to add success page
        return view('house.add-house-success', ['id'=> $house->id]);
    }

    public function delete($delete_id, Request $request) {
      //dd($request);
      $house= House::where('id', $delete_id)->first();
      $house->is_deleted = 1;
      $house->save();

      return back();
    }

    public function undelete($delete_id, Request $request) {
      //dd($request);
      $house= House::where('id', $delete_id)->first();
      $house->is_deleted = 0;
      $house->save();

      return back();
    }

    public function delete_image($house_imgID) {

      $house_image = HouseImage::where('id',$house_imgID)->delete();

      return back();
    }

    public function search(Request $request){
    if ( $request->has('search') ){

        $houses = House::where('id', "LIKE", "%".$request->search."%")
                        ->orWhere('title', "LIKE", "%".$request->search."%")
                        ->orWhere('subtitle', "LIKE", "%".$request->search."%")
                        ->orWhere('size', "LIKE", "%".$request->search."%")
                        ->orWhere('price', "LIKE", "%".$request->search."%")
                        ->orWhere('owner_id', "LIKE", "%".$request->search."%")
                        ->latest()
                        ->paginate(5)
                        ->appends('search', $request->search);

    }else{
      $houses = House::latest()->paginate(5);
    }

    $searchPhrase = $request->search;
    return view('house.list-house', compact('houses','searchPhrase'));
   }

}
