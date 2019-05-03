@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="house-group">
        {{ csrf_field() }}

        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">  <!--size of form box -->
            <div class="panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">

                <h4 class="title text-muted">Group Information</h4>
                </div>

                <div class="panel-body-edit">

      				  <dt class="col-sm-5">Group ID</dt>
      				  <dd class="col-sm-7">{{ $house->id }}</dd>

      				  <dt class="col-sm-5">Title</dt>
      				  <dd class="col-sm-7">{{ $group->title }}</dd>

      				  <dt class="col-sm-5">Leader ID</dt>
      				  <dd class="col-sm-7">{{ $group->leader_user_id }}</dd>

                <dt class="col-sm-5">Member ID</dt>
                @foreach ($group_details as $group_detail)
                <dd class="col-sm-7">{{ $group_detail->member_user_id }}</dd>
                @endforeach

                <dt class="col-sm-5">Group Status</dt>
                <dd class="col-sm-7">{{ $group_detail->status }}</dd>

      				  <dt class="col-sm-5">Maximum No. People</dt>
      				  <dd class="col-sm-7">{{ $group->max_ppl }}</dd>

      				  <dt class="col-sm-5">Duration</dt>
      				  <dd class="col-sm-7">{{ $group->duration }}</dd>

      				  <dt class="col-sm-5">Rent</dt>
      				  <dd class="col-sm-7">{{ $group->is_rent }}</dd>

			          </div>

                <!-- edit button -->

                </div>
            </div>

            <div class = "buttonView">
                <a href="{{ url('/house') }}">
                <button type="button" class="btn" style="width: 120px; background-color: orange;">Back</button></a>
            </div>
        </div>
    </div>
</div>
@endsection
