<!DOCTYPE html>
<html>
<title>@yield('title')</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Open+Sans'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script src="../../../../js/flashcart-js1.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../css/home.css" />
    <!-- Styles -->
    <!--<link href="/css/app.css" rel="stylesheet">-->

    <!-- Scripts -->
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

<style>

</style>

<nav class="navbar navbar-default ">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="/user/home" title="@yield('title')">@yield('title')</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        @if (Auth::guest())
                            <li><a href="{{ url('/user/login') }}">Login</a></li>
                            <li><a href="{{ url('/user/register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    
                                </ul>
                            </li>
                            <li>
                                        <a href="{{ url('/user/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/user/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                        @endif
        <li class="divider-vertical"></li>
            <a href="#" data-toggle="collapse" data-target="#notification"><i aria-hidden="true" class="fa fa-bell-o"></i></a>
            <div class="collapse" id="notification">
                <div class="shadow">
                    asd
                    @yield('notification')
                </div>
          </div>
      </ul>
    </div>
  </div>
</nav>

<body class="w3-theme-l5">

<div class="container" style="max-width:1400px;margin-top:80px">    

  <div class="row">

    <div class="col-md-3">
        @yield('content-3')
    </div>
    
    <div class="col-md-7">
        @yield('content-7')
    </div>
    
    <!-- Right Column -->
    <div class="col-md-2">
        @yield('content-2')   
      <div class="w3-card-2 w3-round w3-white w3-padding-16 w3-center">
        <p></p>
      </div>      
    </div>








  </div>
</div>


<footer class="container">
  <h5>Footer</h5>
</footer>

<footer class="container">
  <p>Powered by <a href="https://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a></p>
</footer>
 
</body>
</html> 
