@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class ="container" id="mainDiv">
    <div id="mydiv" style="height:50px; "></div>
</div>

<div class="container before-nav">
    <form id="add-house-form" enctype="multipart/form-data" method="POST" action="{{ route('house-add-form')}}">
        {{ csrf_field() }}
        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Add New Apartment</h4>
                </div>
                <div class="panel-body-edit">
                <div class="col-sm-12">
                  <!-- Title -->
                  <div class="form-group row {{ $errors->has('add-house-address') ? 'has-error' : '' }}">
                      <label for="add-house-title" class="col-sm-2 col-form-label"> Title  </label>
                      <div class="col-sm-12">
                          <input type="text" class="form-control" id="add-house-title" name="add-house-title" value="{{ old('add-house-title') }}">
                          @if($errors->has('add-house-title'))
                              <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-title') }}</span>
                          @endif
                      </div>
                  </div>

                  <!--Subtitle -->
                  <div class="form-group row {{ $errors->has('add-house-subtitle') ? 'has-error' : '' }}">
                      <label for="add-house-subtitle" class="col-sm-3 col-form-label"> Subtitle  </label>
                      <div class="col-sm-12">
                          <input type="text" class="form-control" id="add-house-subtitle" name="add-house-subtitle" value="{{ old('add-house-subtitle') }}">
                          @if($errors->has('add-house-subtitle'))
                              <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-subtitle') }}</span>
                          @endif
                      </div>
                  </div>

                    <!-- Address -->
                    <div class="form-group row {{ $errors->has('add-house-address') ? 'has-error' : '' }}">
                        <label for="add-house-address" class="col-sm-2 col-form-label"> Address  </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="add-house-address" name="add-house-address" value="{{ old('add-house-address') }}">
                            @if($errors->has('add-house-address'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-address') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Owner ID -->
                    <div class="form-group row {{ $errors->has('add-house-owner_id') ? 'has-error' : '' }}">
                        <label for="add-house-owner_id" class="col-sm-4 col-form-label"> Owner ID </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="add-house-owner_id" name="add-house-owner_id" value="{{ old('add-house-owner_id') }}">
                            @if($errors->has('add-house-owner_id'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-owner_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- House Type: need to select -->
                     <div class="form-group row {{ $errors->has('add-house-type') ? 'has-error' : '' }}">
                        <label for="add-house-type" class="col-sm-4 col-form-label"> Apartment Type </label>
                        <div class="col-sm-8">
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
                        <label for="add-house-district_id" class="col-sm-4 col-form-label"> Apartment District ID </label>
                        <div class="col-sm-8">
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

                    <!-- House Status: need to select -->
                    <div class="form-group row {{ $errors->has('add-house-status') ? 'has-error' : '' }}">
                        <label for="add-house-status" class="col-sm-4 col-form-label"> Apartment Status </label>
                        <div class="col-sm-8">
                            <select class="form-control" id="add-house-status" name="add-house-status" value="{{ old('add-house-status')}}">
                                <option value="" selected disabled hidden> Please Select </option>
                                @foreach($house_statuses as $house_status)
                                    <option value="{{ $house_status->id }}">{{ $house_status->status }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('add-house-status'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-status') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Size -->
                    <div class="form-group row {{ $errors->has('add-house-size') ? 'has-error' : '' }}">
                        <label for="add-house-size" class="col-sm-4 col-form-label"> Size </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="add-house-size" name="add-house-size" value="{{ old('add-house-size') }}">
                            @if($errors->has('add-house-size'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-size') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="form-group row {{ $errors->has('add-house-price') ? 'has-error' : '' }}">
                        <label for="add-house-price" class="col-sm-4 col-form-label"> Price </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="add-house-price" name="add-house-price" value="{{ old('add-house-price') }}">
                            @if($errors->has('add-house-price'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-price') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Max_ppl -->
                    <div class="form-group row {{ $errors->has('add-house-max_ppl') ? 'has-error' : '' }}">
                        <label for="add-house-max_ppl" class="col-sm-4 col-form-label"> Maximum No. People </label>
                            <div class="col-sm-8">
                                <input type="number" class="form-control" id="add-house-max_ppl" name="add-house-max_ppl" step=1 value="{{ old('add-house-max_ppl') }}">
                                @if($errors->has('add-house-max_ppl'))
                                    <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-max_ppl') }}</span>
                                @endif
                            </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group row {{ $errors->has('add-house-description') ? 'has-error' : '' }}">
                        <label for="add-house-description" class="col-sm-2 col-form-label"> Description </label>
                        <div class="col-sm-12">
                            <textarea class="form-control form-textarea" id="add-house-description" name="add-house-description" rows="4">{{ old('add-house-description') }}</textarea>
                            @if($errors->has('add-house-description'))
                                    <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-house-description') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Image -->
                    <!-- <div class="form-group row">
                      <label for="add-file" class="col-sm-2"> Image </label>
                      <div class="col-sm-12 text-right">
                        <div class="input-group control-group increment">
                          <input type="file" name="add-file" id="add-file" class="form-control form-control-file" multiple/>
                          <div class="input-group-btn">
                            <button class="btn btn-success" type="button"><i class="far fa-image"></i>Add</button>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <div class="col-sm-12" id="preview-area">
                            <div class="text-center">
                                <label> Preview </label>
                                <br>
                                <img class="img-responsive center-block" id="preview" src="#">
                                <script type="text/javascript">
                                    $(document).ready(function() {
                                      $(".btn-success").click(function(){
                                          var html = $(".clone").html();
                                          $(".increment").after(html);
                                      });

                                      $("body").on("click",".btn-danger",function(){
                                          $(this).parents(".control-group").remove();
                                      });

                                      $("#add-file").on("change", function() {

                                        $('#preview').html("");
                                        var total_file=document.getElementById("add-file").files.length;
                                        for(var i=0;i<total_file;i++)
                                        {
                                         $('#preview').append("<img src='"+URL.createObjectURL(event.target.files[i])+"'>");
                                        }
                                      });
                                    });
                                </script>
                            </div>
                        </div>
                    </div>

                      <div class="clone hide">
                        <div class="control-group input-group" style="margin-top:10px">
                          <input type="file" name="add-file" class="form-control">
                          <div class="input-group-btn">
                            <button class="btn btn-danger" type="button"><i class="far fa-image"></i> Remove</button>
                          </div>
                        </div>
                      </div>
                    </div> -->

                  </div>






                    </div>

                    <!-- submit button -->
                    <div class="row text-center">
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
