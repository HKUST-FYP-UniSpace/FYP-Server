@extends('layouts.app')


<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
  <div class="row">
      <form  class="form-horizontal"  action="{{ url('/blog/search')}}" method="GET" id='blog-search'>
          <div class="panel panel-default col-md-12">
              <div class="panel-body">
                  <input class="form-control" type="search" name="search" placeholder="{{ $searchPhrase ?? 'Search by ID/title/subtitle/detail' }}">
                      <div class="text-right">Search</div>
              </div>
          </div>
      </form>

  </div>

    <div class="row">
        <a href="{{ route('blog-add') }}">
        <button class="btn btn-default" style="float: right">Add New Blog</button></a>
    </div>

    <div class="row">
        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
            <div class="panel-body">
                <h3>Blog List</h3>
                <hr>

                <table class="table" >
                    <thead>
                        <tr>
                            <th>Blog ID</th>
                            <th>Title</th>
                            <th>Subitle</th>
                            <th>Post Date</th>
                            <th>Update Date</th>
                            <th>Admin ID </th>
                            <th>Status</th>
                            <th>View Detail</th>
                            <th>Blog Comments</th>
                            <th>Delete Post</th>

                        </tr>
                    </thead>
                    @foreach ($blogs as $blog)
                        <tbody>

                            <th>{{ $blog->id }}</th>
                            <th>{{ $blog->title }}</th>
                            <th>{{ $blog->subtitle }}</th>
                            <th>{{ $blog->created_at }}</th>
                            <th>{{ $blog->updated_at }}</th>
                            <th>{{ $blog->admin_id }}</th>
                            <th>{{ $blog->status }}</th>
                            <td><a href="{{ route('blog-view', $blog->id) }}">details</a></td>
                            <td><a href="{{ route('blog-comment', $blog->id) }}">show comments</a></td>
                            @if($blog->is_deleted == 0)
                            <td>
                                <form method="POST" action="{{ route('blog-delete', $blog->id) }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <a><button type="submit" class="btn-danger submit-delete" onclick="return confirm('Are you sure to delete the post?')"> Delete </button></a>
                                </form>
                            </td>
                            @else
                            <td>
                                <form method="POST" action="{{ route('blog-undelete', $blog->id) }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <a><button type="submit" class="btn-primary" onclick="return confirm('Are you sure to undelete the post?')"> Undelete </button></a>
                                </form>
                            </td>
                            @endif
                        </tbody>
                     @endforeach
                </table>
                <div>
                    {{ $blogs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
