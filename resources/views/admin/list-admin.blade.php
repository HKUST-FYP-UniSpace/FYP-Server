@extends('layouts.app')


<!-- css style (name corresponds to app.blade.php) -->
@push('add-style')
    <link href="{{ asset('css/form.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container before-nav">
    <div class="row">
        <div class="panel panel-default col-md-12" style="border-color: white; padding-left:10%; padding-right:10%;">
            <div class="panel-body">
                <h3>Admin List</h3>
                <hr>
                <table class="table" >
                    <thead>
                        <tr>
                            <th>Admin ID</th>
                            <th>Name</th>
                            <th>Email</th>

                        </tr>
                    </thead>
                    @foreach ($admins as $admin)
                        <tbody>
                            <th>{{ $admin->id }}</th>
                            <th>{{ $admin->name}}</th>
                            <th>{{ $admin->email}}</th>

                        </tbody>
                     @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection


<!-- javascript (name corresponds to app.blade.php) -->
@push('add-script')
    <script src="{{ asset('/js/admin/add.js') }}"></script>
@endpush
