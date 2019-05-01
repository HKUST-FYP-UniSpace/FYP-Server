<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Trade;
use App\TradeStatus;
use App\TradeCategory;
use App\TradeConditionType;
use App\TradeImage;
use App\District;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\UploadedFile;
use Validator;

class TradeController extends Controller
{
    //
     public function list_all_trade() {
    	$trades = array();
    	$stacks = Trade::get();

    	foreach($stacks as $stack) {
    		$trade = array();
    		$trade['id'] = $stack->id;
    		$trade['title'] = $stack->title;
    		$trade['price'] = $stack->price;
    		$trade['quantity'] = $stack->quantity;
    		$trade['description'] = $stack->description;
    		// $trade['post_date'] = $stack->post_date;
    		$trade['status'] = $stack->status;
    		$trade['user_id'] = $stack->user_id;
    		$trade['trade_category_id'] = $stack->trade_category_id;
    		$trade['trade_condition_type_id'] = $stack->trade_condition_type_id;
    		$trade['trade_status_id'] = $stack->trade_status_id;
    		$trade['is_deleted'] = $stack->is_deleted;
    		$trade['created_at'] = $stack->created_at;
        $trade['updated_at'] = $stack->updated_at;
    	}
    	return $trades;
    }

    public function show_trade() {

        $trades = Trade::paginate(5);

        return view('trade.list-trade', compact('trades'));
    }

	public function show_trade_details($id) {
        // $trade = Trade::where('id', $id)->first();
        $trade = TradeImage::join('trades','trade_images.trade_id','=','trades.id')->where('trades.id', $id)->first();
        // $trade_urls = $trade->where('trade_id', $id)->get();
        $trade_urls =  TradeImage::where('trade_id', $id)->get();
        $category = TradeCategory::join('trades','trade_categories.id','=','trades.trade_category_id')->where('trades.id', $id)->first();
        $condition_type = TradeConditionType::join('trades','trade_condition_types.id','=','trades.trade_condition_type_id')->where('trades.id', $id)->first();
        $status = TradeStatus::join('trades','trade_statuses.id','=','trades.trade_status_id')->where('trades.id', $id)->first();
        $district_id = District::join('trades','districts.id','=','trades.district_id')->where('trades.id', $id)->first();
        $user = User::join('trades','users.id','=','trades.user_id')
                ->where('trades.id', $id)->first()->value('name');


		return view('trade.view-trade',compact('trade','trade_urls','category','condition_type','status','district_id','user'));
	}

    public function edit_trade_form($id) { // $id is user id
        $trade = Trade::where('id', $id)->first();
        $trade_statuses = TradeStatus::get();
        $trade_categories = TradeCategory::get();
        $trade_conditions = TradeConditionType::get();
        $trade_districts = District::get();

        $trade_imgList = TradeImage::where('trade_id', $id)->get();
        $trade_imgArrays = array();
        if($trade_imgList->count()>0){
          $trade_imgs = $trade_imgList;
          foreach($trade_imgs as $trade_img){
            array_push($trade_imgArrays, $trade_img->image_url);
          }
        }

        return view('trade.edit-trade', compact('trade','trade_statuses','trade_categories','trade_conditions','trade_imgArrays','trade_districts'));

    }

    public function add_trade_form() { // $id is user id
        $trade_statuses = TradeStatus::get();
        $trade_categories = TradeCategory::get();
        $trade_conditions = TradeConditionType::get();
        $trade_districts = District::get();

        return view('trade.add-trade',compact('trade_statuses','trade_categories','trade_conditions','trade_districts'));
    }


    public function update_trade($id, Request $request) {

        $this->validate($request, [
            'edit-trade-title' => 'required|max:255',
            'edit-trade-price' => 'required|max:255',
            'edit-trade-quantity' => 'required|max:255',
            'edit-trade-trade_category_id' => 'required|max:255',
            'edit-trade-trade_condition_type_id' => 'required|max:255',
            'edit-trade-trade_status_id'  => 'required|max:255',
            'edit-trade-district_id'=> 'required',
            'edit-trade-description' => 'nullable|max:255'
            ],

           [
            'edit-trade-title' => 'Input Title',
            'edit-trade-price' => 'Input Price',
            'edit-trade-quantity' => 'Input Quantity',
            'edit-trade-trade_category_id' => 'Select Trade Category ID',
            'edit-trade-trade_condition_type_id' => 'Select Trade Condition Type ID',
            'edit-trade-trade_status_id'  => 'Select Trade Status ID',
            'edit-trade-district_id.required' => 'Select District ID', //select from database
            'edit-trade-description' => 'Input Description'
            ]);


        // get targeted data
        $trade = Trade::where('id', $id)->first();


        $trade->title = $request->input('edit-trade-title');
        $trade->price = $request->input('edit-trade-price');
        $trade->quantity = $request->input('edit-trade-quantity');
        $trade->trade_category_id = $request->input('edit-trade-trade_category_id');
        $trade->trade_condition_type_id = $request->input('edit-trade-trade_condition_type_id');
        $trade->trade_status_id= $request->input('edit-trade-trade_status_id');
        $trade->district_id = intval($request->input('edit-trade-district_id'));
        $trade->description = $request->input('edit-trade-description');

        $trade->save();

        $images = $request->file('filename');
        $size = sizeof($images);
        $last_image = TradeImage::where('trade_id',$id)->get()->count();



        if(!empty($images)) {
          // foreach($images as $image) {
           $j = $last_image;
          for($i = 0; $i < $size; $i++) {
            $extension = $images[$i]->getClientOriginalExtension();
            $now = strtotime(Carbon::now());
            $url = 'trade_' . $trade->id . '_' . $now . '_' .$j .'.' . $extension;
            Storage::disk('public')->put($url,  File::get($images[$i]));
            $j++;
            //store
            $trade_image= new TradeImage();
            $trade_image->trade_id = $trade->id;
            $trade_image->image_url = url('uploads/'.$url);
            $trade_image->save();
          }
        }


        // redirect to edit success page
        return view('trade.edit-trade-success', ['id'=> $id]);
    }

    // process POST request
    public function add_trade(Request $request) {
        // validation
        //dd($request);
        $this->validate($request, [
                'add-trade-title' => 'required|max:255',
                'add-trade-price' => 'required|max:255',
                'add-trade-quantity' => 'required|integer',
                'add-trade-description' => 'required|max:255',
                'add-trade-user_id' => 'required|max:255',
                'add-trade-district_id' => 'required',
                'add-trade-status' => 'required',
                'add-trade-trade_category_id' => 'required',
                'add-trade-trade_condition_type_id' => 'required',
                'filename' => 'required',
                'filename.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ],
            [

                'add-trade-title.required' => 'Input trade title',
                'add-trade-title.max' => 'Title cannot be too long',

                'add-trade-price.required' => 'Input price',

                'add-trade-quantity.required' => 'Input price',
                'add-trade-quantity.integer' => 'Input integer only',

                'add-trade-district_id.required' => 'Select District ID', //select from database

                'add-trade-description.required' => 'Input description',
                'add-trade-description.max' => 'Description cannot be too long',

                'add-trade-user_id.required' => 'Input trade user_id',
                'add-trade-user_id.max' => 'User ID cannot be too long',

                'add-trade-status.required' => 'Select Status', //select from database
                'add-trade-trade_category_id.required' => 'Select Trade Category', //select from database
                'add-trade-trade_condition_type_id.required' => 'Select Status' //select from database
            ]
        );

        // form information filled by users
        $trade= new Trade();

        $trade->is_deleted = "0";
        $trade->user_id = "1";


        // title
        $trade->title = $request->input('add-trade-title');
        // description
        $trade->description = $request->input('add-trade-description');
        // quantity
        $trade->quantity = $request->input('add-trade-quantity');
        // price
        $trade->price = $request->input('add-trade-price');
        //$user_id
        $trade->user_id = $request->input('add-trade-user_id');
        // status
        $trade->trade_status_id = intval($request->input('add-trade-status'));
        // trade_category_id
        $trade->trade_category_id= intval($request->input('add-trade-trade_category_id'));
        // trade_condition_type_id
        $trade->trade_condition_type_id= intval($request->input('add-trade-trade_condition_type_id'));
        // district_id
        $trade->district_id = intval($request->input('add-trade-district_id'));

        $trade->save();

        $images = $request->file('filename');
        $size = sizeof($images);

        if(!empty($images)) {
          // foreach($images as $image) {
          for($i = 0; $i < $size; $i++) {
            $extension = $images[$i]->getClientOriginalExtension();
            $now = strtotime(Carbon::now());
            $url = 'trade_' . $trade->id . '_' . $now . '_' .$i .'.' . $extension;
            Storage::disk('public')->put($url,  File::get($images[$i]));
            //store
            $trade_image= new TradeImage();
            $trade_image->trade_id = $trade->id;
            $trade_image->image_url = url('uploads/'.$url);
            $trade_image->save();
          }
        }
        // redirect to add success page
        return view('trade.add-trade-success', ['id'=> $trade->id]);
    }

    public function delete($delete_id, Request $request) {
      //dd($request);
      $trade= Trade::where('id', $delete_id)->first();
      $trade->is_deleted = 1;
      $trade->save();

      return back();
    }

    public function undelete($delete_id, Request $request) {
      //dd($request);
      $trade= Trade::where('id', $delete_id)->first();
      $trade->is_deleted = 0;
      $trade->save();

      return back();
    }

    public function delete_image($trade_imgArray) {

      $trade_image = TradeImage::where('image_url',$trade_imgArray)->first()->delete();

      return back();
    }

    public function search(Request $request){
    if ( $request->has('search') ){

        $trades = Trade::where('id', "LIKE", "%".$request->search."%")
                        ->orWhere('title', "LIKE", "%".$request->search."%")
                        ->orWhere('price', "LIKE", "%".$request->search."%")
                        ->orWhere('user_id', "LIKE", "%".$request->search."%")
                        ->latest()
                        ->paginate(5)
                        ->appends('search', $request->search);

    }else{
      $trades = Trade::latest()->paginate(5);
    }

    $searchPhrase = $request->search;
    return view('trade.list-trade', compact('trades','searchPhrase'));
   }
}
