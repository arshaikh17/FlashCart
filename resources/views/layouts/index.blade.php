<!DOCTYPE html>
<html>
<head>
	<title>@yield('title')</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="../../../js/jquery.min-3.1.1.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<script src="../../../js/flashcart-js4.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../../../css/main.css" />
    <link rel="stylesheet" type="text/css" href="../../../css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="../../../css/index.css" />
    <link rel="stylesheet" type="text/css" href="../../../../../css/store.css" />
    @yield('css')
</head>

<nav class="navbar navbar-default ">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="/mystore/{{$store_username}}" title="{{$store_name}}">@yield('brandmark-icon') LOGO</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        @yield('nav1')
        @yield('nav2')
        @yield('nav3')
        @yield('nav4')
        @yield('nav5')
        <li class="divider-vertical"></li>
          
      </ul>
    </div>
  </div>
</nav>
<body>

<div>
	@yield('brand')
</div>
<div>
	@yield('search')
</div>
<div class="main-content container">
	<div class="row">
  @yield('alert')
  @yield('success')
		<div class="col-lg-3 col-md-3 col-sm-12 col-xs-12">
			<div class="leftPanel">
				@yield('leftPanel')
			</div>
		</div>
		<div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
			<div class="rightPanel">
				@yield('rightPanel')
			</div>
		</div>
	</div>
</div>
</body>
</html>

