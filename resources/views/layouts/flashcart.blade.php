<?php
	$identifiers = getIdentifiers();
?>
<!DOCTYPE html>
<html>
	<head>
		<title>@yield('title')</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		 <meta name="description" content="Buy them or sell them.">
  <meta name="keywords" content="buy, products, sell, store, shop">
  <meta name="author" content="John Doe">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script  src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
		<script  src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
		<script src="../../../../../js/jquery.min-3.1.1.js"></script>
		<script src="../../../../../js/flashcart/body.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="icon" href="../../../../uploads/flashcart/logo/FlashCart.png" type="image/x-icon"/>
		<link rel="shortcut icon" href="../../../../uploads/flashcart/logo/FlashCart.png" type="image/x-icon"/>
		<link rel="stylesheet" type="text/css" href="../../../../../css/flashcart/body.css" />
		<link rel="stylesheet" type="text/css" href="../../../../../css/font-awesome.min.css">
		<link rel="stylesheet" href="../../../../../css/flashcart/search/index.css">  <!-- the file name of css-->
		<link rel="stylesheet" href="../../../../../css/flashcart/search/hover.css">
		<link rel="stylesheet" href="../../../../../css/flashcart/search/animate.css">
		
		<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
		@yield('jquery')
		<style>
		    .top_button 
		    {
		        /*margin-left: -50px !important;*/
		    }
		</style>
	</head>
	<body>
		<style>
		</style>
		<div id="header">
			<div class="" id="header_content">
				<nav class="navbar">
					<div class="container-fluid">
						<div class="navbar-header">
							<a class="navbar-brand brandmark" href="/"><img src="../../../../uploads/flashcart/logo/Flashcart.png" width="150"></a>
							<button type="button" class="navbar-toggle top_button" data-toggle="collapse" data-target="#myNavbar" style="color: black !important;">
        <i class="fa fa-chevron-down"></i>
      </button>
						</div>
    <div class="collapse navbar-collapse" id="myNavbar">
						<ul class="nav navbar-nav navbar-right" style="background-color: white;">


							@if(Auth::user())
							<li class="link_to"><a href="/user/home"><i class="fa fa-user"></i> <b>Home</b></a></li>
							<li class="link_to"><a href="/stores"><i class="fa fa-shopping-bag"></i> <b>Stores</b></a></li>
							<li class="link_to"><a href="/employ"><span class="fa fa-user-plus"></span> <b>Employment</b></a></li>
							@if(session('store_id') != "")
							<li class="link_to"><a href="/store"><i class="fa fa-home"></i> <b>My Store</b></a></li>
							@endif
							<li class="link_to"><a href="{{ url('/user/logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <b>Logout</b></a></li>
							<form id="logout-form" action="{{ url('/user/logout') }}" method="POST" style="display: none;">
								{{ csrf_field() }}
							</form>
							@else
							<li class="link_to"><a href="/stores"><i class="fa fa-shopping-bag"></i> <b>Stores</b></a></li>
							<li class="link_to"><a href="/employ"><span class="fa fa-user-plus"></span> <b>Employment</b></a></li>
							<li class="link_to"><a href="/user/login"><span class="glyphicon glyphicon-log-in"></span> <b>Login/Register</b></a></li>
							@endif
							@if(session('products') != "")
							<?php
							$a = array();
							foreach(session('products') as $p)
							{
							$a[] = $p['product'];
							}
							?>
							<li class="cart_tag" style="background-color: white; "><a data-toggle="collapse" data-target="#cart_items"><i aria-hidden="true" class="fa fa-shopping-cart">&nbsp;<span class="badge">{{ count($a) }}</span></i></a>
							<div class="collapse box" id="cart_items"  style="border: 2px solid #0050A0; ;background-color: white; position: absolute; margin-left: -700px;">
								<?php
								$cart_products = get_cart_products($a);
								foreach($cart_products as $product)
								{
								?>
								<div class="panel panel-default" >
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
		</div>
	</div>
	<div class="fc-container" id="main-container">

		@yield('content')

	</div>
</body>
<footer id="footer">
	<!-- Start section about-->
	<section class="links">
		<div class="back-color">
			<div class="row">
				<div class="col-md-4">
					<div class="line">
						<h2 class="title2">
						<span>Our mission</span>
						</h2>
						<ul class="list-unstyled">
							<li>
								<p>Our mission is to provide buyers a platform to find their desired products amongst various shops. And to provide a platform to shop owners to manage their shops and inventory without any hassle.</p></li>
							</ul>
						</div>
					</div>
					<div class="col-md-3">
						<div class="line">
							<h2 class="title2">
							<span>Information </span>
							</h2>
							<ul class="list-unstyled">
								<br />
								<br />
								<li><a href="/about-us">about us</a></li>
								<li><a href="/our-partners">our partners</a></li>
								<li><a href="#">contact us</a></li>
								<br />
							</ul>
						</div>
					</div>
					<div class="col-md-3">
						<div class="line">
							<h2 class="title2">
							<span>Request </span>
							</h2>
							<ul class="list-unstyled">
								<br />
								<br />
								<li><a href="/report">report</a></li>
								<li><a href="/request-feature">request feature</a></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</section>
	</footer>
</html>