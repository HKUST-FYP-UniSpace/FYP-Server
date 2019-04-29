@extends('layouts.app')

@section('content')
<div class="container before-nav">


    <div class="row">
        <form  class="form-horizontal"  action="{{ url('/message/search')}}" method="GET" id='message-search'>
            <div class="panel panel-default col-md-12">
                <div class="panel-body">
                    <input class="form-control" type="search" name="search" placeholder="{{ $searchPhrase ?? 'Search by ID/identifiers' }}">
                        <div class="text-right">Search</div>
                </div>
            </div>
        </form>

    </div>


    <div class="row">
        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
            <div class="panel-body">
                <h3>Message List</h3>
                <hr>
                <div class="panel-body">
                  <ul class="nav nav-tabs">
                      <ul class="nav nav-tabs" style=" font-size: 17px;">
                        <li class="nav-item"><a  class="nav-link" href="{{ url('message/')}}"> Message To Admin </a></li>
                      </ul>
                </div>

                <table class="table" >
                    <thead>
                        <tr>
                            <th>Chatroom ID</th>
                            <th>Title</th>
                            <!-- <th>Total Messages</th> -->
                            <th>Post Date</th>
                            <th>Check Messages</th>
                        </tr>
                    </thead>
                    @foreach ($chatrooms as $chatroom)
                        <tbody>
                            <th>{{ $chatroom->id }}</th>
                            <th>{{ $chatroom->title }}</th>
                            <!-- <th>{{ $chatroom->total_message}}</th> -->
                            <th>{{ $chatroom->created_at}}</th>
                            <td><a href="{{ route('get-messages', $chatroom->id) }}"> Enter </a></td>
                        </tbody>
                     @endforeach

                </table>
            </div>
        </div>
    </div>
</div>
@endsection
