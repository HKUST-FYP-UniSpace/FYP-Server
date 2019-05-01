@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="trade-view">
        {{ csrf_field() }}

        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">  <!--size of form box -->
            <div class="panel panel-default" style="height: 700px;"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Trade Item</h4>
                </div>



                <div class="panel-body-edit">


                  <dt class="col-sm-3">Trade ID</dt>
                  <dd class="col-sm-9">{{ $trade['id'] }}</dd>

                  <dt class="col-sm-3">User ID</dt>
                  <dd class="col-sm-9">{{ $trade['user_id']  }}</dd>

                  <dt class="col-sm-3">User Name</dt>
                  <dd class="col-sm-9">{{ $user }}</dd>

                  <dt class="col-sm-3">Title</dt>
                  <dd class="col-sm-9">{{ $trade['title'] }}</dd>

                  <dt class="col-sm-3">Price (HKD)</dt>
                  <dd class="col-sm-9">${{ $trade['price'] }}</dd>

                  <dt class="col-sm-3">Quantity</dt>
                  <dd class="col-sm-9">{{ $trade['quantity'] }}</dd>

                  <dt class="col-sm-3">Trade District</dt>
                  <dd class="col-sm-9">{{ $district_id['name'] }}</dd>

                  <dt class="col-sm-3">Description</dt>
                  <dd class="col-sm-9">{{ $trade['description'] }}</dd>

                  <dt class="col-sm-3">Category</dt>
                  <dd class="col-sm-9">{{ $category['category']}}</dd>

                  <dt class="col-sm-3">Condition Type</dt>
                  <dd class="col-sm-9">{{ $condition_type['type'] }}</dd>

                  @foreach ($trade_urls as $trade_url)
                  <dt class="col-sm-3">Image URLs</dt>
                  <dd class="col-sm-9"><img src="{{ $trade_url['image_url'] }}" style="height: 100px; padding-bottom: 10px"></dd>
                  <!-- <dd class="col-sm-9">{{ $trade_url['image_url'] }}</dd> -->
                  @endforeach

                  <dt class="col-sm-3">Status</dt>
                  <dd class="col-sm-9">{{ $status['status']}}</dd>

                  <dt class="col-sm-3">Post Date</dt>
                  <dd class="col-sm-9">{{ $trade['created_at'] }}</dd>

                  <dt class="col-sm-3">Update Date</dt>
                  <dd class="col-sm-9">{{ $trade['updated_at'] }}</dd>

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
