<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Trade;
use App\TradeBookmark;
use App\TradeCategory;
use App\TradeConditionType;
use App\TradeImage;
use App\TradeStatus;
use App\TradeTransaction;
use App\TradeVisitor;

use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Arr;

class TradeController extends Controller
{
    //define helper functions
    // private function store_trade_image(){
    //
    // }
    //
    // private function update_trade_image(){
    //
    // }
    //
    // private function show_trade_image(){
    //
    // }
    //
    // private function delete_trade_image(){
    //
    // }


//-----------------------------------------------------------------------------------------------------
//------------------------------- Trade category related functions ------------------------------------
//-----------------------------------------------------------------------------------------------------

    public function store_trade_category(Request $request){
      $trade_cat = new TradeCategory();

      $trade_cat->category = $request->input('category');

      $trade_cat->save();

      $success_msg = "New trade category stored Successfully! (Category ID = {$trade_cat->id})";
      return $success_msg;
    }


    public function show_trade_category($id){
      $trade_cat = TradeCategory::where("id", $id)->first();

      if($trade_cat == null){
        return "Trade Category with respective ID numebr does not exist";
      }

      $result_all = array();
      $result_all['status'] = 0;
      $result = array();
      //$result['errors'] = array();

      $result_trade_cat = array();
      $result_trade_cat['category'] = $trade_cat->category;

      $result['trade_cat'] = $result_trade_cat;
      //$result['errors'] = $errors;
      $result_all['result'] = $result;
      $result_all['status'] = '1';

      return $result_all;
    }


    public function index_trade_category(){
      $result_all = array();
      $result_all['status'] = 0;
      $result = array();
      //$errors = array();

      $result_trade_cats = array();
      $trade_cats = TradeCategory::get();
      foreach ($trade_cats as $trade_cat) {
        $result_trade_cat = array();
        $result_trade_cat['id'] = $trade_cat->id;
        $result_trade_cat['category'] = $trade_cat->category;
        array_push($result_trade_cats, $result_trade_cat);
      }

      $result['trade_cats'] = $result_trade_cats;
      //$result['errors'] = $errors;
      $result_all['result'] = $result;
      $result_all['status'] = '1';

      return $result_all;
    }


    public function delete_trade_category($id){
      $trade_cat = TradeCategory::where('id', $id)->first();
      if($trade_cat == null){
        return "Trade Category with respective ID number does not exist.";
      }

      $trade_cat->delete();

      $success_msg = "Successfully deleted trade category with ID = {$id}";
      return $success_msg;
    }


//----------------------------------------------------------------------------------------------------------
//----------------------------- Trade transaction related functions ----------------------------------------
//----------------------------------------------------------------------------------------------------------

    public function store_trade_transaction(Request $request){
      $trade_txn = new TradeTransaction();

      $trade_txn->date = $request->input('date');
      $trade_txn->user_id = $request->input('user_id');

      $trade_txn->save();

      $success_msg = "New trade transaction stored Successfully! (Transaction ID = {$trade_txn->id})";
      return $success_msg;
    }


    public function show_trade_transaction($id){
      $trade_txn = TradeTransaction::where("id", $id)->first();

      if($trade_txn == null){
        return "Trade Transaction with respective ID numebr does not exist";
      }

      $result_all = array();
      $result_all['status'] = 0;
      $result = array();
      //$result['errors'] = array();

      $result_trade_txn = array();
      $result_trade_txn['date'] = $trade_txn->date;
      $result_trade_txn['user_id'] = $trade_txn->user_id;

      $result['trade_txn'] = $result_trade_txn;
      //$result['errors'] = $errors;
      $result_all['result'] = $result;
      $result_all['status'] = '1';

      return $result_all;
    }


    public function index_trade_transaction(){
      $result_all = array();
      $result_all['status'] = 0;
      $result = array();
      //$errors = array();

      $result_trade_txns = array();
      $trade_txns = TradeTransaction::get();
      foreach ($trade_txns as $trade_txn) {
        $result_trade_txn = array();
        $result_trade_txn['id'] = $trade_txn->id;
        $result_trade_txn['date'] = $trade_txn->date;
        $result_trade_txn['user_id'] = $trade_txn->user_id;
        array_push($result_trade_txns, $result_trade_txn);
      }

      $result['trade_txns'] = $result_trade_txns;
      //$result['errors'] = $errors;
      $result_all['result'] = $result;
      $result_all['status'] = '1';

      return $result_all;
    }


//----------------------------------------------------------------------------------------------------------
//------------------------------------- Basic Trade functions ----------------------------------------------
//----------------------------------------------------------------------------------------------------------

    // Get trade detail
    public function show_trade($userId, $id){
      $trade = Trade::where("id", $id)->first();
      //$userId = $request->input('userId');

      if($trade == null){
        return "Trade with respective ID numebr does not exist";
      }

      // $result_all = array();
      // $result_all['status'] = 0;
      // $result = array();
      //$result['errors'] = array();

      //$trade_img = TradeImage::where('trade_id', $id)->get();
      $trade_imgList = TradeImage::where('trade_id', $id);
      $trade_imgArray = array();
      if($trade_imgList->count()>0){
        $trade_imgs = $trade_imgList->get();
        foreach($trade_imgs as $trade_img){
          array_push($trade_imgArray, $trade_img->image_url);
        }
      }

      $result_trade = [
        'id' => $trade->id,
        'title' => $trade->title,
        'price' => $trade->price,
        'status' => self::convertTradeConditionIdtoStr($trade->trade_condition_type_id),
        'description' => $trade->description,
        'isBookmarked' => (TradeBookmark::where('trade_id', $id)->where('user_id', $userId)->count()>0)?true:false,
        'photoURLs' => $trade_imgArray,
        'district_id' => app('App\Http\Controllers\API\HouseController')->convertDistrictIdToEnum($trade->district_id),

        // Bonuse Information that may be needed
        'quantity' => $trade->quantity,
        'post_date' => $trade->post_date,
        'trade_transaction_id' => $trade->trade_transaction_id,
        'trade_category_id' => $trade->trade_category_id,
        'trade_condition_type_id' => $trade->trade_condition_type_id,
        'trade_status_id' => $trade->trade_status_id,
        'is_deleted' => $trade->is_deleted,
        'created_at' => $trade->created_at,
        'updated_at' => $trade->updated_at
      ];


      // $result['trade'] = $result_trade;
      // //$result['errors'] = $errors;
      // $result_all['result'] = $result;
      // $result_all['status'] = '1';

      self::count_visitor($userId, $id);

      //return $result_all;
      return $result_trade;
    }


    // Get Trade Selling Items
    //param: userId (ownerId)
    Public function show_sellingTrade($userId){
      $trades = Trade::where('user_id', $userId)->where('trade_status_id', 1)->get(); // status 1 for selling item

      $result_trades = array();
      foreach($trades as $trade){
        $trade_id = $trade->id;
        // $trade_img = (TradeImage::where('trade_id', $trade_id)->count()>0)?TradeImage::where('trade_id', $trade_id)->get():null;
        $trade_img = TradeImage::where('trade_id', $trade_id)->first();
        // $trade_imgList = TradeImage::where('trade_id', $trade_id);
        // $trade_imgArray = array();
        // if($trade_imgList->count()>0){
        //   $trade_imgs = $trade_imgList->get();
        //   foreach($trade_imgs as $trade_img){
        //     array_push($trade_imgArray, $trade_img->image_url);
        //   }
        // }

        $result_trade=[
          'id'=>$trade_id,
          'title'=>$trade->title,
          'price'=>$trade->price,
          'views'=>TradeVisitor::where('trade_item_id', $trade_id)->count(), //visitor counter to be added
          'photoURLs'=>$trade_img!=null?$trade_img->image_url:null
        ];
        array_push($result_trades, $result_trade);
      }
      return $result_trades;
    }

    // Get Trade List
    // Handling on search criteria is pending to be added
    // $userId is needed to check if items bookmarked
    // public function index_trade($userId, $title=null, $seller=null, $category=null, $itemCondition=null, $minPrice=null, $maxPrice){
    public function index_trade($userId, Request $request){
      // $result_all = array();
      // $result_all['status'] = 0;
      // $result = array();
      //$errors = array();

      $result_trades = array();
      // $trades = Trade::get();
      $trades = DB::table('trades');

      // filter
      $title = $request->input('title');
      $seller = $request->input('seller');
      $category = $request->input('category');
      $itemCondition = $request->input('itemCondition');
      $minPrice = $request->input('minPrice');
      $maxPrice = $request->input('maxPrice');

      if(isset($title)){
        // $trades = $trades->where('title', 'LIKE', "%{$title}%")->orWhere('description', 'LIKE', "%{$title}%");
        $trades = $trades->where(function ($query) use ($title){
          $query->where('title', 'LIKE', "%{$title}%")->orWhere('description', 'LIKE', "%{$title}%");
        });
      }
      if(isset($seller)){
        $trades = $trades->where('user_id', $seller);
      }
      if(isset($category)){
        $trades = $trades->whereIn('trade_category_id', $category);
      }
      if(isset($itemCondition)){
        $trades = $trades->whereIn('trade_condition_type', self::convertTradeConditionIdtoStr($itemCondition));
      }
      if(isset($minPrice)){
        $trades = $trades->where('price', '>=', $minPrice);
      }
      if(isset($maxPrice)){
        $trades = $trades->where('price', '<=', $maxPrice);
      }

      $trades= $trades->where('is_deleted', 0)->get(); // get data that are not deleted only

      foreach ($trades as $trade) {
        $trade_id = $trade->id;
        //$trade_img = TradeImage::where('trade_id', $trade_id)->get();

        $trade_imgList = TradeImage::where('trade_id', $trade_id);
        $trade_imgArray = array();
        if($trade_imgList->count()>0){
          $trade_imgs = $trade_imgList->get();
          foreach($trade_imgs as $trade_img){
            array_push($trade_imgArray, $trade_img->image_url);
          }
        }

        $result_trade = [
          'id' => $trade_id,
          'title' => $trade->title,
          'price' => $trade->price,
          'status' => self::convertTradeConditionIdtoStr($trade->trade_condition_type_id),
          'description' => $trade->description,
          'isBookmarked' => (TradeBookmark::where('trade_id', $trade_id)->where('user_id', $userId)->count()>0)?true:false,
          'photoURLs' => $trade_imgArray,
        ];
        // $result_trade = array();
        // $result_trade['id'] = $trade->id;
        // $result_trade['title'] = $trade->title;
        // $result_trade['price'] = $trade->price;
        // $result_trade['description'] = $trade->description;
        // $result_trade['quantity'] = $trade->quantity;
        // $result_trade['post_date'] = $trade->post_date;
        // $result_trade['status'] = $trade->status;
        // $result_trade['trade_transaction_id'] = $trade->trade_transaction_id;
        // $result_trade['trade_category_id'] = $trade->trade_category_id;
        // $result_trade['trade_condition_type_id'] = $trade->trade_condition_type_id;
        // $result_trade['trade_status_id'] = $trade->trade_status_id;
        // $result_trade['is_deleted'] = $trade->is_deleted;
        // $result_trade['created_at'] = $trade->created_at;
        // $result_trade['updated_at'] = $trade->updated_at;
        array_push($result_trades, $result_trade);
      }

      // $result['trades'] = $result_trades;
      // //$result['errors'] = $errors;
      // $result_all['result'] = $result;
      // $result_all['status'] = '1';

      //return $result_all;
      return $result_trades;
    }


    // Get Trade History
    // Show the list of items that are traded in/out by the user given the owner's user id
    public function index_tradeHistory($userId){
      $result_pastTrades = array();

      //Trade out
      $pastTradeOuts = Trade::where('user_id', $userId)->get();

      foreach($pastTradeOuts as $pastTradeOut){
        $trade_id = $pastTradeOut->id;

        $trade_imgList = TradeImage::where('trade_id', $trade_id);
        $trade_imgArray = array();
        if($trade_imgList->count()>0){
          $trade_imgs = $trade_imgList->get();
          foreach($trade_imgs as $trade_img){
            array_push($trade_imgArray, $trade_img->image_url);
          }
        }

        $result_pastTrade = [
          'transactionType'=>'out',
          'id' => $trade_id,
          'title'=> $pastTradeOut->title,
          'price' => $pastTradeOut->price,
          'views' => TradeVisitor::where('trade_item_id', $trade_id)->count(), //extra
          'status'=> self::convertTradeConditionIdtoStr($pastTradeOut->trade_condition_type_id),
          'description'=> $pastTradeOut->description,
          'photoURLs' => $trade_imgArray
        ];

        array_push($result_pastTrades, $result_pastTrade);
      }

      //Trade in
      $pastTransactionIn = TradeTransaction::where('user_id', $userId)->get();
      foreach($pastTransactionIn as $pastTransaction){
        $pastTradeIn = Trade::where('id',$pastTransaction->trade_id)->first();
        $trade_id = $pastTradeIn->id;

        $trade_imgList = TradeImage::where('trade_id', $trade_id);
        $trade_imgArray = array();
        if($trade_imgList->count()>0){
          $trade_imgs = $trade_imgList->get();
          foreach($trade_imgs as $trade_img){
            array_push($trade_imgArray, $trade_img->image_url);
          }
        }

        $result_pastTrade = [
          'TransactionType'=>'in',
          'id' => $trade_id,
          'title'=> $pastTradeIn->title,
          'price' => $pastTradeIn->price,
          'views' => TradeVisitor::where('trade_item_id', $trade_id)->count(), //extra
          'status'=> self::convertTradeConditionIdtoStr($pastTradeIn->trade_condition_type_id),
          'description'=> $pastTradeIn->description,
          'photoURLs' => $trade_imgArray
        ];

        array_push($result_pastTrades, $result_pastTrade);
      }


      return $result_pastTrades;
    }

    // Get Trade Featured
    public function index_tradeFeatured($userId){
      $required_num = 10;// default as 10
      $popularity_score = array();
      // get all common house_id in tradeBookmark table
      // then distribute score by the number of records they have (Default 10 points per each record)
      $popular_trade_byBookmarkCount = TradeBookmark::select('trade_id')->groupBy('trade_id')->get();
      foreach ($popular_trade_byBookmarkCount as $popular_tradeId) {
        $temp_tradeId = $popular_tradeId->trade_id;
        if(Arr::exists($popularity_score, $temp_tradeId)){
          $popularity_score[$temp_tradeId] += TradeBookmark::where('trade_id', $temp_tradeId)->count() * 10;
        }else{
          $popularity_score[$temp_tradeId] = TradeBookmark::where('trade_id', $temp_tradeId)->count() * 10;
        }
      }

      // get all trade_item_id in TradeVisitor table
      // then distribute score by the number of records they have (Default 2 points per each record)
      $popular_trade_byVisitCount = TradeVisitor::select('trade_item_id')->groupBy('trade_item_id')->get();
      foreach ($popular_trade_byVisitCount as $popular_tradeId) {
        $temp_tradeId = $popular_tradeId->trade_item_id;
        if(Arr::exists($popularity_score, $temp_tradeId)){
          $popularity_score[$temp_tradeId] += TradeVisitor::where('trade_item_id', $temp_tradeId)->count() * 2;
        }else{
          $popularity_score[$temp_tradeId] = TradeVisitor::where('trade_item_id', $temp_tradeId)->count() * 2;
        }
      }

      // return $popularity_score;
      arsort($popularity_score);
      // dd($popularity_score);
      $result = array_slice($popularity_score, 0, $required_num, $preserve_keys = TRUE);

      $trades = Trade::whereIn('id', array_keys($result))->where('is_deleted', 0)->get();
      $result_trade = array();
      foreach($trades as $trade){
        $trade_id = $trade->id;

        $trade_imgList = TradeImage::where('trade_id', $trade_id);
        $trade_imgArray = array();
        if($trade_imgList->count()>0){
          $trade_imgs = $trade_imgList->get();
          foreach($trade_imgs as $trade_img){
            array_push($trade_imgArray, $trade_img->image_url);
          }
        }

        $result_pastTrade = [
          'id' => $trade_id,
          'title'=> $trade->title,
          'price' => $trade->price,
          //'views' => TradeVisitor::where('trade_item_id', $trade_id)->count(), //extra
          'status'=> self::convertTradeConditionIdtoStr($trade->trade_condition_type_id),
          'description'=> $trade->description,
          'isBookmarked'=> (TradeBookmark::where('trade_id', $trade_id)->where('user_id', $userId)->count()>0)?true:false,
          'photoURLs' => $trade_imgArray
        ];

        array_push($result_trade, $result_pastTrade);
      }
      return $result_trade;
    }


    // Get Trade Saved
    // Retrieve list of bookedmarked Trade given the userId
    public function index_bookmarkedTrade($userId){
      $result_bookmarkedTrades = array();
      $bookmarkedTrades = TradeBookmark::where('user_id', $userId)->get();

      foreach ($bookmarkedTrades as $bookmarkedTrade) {
        $trade = Trade::where('id', $bookmarkedTrade->trade_id)->where('is_deleted', 0)->first();
        if($trade != null){
          $trade_id = $trade->id;

          $trade_imgList = TradeImage::where('trade_id', $trade_id);
          $trade_imgArray = array();
          if($trade_imgList->count()>0){
            $trade_imgs = $trade_imgList->get();
            foreach($trade_imgs as $trade_img){
              array_push($trade_imgArray, $trade_img->image_url);
            }
          }

          $result_bookmarkedTrade = [
            'id' => $trade_id,
            'title' => $trade->title,
            'price' => $trade->price,
            'status' => self::convertTradeConditionIdtoStr($trade->trade_condition_type_id),
            'description' => $trade->description,
            'photoURLs' => $trade_imgArray
          ];

          array_push($result_bookmarkedTrades, $result_bookmarkedTrade);
        }
      }

      return $result_bookmarkedTrades;
    }


    // Create Trade Item
    public function store_trade(Request $request){
      $trade = new Trade();

      $trade->title = $request->input('title');
      $trade->price = $request->input('price');
      $trade->description = $request->input('description');
      $trade->quantity = $request->input('quantity');
      //$trade->post_date = $request->input('post_date'); //obsolete
      //$trade->status = $request->input('status'); //obsolete
      //$trade->trade_transaction_id = 0; //should be null by default (no transaction has been done) //obsolete
      $trade->trade_category_id = $request->input('trade_category_id');
      $trade->trade_condition_type_id = $request->input('trade_condition_type_id');
      $trade->trade_status_id = 1; //'Reveal' when first create
      $trade->is_deleted = 0; //not 'Deleted' by default
      $trade->user_id = $request->input('userId');
      $trade->district_id = app('App\Http\Controllers\API\HouseController')->convertDistrictEnumToId($request->input('district_id')); // updated in server

      $trade->save();

      // $success_msg = "New trade stored Successfully! (House ID = {$trade->id})";
      // return $success_msg;
      $response = ['isSuccess' => true];
      return $response;
    }


    public function delete_trade($id){
      $trade = Trade::where('id', $id)->first();
      if($trade == null){
        return "Trade with respective ID number does not exist.";
      }

      $trade->delete();

      $success_msg = "Successfully deleted trade with ID = {$id}";
      return $success_msg;
    }


    // Edit Trade Item
    public function update_trade($userId, $tradeId, Request $request){
      $trade = Trade::where("id", $tradeId)->where("user_id", $userId)->first();

      if($trade == null){
        return "Trade with respective ID number does not exist";
      }

      $trade->title = ($request->input('title')==null ? "" : $request->input('title'));
      $trade->price = (double)($request->input('price')==null ? "" : $request->input('price'));
      $trade->description = ($request->input('description')==null ? "" : $request->input('description'));
      $trade->quantity = (int)($request->input('quantity')==null ? "" : $request->input('quantity'));
      //$trade->post_date = ($request->input('post_date')==null ? "" : $request->input('post_date')); //obselete
      $trade->trade_category_id = (int)($request->input('trade_category_id')==null ? "" : $request->input('trade_category_id'));
      $trade->trade_condition_type_id = (int)($request->input('status')==null ? "" : $request->input('status'));
      //$trade->trade_status_id = (int)($request->input('status')==null ? "" : $request->input('status'));
      //$trade->is_deleted = (int)($request->input('is_deleted')==null ? "" : $request->input('is_deleted'));

      $trade->save();

      // Update isBookmarked
      if($request->input('isBookmarked')!=null){
        $user_id = $request->input('userId');
        $bookmarkNum = TradeBookmark::where('trade_id', $tradeId)->where('user_id', $user_id)->count();

        if($request->input('isBookmarked') == true && $bookmarkNum==0){
          $newBookmark = new TradeBookmark();

          $newBookmark->trade_id = $tradeId;
          $newBookmark->user_id = $user_id;

          $newBookmark->save();
        }elseif($request->input('isBookmarked') == false && $bookmarkNum>0) {
          $bookmark->delete();
        }

      }

      // Update photoURL (photo upload API should be calld separately)
      $img_urls = $request->input('photoURLs');
      if($img_urls != "NULL"){
        TradeImage::where('trade_id', $tradeId)->delete();

        if(!empty($img_urls)){
          foreach($img_urls as $img_url){
            $trade_img = new TradeImage();
            $trade_img->image_url = $img_url;
            $trade_img->trade_id =$tradeId;
            $trade_img->save();
          }
        }

      }

      // $success_msg = "Trade Updated Successfully (ID = {$tradeId})";
      // return $success_msg;
      $response = ['isSuccess' => true];
      return $response;
    }


    public function archive_trade($id){
      $trade = Trade::where('id', $id)->first();

      if($trade == null){
        return "Trade with respective ID numebr does not exist";
      }

      $trade->status = 2; // currently set "2" as "archive" status
      $trade->save();

      $success_msg = "Trade archived Successfully (House ID = {$id})";
      return $success_msg;
    }


    public function hide_trade($id){
      $trade = Trade::where('id', $id)->first();

      if($trade == null){
        return "Trade with respective ID numebr does not exist";
      }

      $trade->status = 0; // currently set "0" as "hide" status
      $trade->save();

      $success_msg = "Trade hidden Successfully (House ID = {$id})";
      return $success_msg;
    }


    public function reveal_trade($id){
      $trade = Trade::where('id', $id)->first();

      if($trade == null){
        return "Trade with respective ID numebr does not exist";
      }

      $trade->status = 1; // currently set "1" as "reveal" status
      $trade->save();

      $success_msg = "Trade revealed Successfully (House ID = {$id})";
      return $success_msg;
    }


    // Create Trade Item:[Image]
    public function upload_tradeItemPhoto(Request $request){
      // dd($request);
      $trade_id = $request->input('tradeId');
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

          // Save url in db
          $trade_image = new TradeImage();
          // $tradeImage->img_url = $images[$i];
          $trade_image->image_url = url('uploads/'.$url);
          $trade_image->trade_id = $trade_id;
          $trade_image->save();

          $temp++;
        }
        $response = ['isSuccess' => true, 'counter' => $temp];

      }
      else{
        $response = ['isSuccess' => false];
      }

      return $response;
    }


    // Get Trade Data
    public function get_tradeData($userId, $tradeId, $chartFilterOptions){
      $targetViews = array();
      $otherViews = array();
      $targetBookmarks = array();
      $otherBookmarks = array();

      if($chartFilterOptions == 0){ // Week
        for($i = 8, $order = 1; $i > 0; $i--){
          $day_before = Carbon::now()->subDays($i)->toDateTimeString();;
          $day_before_end = Carbon::now()->subDays($i-1)->toDateTimeString();

          // $viewFirst = TradeVisitor::where('trade_id', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$day_before, $day_before_end])->get();
          // $viewCount = $viewFirst->count();
          $viewCount = TradeVisitor::where('trade_item_id', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$day_before, $day_before_end])->count();
          $targetView = ['order' => $order,
                          'time' => $day_before,
                          'x' => $order,
                          'y' => $viewCount
                        ];
          array_push($targetViews, $targetView);

          $notViewAtDate = TradeVisitor::where('trade_item_id', '!=', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$day_before, $day_before_end]);
          $notViewCount = $notViewAtDate->count();
          $viewTradeNum =  $notViewAtDate->select('trade_item_id')->groupBy('trade_item_id')->count();
          $otherView = ['order' => $order,
                          'time' => $day_before,
                          'x' => $order,
                          'y' => $viewTradeNum==0 ? 0 : $notViewCount/$viewTradeNum
                        ];
          array_push($otherViews, $otherView);

          $bookmarkCount = TradeBookmark::where('trade_id', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$day_before, $day_before_end])->count();
          $targetBookmark = ['order' => $order,
                              'time' => $day_before,
                              'x' => $order,
                              'y' => $bookmarkCount
                            ];
          array_push($targetBookmarks, $targetBookmark);

          $notBookmarkAtDate = TradeBookmark::where('trade_id', '!=', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$day_before, $day_before_end]);
          $notBookmarkCount = $notBookmarkAtDate->count();
          $bookmarkTradeNum =  $notBookmarkAtDate->select('trade_id')->groupBy('trade_id')->count();
          $otherBookmark = ['order' => $order,
                            'time' => $day_before,
                            'x' => $order,
                            'y' => $bookmarkTradeNum==0 ? 0 : $notBookmarkCount/$bookmarkTradeNum
                            ];
          array_push($otherBookmarks, $otherBookmark);

          $order++;
        }
      }else if($chartFilterOptions == 1){ // Month
        for($i = 31, $order = 1; $i > 0; $i--){
          // $day_before = date( 'Y-m-d h:i:s', strtotime( $date . ' -'.$i. ' day' ) );
          $day_before = Carbon::now()->subDays($i)->toDateTimeString();;
          $day_before_end = Carbon::now()->subDays($i-1)->toDateTimeString();
          // $day_before = date( 'Y-m-d', strtotime( $date . ' -'.$i. ' day' ) );
  // $viewCount = $views->whereDate('created_at', '=', date('2019-04-04'))->count();
  // dd($viewCount);
          $viewCount = TradeVisitor::where('trade_item_id', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$day_before, $day_before_end])->count();
          $targetView = ['order' => $order,
                          'time' => $day_before,
                          'x' => $order,
                          'y' => $viewCount
                        ];
          array_push($targetViews, $targetView);

          $notViewAtDate = TradeVisitor::where('trade_item_id', '!=', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$day_before, $day_before_end]);
          $notViewCount = $notViewAtDate->count();
          $viewTradeNum =  $notViewAtDate->select('trade_item_id')->groupBy('trade_item_id')->count();
          $otherView = ['order' => $order,
                          'time' => $day_before,
                          'x' => $order,
                          'y' => $viewTradeNum==0 ? 0 : $notViewCount/$viewTradeNum
                        ];
          array_push($otherViews, $otherView);

          $bookmarkCount = TradeBookmark::where('trade_id', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$day_before, $day_before_end])->count();
          $targetBookmark = ['order' => $order,
                              'time' => $day_before,
                              'x' => $order,
                              'y' => $bookmarkCount
                            ];
          array_push($targetBookmarks, $targetBookmark);

          $notBookmarkAtDate = TradeBookmark::where('trade_id', '!=', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$day_before, $day_before_end]);
          $notBookmarkCount = $notBookmarkAtDate->count();
          $bookmarkTradeNum =  $notBookmarkAtDate->select('trade_id')->groupBy('trade_id')->count();
          $otherBookmark = ['order' => $order,
                            'time' => $day_before,
                            'x' => $order,
                            'y' => $bookmarkTradeNum==0 ? 0 : $notBookmarkCount/$bookmarkTradeNum
                            ];
          array_push($otherBookmarks, $otherBookmark);

          $order++;
        }
      }else if ($chartFilterOptions == 2){ // Year
        for($i = 13, $order = 1; $i > 0; $i--){
          // $month_before = date( 'Y-m-d h:i:s', strtotime( $date . ' -'.$i. ' month' ) );
          // $month_before_end = date( 'Y-m-d h:i:s', strtotime( $month_before . ' +1 month' ) );
          $month_before = Carbon::now()->subMonth($i)->toDateTimeString();;
          $month_before_end = Carbon::now()->subMonth($i-1)->toDateTimeString();

          $viewCount = TradeVisitor::where('trade_item_id', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$month_before, $month_before_end])->count();
          $targetView = ['order' => $order,
                          'time' => $month_before,
                          'x' => $order,
                          'y' => $viewCount
                        ];
          array_push($targetViews, $targetView);

          $notViewAtDate = TradeVisitor::where('trade_item_id', '!=', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$month_before, $month_before_end]);
          $notViewCount = $notViewAtDate->count();
          $viewTradeNum =  $notViewAtDate->select('trade_item_id')->groupBy('trade_item_id')->count();
          $otherView = ['order' => $order,
                          'time' => $month_before,
                          'x' => $order,
                          'y' => $viewTradeNum==0 ? 0 : $notViewCount/$viewTradeNum
                        ];
          array_push($otherViews, $otherView);

          $bookmarkCount = TradeBookmark::where('trade_id', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$month_before, $month_before_end])->count();
          $targetBookmark = ['order' => $order,
                              'time' => $month_before,
                              'x' => $order,
                              'y' => $bookmarkCount
                            ];
          array_push($targetBookmarks, $targetBookmark);

          $notBookmarkAtDate = TradeBookmark::where('trade_id', '!=', $tradeId)->whereBetween(DB::raw('date(created_at)'), [$month_before, $month_before_end]);
          $notBookmarkCount = $notBookmarkAtDate->count();
          $bookmarkTradeNum =  $notBookmarkAtDate->select('trade_id')->groupBy('trade_id')->count();
          $otherBookmark = ['order' => $order,
                            'time' => $month_before,
                            'x' => $order,
                            'y' => $bookmarkTradeNum==0 ? 0 : $notBookmarkCount/$bookmarkTradeNum
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
//-----------------------------helper function --------------------------------


    // helper function
    public function count_visitor($userId, $tradeId){
      $visitor_count = new TradeVisitor();

      //Should only accept a duplicated visit request made by the same user only after an hour maybe?

      $visitor_count->user_id = $userId;
      $visitor_count->trade_item_id = $tradeId;

      $visitor_count->save();
    }


    // heper function
    public function convertTradeConditionIdtoStr($statusId){
      switch($statusId){
        case 1:
          return 'Perfect';
          break;

        case 2:
          return 'Almost Perfect';
          break;

        case 3:
          return 'Okay';
          break;

        default:
          return 'Worn';
          break;
      }
    }




}
