<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Message;
use App\Chatroom;
use App\User;
use App\ChatroomParticipant;
use App\ChatroomType;
use Auth;

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
            $message['deleted'] = $stack->deleted;
            $message['chatroom_id	'] = $stack->chatroom_id	;
            $message['created_at'] = $stack->created_at;
        }
        return $messages;
    }


    //
    public function show_message() {
      $chatrooms = Chatroom::where('chatroom_type_id', '5')->get();
      // $admin_chats = Chatroom::join('messages','chatrooms.id','=','messages.chatroom_id')
      //                       ->join('chatroom_types','chatrooms.chatroom_type_id', '=','chatroom_types.id')
      //                       ->get();

      return view('message.list-message', compact('chatrooms'));
    }

    public function get_messages($chatroom_id){

      $all_msgs = Message::where('chatroom_id', $chatroom_id)->orderBy('created_at', 'asc')->get();
      $user = User::select('name')->join('messages', 'users.id', '=','messages.sender')
                ->where('chatroom_id', $chatroom_id)
                ->value('name');

      // $all_msgs = Message::where('chatroom_id', $chatroom_id)->latest()->get();
      // $chatrooms = Chatroom::where('id', $chatroom_id)->latest()->get();
      // $chatrooms->total_message = Message::where('chatroom_id', $chatroom_id)->latest()->get()->count();


      return view('message.chatroom-messages', compact('all_msgs','user'));
    }

    // public function reply( $sender, $receiver, $chatroom_id, Request $request){
      public function reply($chatroom_id, Request $request){

      $this->validate($request,
                      ['reply-message' => 'required|max:255'],
                      ['reply-message.required' => 'Type your response',
                       'reply-message.max' => 'Message cannot be too long']);

      $reply = new Message();
      $admin_chats = Message::where('chatroom_id', $chatroom_id)->latest()->get();

      $reply->message = $request->input('reply-message');
      $reply->chatroom_id = $chatroom_id;
      $reply->sender = 99999;
      $reply->deleted = 0;
      $reply->save();

     $all_msgs = Message::where('chatroom_id', $chatroom_id)->orderBy('created_at', 'asc')->get();
      // $all_msgs = Message::where('chatroom_id', $chatroom_id)->latest()->get();
    // $user = User::join('messages', 'users.id', '=','messages.sender')
    //           ->where('chatroom_id', $chatroom_id)
    //           ->latest()->value('name');
    $user = User::select('name')->join('messages', 'users.id', '=','messages.sender')
              ->where('chatroom_id', $chatroom_id)
              ->value('name');

      return view('message.chatroom-messages', compact('all_msgs','user'));
    }

    public function search(Request $request){
    if ( $request->has('search') ){

        $chatrooms = Chatroom::where('id', "LIKE", "%".$request->search."%")
                        ->orWhere('identifiers', "LIKE", "%".$request->search."%")
                        ->latest()
                        ->paginate(5)
                        ->appends('search', $request->search);

    }else{
      $chatrooms = Chatroom::latest()->paginate(5);
    }

    $searchPhrase = $request->search;
    return view('message.list-message', compact('chatrooms','searchPhrase'));
   }

}
