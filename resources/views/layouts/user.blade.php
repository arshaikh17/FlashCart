<!DOCTYPE html>
<html>
<title>{{Auth::user()->name}}</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open Sans">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
  <script src="../../../../js/jquery.min-3.1.1.js"></script>
  <script src="../../../../js/user/user.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../../../../css/auth/body.css" />
<script src="../../../../../js/functions.js"></script>
<style>
html,body,h1,h2,h3,h4,h5 {font-family: Open Sans}
.shadow
{
  -webkit-box-shadow: 0px 0px 8px 1px rgba(0,0,0,0.75);
-moz-box-shadow: 0px 0px 8px 1px rgba(0,0,0,0.75);
box-shadow: 0px 0px 8px 1px rgba(0,0,0,0.75);
}
.side-menu a
{
  text-decoration: none;
}
.link_to a
{
  text-decoration: none;
}
.link_to span
{
  color: white !important;
}

</style>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-bar w3-top w3-black w3-large" style="z-index:4">
  <a href="/" class="link_to"><span class="w3-bar-item w3-left">FlashCart</span></a>
  <button class="w3-bar-item w3-button w3-hide-large w3-hover-none w3-hover-text-light-grey" onclick="w3_open();"><i class="fa fa-bars"></i>  Menu</button>
  <span class="w3-bar-item w3-right">{{mb_substr(Auth::user()->name, 0, 1)}}</span>
</div>

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidebar"><br>
  <div class="w3-container w3-row">
    <div class="w3-col s4">
      <img src="/uploads/user/pictures/{{Auth::user()->picture}}" class="img-thumbnail w3-margin-right" style="width:80px">
    </div>
    <div class="w3-col s8 w3-bar">
      <span>Welcome, <strong>{{Auth::user()->name}}</strong></span><br>
      <a href="/user/messages/" class="w3-bar-item w3-button"><i class="fa fa-envelope"></i></a>
      <a href="#" class="w3-bar-item w3-button"><i class="fa fa-user"></i></a>
      <a href="/user/settings/" class="w3-bar-item w3-button"><i class="fa fa-cog"></i></a>
    </div>
  </div>
  <hr>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <div class="w3-bar-block side-menu">
    <a href="#" class="w3-bar-item w3-button w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>  Close Menu</a>
    <a href="/user/home" class="w3-bar-item w3-button w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>  Home</a>
    <a href="/user/conversations" class="w3-bar-item w3-button w3-padding"><i class="fa fa-envelope fa-fw"></i>  Conversations Room</a>
    <a href="/user/messages" class="w3-bar-item w3-button w3-padding"><i class="fa fa-envelope fa-fw"></i>  Direct Messages</a>
    <hr />
    <a href="/user/stores" class="w3-bar-item w3-button w3-padding"><i class="fa fa-home fa-fw"></i>  Stores</a>
    <hr />
    <a href="#" class="w3-bar-item w3-button w3-padding"><i class="fa fa-diamond fa-fw"></i>  Orders</a>
    <hr />
    <a data-toggle="collapse" data-target="#userSettings" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog fa-fw"></i>  Settings</a>
    <div class="collapse" id="userSettings">
      <a href="/user/settings/" class="w3-bar-item w3-button w3-padding"><i class="fa fa-cog"></i>  Main Settings</a>
      <a href="/user/settings/address" class="w3-bar-item w3-button w3-padding"><i class="fa fa-address-card fa-fw"></i>  Address Information</a>
    </div>
    <hr />
    <a href="/user/logout" class="w3-bar-item w3-button w3-padding" href="{{ url('/user/logout') }}"                                             onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i>  Logout</a>
                                                     <form id="logout-form" action="{{ url('/user/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
  </div>
</nav>


<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">


  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    @yield('user-header')
  </header>
  <div>
    @yield('user-alert')
    @yield('user-success')
    @yield('user-content')
    
  </div>

  

  <!-- End page content -->
</div>

<script>
// Get the Sidebar
var mySidebar = document.getElementById("mySidebar");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidebar, and add overlay effect
function w3_open() {
    if (mySidebar.style.display === 'block') {
        mySidebar.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidebar.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidebar with the close button
function w3_close() {
    mySidebar.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</body>
</html>
