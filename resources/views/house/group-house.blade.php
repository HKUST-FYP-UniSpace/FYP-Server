@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="house-group">
        {{ csrf_field() }}

        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
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
                <a href="{{ url('/{id}/view-house') }}">
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
