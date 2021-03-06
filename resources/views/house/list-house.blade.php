@extends('layouts.app')

@section('content')
<div class="container before-nav">
    <div class="row">
        <form  class="form-horizontal"  action="{{ url('/house/search')}}" method="GET" id='house-search'>
            <div class="panel panel-default col-md-12">
                <div class="panel-body">
                    <input class="form-control" type="search" name="search" placeholder="{{ $searchPhrase ?? 'Search by ID/title/subtitle/size/price/owner ID' }}">
                        <div class="text-right">Search</div>
                </div>
            </div>
        </form>

    </div>

    <div class="row">
        <a href="{{ route('house-add') }}">
        <button class="btn btn-default" style="float: right">Add New Apartment</button></a>
    </div>

    <div class="row">
        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
            <div class="panel-body">
                <h3 >Apartment List</h3>
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
                            <th>Price(HKD)</th>
                            <th>Status</th>
                            <th>Owner ID</th>
                            <th>Maximum People</th>
                            <th>View Details</th>
                            <th>Apartment Comments</th>
                            <th>Delete Apartment </th>

                        </tr>
                    </thead>
                    @foreach ($houses as $house)
                        <tbody>

                            <th>{{ $house->id }}</th>
                            <th>{{ $house->title }}</th>
                            <th>{{ $house->subtitle }}</th>
                            <th>{{ $house->address }}</th>

                            @if ($house->type == "0") <th>{{ "Flat" }}</th>
                            @elseif ($house->type == "1") <th>{{ "Cottage" }}</th>
                            @elseif ($house->type == "2") <th>{{ "Detached" }}</th>
                            @else <th>{{ "Sub-divided" }}</th>
                            @endif

                            <th>{{ $house->size }}sq.ft.</th>
                            <th>${{ $house->price }}</th>

                            @if ($house->status == "1") <th>{{ "Hide" }}</th>
                            @elseif ($house->status == "2") <th>{{ "Reveal" }}</th>
                            @elseif ($house->status == "3") <th>{{ "Archive" }}</th>
                            @else <th>{{ "Rent" }}</th>
                            @endif

                            <th>{{ $house->owner_id }}</th>
                            <th>{{ $house->max_ppl }}</th>
                            <td><a href="{{ route('house-view', $house->id) }}">details</a></td>
                            <td><a href="{{ route('house-comment', $house->id) }}">show comments</a></td>
                            @if($house->is_deleted == 0)
                            <td>
                                <form method="POST" action="{{ route('house-delete', $house->id) }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <a><button type="submit" class="btn-danger" onclick="return confirm('Are you sure to delete this apartment?')"> Delete </button></a>
                                </form>
                            </td>
                            @else
                            <td>
                                <form method="POST" action="{{ route('house-undelete', $house->id) }}">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <a><button type="submit" class="btn-primary" onclick="return confirm('Are you sure to undelete this apartment?')"> Undelete </button></a>
                                </form>
                            </td>
                            @endif
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
