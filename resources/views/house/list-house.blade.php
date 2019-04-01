@extends('layouts.app')

@section('content')
<div class="container before-nav">
    <div class="row">
        <form  class="form-horizontal"  action="{{ url('/house/search')}}" method="GET" id='house-search'>
            <div class="panel panel-default col-md-12">
                <div class="panel-body">
                    <input class="form-control" type="search" name="search" placeholder="{{ $searchPhrase ?? 'Search' }}">
                        <div class="text-right">Search</div>
                </div>
            </div>
        </form>

    </div>

    <div class="row">
        <a href="{{ route('house-add') }}">
        <button class="btn btn-default add-new-item">Add New Apartment</button></a>
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
                            <th>Title</th>
                            <th>Subtitle</th>
                            <th>Address</th>
                            <th>Type</th>
                            <th>Size</th>
                            <th>Price</th>
                            <th>Maximum People</th>
                            <th>Status</th>
                            <th>Owner</th>
                            <th>View Details</th>
                            <th>Apartment Comments</th>

                        </tr>
                    </thead>
                    @foreach ($houses as $house)
                        <tbody>

                            <th>{{ $house->id }}</th>
                            <th>{{ $house->title }}</th>
                            <th>{{ $house->subtitle }}</th>
                            <th>{{ $house->address }}</th>
                            <th>{{ $house->type }}</th>
                            <th>{{ $house->size }}</th>
                            <th>{{ $house->price }}</th>
                            <th>{{ $house->max_ppl }}</th>
                            <th>{{ $house->status }}</th>
                            <th>{{ $house->owner_id }}</th>
                            <td><a href="{{ route('house-view', $house->id) }}">details</a></td>
                            <td><a href="{{ route('house-comment', $house->id) }}">show comments</a></td>
                        </tbody>
                     @endforeach

                </table>
                <div>
                    {{ $houses->links() }}
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
