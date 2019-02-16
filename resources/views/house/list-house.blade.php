


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
        
        <a href=""><button class="btn btn-default add-new-item">New Apartment</button></a>
        
       
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
                <h3>Apartment List</h3>
                <hr>
                
                <table class="table" >
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Address</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Maximum People</th>
                            <th>Status</th>
                            <th>Owner</th>
                            <th>View More</th>

                        </tr>
                    </thead>
                    <tbody>
                            <th>1</th>
                            <th>Tsuen Wan</th>
                            <th>House</th>
                            <th>400</th>
                            <th>10000</th>
                            <th>5</th>
                            <th>Available</th>
                            <th>HKUST</th>
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
