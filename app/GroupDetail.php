<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupDetail extends Model
{
    //
    public function group() {
    	return $this->belongsTo('App\Group');
    }
}
