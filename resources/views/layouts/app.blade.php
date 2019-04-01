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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

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
              <a class="navbar-brand" href=="{{ url('/admin') }}">UniSpace CMS</a>
            </nav>

          <nav>
            <div>
            <!-- Logout -->
              <ul class="nav navbar-nav navbar-right">
                     <li><a href="{{ url('/') }}">Logout</a></li>
              </ul>

              <!-- Admin -->
              <ul class="nav navbar-nav navbar-right">
                  @if( \Request::is('message/*') )
                       <li class="active"><a href="{{ url('/admin') }}"Admin</a></li>
                  @else
                       <li ><a href="{{ url('/admin') }}">Admin</a></li>
                  @endif
              </ul>

              <!-- User -->
              <ul class="nav navbar-nav navbar-right">
                    @if( \Request::is('users') || \Request::is('profile/*') || \Request::is('user/*'))
                            <li class="active"><a href="{{ url('/user') }}">User</a></li>
                    @else
                            <li ><a href="{{ url('/user') }}">User</a></li>
                    @endif
              </ul>

                <!-- Message -->
                <ul class="nav navbar-nav navbar-right">
                    @if( \Request::is('message/*') )
                         <li class="active"><a href="{{ url('/message') }}">Message</a></li>
                    @else
                         <li ><a href="{{ url('/message') }}">Message</a></li>
                    @endif
                </ul>

                <!-- Blog -->
                <ul class="nav navbar-nav navbar-right">
                    @if( \Request::is('other-mission/*') || \Request::is('other-missions')|| \Request::is('mission/*/othersmission'))
                         <li class="active"><a href="{{ url('/blog') }}">Blog</a></li>
                    @else
                         <li ><a href="{{ url('/blog') }}">Blog</a></li>
                     @endif
                </ul>

                <!-- Trade -->
                <ul class="nav navbar-nav navbar-right">
                      @if( \Request::is('report/*') || \Request::is('reports'))
                          <li class="active"><a href="{{ url('/trade') }}">Trade</a></li>
                      @else
                          <li ><a href="{{ url('/trade') }}">Trade</a></li>
                      @endif
                </ul>

                <!-- Apartment -->
                <ul class="nav navbar-nav navbar-right">
                     @if( (\Request::is('mission/*') || \Request::is('missions') ) && !\Request::is('mission/*/othersmission'))
                          <li class="active"><a href="{{ url('/house') }}">Apartment</a></li>
                     @else
                         <li ><a href="{{ url('/house') }}">Apartment</a></li>
                     @endif
                </ul>

            </div>

          </nav>

            </div>
        </nav>

        <div id="mainDiv">
            <div id="mydiv" style="height:150px; "></div>
        </div>
         @yield('content')

    </div>
    <!-- Scripts -->
    <script src="{{ asset('/js/app.js') }}"></script>
    @stack('add-script')



</body>
</html>
