<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chatroom extends Model
{
    public function chatroom_participant() {
    	return $this->hasMany('App\ChatroomParticipant');
    }
}
