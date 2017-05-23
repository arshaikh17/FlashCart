<link rel="stylesheet" type="text/css" href="../../../../../../css/store/product_area/product-area-1.css" />


@forelse($products as $product)
<div class="product-area">
	@if($product->sale_id != "")
	<a href="/mystore/{{ $product->product_id }}/sale/{{ $product->sale_id }}/{{ $product->sale_slug }}">
		<div class="sale_tag">
			<span class="badge sale_badge">Sale</span>
		</div>
	</a>
	@endif
	<div class="product">
		<div class="product_image">
			<img width="180" height="300" src="../../../../../../uploads/store/products/{{ $product->product_image1 }}" alt="{{$product->product_name}}" class="img img-responsive product_image_content" />
		</div>
		<div class="product_name">
			<p class="product_name_content marquee"><a href="/mystore/{{$product->store_username}}/product/{{$product->product_id}}/{{$product->product_slug}}">@if(strlen($product->product_name) > 40) {{ substr("$product->product_name", 0, 40) }}... @else {{$product->product_name}} @endif</a></p>
			<p class="price">Rs. {{ price_check($product->product_discount,$product->product_price,$product->sale_id, $product->discount,$product->status) }}/-</p>
		</div>
		<a href="/store/{{$product->store_username}}/product/{{ $product->product_id }}/add_to_cart" class="btn btn-small">add to cart</a>
	</div>
</div>
@empty
No products to display by store.
@endforelse