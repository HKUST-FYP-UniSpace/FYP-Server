@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <form id="edit-blog-form"  enctype="multipart/form-data"  method="POST" action="{{ route('blog-edit-form', $blog->id) }}">
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

                    <!-- Blog Status: need to select -->
                    <div class="form-group row">
                        <dt for="edit-blog-status" class="col-sm-9" style="padding-left:30px"> Blog Status </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                          <select class="form-control" id="edit-blog-status" name="edit-blog-status" value="{{ isset($house) ? old('edit-blog-status', $house->type) :  old('edit-blog-status')}}">
                              <option value= "" selected disabled hidden> Please Select </option>
                              <option value = "1" {{ old('edit-blog-status') == 0 ? 'selected' : '' }}> Hide </option>
                              <option value = "2" {{ old('edit-blog-status') == 1 ? 'selected' : '' }}> Reveal </option>
                              <option value = "3" {{ old('edit-blog-status') == 1 ? 'selected' : '' }}> Archive </option>
                          </select>
                        </dd>
                    </div>


                    <div class="form-group row">
                        <dt for="edit-blog-admin_id" class="col-sm-9" style="padding-left:30px"> Admin ID </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-blog-admin_id" name="edit-blog-admin_id" value="{{ isset($blog) ? old('edit-blog-admin_id', $blog->admin_id) : old('edit-blog-admin_id') }}">
                        </dd>
                    </div>

                    <!-- <div class="form-group row">
                        <dt for="edit-blog-image_url" class="col-sm-9" style="padding-left:30px"> Image URL </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-blog-image_url" name="edit-blog-image_url" value="{{ isset($blog) ? old('edit-blog-image_url', $blog->image_url) : old('edit-blog-image_url') }}">
                        </dd>
                    </div> -->


                    <div class="form-group row">
                        <dt for="edit-blog-detail" class="col-sm-9" style="padding-left:30px">Blog Detail</dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <textarea class="form-control" id="edit-blog-detail" name="edit-blog-detail" placeholder="Write something.." style="height:100px" value="{{ isset($blog) ? old('edit-blog-detail', $blog->detail) : old('edit-blog-detail') }}">{{$blog->detail}}</textarea>
                        </dd>
                    </div>

                    <!-- Image  -->
                    <div class="form-group row">
                        <label for="edit-file" class="col-sm-4">Blog image</label>
                        <div class="col-sm-12 {{ $errors->has('edit-file') ? 'has-error' : '' }}">
                            <!-- original image-->
                            <div class="form-group row col-sm-12" id="edit-original-file">
                                <img src="{{ $blog->image_url }}" class="img-responsive center-block">
                            </div>
                            <!-- choose new pic use -->
                            <div class="form-group row">
                                <div class="col-sm-5 text-center">
                                  <label class="form-control btn btn-primary view-btn" id="upload-btn">
                                    <input type="file" class="form-control form-control-file" id="edit-file" name="edit-file"><i class="far fa-image"></i> Choose New File </label>
                                </div>

                                <div class="col-sm-6 text-center display_none" id="edit-use-original-area">
                                    <label class="form-control btn btn-primary view-btn" id="edit-use-original"><i class="far fa-image"></i> Use Original Image </label>
                                </div>
                            </div>
                            <!-- preview area -->
                            <div class="form-group row">
                                <div class="col-sm-12" id="preview-area">
                                    <div class="text-center">
                                        <label> Preview </label>
                                        <br>
                                        <img class="img-responsive center-block" id="preview" src="#">
                                          <script>
                                            $(document).ready(function() {
                                                $("#edit-file").on("change", function() {
                                                  readURL(this);
                                                  $("#edit-original-file").hide(200);
                                                  $("#edit-use-original-area").show(200);
                                                });

                                                $("#edit-use-original").on("click", function() {

                                                  $("#preview-area").hide(200);
                                                  $("#edit-original-file").show(200);
                                                  $("#hidden-flag").val("original");
                                                  $("#edit-use-original-area").hide(200);
                                                });

                                                function readURL(input) {
                                                  console.log(input.files[0]);
                                                  if (input.files && input.files[0]) {
                                                  var reader = new FileReader();
                                                  reader.onload = function(e) {
                                                    $("#preview")
                                                      .attr("src", e.target.result)
                                                  };
                                                  reader.readAsDataURL(input.files[0]);
                                                  $("#preview-area").show(200);
                                                  $("#hidden-flag").val("new");
                                                }
                                                }
                                            });
                                          </script>
                                    </div>
                                </div>
                            </div>
                            @if($errors->has('edit-file'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('edit-file') }}</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <input type="hidden" id="hidden-flag" name="hidden-flag" value="original">
                    </div>

                    <!-- edit button -->
                    <div class="row text-center">
                        <button type="submit" class="btn form-btn" id="edit-blog-submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>


    </form>
</div>
@endsection
