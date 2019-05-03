@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <form id="edit-trade-form" enctype="multipart/form-data" method="POST" action="{{ route('trade-edit-form', $trade->id) }}">
        {{ csrf_field() }}


        <div class="col-md-8 col-md-offset-2">  <!--price of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Edit Trade</h4>
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

                    <!-- Name  -->
                    <div class="form-group row">
                        <dt for="edit-trade-title" class="col-sm-9" style="padding-left:30px"> Title</dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-trade-title" name="edit-trade-title" value="{{ isset($trade) ? old('edit-trade-title', $trade->title) : old('edit-trade-title') }}">
                        </dd>
                    </div>

                    <!-- Price -->
                    <div class="form-group row">
                        <dt for="edit-trade-price" class="col-sm-9" style="padding-left:30px"> Price </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-trade-price" name="edit-trade-price" value="{{ isset($trade) ? old('edit-trade-price', $trade->price) : old('edit-trade-price') }}">
                        </dd>
                    </div>

                    <!-- Quantity -->
                    <div class="form-group row">
                        <dt for="edit-trade-quantity" class="col-sm-9" style="padding-left:30px"> Quantity </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-trade-quantity" name="edit-trade-quantity" value="{{ isset($trade) ? old('edit-trade-quantity', $trade->quantity) : old('edit-trade-quantity') }}">
                        </dd>
                    </div>

                    <!-- Trade Category ID  -->
                    <div class="form-group row">
                        <dt for="edit-trade-trade_category_id" class="col-sm-9" style="padding-left:30px">  Category </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <select class="form-control" id="edit-trade-trade_category_id" name="edit-trade-trade_category_id" value="{{  isset($trade) ? old('edit-trade-trade_category_id', $trade->trade_category_id) : old('edit-trade-trade_category_id')}}">
                                <option value="" selected disabled hidden> Please Select </option>
                                @foreach($trade_categories as $trade_category)
                                    <option value="{{ $trade_category->id}}">{{ $trade_category->category }}</option>
                                @endforeach
                            </select>
                        </dd>
                    </div>

                    <!-- Trade Condition Type -->
                    <div class="form-group row">
                        <dt for="edit-trade-trade_condition_type_id" class="col-sm-9" style="padding-left:30px"> Condition Type </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <select class="form-control" id="edit-trade-trade_condition_type_id" name="edit-trade-trade_condition_type_id" value="{{ isset($trade) ? old('edit-trade-trade_condition_type_id', $trade->trade_condition_type_id) : old('edit-trade-trade_condition_type_id') }}">
                              <option value="" selected disabled hidden> Please Select </option>
                              @foreach($trade_conditions as $trade_condition)
                                  <option value="{{ $trade_condition->id }}">{{ $trade_condition->type }}</option>
                              @endforeach
                            </select>
                        </dd>
                    </div>

                    <!-- Status -->
                    <div class="form-group row">
                        <dt for="edit-trade-trade_status_id" class="col-sm-9" style="padding-left:30px"> Status </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                          <select class="form-control" id="edit-trade-trade_status_id" name="edit-trade-trade_status_id" value="{{ old('edit-trade-trade_status_id')}}">
                              <option value="" selected disabled hidden> Please Select </option>
                              @foreach($trade_statuses as $trade_status)
                                  <option value="{{ $trade_status->id }}">{{ $trade_status->status }}</option>
                              @endforeach
                          </select>
                        </dd>
                    </div>

                    <!-- trade District ID: need to select -->
                    <div class="form-group row">
                        <dt for="edit-trade-district_id" class="col-sm-9" style="padding-left:30px"> Trade District </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                          <select class="form-control" id="edit-trade-district_id" name="edit-trade-district_id" value="{{  isset($trade) ? old('edit-trade-district_id', $trade->district_id) : old('edit-trade-district_id')}}">
                              <option value="" selected disabled hidden> Please Select </option>
                              @foreach($trade_districts as $trade_district)
                                  <option value="{{ $trade_district ->id }}">{{ $trade_district->name }}</option>
                              @endforeach
                          </select>
                        </dd>
                    </div>

                    <!-- Description  -->
                    <div class="form-group row">
                        <dt for="edit-trade-description" class="col-sm-9" style="padding-left:30px"> Description </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <textarea class="form-control" id="edit-trade-description" name="edit-trade-description" placeholder="Write something.." style="height:100px" value="{{ isset($trade) ? old('edit-trade-description', $trade->description) : old('edit-trade-description') }}">{{$trade->description}}</textarea>
                        </dd>
                    </div>


                    <!-- Images -->
                    <div class="form-group row">
                        <label for="edit-file" class="col-sm-12">Trade images</label>
                        @foreach($trade_imgIDs as $trade_imgID)
                        <div class="col-sm-6" style="padding-left:30px; padding-bottom: 10px;font-size:15px;"><img src="{{ $trade_imgID["image_url"] }}" style="height: 200px;"></div>

                        <div class="row" style="padding-left: 90%;font-size:15px;">
                          <form method="POST" action="{{ route('tradeimage-delete', $trade_imgID["id"]) }}">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <a><button type="submit" class="btn-danger" onclick="return confirm('Are you sure to delete {{ $trade_imgID["image_url"] }}?')"> Delete </button></a>
                          </form>
                        </div>

                        @endforeach

                      <div class="col-sm-12" style="padding-bottom: 15px; left: 2%;">
                        <i class="fas fa-plus" style=" padding-right: 5px;"></i><input id="myButton" type="button" class="btn btn-default" value="Add New Images"/>
                          <div id="myDiv" style="display:none; padding-top:30px;">
                            <div class="input-group control-group increment" >
                              <input type="file" name="filename[]" class="form-control">
                              <div class="input-group-btn">
                                <button class="btn add" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
                              </div>
                            </div>
                            <div class="clone hide">
                            <div class="control-group input-group" style="margin-top:10px">
                              <input type="file" name="filename[]" class="form-control">
                              <div class="input-group-btn">
                                <button class="btn btn-danger" type="button"><i class="glyphicon glyphicon-remove"></i> Remove </button>
                              </div>
                            </div>
                          </div>
                          </div>
                        </div>
                    </div>
                    </div>

                    <!-- edit button -->
                    <div class="row text-center">
                        <button type="submit" class="btn form-btn" id="edit-trade-submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>


    </form>
</div>
@endsection


<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
<script type="text/javascript">
$(document).ready(function() {
  $('#myButton').click(function() {
    $('#myDiv').toggle('fast', function() {
    });
  });
$(".add").click(function(){
    var html = $(".clone").html();
    $(".increment").after(html);
});

$("body").on("click",".btn-danger",function(){
    $(this).parents(".control-group").remove();
});
});
</script>
@endpush
