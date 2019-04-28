@extends('layouts.app')

@section('userTypes')

<div class ="container" >
    <nav>

        <!-- Tenants -->

        <ul class="nav navbar-nav navbar-right">
        @if( \Request::is('tenant/*') || \Request::is('tenant') )
                 <li><a href="{{ url('user/tenant') }}">Tenants</a></li>
        @else
        <li><a href="{{ url('user/tenant') }}">Tenants</a></li>
        @endif
        </ul>

        <!-- House Owners -->
        <ul class="nav navbar-nav navbar-right">
        @if( \Request::is('owner/*') || \Request::is('owner') )
               <li><a href="{{ url('user/owner') }}">Apartment Owners</a></li>
        @else
               <li><a href="{{ url('user/owner') }}">Apartment Owners</a></li>
        @endif
        </ul>

        <!-- all users -->
        <ul class="nav navbar-nav navbar-right">
        @if( \Request::is('user/*') || \Request::is('user') )
               <li><a href="{{ url('/user') }}">All Users</a></li>
        @else
              <li><a href="{{ url('/user') }}">All Users</a></li>
        @endif
        </ul>

    </nav>
</div>
@endsection
