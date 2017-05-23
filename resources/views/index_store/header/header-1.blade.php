<link rel="stylesheet" type="text/css" href="../../../../../../css/store/header/header-1.css">

<script src="https://devitems.com/html/alto-preview/alto/js/vendor/jquery-1.12.0.min.js"></script>
<script src="https://devitems.com/html/alto-preview/alto/js/jquery.meanmenu.js"></script>
<script src="https://devitems.com/html/alto-preview/alto/js/main.js"></script>
<link rel="stylesheet" href="https://devitems.com/html/alto-preview/alto/css/meanmenu.min.css">
<header>
	<div class="fixed-header-area" id="sticky-header">
		<div class="container">
			<div class="row">
				<div class="col-lg-8 col-md-7 col-sm-7">
					<div class="mean-menu-area">
						<div class="mean-menu text-center">
							<nav>
								<ul>
									<li><a href="/mystore/{{ $store->store_username }}">{{ $store->store_name }}<i class="fa fa-home"></i></a></li>
									<li><a href="/mystore/{{ $store->store_username }}/category/ }}">Sales<i class="fa fa-angle-down"></i></a>
									<ul class="mega-menu mega-menu2">
										@foreach($sales as $sale)
										<li><a href="/mystore/{{ $store->store_username }}/sale/{{$sale->sale_slug}}">{{$sale->sale_name}}</a></li>
										@endforeach
									</ul>
								</li>
								<li class="static"><a href="#">Categories<i class="fa fa-angle-down"></i></a>
								<ul class="mega-menu col-md-offset-3" id="hidden-menu">
									@foreach($categories as $category)
									<?php $sub_categories = getSubCategories($category->id); ?>
									<li>
										<a href="/mystore/{{$store->store_username}}/category/{{ $category->category }}" class="title">{{ $category->category }}</a>
										
										@foreach($sub_categories as $sub)
										<a href="/mystore/{{ $store->store_username }}/category/sub_cat/{{ $sub->sub_category }}">{{ $sub->sub_category }}</a>
										@endforeach
									</li>
									@endforeach
								</ul>
							</li>
							<li><a href="/mystore/{{ $store->store_username }}/contact">contact</a></li>
							<li><a href="/mystore/{{ $store->store_username }}/policies">policies</a></li>
						</ul>
					</nav>
				</div>
			</div>
			
		</div>
		<div class="col-lg-2 col-md-3 col-sm-3">
			
			<div class="cart-total text-right">
				<ul class="cart-menu">
					<li>
						<a href="#">
							<i class="fa fa-shopping-cart"></i>
						</a>
						<div class="shopping-cart">
							<?php
								$a = array();
								if(session('products'))
								{
									foreach(session('products') as $p)
									{
										$a[] = $p['product'];
									}
									
								}
								$cart_products = get_cart_products($a);
							?>
							@forelse($cart_products as $product)
							
							<div class="cart-list">
								<div class="cart-img">
									<a href="#" title="{{ $product->product_name }}"><img src="/uploads/store/products/{{ $product->product_image1 }}" alt="{{$product->product_name}}" /></a>
								</div>
								<div class="cart-info">
									<h4><a href="#">{{$product->product_name}}</a></h4>
									<div class="cart-price">
										<span class="price">Rs. {{ price_check($product->product_discount,$product->product_price,$product->sale_id, $product->discount,$product->status) }} </span>
									</div>
								</div>
								<div class="pro-del">
									<a href="#"><i class=" pe-7s-close-circle"></i></a>
								</div>
							</div>
							@empty
							No items in cart.
							@endforelse
							<div class="cart-button">
								<a href="/order/review" title="Checkout" class="right">Checkout</a>
							</div>
						</div>
					</li>
					<li><a href="#"><span class="product-number"><span class="sell">{{ count(session('products')) }}</span> item(s) -</span> </a></li>
					<li><a href="#"><span class="cart-count">view</span></a></li>
				</ul>
			</div>
			
		</div>
	</div>
</div>
</div>
<div class="header-top-area ptb-15">
<div class="container">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="social-icon">
				<ul>
					<li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Share on Facebook"><i class="fa fa-facebook"></i></a></li>
					<li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Share on Twitter"><i  class="fa fa-twitter"></i></a></li>
					<li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Email to a Friend"><i class="fa fa-envelope-o"></i></a></li>
					<li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Pin on Pinterest"><i class="fa fa-pinterest"></i></a></li>
					<li><a href="#" data-toggle="tooltip" data-placement="bottom" title="Share on Google+"><i class="fa fa-google-plus"></i></a></li>
				</ul>
			</div>
		</div>
		<div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
			<div class="header-account text-right">
				<ul>
					<li><a href="#" title="Wishlist"><i class="pe-7s-like"></i>Wishlist</a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
<div class="header-mid-area ptb-50">
<div class="container">
	<div class="row">
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="header-search">
				<form action="/mystore/{{$store->store_username}}/products/search">
					<i class="pe-7s-search"></i>
					<input type="text" placeholder="Search here" name="product" value="{{$search}}" />
				</form>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
			<div class="logo text-center">
				<a href="/mystore/{{ $store->store_username }}"><img src="/uploads/store/brand_marks/logo/{{ $store->brand_logo }}" width="50" height="50" alt="{{$store->store_name}}" /></a>
			</div>
		</div>
		<div class="col-lg-4 col-md-4 col-sm-4 hidden-xs">
			<div class="cart-total text-right">
				<ul class="cart-menu">
					<li>
						<a href="#">
							<i class="fa fa-shopping-cart"></i>
						</a>
						<div class="shopping-cart">
							<?php
								$a = array();
								if(session('products'))
								{
									foreach(session('products') as $p)
									{
										$a[] = $p['product'];
									}
									
								}
								$cart_products = get_cart_products($a);
							?>
							@forelse($cart_products as $product)
							
							<div class="cart-list">
								<div class="cart-img">
									<a href="#" title="Samsung Galaxy"><img src="/uploads/store/products/{{ $product->product_image1 }}" alt="{{$product->product_name}}" /></a>
								</div>
								<div class="cart-info">
									<h4><a href="#">{{$product->product_name}}</a></h4>
									<div class="cart-price">
										<span class="price">Rs. {{ price_check($product->product_discount,$product->product_price,$product->sale_id, $product->discount,$product->status) }} </span>
									</div>
								</div>
								<div class="pro-del">
									<a href="#"><i class=" pe-7s-close-circle"></i></a>
								</div>
							</div>
							@empty
							No items in cart.
							@endforelse
							<div class="cart-button">
								<a href="/order/review" title="Checkout" class="right">Checkout</a>
							</div>
						</div>
					</li>
					<li><a href="#"><span class="product-number"><span class="sell">{{ count(session('products')) }}</span> item(s) -</span> </a></li>
					<li><a href="#"><span class="cart-count">view</span></a></li>
				</ul>
			</div>
		</div>
	</div>
</div>
</div>
<div class="mean-menu-area hidden-sm hidden-xs">
<div class="container">
	<div class="row">
		<div class="col-lg-12">
			<div class="mean-menu text-center">
				<nav>
					<ul>
						<li><a href="/mystore/{{$store->store_username}}/">{{ $store->store_name }}<i class="fa fa-home"></i></a></li>
						<li><a href="/mystore/{{ $store->store_username }}/sales/">Sales<i class="fa fa-angle-down"></i></a>
						<ul class="sub-menu text-left">
							@foreach($sales as $sale)
							<li><a href="/mystore/{{ $store->store_username }}/sale/{{$sale->sale_id}}/{{$sale->sale_slug}}">{{$sale->sale_name}}</a></li>
							@endforeach
						</ul>
					</li>
					<li class="static"><a href="/mystore/{{$store->store_username}}/category/">Categories<i class="fa fa-angle-down"></i></a>
					<ul class="mega-menu">
						@foreach($categories as $category)
						<?php $sub_categories = getSubCategories($category->id); ?>
						<li>
							<a href="/mystore/{{$store->store_username}}/category/{{ $category->category }}" class="title">{{ $category->category }}</a>
							
							@foreach($sub_categories as $sub)
							<a href="/mystore/{{ $store->store_username }}/category/sub_cat/{{ $sub->sub_category }}">{{ $sub->sub_category }}</a>
							@endforeach
						</li>
						@endforeach
					</ul>
				</li>
				<li><a href="/mystore/{{ $store->store_username }}/contact">contact</a></li>
				<li><a href="/mystore/{{ $store->store_username }}/policies">Policies</a></li>
			</ul>
		</nav>
	</div>
</div>
</div>
</div>
</div>
</header>