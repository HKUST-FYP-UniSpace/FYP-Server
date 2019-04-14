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
                <!-- New preference_item -->
                <form id="add-preference_item" method="POST" action="{{ route('preference_item-add')}}">
                  {{ csrf_field() }}
                  <div class="form-group row {{ $errors->has('add-preference_item') ? 'has-error' : '' }}">
                      <label for="add-preference_item" class="col-sm-2"> New Preference </label>
                      <div class="col-sm-5">
                          <input type="text" class="form-control" id="add-preference_item" name="add-preference_item" value="{{ old('add-preference_item') }}">
                          @if($errors->has('add-preference_item'))
                              <span class="label-error"><i class="fa fa-times"></i> {{ $errors->first('add-preference_item') }}</span>
                          @endif
                      </div>
                  </div>

                      <!--  Category ID  -->
                      <div class="form-group row {{ $errors->has('add-preference_item_category') ? 'has-error' : '' }}">
                        <label for="add-preference_item" class="col-sm-3"> Preference Category </label>
                          <div class="col-sm-5">
                              <select class="form-control" id="add-preference_item_category" name="add-preference_item_category" value="{{  old('add-preference_item_category')}}">
                                <option value="" selected disabled hidden> Select </option>
                                @foreach($preference_item_categorys as $preference_item_category)
                                    <option value="{{ $preference_item_category->id }}">{{ $preference_item_category->category }}</option>
                                @endforeach
                              </select>
                          </div>
                            <button type="submit" class="btn  form-btn" id="add-blog-submit" class="row text-center"> Add and Refesh List </button>
                      </div>
                      <!-- submit button -->

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

          <div class="col-md-10 col-md-offset-1"  id="select-preference_item">
              <div class="panel">
                  <div class="panel-body">
                      <table class="table">
                          <thead>
                              <tr>
                                  <th>ID</th>
                                  <th> Preference </th>
                                  <th> Preference Category </th>
                                  <th> Edit Category </th>
                                  <th> Change and Refresh </th>
                              </tr>
                          </thead>
                          @foreach ($preference_items as $preference_item)
                              <tbody>
                                  <th>{{ $preference_item->id }}</th>
                                  <th>{{ $preference_item->name }}</th>
                                  <th>{{ $preference_item->category }}</th>
                                  <!-- Trade Category ID  -->
                                  <form id="edit-preference_item-form" method="POST" enctype="multipart/form-data" action="{{ route('edit-preference_item', $preference_item->id) }}">
                                      {{ csrf_field() }}
                                  <th><div class="form-group row">
                                      <div class="col-sm-12">
                                          <select class="form-control" id="edit-preference_item" name="edit-preference_item" value="{{ old('edit-preference_item')}}">
                                              <option value="" selected disabled hidden> Select </option>
                                              @foreach($preference_item_categorys as $preference_item_category)
                                                  <option value="{{ $preference_item_category->id }}">{{ $preference_item_category->category }}</option>
                                              @endforeach
                                          </select>
                                      </div>
                                  </div>
                                </th>
                                  <!-- edit button -->
                                  <th><button type="submit" class="btn form-btn" id="edit-trade-submit">Change and Refresh</button></th>
                                </form>




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
