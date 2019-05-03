<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;

use App\User;
use App\Chatroom;
use App\ChatroomParticipant;
use App\ChatroomType;
use App\Message;
use App\Group;
use App\GroupDetail;
use App\Profile;
use App\Trade;
use App\House;
use App\Admin;

class ChatroomController extends Controller
{
    // POST: get mesage summaries
    public function get_message_summaries($id, Request $request) {
    	$result = array();

    	$chatrooms = ChatroomParticipant::where('user_id', $id)->get();

    	foreach($chatrooms as $chatroom) {
    		$chatroom_summary = Chatroom::where('id', $chatroom->chatroom_id)->first();
    		$temp = array();

    		$temp['id'] = $chatroom_summary->id;
	    	$temp['title'] = $chatroom_summary->title;

	    	// last message in the chatroom
            if(Message::where('chatroom_id', $chatroom_summary->id)->orderBy('created_at', 'desc')->first() == null) {
                $temp['subtitle'] = '';
            }
            else {
               $temp['subtitle'] = Message::where('chatroom_id', $chatroom_summary->id)->orderBy('created_at', 'desc')->first()->message; 
            }
	    	

	    	$temp['time'] = strtotime($chatroom_summary->created_at);
	    	$temp['MessageGroupType'] = ( (int)$chatroom_summary->chatroom_type_id ) - 1;

	    	$counter = 0;
	    	$timestamp = date('Y-m-d H:i:s', $request[$chatroom_summary->id]);;
	    	$messages = Message::where('chatroom_id', $chatroom_summary->id)->get();
	    	foreach($messages as $message) {
	    		$message_createtime = $message->created_at->toDateTimeString();
	    		if($message_createtime > $timestamp) {
	    			$counter++;
	    		}
	    	}
	    	$temp['unreadMessageCount'] = $counter;

	    	// chatroom icon
	    	if($chatroom_summary->chatroom_type_id == 2) {	// team chatroom
	    		if(Group::where('id', $chatroom_summary->type_identifier)->first() == null) {
                    $temp['photoURL'] = '';
                }
                else {
                    $temp['photoURL'] = Group::where('id', $chatroom_summary->type_identifier)->first()->image_url;
                }
	    	}
	    	else {	// tenant vs owner, trade, request to join team
	    		$receiver_user_id = '';
	    		$participants = ChatroomParticipant::where('chatroom_id', $chatroom_summary->id)->get();
	    		foreach($participants as $participant) {
	    			if($participant->user_id != $id) {
	    				$receiver_user_id = $participant->user_id;
	    			}
	    		}
                if(Profile::where('user_id', $receiver_user_id)->first() == null) {
                    $temp['photoURL'] = '';
                }
                else {
                    $temp['photoURL'] = Profile::where('user_id', $receiver_user_id)->first()->icon_url;
                }
	    		
	    	}
	    	$temp['users'] = array();
	    	$temp_user = array();
	    	$participants = ChatroomParticipant::where('chatroom_id', $chatroom_summary->id)->get();
	    	foreach($participants as $participant) {
                if($participant->user_id == -1) {
                    $temp_user['id'] = $participant->user_id;
                    $temp_user['name'] = 'Admin';
                    $temp_user['username'] = 'admin';
                }
                else {
                    $temp_user['id'] = $participant->user_id;
                    $temp_user['name'] = User::where('id', $participant->user_id)->first()['name'];
                    $temp_user['username'] = User::where('id', $participant->user_id)->first()['username']; 
                }
	    		
	    		array_push($temp['users'], $temp_user);
	    	}
	    	if($chatroom_summary->chatroom_type_id == 2) {	// team
	    		$temp['teamId'] = $chatroom_summary->type_identifier;
                $temp['houseId'] = Group::where('id', $chatroom_summary->type_identifier)->first()->house_id;
	    	}
	    	if($chatroom_summary->chatroom_type_id == 3) {	//trade
	    		$temp['tradeId'] = $chatroom_summary->type_identifier;
	    	}

	    	array_push($result, $temp);
    	}

    	return $result;

    }

    // GET: get all message from the requested chatroom
    public function get_message_detail($id, $message_group_id) {
    	$result = array();

    	$messages = Message::where('chatroom_id', $message_group_id)->orderBy('created_at')->get();

    	foreach($messages as $message) {
    		$temp = array();

            $temp['id'] = $message->id;
    		$temp['message'] = $message->message;
	    	$temp['senderId'] = $message->sender;
	    	$temp['messageType'] = 1;
	    	$temp['time'] = strtotime($message->created_at);

	    	array_push($result, $temp);
    	}

    	return $result;
    }

    // POST: create chatroom: tenant (group leader) + owner
    // note: type = owner, type_identifier = team id
    public function create_chatroom_owner($id, Request $request) {
    	$errors = array();
        $error = array();

    	// check if the chatroom exists
    	$team_id = $request['teamId'];
    	$owner_type_chatrooms = Chatroom::where('chatroom_type_id', 1)->get();	// get all the chatrooms of type = owner
    	foreach($owner_type_chatrooms as $owner_type_chatroom) {
    		if($owner_type_chatroom->type_identifier == $team_id) {
    			$error['message'] = 'The owner chatroom of this team exists.';
    			$error['existChatroomId'] = $owner_type_chatroom->id;
    			array_push($errors, $error);
    		}
    	}
    	if(!empty($errors)) {
            return response()->json($errors, 403);
        }

    	// create a new chatroom
    	$chatroom = new Chatroom();
    	$chatroom->total_message = 1;	// first message will be sent in this API
    	$chatroom->title = User::where('id', $id)->first()->username . ' Team Request';	// title = leader username
    	$chatroom->chatroom_type_id = 1;	// type = owner
    	$chatroom->type_identifier = $request['teamId'];
    	$chatroom->save();

    	// add the leader & house owner into the chatroom_participants table
    	$chatroom_participant_leader = new ChatroomParticipant();
    	$chatroom_participant_leader->chatroom_id = $chatroom->id;
    	$chatroom_participant_leader->user_id = $id;
    	$chatroom_participant_leader->save();
    	$chatroom_participant_owner = new ChatroomParticipant();
    	$chatroom_participant_owner->chatroom_id = $chatroom->id;
    	$house_id = Group::where('id', $request['teamId'])->first()->house_id;
    	$chatroom_participant_owner->user_id = House::where('id', $house_id)->first()->owner_id;
    	$chatroom_participant_owner->save();

    	// send the message
    	$message = new Message();
    	$message->message = $request['message'];
    	$message->sender = $id;
    	$message->deleted = 0;
    	$message->chatroom_id = $chatroom->id;
    	$message->save();

    	$result['chatroomId'] = $chatroom->id;

    	return $result;
    }

    // POST: create chatroom: 2 users [trade]
    // note: type = owner, type_identifier = trade item id
    public function create_chatroom_trade($id, Request $request) {
    	$errors = array();
        $error = array();

    	// check if the chatroom exists
    	$trade_id = $request['tradeId'];
    	$trade_type_chatrooms = Chatroom::where('chatroom_type_id', 3)->get();	// get all the chatrooms of type = trade
    	foreach($trade_type_chatrooms as $trade_type_chatroom) {
    		if($trade_type_chatroom->type_identifier == $trade_id) {	// same trade item
    			$trade_type_chatroom_participants = $trade_type_chatroom->chatroom_participant()->get();
    			foreach($trade_type_chatroom_participants as $trade_type_chatroom_participant) {
    				if($trade_type_chatroom_participant->user_id == $id) {	// same buyer
						$error['message'] = 'The trade chatroom of this user exists.';
		    			$error['existChatroomId'] = $trade_type_chatroom->id;
		    			array_push($errors, $error);
    				}
    			}
    		}
    	}
    	if(!empty($errors)) {
            return response()->json($errors, 403);
        }

        // create a new chatroom
    	$chatroom = new Chatroom();
    	$chatroom->total_message = 1;	// first message will be sent in this API
    	$chatroom->title = Trade::where('id', $request['tradeId'])->first()->title;	// title = trade item name
    	$chatroom->chatroom_type_id = 3;	// type = trade
    	$chatroom->type_identifier = $request['tradeId'];
    	$chatroom->save();

    	// add the leader & house owner into the chatroom_participants table
    	$chatroom_participant_user = new ChatroomParticipant();
    	$chatroom_participant_user->chatroom_id = $chatroom->id;
    	$chatroom_participant_user->user_id = $id;
    	$chatroom_participant_user->save();
    	$chatroom_participant_owner = new ChatroomParticipant();
    	$chatroom_participant_owner->chatroom_id = $chatroom->id;
    	$chatroom_participant_owner->user_id = Trade::where('id', $request['tradeId'])->first()->user_id;
    	$chatroom_participant_owner->save();

    	// send the message
    	$message = new Message();
    	$message->message = $request['message'];
    	$message->sender = $id;
    	$message->deleted = 0;
    	$message->chatroom_id = $chatroom->id;
    	$message->save();

    	$result['chatroomId'] = $chatroom->id;

    	return $result;

    }

    // POST: create chatroom: user + admin
    // note: type = owner, type_identifier = user id
    public function create_chatroom_admin($id, Request $request) {
    	$errors = array();
        $error = array();

    	// check if the chatroom exists
    	$admin_type_chatrooms = Chatroom::where('chatroom_type_id', 5)->get();	// get all the chatrooms of type = admin
    	foreach($admin_type_chatrooms as $admin_type_chatroom) {
    		if($admin_type_chatroom->type_identifier == $id) {
    			$error['message'] = 'The admin chatroom of this user exists.';
    			$error['existChatroomId'] = $admin_type_chatroom->id;
    			array_push($errors, $error);
    		}
    	}
    	if(!empty($errors)) {
            return response()->json($errors, 403);
        }

        // create a new chatroom
    	$chatroom = new Chatroom();
    	$chatroom->total_message = 1;	// first message will be sent in this API
    	$chatroom->title = 'Admin';
    	$chatroom->chatroom_type_id = 5;	// type = admin
    	$chatroom->type_identifier = $id;
    	$chatroom->save();

    	// add the leader & house owner into the chatroom_participants table
    	$chatroom_participant_user = new ChatroomParticipant();
    	$chatroom_participant_user->chatroom_id = $chatroom->id;
    	$chatroom_participant_user->user_id = $id;
    	$chatroom_participant_user->save();
    	$chatroom_participant_admin = new ChatroomParticipant();
    	$chatroom_participant_admin->chatroom_id = $chatroom->id;
    	$chatroom_participant_admin->user_id = -1;
    	$chatroom_participant_admin->save();

    	// send the message
    	$message = new Message();
    	$message->message = $request['message'];
    	$message->sender = $id;
    	$message->deleted = 0;
    	$message->chatroom_id = $chatroom->id;
    	$message->save();

    	$result['chatroomId'] = $chatroom->id;

    	return $result;
    }


    // POST: create chatroom: 1 user only (when first create team)
    // note: type = 2 (team), type_identifier = team id
    // This fucntion should be called from the store_group() function of House Controller
    public function create_chatroom_team($id, $team_id){
        $errors = array();
        $error = array();

    	// check if the chatroom exists
    	$team_type_chatrooms = Chatroom::where('chatroom_type_id', 2)->get();	// get all the chatrooms of type = team
    	foreach($team_type_chatrooms as $team_type_chatroom) {
    		if($team_type_chatroom->type_identifier == $team_id) {
    			$error['message'] = 'The team chatroom of this team exists.';
    			$error['existChatroomId'] = $team_type_chatroom->id;
    			array_push($errors, $error);
    		}
    	}
    	if(!empty($errors)) {
            return response()->json($errors, 403);
        }

    	// create a new chatroom
    	$chatroom = new Chatroom();
        $chatroom->total_message = 0; // Should have no messgae when team first created
    	$chatroom->title = Group::where('id', $request['teamId'])->first()->title;	// title = team name
    	$chatroom->chatroom_type_id = 2;	// type = team
        $chatroom->type_identifier = $team_id;
    	$chatroom->save();

    	// add only the leader into the chatroom_participants table
    	$chatroom_participant_leader = new ChatroomParticipant();
    	$chatroom_participant_leader->chatroom_id = $chatroom->id;
    	$chatroom_participant_leader->user_id = $id;
    	$chatroom_participant_leader->save();

    	$result['chatroomId'] = $chatroom->id;

    	return $result;
    }

    // POST: join chatroom: 1 user joining a chatroom of user(s)
    // note: type = 4 (reqest), type_identifier = team id
    // This fucntion should be called from the join_group() function of House Controller
    public function create_chatroom_request($id, $team_id, $req_message){
        $errors = array();
        $error = array();

    	// check if the chatroom exists
    	$request_type_chatrooms = Chatroom::where('chatroom_type_id', 4)->get();	// get all the chatrooms of type = request
    	foreach($request_type_chatrooms as $request_type_chatroom) {
    		if($request_type_chatroom->type_identifier == $team_id) {
    			$error['message'] = 'The team chatroom of this team exists.';
    			$error['existChatroomId'] = $request_type_chatroom->id;
    			array_push($errors, $error);
    		}
    	}
    	if(!empty($errors)) {
            return response()->json($errors, 403);
        }

    	// create a new chatroom (This new chatroom is just for record status purpose, the chatroom will be deleted after request acceptance)
    	$chatroom = new Chatroom();
        $chatroom->total_message = 1; // Should have no messgae when team first created

    	$chatroom->title = User::where('id', $id)->first()->username;	// title = leader username
    	$chatroom->chatroom_type_id = 4;	// type = request
        $chatroom->type_identifier = $team_id;
    	$chatroom->save();

    	//add the leader and the jion group tenant into the chatroom_participants table
    	$chatroom_participant_member = new ChatroomParticipant();
    	$chatroom_participant_member->chatroom_id = $chatroom->id;
    	$chatroom_participant_member->user_id = $id;
    	$chatroom_participant_member->save();
        $chatroom_participant_leader = new ChatroomParticipant();
    	$chatroom_participant_leader->chatroom_id = $chatroom->id;
    	$chatroom_participant_leader->user_id = Group::where('id', $team_id)->first()->leader_user_id;
    	$chatroom_participant_leader->save();

        // send the message
    	$message = new Message();
    	$message->message = $req_message;
    	$message->sender = $id;
    	$message->deleted = 0;
    	$message->chatroom_id = $chatroom->id;
    	$message->save();

    	$result['chatroomId'] = $chatroom->id;

    	return $result;
    }


    // POST: send message
    public function send_message($id, $message_group_id, Request $request) {
    	$chatroom = Chatroom::where('id', $message_group_id)->first();
    	$chatroom->total_message++;
    	$chatroom->save();

    	$message = new Message();
    	$message->message = $request['message'];
    	$message->sender = $id;
    	$message->deleted = 0;
    	$message->chatroom_id = $chatroom->id;
    	$message->save();

    	$result['chatroomId'] = $chatroom->id;
    	$result['messageId'] = $message->id;

    	return $result;
    }

    // GET: get user role in team chatroom
    public function get_user_role($id, $message_group_id) {
        $result = array();

        $errors = array();
        $error = array();

        $chatroom = Chatroom::where('chatroom_type_id', 2)->where('id', $message_group_id)->first();
        if($chatroom == null) {
            $error['message'] = "Invalid message group id.";
            $error['source'] = "get_user_role()";
            array_push($errors, $error);
        }

        $team_id = $chatroom->type_identifier;
        $group = Group::where('id', $team_id)->first();
        if($group == null) {
            $error['message'] = "The target user is not found.";
            $error['source'] = "get_user_role()";
            array_push($errors, $error);
        }

        $group_details = GroupDetail::where('group_id', $team_id)->where('member_user_id', $id)->first();
        if($group_details == null) {
            $error['message'] = "The target user info is not found in group_details table.";
            $error['source'] = "get_user_role()";
            array_push($errors, $error);
        }

        if(!empty($errors)) {
            return response()->json($errors, 403);
        }
        if($group->leader_user_id == $id) {
            $result['isLeader'] = true;
        }
        else {
            $result['isLeader'] = false;
        }
        // dd(((int) $group_details->status) - 1);
        $result['status'] = ((int) $group_details->status) - 1;

        return $result;
    }
}
