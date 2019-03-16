@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="house-view">
        {{ csrf_field() }}

        <div class="col-md-8 col-md-offset-2">     
            <a href="{{ route('house-edit', $house->id) }}">
            <button class="btn btn-default add-new-item">Edit</button></a>
        </div>
        
        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Apartment</h4>
                </div>
  
            <div class="panel-body-edit">
                          
                  <dt class="col-sm-5">Apartment ID</dt>
                  <dd class="col-sm-7">{{ $house->id }}</dd>

                  <dt class="col-sm-5">Post Date</dt>
                  <dd class="col-sm-7">{{ $house->created_at }}</dd>


                  <dt class="col-sm-5">Update Date</dt>
                  <dd class="col-sm-7">{{ $house->updated_at}}</dd>

                  <dt class="col-sm-5">Address</dt>
                  <dd class="col-sm-7">{{ $house->address }}</dd>

                  <dt class="col-sm-5">Apartment Type</dt>
                  <dd class="col-sm-7">{{ $house->type }}</dd>

                  <dt class="col-sm-5">Apartment Size</dt>
                  <dd class="col-sm-7">{{ $house->size }}</dd>

                  <dt class="col-sm-5">Maximum No. People</dt>
                  <dd class="col-sm-7">{{ $house->max_ppl }}</dd>

                  <dt class="col-sm-5">Price</dt>
                  <dd class="col-sm-7">{{ $house->price }}</dd>

                  <dt class="col-sm-5">Status</dt>
                  <dd class="col-sm-7">{{ $house->status }}</dd>

                  <dt class="col-sm-5">Owner ID</dt>
                  <dd class="col-sm-7">{{ $house->owner_id }}</dd>

                  <dt class="col-sm-5">Description</dt>
                  <dd class="col-sm-7">{{ $house->description }}</dd>

            </div>  

                    <!-- edit button -->
				 	<a href="{{ url('/house') }}">
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