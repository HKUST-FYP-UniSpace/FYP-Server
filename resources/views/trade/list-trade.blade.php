


@extends('layouts.app')

@section('content')
<div class="container before-nav">


    <div class="row">
        <form  class="form-horizontal"  action="{{ url('/user/search')}}" method="GET" id='user-search'>
            <div class="panel panel-default col-md-12">
                <div class="panel-body">
                    <input class="form-control" type="search" name="search" placeholder="{{ $searchPhrase ?? 'Search' }}">
                        <div class="text-right">Search</div>
                </div>  
            </div>         
        </form>
    
    </div>

    <div class="row">
        
        <a href=""><button class="btn btn-default add-new-item">New Item</button></a>
        
       
    </div>

    <div>
        <nav aria-label="Page navigation example">
          <ul class="pagination justify-content-center">
            <li class="page-item disabled">
              <a class="page-link" href="#" tabindex="-1">Previous</a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>
    </div>

   
    <div class="row">
        <div class="panel panel-default col-md-12">
            <div class="panel-body">
                <h3>Trade List</h3>
                <hr>
                
                <table class="table" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Price</th>
                            <th>Description</th>
                            <th>Quantity</th>
                            <th>Post Date</th>
                            <th>Status</th>
                            <th>View More</th>

                        </tr>
                    </thead>
                    <tbody>
                            <th>1</th>
                            <th>Chair</th>
                            <th>$30</th>
                            <th>90% new</th>
                            <th>1</th>
                            <th>2019.1.1</th>
                            <th>Available</th>
                            <td><a href="{{ route('trade-view') }}">details</a></td>

                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</div>
@endsection

<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/select.js') }}"></script>
@endpush
