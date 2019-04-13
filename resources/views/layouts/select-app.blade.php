@extends('layouts.app')


@section('selectionTypes')
<div class="container before-nav">
    <div class="row">
      <h3> Selection Management </h3>
      <hr>
    </div>

    <div class="col-md-12">
		<div class="panel">
        <div class="panel-body">
          <ul class="nav nav-tabs">
              <ul class="nav nav-tabs" style=" font-size: 17px;">
                <li class="nav-item"><a  class="nav-link" href="{{ url('select/district')}}"> Apartment Districts </a></li>
                <li class="nav-item"><a class="nav-link" href="{{ url('select/trade_category')}}"> Trade Category </a></li>
                <li class="nav-item"><a id="trade_condition" class="nav-link"  href="{{ url('select/trade_condition') }}">Trade Condition Type </a></li>
                <li class="nav-item"><a class="nav-link"  href="{{ url('/select/preference_item') }}"> Preference Item </a></li>
                <li class="nav-item"><a  class="nav-link"  href="{{ url('select/preference_item_category')}}">Preference Item Category </a></li>
              </ul>
        </div>
    </div>
  </div>
</div>
@endsection
