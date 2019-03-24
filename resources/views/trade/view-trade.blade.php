@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="trade-view">
        {{ csrf_field() }}

        <div class="col-md-8 col-md-offset-2">     
            <a href="{{ route('trade-edit', $trade->id) }}">
            <button class="btn btn-default add-new-item">Edit</button></a>
        </div>
        
        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Trade Item</h4>
                </div>

                </div>

                <div class="panel-body-edit">
               
                    
                  <dt class="col-sm-5">Trade ID</dt>
                  <dd class="col-sm-7">{{ $trade->id }}</dd>

                  <dt class="col-sm-5">Title</dt>
                  <dd class="col-sm-7">{{ $trade->title }}</dd>

                  <dt class="col-sm-5">Price</dt>
                  <dd class="col-sm-7">{{ $trade->price }}</dd>

                  <dt class="col-sm-5">Post Date</dt>
                  <dd class="col-sm-7">{{ $trade->post_date }}</dd>


                  <dt class="col-sm-5">Update Date</dt>
                  <dd class="col-sm-7">{{ $trade->updated_at}}</dd>

                  <dt class="col-sm-5">Quantity</dt>
                  <dd class="col-sm-7">{{ $trade->quantity }}</dd>

                  <dt class="col-sm-5">Trade Description</dt>
                  <dd class="col-sm-7">{{ $trade->description }}</dd>

                  <dt class="col-sm-5">Status</dt>
                  <dd class="col-sm-7">{{ $trade->status }}</dd>

                  <dt class="col-sm-5">Trade Transaction ID</dt>
                  <dd class="col-sm-7">{{ $trade->trade_transaction_id }}</dd>

                  <dt class="col-sm-5">Trade Category ID</dt>
                  <dd class="col-sm-7">{{ $trade->trade_category_id}}</dd>    

                  <dt class="col-sm-5">Trade Condition Type ID</dt>
                  <dd class="col-sm-7">{{ $trade->trade_condition_type_id }}</dd>

                  <dt class="col-sm-5">Trade Status ID</dt>
                  <dd class="col-sm-7">{{ $trade->trade_status_id }}</dd>            

              </div> 
                      
                    <!-- edit button -->
				 	<a href="{{ url('/trade') }}">
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