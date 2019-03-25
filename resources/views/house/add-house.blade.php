@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <form id="add-house-form" method="POST" action="{{ route('house-add-form')}}">
        {{ csrf_field() }}
        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Add New Apartment</h4>
                </div>
                <div class="panel-body-edit">
                <div class="col-sm-12" style="padding-left:30px; padding-right:30px">  
                    <!-- Address -->
                    <div class="form-group row {{ $errors->has('add-house-address') ? 'has-error' : '' }}">
                        <label for="add-house-address" class="col-sm-2 col-form-label"> Address  </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="add-house-address" name="add-house-address" value="{{ old('add-house-address') }}">
                            @if($errors->has('add-house-address'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-address') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- House Type: need to select -->
                     <div class="form-group row {{ $errors->has('add-house-type') ? 'has-error' : '' }}">
                        <label for="add-house-type" class="col-sm-2 col-form-label"> Apartment Type </label>
                        <div class="col-sm-4">
                            <select class="form-control" id="add-house-type" name="add-house-type" value="{{ old('add-house-type')}}">
                                <option value= "" selected disabled hidden> Please Select </option>
                                <option value = "0"> Flat </option>
                                <option value = "1"> Cottage </option>
                                <option value = "2"> Detached </option>
                                <option value = "3"> Sub-divided </option>
                            </select>
                            @if($errors->has('add-house-type'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-type') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- House District ID: need to select -->
                     <div class="form-group row {{ $errors->has('add-house-district_id') ? 'has-error' : '' }}">
                        <label for="add-house-district_id" class="col-sm-2 col-form-label"> Apartment District ID </label>
                        <div class="col-sm-4">
                            <select class="form-control" id="add-house-district_id" name="add-house-district_id" value="{{ old('add-house-district_id')}}">
                                <option value="" selected disabled hidden> Please Select </option>
                                @foreach($house_districts as $house_district)
                                    <option value="{{ $house_district ->id }}">{{ $house_district->name }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('add-house-district_id'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-district_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Size -->
                    <div class="form-group row {{ $errors->has('add-house-size') ? 'has-error' : '' }}">
                        <label for="add-house-size" class="col-sm-2 col-form-label"> Size </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="add-house-size" name="add-house-size" value="{{ old('add-house-size') }}">
                            @if($errors->has('add-house-size'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-size') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="form-group row {{ $errors->has('add-house-price') ? 'has-error' : '' }}">
                        <label for="add-house-price" class="col-sm-2 col-form-label"> Price </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="add-house-price" name="add-house-price" value="{{ old('add-house-price') }}">
                            @if($errors->has('add-house-price'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-price') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Max_ppl -->
                    <div class="form-group row {{ $errors->has('add-house-max_ppl') ? 'has-error' : '' }}">
                        <label for="add-house-max_ppl" class="col-sm-2 col-form-label"> Maximum No. People </label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="add-house-max_ppl" name="add-house-max_ppl" step=1 value="{{ old('add-house-max_ppl') }}">
                                @if($errors->has('add-house-max_ppl'))
                                    <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-max_ppl') }}</span>
                                @endif
                            </div>
                    </div> 

                    <!-- Description -->
                    <div class="form-group row {{ $errors->has('add-house-description') ? 'has-error' : '' }}">
                        <label for="add-house-description" class="col-sm-2 col-form-label"> Description </label>
                        <div class="col-sm-10">
                            <textarea class="form-control form-textarea" id="add-house-description" name="add-house-description" rows="4">{{ old('add-house-description') }}</textarea>
                            @if($errors->has('add-house-description'))
                                    <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-description') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- House Status: need to select -->



                    <!-- Owner ID -->
                    <div class="form-group row {{ $errors->has('add-house-owner_id') ? 'has-error' : '' }}">
                        <label for="add-house-owner_id" class="col-sm-2 col-form-label"> Owner ID </label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="add-house-owner_id" name="add-house-owner_id" value="{{ old('add-house-owner_id') }}">
                            @if($errors->has('add-house-owner_id'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-owner_id') }}</span>
                            @endif
                        </div>
                    </div>


                    </div>
                                 
                    <!-- submit button -->
                    <div class="row text-center" style="padding-left:45%">
                        <button type="submit" class="btn  form-btn" id="add-house-submit">Submit</button>
                    </div>

                </div>
            </div>
        </div>
    </form>
</div>
@endsection


<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/house/add.js') }}"></script>
@endpush