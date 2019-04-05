@extends('layouts.app')

@section('content')
<div class="container before-nav">


    <div class="row">
        <form  class="form-horizontal"  action="{{ url('/message/search')}}" method="GET" id='message-search'>
            <div class="panel panel-default col-md-12">
                <div class="panel-body">
                    <input class="form-control" type="search" name="search" placeholder="{{ $searchPhrase ?? 'Search' }}">
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

                <table class="table" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Sender ID</th>
                            <th>Receiver ID</th>
                            <th>Chatroom ID</th>
                            <th>Message</th>
                            <th>Deleted</th>
                            <th>Post Date</th>
                        </tr>
                    </thead>
                    @foreach ($messages as $message)
                        <tbody>

                            <th>{{ $message->id }}</th>
                            <th>{{ $message->sender}}</th>
                            <th>{{ $message->receiver}}</th>
                            <th>{{ $message->chatroom_id }}</th>
                            <th>{{ $message->message}}</th>
                            <th>{{ $message->deleted }}</th>
                            <th>{{ $message->created_at}}</th>
                        </tbody>
                     @endforeach

                </table>
                <div>
                    {{ $messages->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/select.js') }}"></script>
@endpush
