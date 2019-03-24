<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    //
    public function user() {
    	returh $this->belongsTo('App\User');
    }
}
