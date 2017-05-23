@extends('layouts.index', ['store_username'=>$store->store_username, 'store_name'=>$store->store_name])

@section('title')
	{{$store->store_name}}
@endsection

@section('nav1')
	<li><a href="/mystore/{{$store->store_username}}">{{ $store->store_name }}</a></li>
@endsection
@section('nav2')
	<li class="active"><a href="/mystore/{{$store->store_username}}/products">Products</a></li>
@endsection
@section('nav3')
	<li><a href="/mystore/{{$store->store_username}}/sales">Sales</a></li>
@endsection
@section('nav4')
	<li><a href="/mystore/{{$store->store_username}}/contact">Contact</a></li>
@endsection

@if($store->status == 1)
@section('nav5')
	<li><a href="/mystore/{{$store->store_username}}/Apply!">APPLY!</a></li>
@endsection
@endif


@section('brand')

<div class="container">
	<div class="row">
		<div class="col-xs-2 logo_div">
			<a href="/mystore/{{$store->store_username}}" title="{{ $store->store_name }}"><img height="100" width="100" src="../../../../uploads/store/brand_marks/logo/{{ $store->brand_logo }}"></a>
		</div>
		<div class="col-xs-10 name_div">
			<a href="/mystore/{{$store->store_username}}" title="{{ $store->store_name }}"><h2>{{ $store->store_name }}</h2></a>
    		<span class="tagline">{{ $store->tagline }}</span>
		</div>
	</div>
   	
</div>
@endsection

@section('search')
	@include('index.static.product-search', ['store_name' => $store->store_name, 'store_username'=>$store->store_username])
@endsection

@section('alert')
@if($errors->any())
    <div class="container">
        <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>NOTE!</strong> {!! $errors->first('check') !!}
        </div>
    </div>
    @endif
@endsection

@section('success')
@if(session()->has('message'))
  <div class="container">
    <div class="alert alert-success alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>SUCCESS!</strong>  
        {!! session()->get('message') !!}
    </div>
  </div>
  @endif
@endsection

@section('leftPanel')
	@include('index.static.categories', ['categories' => $categories])
	@include('index.static.sales', ['sales' => $sales])
@endsection

@section('rightPanel')
<div class="product-single">
	<div class="container single">
		<div class="card">
			<div class="container-fluid">
				<div class="wrapper row">
					<div class="preview col-md-4">
						
						<div class="preview-pic tab-content">
						  <div class="tab-pane active" id="pic-1"><img src="../../../uploads/store/products/{{$product->product_image1}}" class="img-responsive img-preview" width="300" height="300" /></div>
						  <div class="tab-pane" id="pic-2">
						  	<img src="./../../uploads/store/products/{{$product->product_image2}}" class="img-responsive img-preview" width="300" height="300" />
						  </div>
						  <div class="tab-pane" id="pic-3"><img src="./../../uploads/store/products/{{$product->product_image3}}" class="img-responsive img-preview" width="300" height="300" /></div>
						  <div class="tab-pane" id="pic-4"><img src="./../../uploads/store/products/{{$product->product_image4}}" class="img-responsive img-preview" width="300" height="300" /></div>
						</div>
									
					</div>
					<div class="col-md-4">
						<ul class="preview-thumbnail nav nav-tabs">
						  <li class="active"><a data-target="#pic-1" data-toggle="tab"><img src="./../../uploads/store/products/{{$product->product_image1}}" /></a></li>
						  <li><a data-target="#pic-2" data-toggle="tab"><img src="./../../uploads/store/products/{{$product->product_image2}}" /></a></li>
						  <li><a data-target="#pic-3" data-toggle="tab"><img src="./../../uploads/store/products/{{$product->product_image3}}" /></a></li>
						  <li><a data-target="#pic-4" data-toggle="tab"><img src="./../../uploads/store/products/{{$product->product_image4}}" /></a></li>
						</ul>	
					</div>					
				</div>
			</div>
		</div>
	</div>
</div>
<br />
<hr />

<div class="pannel panel-default">
	<div class="panel-body">
		<h1>{{ $product->product_name }}</h1>
		<div class="row">
			<div class="col-md-8 ">
				<div class="price-content box">
					<span>
						<h3 class="content">Price: {{ price_check($product->product_discount, $product->product_price, 	$product->sale_id, $product->discount,$product->sale_status) }}</h3>
					</span>
					@if(isset($product->sale_id))
					<span class="content">
						(On sale: <a href="/mystore/{{$store->store_username}}/sale/{{$product->sale_slug}}">{{$product->sale_name}}</a>)
					</span>
					@endif
				</div>
				<br />
				<div class="description-content box">
					<h4 class="content">Description:</h4>
					<p class="content description">{{ $product->product_desc }}</p>
				</div>
				<br />
				<div class="panel panel-default">
					<div class="panel-heading">
						Place Order
					</div>
					<div class="panel-body">
						Coming soon.
					</div>
				</div>
			</div>
			<div class="col-md-4">
				<a href="/product/{{$product->product_id}}/add_to_cart" class="add-to-cart btn btn-sm btn-default">Add to Cart</a>
				<br />
				<br />
				<hr />
				<br />

				<div class="panel panel-default">
					<div class="panel-heading">
						Statistics
					</div>
					<div class="panel-body">
					<?php $rating = get_review_stars("product", $product->product_id);
						
						for($i= 1; $i<=$rating; $i++)
						{
					?>
							<i class="fa fa-star review_rating" aria-hidden="true"></i>
					<?php } ?>
						<br />
						<br />
						<hr />
						<br />
						<i class="fa fa-eye" aria-hidden="true">&nbsp;&nbsp;{{ $product->product_views }}</i>
						<br />
						<br />
						<hr />
						<br />
						Coming soon.
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-8">
				<div class="panel panel-default">
					<div class="panel-heading" data-toggle="collapse" data-target="#product_review">
						Review {{ $product->product_name }}
					</div>
					<div class="collapse in" id="product_review">
						<div class="panel-body row">
							<div class="col-md-7">
								<div class="stars ">
		  							<form action="/review/product/{{$product->product_id}}" method="POST">
	  								{{ csrf_field() }}
	  									<div class="form-group">
	  										<input class="star star-5" id="star-5" type="radio" value="5" name="star"/>
		    								<label class="star star-5" for="star-5"></label>
		    								<input class="star star-4" id="star-4" type="radio" value="4" name="star"/>
	    									<label class="star star-4" for="star-4"></label>
	   										<input class="star star-3" id="star-3" type="radio" value="3" name="star"/>
	    									<label class="star star-3" for="star-3"></label>
    										<input class="star star-2" id="star-2" type="radio" value="2" name="star"/>
	    									<label class="star star-2" for="star-2"></label>
	    									<input class="star star-1" id="star-1" type="radio" value="1" name="star"/>
	    									<label class="star star-1" for="star-1"></label>
	  									</div>
		  								<br />
		  								<br />
	  									<br />
	    								<div class="form-group">
	    									Your name:
	    									<input type="text" name="review_name" class="form-control" />
	    								</div>
	    								<div class="form-group">
	    									Title:
	    									<input type="text" name="review_title" class="form-control" />
		    							</div>
		    							<div class="form-group">
	    									Review
	    									<textarea name="review_review" class="form-control" /></textarea>
		    							</div>
		    							<div class="form-group">
	    									<input type="submit" name="submit" class="pull-right btn btn-primary" value="Save" />
	    								</div>
	  								</form>
								</div>
							</div>
							<div class="col-md-5 note">
								<div class="panel panel-default">
									<div class="panel-heading">
										NOTE!
									</div>
									<div class="panel-body">
										Please be honest whilst writing a review. Every review is important for either store or product. Thank you :)
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection