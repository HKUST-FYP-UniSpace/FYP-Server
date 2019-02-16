<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    //
    public function participant() {
    	return $this->hansMany('App\GroupDetail');
    }
}
