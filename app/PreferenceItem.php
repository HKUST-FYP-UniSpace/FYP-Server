<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PreferenceItem extends Model
{
    //
    public function category() {
    	return $this->belongsTo('App\PreferenceItemCategory');
    }
}
