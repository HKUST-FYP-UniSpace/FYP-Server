@extends('layouts.select-app')


@section('content')
<div class="container before-nav">
  <div class="col-md-10 col-md-offset-1">
    <div class="panel">

        <div class="form-group row">
          <div class="col-sm-12" style="padding-bottom: 15px; left: 2%;">
              <i class="fas fa-plus" style=" padding-right: 5px;"></i><input id="myButton" type="button" class="btn btn-default" value="Add selection choice"/>
              <!-- onclick show new div with add function -->
              <div id="myDiv" style="display:none; padding-top:30px;" class="answer_list" >
                <!-- New trade_condition -->
                <form id="add-trade_condition" method="POST" action="{{ route('trade_condition-add')}}">
                  {{ csrf_field() }}
                  <div class="form-group row {{ $errors->has('add-trade_condition') ? 'has-error' : '' }}">
                      <label for="add-trade_condition" class="col-sm-3"> New Trade Condition Type</label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" id="add-trade_condition" name="add-trade_condition" value="{{ old('add-trade_condition') }}">
                          @if($errors->has('add-trade_condition'))
                              <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade_condition') }}</span>
                          @endif
                      </div>
                      <!-- submit button -->
                      <button type="submit" class="btn  form-btn" id="add-blog-submit" class="row text-center"> Add and Refesh List </button>
                  </div>
                </form>
              </div>

              <script>
              $('#myButton').click(function() {
                $('#myDiv').toggle('fast', function() {
                });
              });
              </script>
          </div>

          <div class="col-md-10 col-md-offset-1"  id="select-trade_condition">
              <div class="panel" style="padding-left:10%; padding-right:10%;">
                  <div class="panel-body">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Trade Condition Type</th>
                              </tr>
                          </thead>
                          @foreach ($trade_conditions as $trade_condition)
                              <tbody>
                                  <th>{{ $trade_condition->id }}</th>
                                  <th>{{ $trade_condition->type }}</th>
                           @endforeach

                      </table>
                  </div>
              </div>
          </div>
        </div>
    </div>
  </div>
</div>

@endsection
