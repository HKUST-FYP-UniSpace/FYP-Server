@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <form id="add-blog-form" method="POST" action="{{ route('blog-add-form')}}">
        {{ csrf_field() }}
        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Add New Blog</h4>
                </div>
                <div class="panel-body-edit">
                <div class="col-sm-12" style="padding-left:30px; padding-right:30px">

                    <!-- Title -->
                    <div class="form-group row {{ $errors->has('add-blog-title') ? 'has-error' : '' }}">
                        <label for="add-blog-title" class="col-sm-2 col-form-label"> Title  </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="add-blog-title" name="add-blog-title" value="{{ old('add-blog-title') }}">
                            @if($errors->has('add-blog-title'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-blog-title') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Subitle -->
                    <div class="form-group row {{ $errors->has('add-blog-subtitle') ? 'has-error' : '' }}">
                        <label for="add-blog-subtitle" class="col-sm-2 col-form-label"> Subtitle  </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="add-blog-subtitle" name="add-blog-subtitle" value="{{ old('add-blog-subtitle') }}">
                            @if($errors->has('add-blog-subtitle'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-blog-subtitle') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- blog Status: need to select with hard code option -->
                    <div class="form-group row {{ $errors->has('add-blog-status') ? 'has-error' : '' }}">
                        <label for="add-blog-status" class="col-sm-2 col-form-label"> Blog Status </label>
                        <div class="col-sm-12">
                            <select class="form-control" id="add-blog-status" name="add-blog-status" value="{{ old('add-blog-status')}}">
                                <option value= "" selected disabled hidden> Please Select </option>
                                <option value = "0"> Available </option>
                                <option value = "1"> Unavailable </option>
                            </select>
                            @if($errors->has('add-blog-status'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-blog-status') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Admin ID -->
                    <div class="form-group row {{ $errors->has('add-blog-admin_id') ? 'has-error' : '' }}">
                        <label for="add-blog-admin_id" class="col-sm-2 col-form-label"> Admin ID </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="add-blog-admin_id" name="add-blog-admin_id" value="{{ old('add-blog-admin_id') }}">
                            @if($errors->has('add-blog-admin_id'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-blog-admin_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group row {{ $errors->has('add-blog-detail') ? 'has-error' : '' }}">
                        <label for="add-blog-detail" class="col-sm-2 col-form-label"> Detail </label>
                        <div class="col-sm-12">
                            <textarea class="form-control form-textarea" id="add-blog-detail" name="add-blog-detail" rows="4">{{ old('add-blog-detail') }}</textarea>
                            @if($errors->has('add-blog-detail'))
                                    <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-blog-detail') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Image  -->
                    <!-- <div class="form-group row">
                            <label for="add-file" class="col-sm-2">Blog Image </label>
                            <div class="col-sm-12">
                                <div class="form-group row">
                                    <div class="col-sm-10 text-center">
                                      <label class="form-control btn btn-primary view-btn" id="upload-btn">
                                        <input type="file" class="form-control form-control-file" id="add-file" name="add-file"><i class="far fa-image"></i> Choose Image File
                                    </label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-sm-12" id="preview-area">
                                        <div class="text-center">
                                            <label>Preview</label>
                                            <br>
                                            <img class="img-responsive center-block" id="preview" src="#" alt="Unable to preview">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

                    </div>

                    <!-- submit button -->
                    <div class="row text-center">
                        <button type="submit" class="btn  form-btn" id="add-blog-submit">Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
@endsection


<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/blog/add.js') }}"></script>
@endpush
