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
                <!-- New preference_item_category -->
                <form id="add-preference_item_category" method="POST" action="{{ route('preference_item_category-add')}}">
                  {{ csrf_field() }}
                  <div class="form-group row {{ $errors->has('add-preference_item_category') ? 'has-error' : '' }}">
                      <label for="add-preference_item_category" class="col-sm-3"> New Preference Category </label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" id="add-preference_item_category" name="add-preference_item_category" value="{{ old('add-preference_item_category') }}">
                          @if($errors->has('add-preference_item_category'))
                              <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-preference_item_category') }}</span>
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

          <div class="col-md-10 col-md-offset-1"  id="select-preference_item_category">
              <div class="panel" style="padding-left:10%; padding-right:10%;">
                  <div class="panel-body">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th> New Preference Category </th>
                              </tr>
                          </thead>
                          @foreach ($preference_item_categorys as $preference_item_category)
                              <tbody>
                                  <th>{{ $preference_item_category->id }}</th>
                                  <th>{{ $preference_item_category->category }}</th>
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
