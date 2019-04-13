@extends('layouts.app')

@section('userTypes')

<div class ="container" >
    <nav>

        <!-- Tenants -->
        <ul class="nav navbar-nav navbar-right">
                 <li><a href="{{ url('user/tenant') }}">Tenants</a></li>
        </ul>

        <!-- House Owners -->
        <ul class="nav navbar-nav navbar-right">
               <li><a href="{{ url('user/owner') }}">Apartment Owners</a></li>
        </ul>

        <!-- all users -->
        <ul class="nav navbar-nav navbar-right">
               <li><a href="{{ url('/user') }}">All Users</a></li>
        </ul>

    </nav>
</div>
@endsection
