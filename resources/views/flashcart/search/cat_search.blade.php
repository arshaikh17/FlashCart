@extends('layouts.flashcart', ['search'=>$search])

@section('title')
  @if(isset($subCat))
    @if($subCat != "")
    {{ $subCat }}, {{$iCat}} - FlashCart
    @else
    {{$iCat}} - FlashCart
    @endif
  @elsei
    {{$iCat}} - FlashCart
  @endif
@endsection


@section('content')
<section class="left-right-side search_section search_container container">
  <div class="">
    <div class="row">
      <div class="left-side">
        <div class="col-md-3">
          <!-- Start  Prices-->
          <div class="left_category">
            <div class="h">Categories</div>
            @forelse($categories as $cat)
            <a class="left_categories @if($cat->identifier == $iCat) active_category @endif" href="/category/{{ $cat->identifier }}/">&nbsp;&nbsp;&nbsp;{{ $cat->identifier }}</a>
            @empty
            <p>No categories</p>
            @endforelse
          </div>
          <div class="left_category">
            <div class="h">Related Categories</div>
            @forelse($sub_categories as $cat)
            <a class="left_categories @if($type==2) @if($cat->category == $subCat) active_category @endif @endif" href="/category/{{ $cat->identifier }}/{{ $cat->category }}/">&nbsp;&nbsp;&nbsp;{{ $cat->category }}</a>
            @empty
            <p>No related categories</p>
            @endforelse
          </div>
        </div>
        </div>
        <div class="right-side"> <!-- Start right side-->
        <div class="col-md-9">
          <div class="search-bar">
            <form method="GET" action="/product/search">
              <input type="text" name="product" value="{{$search}}" placeholder="Enter product name" />
              <button>
              <i class="fa fa-search"></i>
              <span>Current Search</span>
              </button>
            </form>
          </div>
          <div class="row">
            <div class="all">
              <div class="search-tool row">
                <div class="result">
                  @if($type == 1)
                  <span class="row-icon"><i class="fa fa-eye  fa-fw"></i></span><span class="row-title">Search Results for Category <span style="color:#E5002B">{{$iCat}}</span> - Results : ({{$products->total()}})</span>
                  @elseif($type == 2)
                  <span class="row-icon"><i class="fa fa-eye  fa-fw"></i></span><span class="row-title">Search Results for Category <span style="color:#E5002B">{{$iCat}}</span> and Sub Category <span style="color:#E5002B">{{$subCat}}</span> - Results : ({{count($products)}})</span>
                  @endif
                </div>
              </div>
              
              <div class="products">
                @foreach($products as $product)
                <div class="product">
                  <div class="element">
                    <img src="../../../../../uploads/store/products/{{ $product->product_image1 }}" width="200" height="200" alt="{{$product->product_name}}"/>
                    @if($product->product_quantity > 0)
                    <a href="/store/{{$product->store_username}}/product/{{$product->product_id}}/add_to_cart" class="add_to_cart"><i class="fa fa-shopping-cart"></i>Add to Cart</a>
                    <div class="info-pro">
                      <a href="/mystore/{{ $product->store_username }}/product/{{ $product->product_id }}/{{ $product->slug }}">{{ substr($product->product_name,0,60) }}</a>
                      <span>Rs {{ price_check($product->product_discount, $product->product_price, $product->sale_id, $product->discount, $product->sale_status) }} /-</span>
                      <p>In stock</p>
                    </div>
                    @else
                    <div class="info-pro">
                      <a href="/mystore/{{ $product->store_username }}/product/{{ $product->product_id }}/{{ $product->slug }}">{{substr($product->product_name,0,60)}}</a>
                      <span>Rs {{ price_check($product->product_discount, $product->product_price, $product->sale_id, $product->discount, $product->sale_status) }} /-</span>
                      <p>Out of stock</p>
                    </div>
                    @endif
                  </div>
                </div>
                @endforeach
                <!--End row three-->
                <div class="container">
                {{ $products->links() }}
              </div>
              </div>

            </div>
          </div>
          </div><!-- End right side-->
        </div>
      </div>
    </div>
</section>

                  
@endsection