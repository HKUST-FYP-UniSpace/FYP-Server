<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    //
    public function trade_image() {
    	return $this->hasMany('App\TradeImage');
    }

    public function trade_category() {
    	return $this->belongsTo('App\TradeCategory');
    }

    public function trade_condition_type() {
    	return $this->belongsTo('App\TradeConditionType');
    }

    public function trade_status() {
    	return $this->belongsTo('App\TradeStatus');
    }

    public function trade_transaction() {
    	return $this->hasMany('App\TradeTransaction');
    }
}
