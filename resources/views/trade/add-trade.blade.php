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
    <form id="add-trade-form" method="POST" enctype="multipart/form-data" action="{{ route('addtrade-form')}}">
        {{ csrf_field() }}
        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Add New Trade Item</h4>
                </div>
                <div class="panel-body-edit">

                    <!-- Title -->
                    <div class="form-group row {{ $errors->has('add-trade-title') ? 'has-error' : '' }}">
                        <label for="add-trade-title" class="col-sm-2 col-form-label"> Title </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="add-trade-title" name="add-trade-title" value="{{ old('add-trade-title') }}">
                            @if($errors->has('add-trade-title'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade-title') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="form-group row {{ $errors->has('add-trade-price') ? 'has-error' : '' }}">
                        <label for="add-trade-price" class="col-sm-3 col-form-label"> Price </label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="add-trade-price" name="add-trade-price" value="{{ old('add-trade-price') }}">
                            @if($errors->has('add-trade-price'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade-price') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Quantity-->
                    <div class="form-group row {{ $errors->has('add-trade-quantity') ? 'has-error' : '' }}">
                        <label for="add-trade-quantity" class="col-sm-3 col-form-label">Quantity</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="add-trade-quantity" name="add-trade-quantity" step=1 value="{{ old('add-trade-quantity') }}">
                                @if($errors->has('add-trade-quantity'))
                                    <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade-quantity') }}</span>
                                @endif
                            </div>
                    </div>

                    <!-- Trade Category ID  -->
                     <div class="form-group row {{ $errors->has('add-trade-trade_category_id') ? 'has-error' : '' }}">
                        <label for="add-trade-trade_category_id" class="col-sm-3 col-form-label"> Category </label>
                        <div class="col-sm-9">
                            <select class="form-control" id="add-trade-trade_category_id" name="add-trade-trade_category_id" value="{{ old('add-trade-trade_category_id')}}">
                                <option value="" selected disabled hidden> Please Select </option>
                                @foreach($trade_categories as $trade_category)
                                    <option value="{{ $trade_category->id }}">{{ $trade_category->category }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('add-trade-trade_category_id'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade-trade_category_id') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Trade Condition Type -->
                    <div class="form-group row {{ $errors->has('add-trade-trade_condition_type_id') ? 'has-error' : '' }}">
                       <label for="add-trade-trade_condition_type_id" class="col-sm-3 col-form-label"> Condition Type </label>
                       <div class="col-sm-9">
                           <select class="form-control" id="add-trade-trade_condition_type_id" name="add-trade-trade_condition_type_id" value="{{ old('add-trade-trade_condition_type_id')}}">
                               <option value="" selected disabled hidden> Please Select </option>
                               @foreach($trade_conditions as $trade_condition)
                                   <option value="{{ $trade_condition->id }}">{{ $trade_condition->type }}</option>
                               @endforeach
                           </select>
                           @if($errors->has('add-trade-trade_condition_type_id'))
                               <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade-trade_condition_type_id') }}</span>
                           @endif
                       </div>
                   </div>

                    <!-- Status: need to select -->
                     <div class="form-group row {{ $errors->has('add-trade-status') ? 'has-error' : '' }}">
                        <label for="add-trade-status" class="col-sm-3 col-form-label"> Status </label>
                        <div class="col-sm-9">
                            <select class="form-control" id="add-trade-status" name="add-trade-status" value="{{ old('add-trade-status')}}">
                                <option value="" selected disabled hidden> Please Select </option>
                                @foreach($trade_statuses as $trade_status)
                                    <option value="{{ $trade_status ->id }}">{{ $trade_status->status }}</option>
                                @endforeach
                            </select>
                            @if($errors->has('add-trade-status'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade-status') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-group row {{ $errors->has('add-trade-description') ? 'has-error' : '' }}">
                        <label for="add-trade-description" class="col-sm-2 col-form-label">Description </label>
                        <div class="col-sm-12">
                            <textarea class="form-control form-textarea" id="add-trade-description" name="add-trade-description" rows="4">{{ old('add-trade-description') }}</textarea>
                            @if($errors->has('add-trade-description'))
                                    <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade-description') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- multiple images -->
                    <div class="form-group row {{ $errors->has('add-trade-images') ? 'has-error' : '' }}">
                        <label for="add-trade-images" class="col-sm-2 col-form-label"> Images </label><hr>
                        <div class="input-group control-group increment" >
                          <input type="file" name="filename[]" class="form-control">
                          <div class="input-group-btn">
                            <button class="btn" type="button"><i class="glyphicon glyphicon-plus"></i>Add</button>
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

                    <!-- submit button -->
                    <div class="row text-center">
                        <button type="submit" class="btn form-btn" id="add-trade-submit">Submit</button>
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

      $(".btn").click(function(){ 
          var html = $(".clone").html();
          $(".increment").after(html);
      });

      $("body").on("click",".btn-danger",function(){
          $(this).parents(".control-group").remove();
      });

    });

</script>
@endpush
