@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <form id="add-blog" enctype="multipart/form-data" method="POST" action="{{ route('blog-add') }}">
        <input id="signup-token" name="_token" type="hidden" value="{{ csrf_token() }}">
        
        <div class="col-md-8 col-md-offset-2">      
             <a href="{{ url('/blog') }}">
                        <button type="button" class="btn btn-default add-new-item">Back</button>

            </a>
        </div>

        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Create Blog</h4>
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
                    <!-- blog image -->

                    <!-- blog title -->
                    <div class="form-group row">
                        <label for="add-ad-provider" class="col-sm-2 col-form-label">Blog Titile</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="add-ablog-title">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="add-ad-provider" class="col-sm-2 col-form-label">Post Date</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="add-ablog-title">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="add-ad-provider" class="col-sm-2 col-form-label">Blog ID</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="add-ablog-title">
                        </div>
                    </div>


                    <div class="form-group row">
                        <label for="add-ad-provider" class="col-sm-2 col-form-label">Admin</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="add-ablog-title">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="add-ad-provider" class="col-sm-2 col-form-label">Blog Description</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="add-ablog-title">
                        </div>
                    </div>

                    <div class="form-group row">
                            <label for="add-file" class="col-sm-2">Blog Image</label>
                            <div class="col-sm-10">
                                <div class="form-group row">
                                    <div class="col-sm-4 text-center">
                                      <label id="upload-btn">
                                        <input type="file" id="add-file" name="add-file">
                                    </label>  
                                    </div>
                                </div>

                            </div>                      
                    </div>

                    
                    <!-- submit button -->
                    <div><p align="right">
                        <button type="submit"  class="btn btn-primary btn-lg btn-block" id="add-submit" >Submit</button></p>
        
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
