<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\User;
use App\Chatroom;
use App\ChatroomParticipant;
use App\ChatroomType;
use App\Message;
use App\Group;
use App\GroupDetail;
use App\Profile;

class ChatroomController extends Controller
{
    // GET: get mesage summaries
    public function get_message_summaries($id) {
    	$result = array();

    	$chatrooms = ChatroomParticipant::where('user_id', $id)->get();

    	foreach($chatrooms as $chatroom) {
    		$chatroom_summary = $chatroom->chatroom()->first();
    		$temp = array();

    		$temp['id'] = $chatroom_summary->id;
	    	$temp['title'] = $chatroom_summary->identifiers;

	    	// last message in the chatroom
	    	$temp['subtitle'] = Message::where('chatroom_id', $chatroom_summary->id)->orderBy('created_at', 'desc')->first()->message;

	    	$temp['time'] = strtotime($chatroom_summary->created_at);
	    	$temp['MessageGroupType'] = ( (int)$chatroom_summary->chatroom_type_id ) - 1;

	    	// chatroom icon
	    	if($chatroom_summary->chatroom_type_id == 2) {	// team chatroom
	    		$temp['photoURL'] = Group::where('id', $chatroom_summary->group_id)->first()->image_url;
	    	}
	    	else {	// tenant vs owner, trade, request to join team
	    		$receiver_user_id = '';
	    		$participants = ChatroomParticipant::where('chatroom_id', $chatroom_summary->id)->get();
	    		foreach($participants as $participant) {
	    			if($participant->user_id != $id) {
	    				$receiver_user_id = $participant->user_id;
	    			}
	    		}
	    		$temp['photoURL'] = Profile::where('user_id', $receiver_user_id)->first()->icon_url;
	    	}

	    	array_push($result, $temp);
    	}

    	return $result;
    	
    }

    // GET: get all message from the requested chatroom
    public function get_message_detail($id, $message_id) {
    	$result = array();

    	$messages = Message::where('chatroom_id', $message_id)->orderBy('created_at')->get();

    	foreach($messages as $message) {
    		$temp = array();

    		$temp['message'] = $message->message;
	    	$temp['senderId'] = $message->sender;
	    	$temp['messageType'] = 1;
	    	$temp['time'] = strtotime($message->created_at);

	    	array_push($result, $temp);
    	}

    	return $result;
    }
}
