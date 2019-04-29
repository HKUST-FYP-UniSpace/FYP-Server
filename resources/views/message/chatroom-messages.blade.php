@extends('layouts.app')

@section('content')
<div class="container before-nav">

    <div class="row">
        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
            <div class="panel-body">
                <h3>Chatroom Messages</h3>
                <hr>

                <table class="table" >
                    <thead>
                        <tr>
                            <!-- <th>Message ID</th> -->
                            <th>Sender</th>
                            <th>Message</th>
                            <th>Post Date</th>
                            <!-- <th>Reply Message</th> -->
                        </tr>
                    </thead>
                    @foreach ($all_msgs as $all_msg)

                        <tbody>
                            <!-- <th>{{ $all_msg->id }}</th> -->
                            @if($all_msg->sender != -1)
                            <th>{{ $user}}</th>
                            @else
                            <th>{{ "Admin "}}</th>
                            @endif

                            <th>{{ $all_msg->message }}</th>
                            <th>{{ $all_msg->created_at }}</th>
                            <!-- @if($all_msg->sender != -1)
                            <td>

                            </td>
                            @endif -->
                        </tbody>

                     @endforeach

                </table>
            </div>

            <div>
              <form method="POST" action="{{ route('reply-message', $all_msg->chatroom_id )}}">
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div>
                    <form>
                      <input type="text" class=" col-md-11" style=" height: 40px;" placeholder="type your message" name="reply-message"  required>
                      <button type="submit" class="btn">Sent</button>
                    </form>
                  </div>
              </form>
            </div>

            <div class="container" style="height: 40px;"></div>

            <div class = "buttonView">
                <a href="{{ url('/message') }}">
                <button type="button" class="btn" style="width: 120px; background-color: orange;">Back</button></a>
            </div>

        </div>
    </div>
</div>
@endsection
