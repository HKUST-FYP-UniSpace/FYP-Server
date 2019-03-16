@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="trade-view">
        {{ csrf_field() }}
        <div class="col-md-8 col-md-offset-2">      
            <a href=""><button class="btn btn-default add-new-item">Edit</button></a>
        </div>

        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">User</h4>
                </div>
                <div class="panel-body-edit">
                   
			  <dt class="col-sm-3">User ID</dt>
			  <dd class="col-sm-9">001
			  </dd>

			  <dt class="col-sm-3">Name</dt>
			  <dd class="col-sm-9">
			    <p>haha</p>
	
			  </dd>

			  <dt class="col-sm-3">Contact</dt>
			  <dd class="col-sm-9">11111111</dd>

			  <dt class="col-sm-3">Email</dt>
			  <dd class="col-sm-9">fyp@ust.hk</dd>

			  <dt class="col-sm-3 text-truncate">Gender</dt>
			  <dd class="col-sm-9">female</dd>

			  <dt class="col-sm-3">Self Introduction</dt>
			  <dd class="col-sm-9">Nice to meet you</dd>

			  <dt class="col-sm-3">User Icon</dt>
			  <dd class="col-sm-9"></dd>
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