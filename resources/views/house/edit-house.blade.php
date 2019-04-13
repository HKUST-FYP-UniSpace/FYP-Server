@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <form id="edit-house-form" enctype="multipart/form-data" method="POST" action="{{ route('house-edit-form', $house->id) }}">
        {{ csrf_field() }}


        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Edit Apartment</h4>
                </div>
                <div class="panel-body-edit">
                    @if (count($errors) > 0)
                       <div class = "alert alert-danger" role="alert">
                          <ul>
                             @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                             @endforeach
                          </ul>
                       </div>
                    @endif

                    <!-- Title -->
                    <div class="form-group row">
                        <dt for="edit-house-title" class="col-sm-9" style="padding-left:30px"> Title </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-house-title" name="edit-house-title" value="{{ isset($house) ? old('edit-house-title', $house->title) : old('edit-house-title') }}">
                        </dd>
                    </div>

                    <!-- Subtitle -->
                    <div class="form-group row">
                        <dt for="edit-house-subtitle" class="col-sm-9" style="padding-left:30px"> Subtitle </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-house-subtitle" name="edit-house-subtitle" value="{{ isset($house) ? old('edit-house-subtitle', $house->subtitle) : old('edit-house-subtitle') }}">
                        </dd>
                    </div>

                    <!-- Address  -->
                    <div class="form-group row">
                        <dt for="edit-house-address" class="col-sm-9" style="padding-left:30px"> Address </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-house-address" name="edit-house-address" value="{{ isset($house) ? old('edit-house-address', $house->address) : old('edit-house-address') }}">
                        </dd>
                    </div>

                    <!-- Owner ID -->
                    <div class="form-group row">
                        <dt for="edit-house-owner_id" class="col-sm-9" style="padding-left:30px"> Owner ID </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-house-owner_id" name="edit-house-owner_id" value="{{ isset($house) ? old('edit-house-owner_id', $house->owner_id) : old('edit-house-owner_id') }}">
                        </dd>
                    </div>

                    <!-- House Type: need to select -->
                    <div class="form-group row">
                        <dt for="edit-house-type" class="col-sm-9" style="padding-left:30px"> Apartment Type </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                          <select class="form-control" id="edit-house-type" name="edit-house-type" value="{{ isset($house) ? old('edit-house-type', $house->type) :  old('edit-house-type')}}">
                              <option value= "" selected disabled hidden> Please Select </option>
                              <option value = "0"> Flat </option>
                              <option value = "1"> Cottage </option>
                              <option value = "2"> Detached </option>
                              <option value = "3"> Sub-divided </option>
                          </select>
                        </dd>
                    </div>

                    <!-- House District ID: need to select -->
                    <div class="form-group row">
                        <dt for="edit-house-district_id" class="col-sm-9" style="padding-left:30px"> Apartment District </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                          <select class="form-control" id="edit-house-district_id" name="edit-house-district_id" value="{{  isset($house) ? old('edit-house-district_id', $house->district_id) : old('edit-house-district_id')}}">
                              <option value="" selected disabled hidden> Please Select </option>
                              @foreach($house_districts as $house_district)
                                  <option value="{{ $house_district ->id }}">{{ $house_district->name }}</option>
                              @endforeach
                          </select>
                        </dd>
                    </div>

                    <!-- House Status: need to select -->
                    <div class="form-group row">
                        <dt for="edit-house-status" class="col-sm-9" style="padding-left:30px"> Status </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                          <select class="form-control" id="edit-house-status" name="edit-house-status" value="{{   isset($house) ? old('edit-house-status', $house->status) :  old('edit-house-status')}}">
                              <option value="" selected disabled hidden> Please Select </option>
                              @foreach($house_statuses as $house_status)
                                  <option value="{{ $house_status->id }}">{{ $house_status->status }}</option>
                              @endforeach
                          </select>
                        </dd>
                    </div>

                    <!-- Size -->
                    <div class="form-group row">
                        <dt for="edit-house-size" class="col-sm-9" style="padding-left:30px"> Apartment Size </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-house-size" name="edit-house-size" value="{{ isset($house) ? old('edit-house-size', $house->size) : old('edit-house-size') }}">
                        </dd>
                    </div>


                    <!-- Price -->
                    <div class="form-group row">
                        <dt for="edit-house-price" class="col-sm-9" style="padding-left:30px"> Price </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-house-price" name="edit-house-price" value="{{ isset($house) ? old('edit-house-price', $house->price) : old('edit-house-price') }}">
                        </dd>
                    </div>

                    <!-- Max_ppl -->
                    <div class="form-group row">
                        <dt for="edit-house-max_ppl" class="col-sm-9" style="padding-left:30px"> Maximum No. People </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-house-max_ppl" name="edit-house-max_ppl" value="{{ isset($house) ? old('edit-house-max_ppl', $house->max_ppl) : old('edit-house-max_ppl') }}">
                        </dd>
                    </div>

                    <!-- Description -->
                    <div class="form-group row">
                        <dt for="edit-house-description" class="col-sm-9" style="padding-left:30px">House Description </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <textarea class="form-control" id="edit-house-description" name="edit-house-description" placeholder="Write something.." style="height:200px" value="{{ isset($house) ? old('edit-house-description', $house->description) : old('edit-house-description') }}">{{$house->description}}</textarea>
                        </dd>
                    </div>






                    <!-- edit button -->
                    <div class="row text-center">
                        <button type="submit" class="btn form-btn" id="edit-house-submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>


    </form>
</div>
@endsection


<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/select.js') }}"></script>
@endpush
