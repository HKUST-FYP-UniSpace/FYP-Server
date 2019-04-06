@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <form id="edit-trade-form" method="POST" action="{{ route('trade-edit-form', $trade->id) }}">
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

                    <div class="form-group row">
                        <dt for="edit-trade-price" class="col-sm-9" style="padding-left:30px"> Price </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-trade-price" name="edit-trade-price" value="{{ isset($trade) ? old('edit-trade-price', $trade->price) : old('edit-trade-price') }}">
                        </dd>
                    </div>

                    <div class="form-group row">
                        <dt for="edit-trade-quantity" class="col-sm-9" style="padding-left:30px"> Quantity </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-trade-quantity" name="edit-trade-quantity" value="{{ isset($trade) ? old('edit-trade-quantity', $trade->quantity) : old('edit-trade-quantity') }}">
                        </dd>
                    </div>

                    <!-- <div class="form-group row">
                        <dt for="edit-trade-trade_transaction_id" class="col-sm-9" style="padding-left:30px"> Trade Transaction ID </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <input type="text" class="form-control" id="edit-trade-trade_transaction_id" name="edit-trade-trade_transaction_id" value="{{ isset($trade) ? old('edit-trade-trade_transaction_id', $trade->trade_transaction_id) : old('edit-trade-trade_transaction_id') }}">
                        </dd>
                    </div> -->

                    <div class="form-group row">
                        <dt for="edit-trade-trade_category_id" class="col-sm-9" style="padding-left:30px"> Trade Category ID </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <select class="form-control" id="edit-trade-trade_category_id" name="edit-trade-trade_category_id" value="{{ isset($trade) ? old('edit-trade-trade_category_id', $trade->trade_category_id) : old('edit-trade-trade_category_id') }}">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </dd>

                    </div>
                    <div class="form-group row">
                        <dt for="edit-trade-trade_condition_type_id" class="col-sm-9" style="padding-left:30px"> Trade Condition Type ID </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <select class="form-control" id="edit-trade-trade_condition_type_id" name="edit-trade-trade_condition_type_id" value="{{ isset($trade) ? old('edit-trade-trade_condition_type_id', $trade->trade_condition_type_id) : old('edit-trade-trade_condition_type_id') }}">
                                <option>1</option>
                                <option>2</option>
                            </select>
                        </dd>
                    </div>
                    <div class="form-group row">
                        <dt for="edit-trade-trade_status_id" class="col-sm-9" style="padding-left:30px"> Status </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                          <select class="form-control" id="edit-trade-trade_status_id" name="edit-trade-trade_status_id" value="{{ old('edit-trade-trade_status_id')}}">
                              <option value="" selected disabled hidden> Please Select </option>
                              @foreach($trade_statuses as $trade_status)
                                  <option value="{{ $trade_status ->id }}">{{ $trade_status->status }}</option>
                              @endforeach
                          </select>
                        </dd>
                    </div>

                    <div class="form-group row">
                        <dt for="edit-trade-description" class="col-sm-9" style="padding-left:30px">trade Description </dt>
                        <dd  class="col-sm-12" style="padding-left:30px; padding-right:30px">
                            <textarea class="form-control" id="edit-trade-description" name="edit-trade-description" placeholder="Write something.." style="height:200px" value="{{ isset($trade) ? old('edit-trade-description', $trade->description) : old('edit-trade-description') }}">{{$trade->description}}</textarea>
                        </dd>
                    </div>

                    <!-- edit button -->
                    <div class="row text-center" style="padding-left:49%">
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
    <script src="{{ asset('/js/select.js') }}"></script>
@endpush
