@extends('layouts.flashcart', ['search'=>$search])

@section('title')
  Welcome to FlashCart
@endsection

@section('content')
<?php 
  $identifiers = getIdentifiers();
  $categories = getCategories();
  $products_0 = getCategoryProducts($identifiers[0]->identifier);
  $products_1 = getCategoryProducts($identifiers[1]->identifier);
  $products_2 = getCategoryProducts($identifiers[2]->identifier);
  $products_3 = getCategoryProducts($identifiers[3]->identifier);
  $products_4 = getCategoryProducts($identifiers[4]->identifier);

?>
<div id="home">
<img src="../../../../uploads/service/index-background-2k.jpg" width="1000" />
<div id="home_div">
  <div class="container" id="home_div_content">
    <h1 id="heading">Find your product!</h1>
    <h4 id="tag_line">Search what you are looking for.</h4>
    <form method="GET" action="/product/search">
      <input type="text" name="product" id="search" placeholder="Enter product name" class="searchTextBox" />
      <button type="submit" id="quick-search" class="btn btn-custom"><span class="glyphicon glyphicon-search custom-glyph-color"></span></button>
    </form>
    <br />
    <a href="#" class="featured_anchor">view <i class="fa fa-chevron-down"></i> featuring</a>
  </div>
</div>
</div>
<div class="featured_div container" id="row-container">
  <div class="featured_close">
    <a href="#" class="featured_anchor_close">close <i class="fa fa-chevron-up"></i> featuring</a>
  </div>
  <div class="search-bar">
    <form method="GET" action="/product/search">
      <input type="text" name="product" placeholder="Enter product name" />
      <button>
      <i class="fa fa-search"></i>
      <span>Current Search</span>
      </button>
    </form>
  </div>
  <div class=" items-container" id="container-1">
    <div class="top-row row" id="row-1">
      <span class="row-icon"><i class="{{ $identifiers[0]->icon }} fa-fw"></i></span><span class="row-title">{{ $identifiers[0]->identifier }}</span>
    </div>
    <div class="row item-row" id="item-row-1">
      <div class="col-xs-2 col-lg-2 categories">
        <ul class="list-group categories-list">
          @forelse($categories as $category)
          @if($category->identifier_id == $identifiers[0]->pci_id)
          <a href="/category/{{$identifiers[0]->identifier}}/"><li class="list-group-item category-item">{{ $category->category }}</li></a>
          @endif
          @empty
          <li class="list-group-item category-item">No categories in this section</li>
          @endforelse
        </ul>
      </div>
      <div class="col-xs-10 col-lg-10">
        <div class="products">
          @forelse($products_0 as $product)
          <div class="product">
            <div class="product-image">
              <img class="img-responsive" src="../../../../../uploads/store/products/{{ $product->product_image1 }}" width="130" height="130" alt="{{ $product->product_name }}" />
            </div>
            <div class="product-description">
              <a href="">{{ substr($product->product_name, 0, 40) }}</a>
              <p class="price">Rs. {{ price_check($product->product_discout, $product->product_price, $product->sale_id, $product->discount, $product->status) }} /-</p>
              <p>@ {{ returnStore($product->store_id)->store_name }}</p>
            </div>
          </div>
          @empty
          No products featuring.
          @endforelse
        </div>
      </div>
    </div>
  </div>
  <div class=" items-container" id="container-2">
    <div class="top-row row" id="row-2">
      <span class="row-icon"><i class="{{ $identifiers[1]->icon }} fa-fw"></i></span><span class="row-title">{{ $identifiers[1]->identifier }}</span>
    </div>
    <div class="row item-row" id="item-row-2">
      <div class="col-xs-2 col-lg-2 categories">
        <ul class="list-group categories-list">
          @forelse($categories as $category)
          @if($category->identifier_id == $identifiers[1]->pci_id)
          <a href="/category/{{$identifiers[1]->identifier}}/"><li class="list-group-item category-item">{{ $category->category }}</li></a>
          @endif
          @empty
          <li class="list-group-item category-item">No categories in this section</li>
          @endforelse
        </ul>
      </div>
      <div class="col-lg-10">
        <div class="products">
          
          @forelse($products_1 as $product)
          <div class="product">
            <div class="product-image">
              <img class="img-responsive" src="../../../../../uploads/store/products/{{ $product->product_image1 }}" width="130" height="130" alt="{{ $product->product_name }}" />
            </div>
            <div class="product-description">
              <a href="">{{ substr($product->product_name, 0, 40) }}</a>
              <p class="price">Rs. {{ price_check($product->product_discout, $product->product_price, $product->sale_id, $product->discount, $product->status) }} /-</p>
              <p>@ {{ returnStore($product->store_id)->store_name }}</p>
            </div>
          </div>
          @empty
          No products featuring.
          @endforelse
        </div>
      </div>
    </div>
  </div>
  <div class=" items-container" id="container-3">
    <div class="top-row row" id="row-3">
      <span class="row-icon"><i class="{{ $identifiers[2]->icon }} fa-fw"></i></span><span class="row-title">{{ $identifiers[2]->identifier }}</span>
    </div>
    <div class="row item-row" id="item-row-3">
      <div class="col-xs-2 col-lg-2 categories">
        <ul class="list-group categories-list">
          @forelse($categories as $category)
          @if($category->identifier_id == $identifiers[2]->pci_id)
          <a href="/category/{{$identifiers[2]->identifier}}/"><li class="list-group-item category-item">{{ $category->category }}</li></a>
          @endif
          @empty
          <li class="list-group-item category-item">No categories in this section</li>
          @endforelse
        </ul>
      </div>
      <div class="col-lg-10">
        <div class="products">
          
          
          @forelse($products_2 as $product)
          <div class="product">
            <div class="product-image">
              <img class="img-responsive" src="../../../../../uploads/store/products/{{ $product->product_image1 }}" width="130" height="130" alt="{{ $product->product_name }}" />
            </div>
            <div class="product-description">
              <a href="">{{ substr($product->product_name, 0, 40) }}</a>
              <p class="price">Rs. {{ price_check($product->product_discout, $product->product_price, $product->sale_id, $product->discount, $product->status) }} /-</p>
              <p>@ {{ returnStore($product->store_id)->store_name }}</p>
            </div>
          </div>
          @empty
          No products featuring.
          @endforelse
        </div>
      </div>
    </div>
  </div>
  <div class=" items-container" id="container-4">
    <div class="top-row row" id="row-4">
      <span class="row-icon"><i class="{{ $identifiers[3]->icon }} fa-fw"></i></span><span class="row-title">{{ $identifiers[3]->identifier }}</span>
    </div>
    <div class="row item-row" id="item-row-4">
      <div class="col-xs-2 col-lg-2 categories">
        <ul class="list-group categories-list">
          @forelse($categories as $category)
          @if($category->identifier_id == $identifiers[3]->pci_id)
          <a href="/category/{{$identifiers[3]->identifier}}/"><li class="list-group-item category-item">{{ $category->category }}</li></a>
          @endif
          @empty
          <li class="list-group-item category-item">No categories in this section</li>
          @endforelse
        </ul>
      </div>
      <div class="col-lg-10">
        <div class="products">
          
          
          @forelse($products_3 as $product)
          <div class="product">
            <div class="product-image">
              <img class="img-responsive" src="../../../../../uploads/store/products/{{ $product->product_image1 }}" width="130" height="130" alt="{{ $product->product_name }}" />
            </div>
            <div class="product-description">
              <a href="">{{ substr($product->product_name, 0, 40) }}</a>
              <p class="price">Rs. {{ price_check($product->product_discout, $product->product_price, $product->sale_id, $product->discount, $product->status) }} /-</p>
              <p>@ {{ returnStore($product->store_id)->store_name }}</p>
            </div>
          </div>
          @empty
          No products featuring.
          @endforelse
        </div>
      </div>
    </div>
  </div>
  <div class=" items-container" id="container-6">
    <div class="top-row row" id="row-6">
      <span class="row-icon"><i class="{{ $identifiers[4]->icon }} fa-fw"></i></span><span class="row-title">{{ $identifiers[4]->identifier }}</span>
    </div>
    <div class="row item-row" id="item-row-6">
      <div class="col-xs-2 col-lg-2 categories">
        <ul class="list-group categories-list">
          @forelse($categories as $category)
          @if($category->identifier_id == $identifiers[4]->pci_id)
          <a href="/category/{{$identifiers[4]->identifier}}/"><li class="list-group-item category-item">{{ $category->category }}</li></a>
          @endif
          @empty
          <li class="list-group-item category-item">No categories in this section</li>
          @endforelse
        </ul>
      </div>
      <div class="col-lg-10">
        <div class="products">
          
          @forelse($products_4 as $product)
          <div class="product">
            <div class="product-image">
              <img class="img-responsive" src="../../../../../uploads/store/products/{{ $product->product_image1 }}" width="130" height="130" alt="{{ $product->product_name }}" />
            </div>
            <div class="product-description">
              <a href="">{{ substr($product->product_name, 0, 40) }}</a>
              <p class="price">Rs. {{ price_check($product->product_discout, $product->product_price, $product->sale_id, $product->discount, $product->status) }} /-</p>
              <p>@ {{ returnStore($product->store_id)->store_name }}</p>
            </div>
          </div>
          @empty
          No products featuring.
          @endforelse
        </div>
      </div>
    </div>
  </div>
  <br />
  <div class="featured_close">
    <a href="#" class="featured_anchor_close">close <i class="fa fa-chevron-up"></i> featuring</a>
  </div>
</div>
@endsection