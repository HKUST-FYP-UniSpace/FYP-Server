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

            <nav class="navbar navbar-light bg-light">
              <a class="navbar-brand" href=="{{ url('/admin') }}">
                <img src="logo.jpg" width="30" height="30" class="d-inline-block align-top" alt="">
                UniSpace CMS
              </a>
            </nav>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    
                                <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">

                            @if( \Request::is('users') || \Request::is('profile/*') || \Request::is('user/*'))
                                <li class="active"><a href="{{ url('/users') }}">User</a></li>
                            @else
                                <li ><a href="{{ url('/users') }}">User</a></li>
                            @endif
                            
                            @if( (\Request::is('mission/*') || \Request::is('missions') ) && !\Request::is('mission/*/othersmission'))
                                <li class="active"><a href="{{ url('/missions') }}">Apartment</a></li>
                            @else
                                <li ><a href="{{ url('/missions') }}">Apartment</a></li>
                            @endif

                            @if( \Request::is('report/*') || \Request::is('reports'))
                                <li class="active"><a href="{{ url('/reports') }}">Trade</a></li>
                            @else
                                <li ><a href="{{ url('/reports') }}">Trade</a></li>
                            @endif

                            @if( \Request::is('other-mission/*') || \Request::is('other-missions')|| \Request::is('mission/*/othersmission'))
                                <li class="active"><a href="{{ url('/other-missions') }}">Blog</a></li>
                            @else
                                <li ><a href="{{ url('/other-missions') }}">Blog</a></li>
                            @endif
                            @if( \Request::is('runninggold_wallet') )
                                <li class="active"><a href="{{ url('/runninggold_wallet') }}">Message</a></li>
                            @else
                                <li ><a href="{{ url('/runninggold_wallet') }}">Message</a></li>
                            @endif

                        </ul>
                    
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">                   
                        <li><a href="{{ url('admin/login') }}">Logout</a>
                        </li>

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
