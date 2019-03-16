@extends('layouts.app')

@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div id="trade-view">
        {{ csrf_field() }}

        <div class="col-md-8 col-md-offset-2">      
            <a href=""><button class="btn btn-default add-new-item">Edit</button></a>
        </div>
        
        <div class="col-md-8 col-md-offset-2">  <!--size of form box -->
            <div class="panel panel-default"> <!-- border+background -->
                <div class="panel-heading text-center">
                    <h4 class="title text-muted">Trade Item</h4>
                </div>
                <div class="panel-body-edit">
                    <!-- Item Image  -->
                    <div class="form-group row">
                        <label for="view-file" class="col-sm-2">Item ID </label>
                        <div class="col-sm-10">
                            
                        </div>
                            
                    </div>
                    <!-- Item Name  -->
                    <div class="form-group row">
                        <label class="col-sm-2 col-form-label">Item Name</label>
                        <div class="col-sm-10">
                          
                        </div>
                    </div>

                    <!-- Price-->
                    <div class="form-group row">
                        <label for="view-end-date" class="col-sm-2 col-form-label">Price</label>
                        <div class="col-sm-4">

                        </div>
                    </div>


                    <!-- Post Date-->
                    <div class="form-group row">
                        <label for="view-start-date" class="col-sm-2 col-form-label">Post Date</label>
                        <div class="col-sm-4">
                        	
                        </div>
                    </div>

                    <!-- Description-->
                    <div class="form-group row">
                        <label for="view-start-date" class="col-sm-2 col-form-label">Description</label>
                        <div class="col-sm-4">
                        	
                        </div>
                    </div>

                     <!-- Quantity-->
                    <div class="form-group row">
                        <label for="view-start-date" class="col-sm-2 col-form-label">Quantity</label>
                        <div class="col-sm-4">
                        	
                        </div>
                    </div>

                     <!-- Status-->
                    <div class="form-group row">
                        <label for="view-start-date" class="col-sm-2 col-form-label">Status</label>
                        <div class="col-sm-4">
                        	
                        </div>
                    </div>

                     <!-- User ID-->
                    <div class="form-group row">
                        <label for="view-start-date" class="col-sm-2 col-form-label">User ID</label>
                        <div class="col-sm-4">
                        	
                        </div>
                    </div>                         

                    <!-- edit button -->
				 	<a href="{{ url('/trade') }}">
						<button type="button" class="btn btn-primary btn-lg btn-block">Back</button>
				    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/select.js') }}"></script>
@endpush