<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class TradeController extends Controller
{
    //
     public function show_trade() {

     	 

        return view('trade.list-trade');
    	
    }

    public function view_trade_detail(){
    	return view('trade.view-trade');
    }
}
