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
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Nunito" />
    <link href="https://use.fontawesome.com/releases/v5.0.10/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">


    @stack('add-style')

    <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>

    </script>
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.form/4.2.2/jquery.form.min.js"></script>
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>



</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-fixed-top" style="height: 150px;">
        <div class="container">
            <nav class="nav navbar-light bg-light">
              <a class="navbar-brand" href="{{ url('/admin') }}">
                <img src="{{ asset('/images/AppLogo.png')}}" style="height: 80px; width:80px;"/>
              </a>
              <span class ="CMSName">UniSpace CMS</span>
            </nav>

          <nav>
            <div>
            <!-- Logout -->
              <ul class="nav navbar-nav navbar-right">
                     <li><a href="{{ url('/') }}"><i class="fas fa-sign-out-alt" style=" padding-right: 5px;"></i>Logout</a></li>
              </ul>

              <!-- App Statistics -->
              <ul class="nav navbar-nav navbar-right">
                  @if( \Request::is('message/*') )
                       <li class="active"><a href="{{ url('/select') }}"><i class="fas fa-plus" style=" padding-right: 5px;"></i>Selections</a></li>
                  @else
                       <li ><a href="{{ url('/select') }}"><i class="fas fa-plus" style=" padding-right: 5px;"></i>Selections</a></li>
                  @endif
              </ul>

              <!-- App Statistics -->
              <ul class="nav navbar-nav navbar-right">
                  @if( \Request::is('message/*') )
                       <li class="active"><a href="{{ url('/statistics') }}"><i class="fas fa-users-cog" style=" padding-right: 5px;"></i>App Statistics</a></li>
                  @else
                       <li ><a href="{{ url('/statistics') }}"><i class="fas fa-chart-bar" style=" padding-right: 5px;"></i>App Statistics</a></li>
                  @endif
              </ul>

              <!-- Admin -->
              <ul class="nav navbar-nav navbar-right">
                  @if( \Request::is('message/*') )
                       <li class="active"><a href="{{ url('/admin') }}"><i class="fas fa-users-cog" style=" padding-right: 5px;"></i>Admin</a></li>
                  @else
                       <li ><a href="{{ url('/admin') }}"><i class="fas fa-users-cog" style=" padding-right: 5px;"></i> Admin</a></li>
                  @endif
              </ul>

              <!-- User -->
              <ul class="nav navbar-nav navbar-right">
                    @if( \Request::is('users') || \Request::is('profile/*') || \Request::is('user/*'))
                            <li class="active"><a href="{{ url('/user') }}"><i class="fas fa-users" style=" padding-right: 5px;"></i>User</a></li>
                    @else
                            <li ><a href="{{ url('/user') }}"><i class="fas fa-users" style=" padding-right: 5px;"></i>User</a></li>
                    @endif
              </ul>

                <!-- Message -->
                <ul class="nav navbar-nav navbar-right">
                    @if( \Request::is('message/*') )
                         <li class="active"><a href="{{ url('/message') }}"><i class="fas fa-envelope" style=" padding-right: 5px;"></i>Message</a></li>
                    @else
                         <li ><a href="{{ url('/message') }}"><i class="fas fa-envelope" style=" padding-right: 5px;"></i>Message</a></li>
                    @endif
                </ul>

                <!-- Blog -->
                <ul class="nav navbar-nav navbar-right">
                    @if( \Request::is('other-mission/*') || \Request::is('other-missions')|| \Request::is('mission/*/othersmission'))
                         <li class="active"><a href="{{ url('/blog') }}"><i class="fab fa-blogger" style=" padding-right: 5px;"></i>Blog</a></li>
                    @else
                         <li ><a href="{{ url('/blog') }}"><i class="fab fa-blogger" style=" padding-right: 5px;"></i>Blog</a></li>
                     @endif
                </ul>

                <!-- Trade -->
                <ul class="nav navbar-nav navbar-right">
                      @if( \Request::is('report/*') || \Request::is('reports'))
                          <li class="active"><a href="{{ url('/trade') }}"><i class="fas fa-shopping-cart" style=" padding-right: 5px;"></i>Trade</a></li>
                      @else
                          <li ><a href="{{ url('/trade') }}"><i class="fas fa-shopping-cart" style=" padding-right: 5px;"></i>Trade</a></li>
                      @endif
                </ul>

                <!-- Apartment -->
                <ul class="nav navbar-nav navbar-right">
                     @if( (\Request::is('mission/*') || \Request::is('missions') ) && !\Request::is('mission/*/othersmission'))
                          <li class="active"><a href="{{ url('/house') }}"><i class="fas fa-band-aid" style=" padding-right: 5px;"></i>Apartment</a></li>
                     @else
                         <li ><a href="{{ url('/house') }}"><i class="fas fa-band-aid" style=" padding-right: 5px;"></i>Apartment</a></li>
                     @endif
                </ul>


            </div>

          </nav>

            </div>


        </nav>
        <div class ="container" id="mainDiv">
            <div id="mydiv" style="height:180px; "></div>
        </div>



        @yield('userTypes')
        @yield('selectionTypes')
        @yield('content')

         <div class ="container" id="mainDiv">
             <div id="mydiv" style="height:100px; "></div>
         </div>

    </div>
    <!-- Scripts -->
    <!-- <script src="{{ asset('/js/app.js') }}"></script> -->
    @stack('add-script')



</body>
</html>
