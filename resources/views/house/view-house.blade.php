@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="house-view">
        {{ csrf_field() }}
        <div class="row">
            <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
                <div class="panel-body">
                    <h3>Groups Formed</h3>
                    <hr>
                    <table class="table" >
                        <thead>
                            <tr>
                                <th>Group ID</th>
                                <th>Title</th>
                                <th>Leader ID</th>
                                <th>Description</th>
                                <th>Maximum No. People</th>
                                <th>Duration</th>
                                <th>Rent</th>
                                <th>Group Icon</th>

                            </tr>
                        </thead>
                        @foreach ($groups as $group)
                            <tbody>
                                <th>{{ $group->id }}</th>
                                <td><a href="{{ route('house-group', $group->id) }}">{{ $group->title}}</a></td>
                                <th>{{ $group->leader_user_id }}</th>
                                <th>{{ $group->description }}</th>
                                <th>{{ $group->max_ppl }}</th>
                                <th>{{ $group->duration }}</th>
                                <th>{{ $group->is_rent }}</th>
                                <th><img src="{{ $group->image_url }}" style="height: 100px;"></th>
                            </tbody>
                         @endforeach
                    </table>
                </div>
            </div>
        </div>



        <div class="panel panel-default col-md-12" style="border-color: transparent; padding-left:10%; padding-right:10%;">  <!--size of form box -->


            <div class="panel panel-default" style="height: 600px;"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Apartment</h4>
                </div>

            <div class="panel-body-edit">

                  <dt class="col-sm-3">Apartment ID</dt>
                  <dd class="col-sm-9">{{ $house->id }}</dd>

                  <dt class="col-sm-3">Title</dt>
                  <dd class="col-sm-9">{{ $house->title }}</dd>

                  <dt class="col-sm-3">Subtitle</dt>
                  <dd class="col-sm-9">{{ $house->subtitle }}</dd>

                  <dt class="col-sm-3">Address</dt>
                  <dd class="col-sm-9">{{ $house->address }}</dd>

                  <dt class="col-sm-3">Apartment Type</dt>
                  <dd class="col-sm-9">{{ $type }}</dd>

                  <dt class="col-sm-3">Apartment Size</dt>
                  <dd class="col-sm-9">{{ $house->size }} sq.feets</dd>

                  <dt class="col-sm-3">Max. No. People</dt>
                  <dd class="col-sm-9">{{ $house->max_ppl }}</dd>

                  <dt class="col-sm-3">Price</dt>
                  <dd class="col-sm-9">${{ $house->price }}</dd>


                  @foreach ($house_urls as $house_url)
                  <dt class="col-sm-3">Image URLs </dt>
                  <!-- <dd class="col-sm-9">{{ $house_url->img_url }}</dd> -->
                  <dd class="col-sm-9"><img src="{{ $house_url->img_url }}" style="height: 100px; padding-bottom: 10px"></dd>
                  @endforeach

                  <dt class="col-sm-3">Status</dt>
                  @if ($status  == "1") <dd class="col-sm-9">{{ "Hide" }}</dd>
                  @elseif ($status  == "2") <dd class="col-sm-9">{{ "Reveal" }}</dd>
                  @elseif ($status  == "3") <dd class="col-sm-9">{{ "Archive"  }}</dd>
                  @else <dd class="col-sm-9">{{ "Rent" }}</dd>
                  @endif

                  <dt class="col-sm-3">Owner ID</dt>
                  <dd class="col-sm-9">{{ $house->owner_id }}</dd>

                  <dt class="col-sm-3">Owner Name</dt>
                  <dd class="col-sm-9">{{ $owner['name']}}</dd>

                  <dt class="col-sm-3">Visitors Count</dt>
                  <dd class="col-sm-9">{{ $house_visitors }}</dd>

                  <dt class="col-sm-3">Description</dt>
                  <dd class="col-sm-9">{{ $house->description }}</dd>

                  <dt class="col-sm-3">Post Date</dt>
                  <dd class="col-sm-9">{{ $house->created_at }}</dd>

                  <dt class="col-sm-3">Update Date</dt>
                  <dd class="col-sm-9">{{ $house->updated_at}}</dd>


            </div>

                    <!-- edit button -->
            </div>
          </div>

          <div class = "buttonView">
              <a href="{{ route('house-edit', $house->id) }}">
              <button class="btn" style="width: 120px;">Edit</button></a>

              <a href="{{ url('/house') }}">
              <!-- <a href="javascript:history.go(-1)"> -->
              <button type="button" class="btn" style="width: 120px; background-color: orange;">Back</button></a>
          </div>

        </div>

    </div>
</div>
@endsection
