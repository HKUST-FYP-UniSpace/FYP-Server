<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProfileDetail extends Model
{
    //
    public function profile() {
    	return $this->belongsTo('App\Profile');
    }

    public function hobby_item() {
    	return $this->belongsTo('App\PreferenceItem', 'item_id');
    }
}
