<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HouseImage extends Model
{
    //
    public function house() {
    	return $this->belongsTo('App\House');
    }
}
