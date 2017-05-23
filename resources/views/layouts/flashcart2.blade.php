<!DOCTYPE html>
<html lang="en">
<head>
  <title>@yield('title')</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <link href="https://fonts.googleapis.com/css?family=Open Sans" rel="stylesheet" type="text/css">
  <script src="../../../js/jquery.min-3.1.1.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<link rel="stylesheet" type="text/css" href="../../../css/flashcart.css" />
<link rel="stylesheet" type="text/css" href="../../../css/main.css" />
<script type="text/javascript" src="../../../js/flashcart-js3.js"></script>
<link rel="stylesheet" type="text/css" href="../../../css/font-awesome.min.css">
@yield('css')
</head>
<body id="myPage" data-spy="scroll" data-target=".navbar" data-offset="60">

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>                        
      </button>
      <a class="navbar-brand" href="#myPage">Logo</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="#about">ABOUT</a></li>
        <li><a href="#services">SERVICES</a></li>
        <li><a href="#portfolio">PORTFOLIO</a></li>
        <li><a href="#pricing">PRICING</a></li>
        <li><a href="#contact">CONTACT</a></li>
        @if(Auth::user())
        <li><a href="/user/logout">LOGOUT</a></li>
        @else
        <li><a href="/user/login">LOGIN</a></li>
        <li><a href="/user/register">REGISTER</a></li>
        @endif
        <li class="divider-vertical"></li>
        @if(session('products') != "")
          <?php
            $a = array();
            foreach(session('products') as $p)
            {
              $a[] = $p['product'];
            }
          ?>
          <li class="cart_tag"><a data-toggle="collapse" data-target="#cart_items"><i aria-hidden="true" class="fa fa-shopping-cart">&nbsp;<span class="badge">{{ count($a) }}</span></i></a>
            <div class="collapse box" id="cart_items">
              <?php
                $cart_products = get_cart_products($a);
                foreach($cart_products as $product)
                {
              ?>
              <div class="panel panel-default">
                <div class="panel-body">
                  <div class="media">
                    <div class="media-left media-middle">
                      <img src="/uploads/store/products/{{$product['product_image1']}}" class="media-object" style="width:60px">
                    </div>
                    <div class="media-body">
                      <h4 class="media-heading">{{$product['product_name']}}</h4>
                      <a href="/product/{{$product['id']}}/remove_from_cart"><p class="pull-right"><i aria-hidden="true" class="fa fa-times"></i></p></a>
                    </div>
                </div>

                </div>
              </div>
              <?php
                }
              ?>
              <a href="/order/review">Proceed to checkout</a>
            </div>
          </li>
        @endif
      </ul>
    </div>
  </div>
</nav>

@yield('search')

<div class="container">
  <div class="row">
      @yield('success')
      @yield('alert')
    <div class="col-md-3">
      <div>
        @yield('side-menu-section')
      </div>
    </div>
    <div class="col-md-9">
      <div class="fc-main-content" id="fc-main-content">

        @yield('main-section')
      </div>
    </div>
  </div>
</div>




<!--<div id="googleMap" style="height:400px;width:100%;"></div>-->

<script>

</script>
<script src="https://maps.googleapis.com/maps/api/js"></script>
<script>
var myCenter = new google.maps.LatLng(41.878114, -87.629798);

function initialize() {
var mapProp = {
  center:myCenter,
  zoom:12,
  scrollwheel:false,
  draggable:false,
  mapTypeId:google.maps.MapTypeId.ROADMAP
  };

var map = new google.maps.Map(document.getElementById("googleMap"),mapProp);

var marker = new google.maps.Marker({
  position:myCenter,
  });

marker.setMap(map);
}

google.maps.event.addDomListener(window, 'load', initialize);
</script>

<footer class="container-fluid text-center">
  <a href="#myPage" title="To Top">
    <span class="glyphicon glyphicon-chevron-up"></span>
  </a>
  <p>@ <a href="http://www.flashcart.com.pk" title="Visit FlashCart">FlashCart</a> 2016-2017</p>
</footer>

<script>
$(document).ready(function(){
  // Add smooth scrolling to all links in navbar + footer link
  $(".navbar a, footer a[href='#myPage']").on('click', function(event) {
    // Make sure this.hash has a value before overriding default behavior
    if (this.hash !== "") {
      // Prevent default anchor click behavior
      event.preventDefault();

      // Store hash
      var hash = this.hash;

      // Using jQuery's animate() method to add smooth page scroll
      // The optional number (900) specifies the number of milliseconds it takes to scroll to the specified area
      $('html, body').animate({
        scrollTop: $(hash).offset().top
      }, 900, function(){
   
        // Add hash (#) to URL when done scrolling (default click behavior)
        window.location.hash = hash;
      });
    } // End if
  });
  
  $(window).scroll(function() {
    $(".slideanim").each(function(){
      var pos = $(this).offset().top;

      var winTop = $(window).scrollTop();
        if (pos < winTop + 600) {
          $(this).addClass("slide");
        }
    });
  });
})
</script>
@yield('jquery')
</body>
</html>
