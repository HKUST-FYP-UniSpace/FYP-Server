@extends('layouts.app')


<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
  <div id="house-comment">

    <div class="row">
        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
            <div class="panel-body">
                <h3>Comments of the current Apartment</h3>
                <hr>

                <table class="table" >
                    <thead>
                        <tr>
                            <th>Apartment ID</th>
                            <th>Comment ID</th>
                            <th>Tanent ID</th>
                            <th>Details</th>
                            <th>Post Date</th>
                        </tr>
                    </thead>
                    @foreach ($house_comments as $house_comment)
                        <tbody>

                            <th>{{ $house_comment->house_id }}</th>
                            <th>{{ $house_comment->id }}</th>
                            <th>{{ $house_comment->tanent_id}}</th>
                            <th>{{ $house_comment->details}}</th>
                            <th>{{ $house_comment->created_at }}</th>
                        </tbody>
                     @endforeach
                </table>


                <!-- back button -->
            </div>
        </div>

        <div class = "buttonView">
            <a href="{{ url('/house') }}">
            <button type="button" class="btn" style="width: 120px; background-color: orange;">Back</button></a>
        </div>

    </div>
</div>
</div>
@endsection
