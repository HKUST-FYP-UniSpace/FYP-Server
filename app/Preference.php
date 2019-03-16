<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    //
    public function group() {
    	return $this->belongsTo('App\Group');
    }

    public function preference_item() {
    	return $this->belongsTo('App\PreferenceItem', 'item_id');
    }
}
