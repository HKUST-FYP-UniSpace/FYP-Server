@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">

@endpush

@section('content')
<div class="container before-nav">
    <div id="blog-view">
        {{ csrf_field() }}

        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">  <!--size of form box -->

            <div class="panel panel-default"> <!-- border+background -->

                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Blog</h4>
                </div>

                <div class="panel-body-edit">


                  <dt class="col-sm-3">Blog ID</dt>
                  <dd class="col-sm-9">{{ $blog->id }}</dd>

                  <dt class="col-sm-3">Title</dt>
                  <dd class="col-sm-9">{{ $blog->title }}</dd>

                  <dt class="col-sm-3">Status</dt>
                  <dd class="col-sm-9">{{ $blog->status}}</dd>

                  <dt class="col-sm-3">Admin ID</dt>
                  <dd class="col-sm-9">{{ $blog->admin_id }}</dd>

                  <dt class="col-sm-3">Detail</dt>
                  <dd class="col-sm-9">{{ $blog->detail}}</dd>

                  <dt class="col-sm-3">Image</dt>
                  <dd class="col-sm-9">{{ $blog->image_url }}</dd>

                  <dt class="col-sm-3">Post Date</dt>
                  <dd class="col-sm-9">{{ $blog->created_at}}</dd>

                  <dt class="col-sm-3">Update Date</dt>
                  <dd class="col-sm-9">{{ $blog->updated_at}}</dd>


              </div>

                    <!-- back button -->

                </div>
            </div>

            <div class = "buttonView">
                <a href="{{ route('blog-edit', $blog->id) }}">
                <button class="btn" style="width: 120px;">Edit</button></a>

                <a href="{{ url('/blog') }}">
                <button type="button" class="btn" style="width: 120px; background-color: orange;">Back</button></a>
            </div>

        </div>
    </div>
</div>
@endsection

<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/select.js') }}"></script>
@endpush
