@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="trade-view">
        {{ csrf_field() }}

        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Trade Item</h4>
                </div>

                </div>

                <div class="panel-body-edit">


                  <dt class="col-sm-3">Trade ID</dt>
                  <dd class="col-sm-9">{{ $trade->id }}</dd>

                  <dt class="col-sm-3">Title</dt>
                  <dd class="col-sm-9">{{ $trade->title }}</dd>

                  <dt class="col-sm-3">Price</dt>
                  <dd class="col-sm-9">{{ $trade->price }}</dd>

                  <dt class="col-sm-3">Quantity</dt>
                  <dd class="col-sm-9">{{ $trade->quantity }}</dd>

                  <dt class="col-sm-3">Trade Description</dt>
                  <dd class="col-sm-9">{{ $trade->description }}</dd>

                  <dt class="col-sm-3">Trade Transaction ID</dt>
                  <dd class="col-sm-9">{{ $trade->trade_transaction_id }}</dd>

                  <dt class="col-sm-3">Trade Category ID</dt>
                  <dd class="col-sm-9">{{ $trade->trade_category_id}}</dd>

                  <dt class="col-sm-3">Trade Condition Type ID</dt>
                  <dd class="col-sm-9">{{ $trade->trade_condition_type_id }}</dd>

                  <dt class="col-sm-3">Trade Status ID</dt>
                  <dd class="col-sm-9">{{ $trade->trade_status_id }}</dd>

                  <dt class="col-sm-3">Post Date</dt>
                  <dd class="col-sm-9">{{ $trade->post_date }}</dd>

                  <dt class="col-sm-3">Update Date</dt>
                  <dd class="col-sm-9">{{ $trade->updated_at}}</dd>

              </div>

                    <!-- edit button -->

                </div>
            </div>

            <div class = "buttonView">
                <a href="{{ route('trade-edit', $trade->id) }}">
                <button class="btn" style="width: 120px;">Edit</button></a>

                <a href="{{ url('/trade') }}">
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
