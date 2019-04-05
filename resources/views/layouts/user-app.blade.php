@extends('layouts.app')

@section('userTypes')

<div class ="container" >
    <nav>
        <!-- House Owners -->
        <ul class="nav navbar-nav navbar-right">
               <li><a href="{{ url('/user') }}">Apartment Owners</a></li>
        </ul>

        <!-- Tenants -->
        <ul class="nav navbar-nav navbar-right">
                 <li><a href="{{ url('/user') }}">Tenants</a></li>
        </ul>
    </nav>
</div>
@endsection
