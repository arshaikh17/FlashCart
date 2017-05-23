@extends('layouts.index', ['store_username'=>$store->store_username, 'store_name'=>$store->store_name])

@section('title')
  {{$store->store_name}}
@endsection

@section('nav1')
	<li class="active"><a href="/mystore/{{$store->store_username}}/home">{{ $store->store_name }}</a></li>
@endsection
@section('nav2')
	<li><a href="/mystore/{{$store->store_username}}/products">Products</a></li>
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

@section('leftPanel')
	@include('index.static.categories', ['categories' => $categories])
	@include('index.static.sales', ['sales' => $sales])
@endsection

@section('rightPanel')
	@if(isset($products_categorywise))
		@forelse($products_categorywise as $product)
	<div class="fc-col">
      <div class="panel panel-primary">
        <div class="panel-heading fc-col-head"><div class="marquee">{{ $product->product_name }}</div></div>
        <div class="panel-body fc-col-body">
        	<img src="../../../uploads/store/products/{{ $product->product_image1 }}" class="img-responsive" style="width:100%; height: 100%;" alt="{{ $product->product_name }}" />
        </div>
        <div class="panel-footer fc-col-footer">
        	<span class="price">Rs.
        	{{ 
        		price_check($product->product_discount, $product->product_price, $product->sale_id, $product->discount, $product->sale_status)
        	}}/-
        	</span>
        	<br />
        		<span class="price">
            <?php
              $saleId = trim($product->sale_id);
              $productDiscount = trim($product->product_discount);
              $storeUsername = trim($product->store_username);
              //return_sale($product->sale_id, $product->sale_name, $product->product_dicount, $product->store_username)
              if($saleId != NULL || $saleId != "")
              {
              ?>
              <div class="fc-sale">
                <a href="/mystore/{{ $product->store_username }}/sales/{{ $product->sale_id }}">On Sale</a>
              </div>
              <?php
              }
              else
              {
                if(isset($productDiscount) && $productDiscount != 0)
                {
                  "@".number_format($productDiscount)."% off".'<br />';
                }
              }
        		?>
              
            </span>
        	@if($product->product_quantity > 0)<span class="instock">In Stock</span>
        	<br />
        	<div>
        		<a href="/store/{{$product->store_username}}/product/{{$product->product_id}}/add_to_cart" class="pull-right add-to-cart btn btn-sm btn-default">Add to Cart</a>
        	</div>
        	@else<span class="outstock">Out of Stock</span>
        	@endif
        </div>
      </div>
    </div>
		@empty
		No products in this category.
		@endforelse
	@endif
@endsection