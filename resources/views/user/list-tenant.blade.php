@extends('layouts.user-app')

@section('content')
<div class="container before-nav">
    <div class="row">
        <form  class="form-horizontal"  action="{{ url('/tenant/search')}}" method="GET" id='tenant-search'>
            <div class="panel panel-default col-md-12">
                <div class="panel-body">
                    <input class="form-control" type="search" name="search" placeholder="{{ $searchPhrase ?? 'Search' }}">
                    	<div class="text-right">Search</div>
                </div>
            </div>
        </form>
    </div>

    <div class="row">
		<div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
            <div class="panel-body">
                <h3>Tenants</h3>
                <table class="table table-striped table-hover ">
                    <thead>
                        <tr>
                        	<th>ID</th>
                          <th>Username</th>
                          <th>Name</th>
                          <th>Email</th>
                          <th>View More</th>
                        </tr>
                    </thead>

                    @foreach ($tenants as $tenant)
                        <tbody>

                            <th>{{ $tenant->id }}</th>
                            <th>{{ $tenant->username }}</th>
                            <th>{{ $tenant->name }}</th>
                            <th>{{ $tenant->email }}</th>
                            <td><a href="{{ route('user-view', $tenant->id) }}">details</a></td>
                        </tbody>
                     @endforeach

				</table>
                <div>
                    {{ $tenants->links() }}
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
