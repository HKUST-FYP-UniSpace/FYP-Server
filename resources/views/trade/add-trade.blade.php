@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <form id="add-trade-form" method="POST" action="{{ route('trade-add-form')}}">
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
                        <label for="add-trade-price" class="col-sm-2 col-form-label"> Price </label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="add-trade-price" name="add-trade-price" value="{{ old('add-trade-price') }}">
                            @if($errors->has('add-trade-price'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade-price') }}</span>
                            @endif
                        </div>
                    </div>



                    <!-- Post Date -->
                    <div class="form-group row {{ $errors->has('add-trade-post_date') ? 'has-error' : '' }}" id="add-trade-post_date">
                        <label for="add-trade-post_date" class="col-sm-2 col-form-label">Post Date</label>
                        <div class="col-sm-4">
                            <input type="date" class="form-control" id="add-trade-post_date" name="add-trade-post_date" placeholder="YYYY-MM-DD" value="{{ old('add-trade-post_date') }}">
                            @if($errors->has('add-trade-post_date'))
                                <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade-post_date') }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Quantity-->
                    <div class="form-group row {{ $errors->has('add-trade-quantity') ? 'has-error' : '' }}">
                        <label for="add-trade-quantity" class="col-sm-2 col-form-label">Quantity</label>
                            <div class="col-sm-4">
                                <input type="number" class="form-control" id="add-trade-quantity" name="add-trade-quantity" step=1 value="{{ old('add-trade-quantity') }}">
                                @if($errors->has('add-trade-quantity'))
                                    <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade-quantity') }}</span>
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

                    <!-- submit button -->
                    <div class="row text-center">
                        <button type="submit" class="btn  form-btn" id="add-trade-submit">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection


<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/trade/add.js') }}"></script>
@endpush
