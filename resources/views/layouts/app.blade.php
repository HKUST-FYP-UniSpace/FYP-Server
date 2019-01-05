<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ env('APP_TITLE') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" rel="stylesheet">
    @stack('add-style')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/admin') }}">
                        賞金寶 CMS
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                	@if(Auth::check())
	                    <!-- Left Side Of Navbar -->
	                    <ul class="nav navbar-nav">
	                        @if( \Request::is('users') || \Request::is('profile/*') || \Request::is('user/*'))
	                            <li class="active"><a href="{{ url('/users') }}">使用者</a></li>
	                        @else
	                            <li ><a href="{{ url('/users') }}">使用者</a></li>
	                        @endif
	                        
	                        @if( (\Request::is('mission/*') || \Request::is('missions') ) && !\Request::is('mission/*/othersmission'))
	                            <li class="active"><a href="{{ url('/missions') }}">任務</a></li>
	                        @else
	                            <li ><a href="{{ url('/missions') }}">任務</a></li>
	                        @endif

	                        @if( \Request::is('report/*') || \Request::is('reports'))
	                            <li class="active"><a href="{{ url('/reports') }}">反饋</a></li>
	                        @else
	                            <li ><a href="{{ url('/reports') }}">反饋</a></li>
	                        @endif

	                        @if( \Request::is('other-mission/*') || \Request::is('other-missions')|| \Request::is('mission/*/othersmission'))
	                            <li class="active"><a href="{{ url('/other-missions') }}">趣聞</a></li>
	                        @else
	                            <li ><a href="{{ url('/other-missions') }}">趣聞</a></li>
	                        @endif
	                        @if( \Request::is('runninggold_wallet') )
	                            <li class="active"><a href="{{ url('/runninggold_wallet') }}">runninggold 錢包</a></li>
	                        @else
	                            <li ><a href="{{ url('/runninggold_wallet') }}">runninggold 錢包</a></li>
	                        @endif
	                        {{-- @if( \Request::is('advertisement/*') || \Request::is('advertisement'))
	                            <li class="active"><a href="{{ url('/advertisement') }}">廣告</a></li>
	                        @else
	                            <li ><a href="{{ url('/advertisement') }}">廣告</a></li>
	                        @endif --}}
	                        @if( \Request::is('select/*') || \Request::is('select'))
	                            <li class="active"><a href="{{ url('/select') }}">選項</a></li>
	                        @else
	                            <li ><a href="{{ url('/select') }}">選項</a></li>
	                        @endif
	                        @if( \Request::is('admins/*') || \Request::is('admins'))
	                            <li class="active"><a href="{{ url('/admins') }}">帳戶</a></li>
	                        @else
	                            <li ><a href="{{ url('/admins') }}">帳戶</a></li>
	                        @endif

	                    </ul>
					@endif
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('admin/login') }}">Login</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>		
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('/js/app.js') }}"></script>
    @stack('add-script')

</body>
</html>