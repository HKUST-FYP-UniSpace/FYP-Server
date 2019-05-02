@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="trade-view">
        {{ csrf_field() }}

        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">  <!--size of form box -->
            <div class="panel panel-default" style="height: 1000px;"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Trade Item</h4>
                </div>



                <div class="panel-body-edit">

                  <dt class="col-sm-3">Trade ID</dt>
                  @if (  $trade['id']   != null)
                  <dd class="col-sm-9">{{  $trade['id']  }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">User ID</dt>
                  @if ( $trade['user_id']  != null)
                  <dd class="col-sm-9">{{ $trade['user_id']   }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">User Name</dt>
                  @if ( $user['name']   != null)
                  <dd class="col-sm-9">{{ $user['name'] }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">Title</dt>
                  @if ( $trade['title']  != null)
                  <dd class="col-sm-9">{{ $trade['title'] }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">Price (HKD)</dt>
                  @if ( $trade['price']  != null)
                  <dd class="col-sm-9">${{ $trade['price'] }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">Quantity</dt>
                  @if ( $trade['quantity'] != null)
                  <dd class="col-sm-9">{{ $trade['quantity'] }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">Trade District</dt>
                  @if ( $district_id['name'] != null)
                  <dd class="col-sm-9">{{ $district_id['name'] }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">Description</dt>
                  @if ( $trade['description'] != null)
                  <dd class="col-sm-9">{{ $trade['description'] }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">Category</dt>
                  @if ( $category['category'] != null)
                  <dd class="col-sm-9">{{ $category['category'] }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">Condition Type</dt>
                  @if ( $condition_type['type'] != null)
                  <dd class="col-sm-9">{{ $condition_type['type'] }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  @if ( $trade_urls != null)
                  @foreach ($trade_urls as $trade_url)
                  <dt class="col-sm-3">Image</dt>
                  <dd class="col-sm-9"><img src="{{ $trade_url['image_url'] }}" style="height: 200px; padding-bottom: 10px"></dd>
                  <!-- <dd class="col-sm-9">{{ $trade_url['image_url'] }}</dd> -->
                  @endforeach
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">Status</dt>
                  @if ( $status['status'] != null)
                  <dd class="col-sm-9">{{ $status['status'] }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">Post Date</dt>
                  @if ( $trade['created_at'] != null)
                  <dd class="col-sm-9">{{ $trade['created_at'] }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif

                  <dt class="col-sm-3">Update Date</dt>
                  @if ( $trade['updated_at'] != null)
                  <dd class="col-sm-9">{{ $trade['updated_at'] }}</dd>
                  @else <dd class="col-sm-9">{{ "nil" }}</dd>
                  @endif
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
