<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Trade;
use App\TradeCategory;
use App\TradeConditionType;
use App\TradeImage;
use App\TradeStatus;
use App\TradeTransaction;

use Validator;
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


    // Trade category related functions
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


    // Trade transaction related functions
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


//-------------------------------------------------------------------------------------------------------


    // Basic Trade functions
    // public function create_trade(){
    //
    // }
    //
    //
    // public function edit_trade(){
    //
    // }


    public function show_trade($id){
      $trade = Trade::where("id", $id)->first();

      if($trade == null){
        return "Trade with respective ID numebr does not exist";
      }

      $result_all = array();
      $result_all['status'] = 0;
      $result = array();
      //$result['errors'] = array();

      $result_trade = array();
      $result_trade['title'] = $trade->title;
      $result_trade['price'] = $trade->price;
      $result_trade['description'] = $trade->description;
      $result_trade['quantity'] = $trade->quantity;
      $result_trade['post_date'] = $trade->post_date;
      $result_trade['status'] = $trade->status;
      $result_trade['trade_transaction_id'] = $trade->trade_transaction_id;
      $result_trade['trade_category_id'] = $trade->trade_category_id;
      $result_trade['trade_condition_type_id'] = $trade->trade_condition_type_id;
      $result_trade['trade_status_id'] = $trade->trade_status_id;
      $result_trade['is_deleted'] = $trade->is_deleted;
      $result_trade['created_at'] = $trade->created_at;
      $result_trade['updated_at'] = $trade->updated_at;

      $result['trade'] = $result_trade;
      //$result['errors'] = $errors;
      $result_all['result'] = $result;
      $result_all['status'] = '1';

      return $result_all;
    }


    public function index_trade(){
      $result_all = array();
      $result_all['status'] = 0;
      $result = array();
      //$errors = array();

      $result_trades = array();
      $trades = Trade::get();
      foreach ($trades as $trade) {
        $result_trade = array();
        $result_trade['id'] = $trade->id;
        $result_trade['title'] = $trade->title;
        $result_trade['price'] = $trade->price;
        $result_trade['description'] = $trade->description;
        $result_trade['quantity'] = $trade->quantity;
        $result_trade['post_date'] = $trade->post_date;
        $result_trade['status'] = $trade->status;
        $result_trade['trade_transaction_id'] = $trade->trade_transaction_id;
        $result_trade['trade_category_id'] = $trade->trade_category_id;
        $result_trade['trade_condition_type_id'] = $trade->trade_condition_type_id;
        $result_trade['trade_status_id'] = $trade->trade_status_id;
        $result_trade['is_deleted'] = $trade->is_deleted;
        $result_trade['created_at'] = $trade->created_at;
        $result_trade['updated_at'] = $trade->updated_at;
        array_push($result_trades, $result_trade);
      }

      $result['trades'] = $result_trades;
      //$result['errors'] = $errors;
      $result_all['result'] = $result;
      $result_all['status'] = '1';

      return $result_all;
    }


    public function store_trade(Request $request){
      $trade = new Trade();

      $trade->title = $request->input('title');
      $trade->price = $request->input('price');
      $trade->description = $request->input('description');
      $trade->quantity = $request->input('quantity');
      $trade->post_date = $request->input('post_date');
      $trade->status = $request->input('status');
      $trade->trade_transaction_id = $request->input('trade_transaction_id');
      $trade->trade_category_id = $request->input('trade_category_id');
      $trade->trade_condition_type_id = $request->input('trade_condition_type_id');
      $trade->trade_status_id = $request->input('trade_status_id');
      $trade->is_deleted = $request->input('is_deleted');

      $trade->save();

      $success_msg = "New trade stored Successfully! (House ID = {$trade->id})";
      return $success_msg;
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


    public function update_trade($id, Request $request){
      $trade = Trade::where("id", $id)->first();

      if($trade == null){
        return "Trade with respective ID number does not exist";
      }

      $trade->title = ($request->input('title')==null ? "" : $request->input('title'));
      $trade->price = (double)($request->input('price')==null ? "" : $request->input('price'));
      $trade->description = ($request->input('description')==null ? "" : $request->input('description'));
      $trade->quantity = (int)($request->input('quantity')==null ? "" : $request->input('quantity'));
      $trade->post_date = ($request->input('post_date')==null ? "" : $request->input('post_date')); //date
      $trade->status = (int)($request->input('status')==null ? "" : $request->input('status'));
      $trade->trade_transaction_id = (int)($request->input('trade_transaction_id')==null ? "" : $request->input('trade_transaction_id'));
      $trade->trade_category_id = (int)($request->input('trade_category_id')==null ? "" : $request->input('trade_category_id'));
      $trade->trade_condition_type_id = (int)($request->input('trade_condition_type_id')==null ? "" : $request->input('trade_condition_type_id'));
      $trade->trade_status_id = (int)($request->input('trade_status_id')==null ? "" : $request->input('trade_status_id'));
      $trade->is_deleted = (int)($request->input('is_deleted')==null ? "" : $request->input('is_deleted'));

      $trade->save();

      $success_msg = "Trade Updated Successfully (ID = {$id})";
      return $success_msg;
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


}
