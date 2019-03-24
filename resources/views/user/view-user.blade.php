@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="trade-view">
        {{ csrf_field() }}
        <div class="col-md-8 col-md-offset-2">      
            <a href="{{ route('user-edit', $user->id) }}">
            <button class="btn btn-default add-new-item">Edit</button></a>
        </div>

        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">

                <h4 class="title text-muted">User</h4>
                </div>



                <div class="panel-body-edit">
               
	                
				  <dt class="col-sm-3">Profile ID</dt>
				  <dd class="col-sm-9">{{ $user->profile->id }}</dd>

				  <dt class="col-sm-3">Name</dt>
				  <dd class="col-sm-9">{{ $user->profile->name }}</dd>

				  <dt class="col-sm-3">Username</dt>
				  <dd class="col-sm-9">{{ $user->username }}</dd>

				  <dt class="col-sm-3">User ID</dt>
				  <dd class="col-sm-9">{{ $user->profile->user_id }}</dd>

				  <dt class="col-sm-3">Contact</dt>
				  <dd class="col-sm-9">{{ $user->profile->contact}}</dd>

				  <dt class="col-sm-3">Email</dt>
				  <dd class="col-sm-9">{{ $user->email }}</dd>

				  <dt class="col-sm-3 text-truncate">Gender</dt>
				  <dd class="col-sm-9">{{ $user->profile->gender}}</dd>

				  <dt class="col-sm-3">Self Introduction</dt>
				  <dd class="col-sm-9">{{ $user->profile->self_intro }}</dd>

				  <dt class="col-sm-3">User Icon</dt>
				  <dd class="col-sm-9">{{ $user->profile->icon_url }}</dd>

                  <dt class="col-sm-3">Regestration Date</dt>
                  <dd class="col-sm-9">{{ $user->created_at}}</dd>

                  <dt class="col-sm-3">Update Date</dt>
                  <dd class="col-sm-9">{{ $user->updated_at}}</dd>
				 

			  </div>
                    <!-- edit button -->
				 	<a href="{{ url('/user') }}">
						<button type="button" class="btn btn-primary btn-lg btn-block">Back</button>
				    </a>


                </div>
            </div>
        </div>
    </div>
</div>
@endsection



<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/select.js') }}"></script>
@endpush