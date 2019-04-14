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
                                <th>Image</th>
                            </tr>
                        </thead>
                        @foreach ($groups as $group)
                            <tbody>
                                <th>{{ $group->id }}</th>
                                <td><a href="{{ route('house-group', $group->id) }}">{{ $group->title}}</a></td>
                                <th>{{ $group->leader_user_id }}</th>
                                <th>{{ $group->max_ppl }}</th>
                                <th>{{ $group->description }}</th>
                                <th>{{ $group->is_rent }}</th>
                                <th>{{ $group->image_url }}</th>
                            </tbody>
                         @endforeach
                    </table>
                </div>
            </div>
        </div>



        <div class="panel panel-default col-md-12" style="border-color: transparent; padding-left:10%; padding-right:10%;">  <!--size of form box -->


            <div class="panel panel-default" style="height: 400px;"> <!-- border+background -->
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
                  <dd class="col-sm-9">{{ $house->type }}</dd>

                  <dt class="col-sm-3">Apartment Size</dt>
                  <dd class="col-sm-9">{{ $house->size }}</dd>

                  <dt class="col-sm-3">Maximum No. People</dt>
                  <dd class="col-sm-9">{{ $house->max_ppl }}</dd>

                  <dt class="col-sm-3">Price</dt>
                  <dd class="col-sm-9">{{ $house->price }}</dd>

                  <dt class="col-sm-3">Image URLs</dt>
                  <dd class="col-sm-9">{{ $house->img_url }}</dd>

                  <dt class="col-sm-3">Status</dt>
                  <dd class="col-sm-9">{{ $house->status }}</dd>

                  <dt class="col-sm-3">Owner ID</dt>
                  <dd class="col-sm-9">{{ $house->owner_id }}</dd>

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
              <button type="button" class="btn" style="width: 120px; background-color: orange;">Back</button></a>
          </div>

        </div>

    </div>
</div>
@endsection

<!-- javascript (name corresponds to app.blade.php) -->
<!-- @push('add-script')
    <script src="{{ asset('/js/select.js') }}"></script>
@endpush -->
