@extends('layouts.app')

@section('content')
<div class="container before-nav">
    <div class="row">
        <form  class="form-horizontal"  action="{{ url('/trade/search')}}" method="GET" id='trade-search'>
            <div class="panel panel-default col-md-12">
                <div class="panel-body">
                    <input class="form-control" type="search" name="search" placeholder="{{ $searchPhrase ?? 'Search' }}">
                        <div class="text-right">Search</div>
                </div>
            </div>
        </form>

    </div>

    <div class="row">
        <a href="{{ route('trade-add') }}">
        <button class="btn btn-default" style="float: right">Add New Trade Item</button></a>
    </div>

    <div class="row" >
        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
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
                            <th>View More</th>
                            <th>Delete Item</th>

                        </tr>
                    </thead>
                    @foreach ($trades as $trade)
                        <tbody>

                            <th>{{ $trade->id }}</th>
                            <th>{{ $trade->title }}</th>
                            <th>{{ $trade->price }}</th>
                            <th>{{ $trade->description }}</th>
                            <th>{{ $trade->quantity }}</th>
                            <th>{{ $trade->created_at }}</th>
                            <td><a href="{{ route('trade-view', $trade->id) }}">details</a></td>
                            @if($trade->is_deleted == 0)
                            <td>
                                <form method="POST" action="{{ route('trade-delete', $trade->id) }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <a><button type="submit" class="btn-danger submit-delete" onclick="return confirm('Are you sure to delete this item?')"> Delete </button></a>
                                </form>
                            </td>
                            @endif
                        </tbody>
                     @endforeach
                </table>
                <div>
                    {{ $trades->links() }}
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
