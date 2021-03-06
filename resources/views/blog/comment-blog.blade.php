@extends('layouts.app')


<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
  <div id="blog-comment">
    <div class="row">
        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
            <div class="panel-body">
                <h3>Comments of the current blog</h3>
                <hr>

                <table class="table" >
                    <thead>
                        <tr>
                            <th>Blog ID</th>
                            <th>Comment ID</th>
                            <th>User ID</th>
                            <th>Details</th>
                            <th>Post Date</th>
                        </tr>
                    </thead>
                    @foreach ($blog_comments as $blog_comment)
                        <tbody>

                            <th>{{ $blog_comment->blog_id }}</th>
                            <th>{{ $blog_comment->id }}</th>
                            <th>{{ $blog_comment->user_id}}</th>
                            <th>{{ $blog_comment->details}}</th>
                            <th>{{ $blog_comment->created_at }}</th>
                        </tbody>
                     @endforeach
                </table>


                <!-- back button -->

            </div>

            <div class = "buttonView">
                <a href="{{ url('/blog') }}">
                <button type="button" class="btn" style="width: 120px; background-color: orange;">Back</button></a>
            </div>

        </div>
    </div>
</div>
@endsection
