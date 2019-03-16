@extends('layouts.app')


<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">


    <div class="row">
        
            <a href="{{ route('blog-add') }}"><button class="btn btn-default add-new-blog">New Blog</button></a>
       
        
       
    </div>

    <div class="row">
        <div class="panel panel-default col-md-12">
            <div class="panel-body">
                <h3>Blog List</h3>
                <hr>
                
                <table class="table" >
                    <thead>
                        <tr>
                            <th>Blog ID</th>
                            <th>Title</th>
                            <th>Post Date</th>
                            <th>Update Date</th>
                            <th>Admin ID </th>    
                            <th>Status</th>
                            <th>View More</th>

                        </tr>
                    </thead>
                    @foreach ($blogs as $blog)
                        <tbody>
                         
                            <th>{{ $blog->id }}</th>
                            <th>{{ $blog->title }}</th>
                            <th>{{ $blog->created_at }}</th>
                            <th>{{ $blog->updated_at }}</th>
                            <th>{{ $blog->admin_id }}</th>
                            <th>{{ $blog->status }}</th>
                            <td><a href="{{ route('blog-view', $blog->id) }}">details</a></td>
                        </tbody>
                     @endforeach
                </table> 
            </div>
        </div>
    </div>
</div>
@endsection


<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/blog/add.js') }}"></script>
@endpush
