@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <form id="edit-blog-form" method="POST" action="{{ route('blog-edit-form', $blog->id) }}">
        {{ csrf_field() }}


        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Edit Blog</h4>
                </div>
                <div class="panel-body-edit">
                    @if (count($errors) > 0)
                       <div class = "alert alert-danger" role="alert">
                          <ul>
                             @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                             @endforeach
                          </ul>
                       </div>
                    @endif

                    <!-- Title  -->
                    <div class="form-group row">
                        <dt for="edit-blog-title" class="col-sm-9" style="padding-left:30px"> Blog Title </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-blog-title" name="edit-blog-title" value="{{ isset($blog) ? old('edit-blog-title', $blog->title) : old('edit-blog-title') }}">
                        </dd>
                    </div>

                    <!-- Subitle  -->
                    <div class="form-group row">
                        <dt for="edit-blog-subtitle" class="col-sm-9" style="padding-left:30px"> Blog Subtitle </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-blog-subtitle" name="edit-blog-subtitle" value="{{ isset($blog) ? old('edit-blog-subtitle', $blog->subtitle) : old('edit-blog-subtitle') }}">
                        </dd>
                    </div>

                    <div class="form-group row">
                        <dt for="edit-blog-status" class="col-sm-9" style="padding-left:30px"> Status </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-blog-status" name="edit-blog-status" value="{{ isset($blog) ? old('edit-blog-status', $blog->status) : old('edit-blog-status') }}">
                        </dd>
                    </div>


                    <div class="form-group row">
                        <dt for="edit-blog-admin_id" class="col-sm-9" style="padding-left:30px"> Admin ID </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-blog-admin_id" name="edit-blog-admin_id" value="{{ isset($blog) ? old('edit-blog-admin_id', $blog->admin_id) : old('edit-blog-admin_id') }}">
                        </dd>
                    </div>

                    <div class="form-group row">
                        <dt for="edit-blog-image_url" class="col-sm-9" style="padding-left:30px"> Image URL </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-blog-image_url" name="edit-blog-image_url" value="{{ isset($blog) ? old('edit-blog-image_url', $blog->image_url) : old('edit-blog-image_url') }}">
                        </dd>
                    </div>


                    <div class="form-group row">
                        <dt for="edit-blog-detail" class="col-sm-9" style="padding-left:30px">Blog Detail</dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <textarea class="form-control" id="edit-blog-detail" name="edit-blog-detail" placeholder="Write something.." style="height:200px" value="{{ isset($blog) ? old('edit-blog-detail', $blog->detail) : old('edit-blog-detail') }}">{{$blog->detail}}</textarea>
                        </dd>
                    </div>

                    <!-- edit button -->
                    <div class="row text-center" style="padding-left:49%">
                        <button type="submit" class="btn form-btn" id="edit-blog-submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>


    </form>
</div>
@endsection


<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/select.js') }}"></script>
@endpush
