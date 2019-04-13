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
                <!-- New trade_category -->
                <form id="add-trade_category" method="POST" action="{{ route('trade_category-add')}}">
                  {{ csrf_field() }}
                  <div class="form-group row {{ $errors->has('add-trade_category') ? 'has-error' : '' }}">
                      <label for="add-trade_category" class="col-sm-3"> New Trade Category </label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" id="add-trade_category" name="add-trade_category" value="{{ old('add-trade_category') }}">
                          @if($errors->has('add-trade_category'))
                              <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-trade_category') }}</span>
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

          <div class="col-md-10 col-md-offset-1"  id="select-trade_category">
              <div class="panel" style="padding-left:10%; padding-right:10%;">
                  <div class="panel-body">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th>Trade Category</th>
                              </tr>
                          </thead>
                          @foreach ($trade_categorys as $trade_category)
                              <tbody>
                                  <th>{{ $trade_category->id }}</th>
                                  <th>{{ $trade_category->category }}</th>
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
