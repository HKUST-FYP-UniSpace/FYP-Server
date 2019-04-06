@extends('layouts.app')

<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Edit Trade </h4>
                </div>
                <div class="panel-body text-center">
                    <div class="row" style="padding-top: 5px;">
                        <h5>Edit Success!!!</h5>
                    </div>
                    <div class="row">
                        <a href="{{ route('trade-view', ['id'=>$id])}}" class="btn  form-btn" > Back to Trade Details</a>
                    </div>
                </div>
            </div>
        </div>
</div>
@endsection
