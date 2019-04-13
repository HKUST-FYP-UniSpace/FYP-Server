<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChatroomParticipant extends Model
{
    public function chatroom() {
    	return $this->belongsTo('App\Chatroom');
    }
}
