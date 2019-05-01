<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class House extends Model
{
    //
    public function owner() {
    	return $this->belongsTo('App\Owner');
    }
    public function image() {
    	return $this->hasMany('App\HouseImage');
    }
    public function detail() {
    	return $this->hasMany('App\HouseDetail');
    }
}
