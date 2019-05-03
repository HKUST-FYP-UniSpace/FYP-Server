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

      				  <dt class="col-sm-3">Group ID</dt>
      				  <dd class="col-sm-9">{{ $house->id }}</dd>

                <dt class="col-sm-3">Title</dt>
                @if ( $group->title != null)
                <dd class="col-sm-9">{{ $group->title }}</dd>
                @else <dd class="col-sm-9">{{ "nil" }}</dd>
                @endif

                <dt class="col-sm-3">Leader ID</dt>
                @if ( $group->leader_user_id != null)
                <dd class="col-sm-9">{{ $group->leader_user_id }}</dd>
                @else <dd class="col-sm-9">{{ "nil" }}</dd>
                @endif

                <dt class="col-sm-3">Member ID</dt>
                @foreach ($group_details as $group_detail)
                @if ( $group_detail->member_user_id != null)
                <dd class="col-sm-9">{{ $group_detail->member_user_id }}</dd>
                @else <dd class="col-sm-9">{{ "nil" }}</dd>
                @endif
                @endforeach

                <dt class="col-sm-3">Group Status</dt>
                @if ( $group_detail->status  != null)
                <dd class="col-sm-9">{{ $group_detail->status  }}</dd>
                @else <dd class="col-sm-9">{{ "nil" }}</dd>
                @endif

                <dt class="col-sm-3">Maximum No. People</dt>
                @if ( $group->max_ppl  != null)
                <dd class="col-sm-9">{{ $group->max_ppl  }}</dd>
                @else <dd class="col-sm-9">{{ "nil" }}</dd>
                @endif

                <dt class="col-sm-3">Duration</dt>
                @if ( $group->duration  != null)
                <dd class="col-sm-9">{{ $group->duration }} year</dd>
                @else <dd class="col-sm-9">{{ "nil" }}</dd>
                @endif

                <dt class="col-sm-3">Rent</dt>
                @if ( $group->is_rent  != null)
                <dd class="col-sm-9">{{ $group->is_rent }}</dd>
                @else <dd class="col-sm-9">{{ "nil" }}</dd>
                @endif
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
