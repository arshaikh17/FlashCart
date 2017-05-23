<!DOCTYPE html>
<html lang="en">
@if (Auth::user())
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <link href="../../../../../css/app.css" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="../../../../../js/jquery.min-3.1.1.js"></script>

    <link rel="stylesheet" type="text/css" href="../../../../../css/font-awesome.min.css" />
    <title>@yield('storetitle')</title>
    <script src="../../../../../js/flashcart-js2.js"></script>
    <script src="../../../../../js/flashcart-js3.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../../../css/store.css" />
    <link rel="stylesheet" type="text/css" href="../../../../../css/main.css" />
    <!-- Styles -->
    @yield('css')

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
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
                    <a class="navbar-brand" href="{{ url('/store') }}">
                        {{ session('store_name') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu" role="menu">
                                <li><a href="{{ url('/home') }}">Profile</a></li>
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
                    </ul>
                </div>
            </div>
        </nav>
    </div>

    <div class="container">
        <div class="">
            <div class="row">
                @yield('storecontent-success')
                @yield('storecontent-alert')
                <div id="left" class="">
                    <div id="left-content">
                        <div class="col-md-8">
                            @yield('storecontent')
                        </div>
                    </div>
                </div>    

                <div id="right" class="">
                    <div id="right-content">
                        <div class="col-md-4">
                            <div id="view_cols">
                                @yield('storecontent-right')
                            </div>
                            <div id="sidemenu_cols">
                                @include('store.static.sidemenu')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="/js/app.js"></script>
    @yield('jquery')
    @else
        <strong>You are not authorized to this page.</strong>
    @endif
</body>
</html>
