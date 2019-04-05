@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <form id="edit-profile-form" method="POST" action="{{ route('user-edit-form', $user->id) }}">
        {{ csrf_field() }}
        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Edit User Profile</h4>
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

                    <div class="form-group row">
                        <dt for="edit-profile-username" class="col-sm-3" style="padding-left:30px"> Username </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-profile-username" name="edit-profile-username" value="{{ isset($user) ? old('edit-profile-username', $user->username) : old('edit-profile-username') }}">
                        </dd>
                    </div>

                    <div class="form-group row">
                        <dt for="edit-profile-contact" class="col-sm-3" style="padding-left:30px"> Contact </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-profile-contact" name="edit-profile-contact" value="{{ isset($user) ? old('edit-profile-contact', $user->profile->contact) : old('edit-profile-contact') }}">
                        </dd>
                    </div>

                    <div class="form-group row">
                        <dt for="edit-profile-email" class="col-sm-3" style="padding-left:30px"> Email </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-profile-email" name="edit-profile-email" value="{{ isset($user) ? old('edit-profile-username', $user->email) : old('edit-profile-email') }}">
                        </dd>
                    </div>

                    <div class="form-group row">
                        <dt for="edit-profile-gender" class="col-sm-3" style="padding-left:30px"> Gender </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <select class="form-control" id="edit-profile-gender" name="edit-profile-gender" value="{{ isset($user) ? old('edit-profile-gender', $user->profile->gender) : old('edit-profile-gender') }}">
                                <option>f</option>
                                <option>m</option>
                            </select>
                        </dd>
                    </div>

                    <div class="form-group row">
                        <dt for="edit-profile-selfIntroduction" class="col-sm-3" style="padding-left:30px"> Self Introduction </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <textarea class="form-control" id="edit-profile-selfIntroduction" name="edit-profile-selfIntroduction" style="height:200px" value="{{ isset($user) ? old('edit-profile-selfIntroduction', $user->profile->self_intro) : old('edit-profile-selfIntroduction') }}">{{$user->profile->self_intro}}</textarea>
                        </dd>
                    </div>
                    <!-- edit button -->
                    <div class="row text-center" style="padding-left:49%">
                        <button type="submit" class="btn form-btn" id="edit-profile-submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/profile.js') }}"></script>
@endpush
