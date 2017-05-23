@extends('layouts.flashcart')

@section('search')
  @include('flashcart.static.product-search')
@endsection

@section('title')
  @if($search)
    {{ $search }}
  @else
    All Products
  @endif
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

@section('main-section')
<div class="container fc-col-container">
	<h2>
		@if($search)
			'{{ $search }}' 
		@else
			All Products
		@endif
	- {{ $products->count() }} Total result
	</h2>
  <div class="row">

  	@foreach($products as $product)
	<a href="/mystore/{{$product->store_username}}/product/{{$product->slug}}"><div class="fc-col">
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
                <a href="/{{ $product->store_username }}/sales/{{ $product->sale_id }}">On Sale</a>
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
  	@endforeach
  </div>
  <div class="fc-pagination">
  		{{ $products->appends(request()->input())->links() }}
  	</div>
</div>
@endsection