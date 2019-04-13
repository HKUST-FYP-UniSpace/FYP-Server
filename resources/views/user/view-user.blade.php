@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="user-view">
        {{ csrf_field() }}
        <div class="row">
            <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
                <div class="panel-body">
                    <h3>Apartment Owner Rating on Tenants</h3>
                    <hr>
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>Rating ID</th>
                                <th>Owner ID</th>
                                <th>Tenant ID</th>
                                <th>Rate</th>
                                <th>Review</th>
                                <th>Post Date</th>
                            </tr>
                        </thead>
                        @foreach ($tenant_ratings as $tenant_rating)
                            <tbody>

                                <th>{{ $tenant_rating->id }}</th>
                                <th>{{ $tenant_rating->owner_id }}</th>
                                <th>{{ $tenant_rating->tenant_id }}</th>
                                <th>{{ $tenant_rating->rate }}</th>
                                <th>{{ $tenant_rating->review }}</th>
                                <th>{{ $tenant_rating->created_at }}</th>
                            </tbody>
                         @endforeach
                    </table>
                </div>
            </div>
        </div>

        <div class= "row">

        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">  <!--size of form box -->
            <div class="panel panel-default" style="height: 300px;"> <!-- border+background -->
                <div class="panel-heading text-center">

                <h4 class="title text-muted">User</h4>
                </div>

                <div class="panel-body-edit">

      				  <dt class="col-sm-5">Profile ID</dt>
      				  <dd class="col-sm-7">{{ $profile->id}}</dd>

      				  <dt class="col-sm-5">Username</dt>
      				  <dd class="col-sm-7">{{ $user->username }}</dd>

      				  <dt class="col-sm-5">User ID</dt>
      				  <dd class="col-sm-7">{{ $profile->user_id }}</dd>

      				  <dt class="col-sm-5">Contact</dt>
      				  <dd class="col-sm-7">{{ $profile->contact }}</dd>

      				  <dt class="col-sm-5">Email</dt>
      				  <dd class="col-sm-7">{{ $user->email }}</dd>

      				  <dt class="col-sm-5 text-truncate">Gender</dt>
      				  <dd class="col-sm-7">{{ $profile->gender }}</dd>

      				  <dt class="col-sm-5">Self Introduction</dt>
      				  <dd class="col-sm-7">{{ $profile->self_intro}}</dd>

      				  <dt class="col-sm-5">User Icon</dt>
      				  <dd class="col-sm-7">{{ $profile->icon_url }}</dd>

                <dt class="col-sm-5">Regestration Date</dt>
                <dd class="col-sm-7">{{ $user->created_at}}</dd>

                <dt class="col-sm-5">Update Date</dt>
                <dd class="col-sm-7">{{ $user->updated_at}}</dd>

			          </div>
                    <!-- edit button -->



                </div>
            </div>
        </div>

        <div class = "buttonView">
            <a href="{{ route('user-edit', $user->id) }}">
            <button class="btn" style="width: 120px;">Edit</button></a>

            <a href="{{ url('/user') }}">
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
