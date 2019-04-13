@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')

<div class ="container" id="mainDiv">
    <div id="mydiv" style="height:50px; "></div>
</div>

<div class="container before-nav">
    <form id="add-blog-form" enctype="multipart/form-data" method="POST" action="{{ route('addadmin-form')}}">
        {{ csrf_field() }}
        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted"> Add New Admin </h4>
                </div>

                <div class="panel-body-edit">
                  <div class="col-sm-12">
                      <!-- Name  -->
                      <div class="form-group row {{ $errors->has('add-admin-name') ? 'has-error' : '' }}">
                          <label for="add-admin-name" class="col-sm-2 col-form-label"> Name </label>
                          <div class="col-sm-12">
                              <input type="text" class="form-control" id="add-admin-name" name="add-admin-name" value="{{ old('add-admin-name') }}">
                              @if($errors->has('add-admin-name'))
                                  <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-admin-name') }}</span>
                              @endif
                          </div>
                      </div>

                      <!-- Email -->
                      <div class="form-group row {{ $errors->has('add-admin-email') ? 'has-error' : '' }}">
                          <label for="add-admin-email" class="col-sm-4 col-form-label"> Login email </label>
                          <div class="col-sm-12">
                              <input type="text" class="form-control" id="add-admin-email" name="add-admin-email" value="{{ old('add-admin-email') }}">
                              @if($errors->has('add-admin-email'))
                                  <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-admin-email') }}</span>
                              @endif
                          </div>
                      </div>

                      <!-- Set Password -->
                      <div class="form-group row {{ $errors->has('add-admin-password') ? 'has-error' : '' }}">
                          <label for="add-admin-password" class="col-sm-4 col-form-label"> Set password </label>
                          <div class="col-sm-12">
                              <input type="text" class="form-control" id="add-admin-password" name="add-admin-password" value="{{ old('add-admin-password') }}">
                              @if($errors->has('add-admin-password'))
                                  <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-admin-password') }}</span>
                              @endif
                          </div>
                      </div>

                      <!-- Confirm Password -->
                      <div class="form-group row {{ $errors->has('add-admin-password-confirm') ? 'has-error' : '' }}">
                          <label for="add-admin-password-confirm" class="col-sm-4 col-form-label"> Confirm password </label>
                          <div class="col-sm-12">
                              <input type="text" class="form-control" id="add-admin-password-confirm" name="add-admin-password-confirm" value="{{ old('add-admin-password-confirm') }}">
                              @if($errors->has('add-admin-password-confirm'))
                                  <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-admin-password-confirm') }}</span>
                              @endif
                          </div>
                      </div>
                  </div>

                    <!-- submit button -->
                    <div class="row text-center">
                        <button type="submit" class="btn  form-btn" id="add-admin-submit"> Submit </button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
@endsection
