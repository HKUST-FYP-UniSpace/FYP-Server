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
use Carbon\Carbon;

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

      $trade_img = TradeImage::where('trade_id', $id)->get();
      $result_trade = [
        'id' => $id,
        'title' => $trade->title,
        'price' => $trade->price,
        'status' => self::convertTradeConditionIdtoStr($trade->trade_condition_type_id),
        'description' => $trade->description,
        'isBookmarked' => (TradeBookmark::where('trade_id', $id)->where('user_id', $userId)->count()>0)?true:false,
        'photoURL' => ($trade_img->count()!=0)?$trade_img->image_url:null,

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
        $trade_img = TradeImage::where('trade_id', $trade_id)->get();

        $result_trade=[
          'id'=>$trade_id,
          'title'=>$trade->title,
          'price'=>$trade->price,
          'views'=>TradeVisitor::where('trade_item_id', $trade_id)->count(), //visitor counter to be added
          'photoURL'=>$trade_img
        ];
        array_push($result_trades, $result_trade);
      }
      return $result_trades;
    }

    // Get Trade List
    // Handling on search criteria is pending to be added
    // $userId is needed to check if items bookmarked
    public function index_trade($userId){
      // $result_all = array();
      // $result_all['status'] = 0;
      // $result = array();
      //$errors = array();

      $result_trades = array();
      $trades = Trade::get();
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
          'photoURL' => $trade_imgArray,
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

        $result_pastTrade = [
          'transactionType'=>'out',
          'id' => $trade_id,
          'title'=> $pastTradeOut->title,
          'price' => $pastTradeOut->price,
          'views' => TradeVisitor::where('trade_item_id', $trade_id)->count(), //extra
          'status'=> self::convertTradeConditionIdtoStr($pastTradeOut->trade_condition_type_id),
          'description'=> $pastTradeOut->description,
          'photoURL' => TradeImage::where('trade_id', $trade_id)->get()
        ];

        array_push($result_pastTrades, $result_pastTrade);
      }

      //Trade in
      $pastTransactionIn = TradeTransaction::where('user_id', $userId)->get();
      foreach($pastTransactionIn as $pastTransaction){
        $pastTradeIn = Trade::where('id',$pastTransaction->trade_id)->first();
        $trade_id = $pastTradeIn->id;

        $result_pastTrade = [
          'TransactionType'=>'in',
          'id' => $trade_id,
          'title'=> $pastTradeIn->title,
          'price' => $pastTradeIn->price,
          'views' => TradeVisitor::where('trade_item_id', $trade_id)->count(), //extra
          'status'=> self::convertTradeConditionIdtoStr($pastTradeIn->trade_condition_type_id),
          'description'=> $pastTradeIn->description,
          'photoURL' => TradeImage::where('trade_id', $trade_id)->get()
        ];

        array_push($result_pastTrades, $result_pastTrade);
      }


      return $result_pastTrades;
    }


    // Get Trade Saved
    // Retrieve list of bookedmarked Trade given the userId
    public function index_bookmarkedTrade($userId){
      $result_bookmarkedTrades = array();
      $bookmarkedTrades = TradeBookmark::where('user_id', $userId)->get();

      foreach ($bookmarkedTrades as $bookmarkedTrade) {
        $trade = Trade::where('id', $bookmarkedTrade->trade_id)->first();
        $trade_id = $trade->id;

        $result_bookmarkedTrade = [
          'id' => $trade_id,
          'title' => $trade->title,
          'price' => $trade->price,
          'status' => self::convertTradeConditionIdtoStr($trade->trade_condition_type_id),
          'description' => $trade->description,
          'photoURL' => TradeImage::where('trade_id', $trade_id)->get()
        ];

        array_push($result_bookmarkedTrades, $result_bookmarkedTrade);
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
    public function update_trade($id, Request $request){
      $trade = Trade::where("id", $id)->first();

      if($trade == null){
        return "Trade with respective ID number does not exist";
      }

      $trade->title = ($request->input('title')==null ? "" : $request->input('title'));
      $trade->price = (double)($request->input('price')==null ? "" : $request->input('price'));
      $trade->description = ($request->input('description')==null ? "" : $request->input('description'));
      $trade->quantity = (int)($request->input('quantity')==null ? "" : $request->input('quantity'));
      //$trade->post_date = ($request->input('post_date')==null ? "" : $request->input('post_date')); //obselete
      //$trade->status = (int)($request->input('status')==null ? "" : $request->input('status')); //obselete
      //$trade->trade_transaction_id = (int)($request->input('trade_transaction_id')==null ? "" : $request->input('trade_transaction_id'));
      $trade->trade_category_id = (int)($request->input('trade_category_id')==null ? "" : $request->input('trade_category_id'));
      $trade->trade_condition_type_id = (int)($request->input('trade_condition_type_id')==null ? "" : $request->input('trade_condition_type_id'));
      $trade->trade_status_id = (int)($request->input('status')==null ? "" : $request->input('status'));
      //$trade->is_deleted = (int)($request->input('is_deleted')==null ? "" : $request->input('is_deleted'));

      $trade->save();

      // Update isBookmarked
      if($request->input('isBookmarked')!=null){
        $user_id = $request->input('userId');
        $bookmarkNum = TradeBookmark::where('trade_id', $id)->where('user_id', $user_id)->count();

        if($request->input('isBookmarked') == true && $bookmarkNum==0){
          $newBookmark = new TradeBookmark();

          $newBookmark->trade_id = $id;
          $newBookmark->user_id = $user_id;

          $newBookmark->save();
        }elseif($request->input('isBookmarked') == false && $bookmarkNum>0) {
          $bookmark->delete();
        }

      }

      // Update photoURL
      // To be added

      // $success_msg = "Trade Updated Successfully (ID = {$id})";
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
      $trade_id = $request->input('tradeId');

      if(!empty($request->file('photoURL'))) {
        $image = $request->file('photoURL');
        $extension = $image->getClientOriginalExtension();

        $now = strtotime(Carbon::now());
        $url = 'trade_' . $trade_id . '_' . $now . '.' . $extension;
        Storage::disk('public')->put($url,  File::get($image));


        $response = ['isSuccess' => true];

      }else{
        $response = ['isSuccess' => false];
      }

      return $response;
    }


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
