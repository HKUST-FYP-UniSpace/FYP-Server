<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;

class MessageController extends Controller
{
    //

    public function list_all_messages() {
        $messages = array();
        $stacks = Message::get();
        foreach($stacks as $stack) {
            $message = array();
            $message['id'] = $stack->id;
            $message['message'] = $stack->message;
            $message['sender'] = $stack->sender;
            $message['receiver'] = $stack->receiver;
            $message['order'] = $stack->order;
            $message['deleted'] = $stack->deleted;
            $message['chatroom_id	'] = $stack->chatroom_id	;
            $message['created_at'] = $stack->created_at;
        }
        return $messages;
    }


    //
    public function show_message() {
        $messages = Message::paginate(10);

        return view('message.list-message', compact('messages'));
    }

}
