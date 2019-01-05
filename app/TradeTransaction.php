<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TradeTransaction extends Model
{
    //
    public function trade_item() {
    	return $this->belongsTo('App\Trade');
    }

    public function user() {
    	return $this->belongsTo('App\User');
    }
}
