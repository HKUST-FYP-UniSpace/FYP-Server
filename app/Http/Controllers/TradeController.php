<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Trade;
use App\TradeStatus;


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
    		// $trade['trade_transaction_id'] = $stack->trade_transaction_id;
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
        $trade = Trade::where('id', $id)->first();

		return view('trade.view-trade',compact('trade'));
	}

    public function edit_trade_form($id) { // $id is user id
        $trade = Trade::where('id', $id)->first();
        $trade_statuses = TradeStatus::get();

        return view('trade.edit-trade', compact('trade','trade_statuses'));

    }

    public function add_trade_form() { // $id is user id
        $trade_statuses = TradeStatus::get();
        return view('trade.add-trade',compact('trade_statuses'));
    }


    public function update_trade($id, Request $request) {

        $this->validate($request, [
            'edit-trade-title' => 'required|max:255',
            'edit-trade-price' => 'required|max:255',
            'edit-trade-quantity' => 'required|max:255',
            // 'edit-trade-trade_transaction_id' => 'required|max:255',
            'edit-trade-trade_category_id' => 'required|max:255',
            'edit-trade-trade_condition_type_id' => 'required|max:255',
            'edit-trade-trade_status_id'  => 'required|max:255',
            'edit-trade-description' => 'nullable|max:255'
            ],

           [
            'edit-trade-title' => 'Input Title',
            'edit-trade-price' => 'Input Price',
            'edit-trade-quantity' => 'Input Quantity',
            // 'edit-trade-trade_transaction_id' => 'Input Trade Transaction ID',
            'edit-trade-trade_category_id' => 'Select Trade Category ID',
            'edit-trade-trade_condition_type_id' => 'Select Trade Condition Type ID',
            'edit-trade-trade_status_id'  => 'Select Trade Status ID',
            'edit-trade-description' => 'Input Description'
            ]);


        // get targeted data
        $trade = Trade::where('id', $id)->first();


        $trade->title = $request->input('edit-trade-title');
        $trade->price = $request->input('edit-trade-price');
        $trade->quantity = $request->input('edit-trade-quantity');
        // $trade->trade_transaction_id = $request->input('edit-trade-trade_transaction_id');
        $trade->trade_category_id = $request->input('edit-trade-trade_category_id');
        $trade->trade_condition_type_id = $request->input('edit-trade-trade_condition_type_id');
        $trade->trade_status_id= $request->input('edit-trade-trade_status_id');
        $trade->description = $request->input('edit-trade-description');

        $trade->save();


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
                // 'add-trade-post_date' => 'required',
                'add-trade-status' => 'required'
                // 'add-trade-trade_category_id' => 'required'
            ],
            [

                'add-trade-title.required' => 'Input trade title',
                'add-trade-title.max' => 'Title cannot be too long',

                'add-trade-price.required' => 'Input price',

                'add-trade-quantity.required' => 'Input price',
                'add-trade-quantity.integer' => 'Input integer only',

                'add-trade-description.required' => 'Input description',
                'add-trade-description.max' => 'Description cannot be too long',

                // 'add-trade-post_date.required' => 'Input Post Date in YYYY-MM-DD',

                'add-trade-status.required' => 'Select Status' //select from database

                // 'add-trade-trade_category_id' => 'Select Trade Category'
            ]
        );

        // form information filled by users
        $trade= new Trade();

        $trade->trade_category_id = "1";
        $trade->trade_condition_type_id = "1";
        $trade->is_deleted = "1";


        // title
        $trade->title = $request->input('add-trade-title');
        // trade_category_id
        // $trade->trade_category_id = intval($request->input('add-trade-trade_category_id'));
        // description
        $trade->description = $request->input('add-trade-description');
        // quantity
        $trade->quantity = $request->input('add-trade-quantity');
        // price
        $trade->price = $request->input('add-trade-price');
        // // quantity
        // $trade->post_date = $request->input('add-trade-post_date');
        // status
        $trade->trade_status_id = intval($request->input('add-trade-status'));

        // save in database
        $trade->save();

        // redirect to add success page
        return view('trade.add-trade-success', ['id'=> $trade->id]);
    }



}
