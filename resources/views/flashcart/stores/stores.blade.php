@extends('layouts.flashcart')

@section('title')
	Stores @ FlashCart
@endsection

@section('content')
<link rel="stylesheet" type="text/css" href="../../../../css/store/product_area/product-area-1.css" />
<div class="container search_container" id="stores_container">
<h1>Stores at FlashCart</h1>
  
  <div class="row">
    <div class="col-lg-3">
      <div>
        <ul class="list-group">
        <a href="/stores"><li class="list-group-item @if(!isset($category)) active @endif">All Stores</li></a>
          @forelse($store_categories as $store_cat)

          <a href="/stores/category/{{ $store_cat->category_of_store }}"><li class="list-group-item @if(isset($category)) @if($category == $store_cat->category_of_store) active @endif @endif">{{ $store_cat->category_of_store }}</li></a>
          @empty
          No store categories.
          @endif
        </ul>
      </div>
    </div>
      <link rel="stylesheet" type="text/css" href="../../../../css/store/product_area/product-area-1.css" />
    <div class="col-lg-9">

    <div  id="stores">
    <form method="GET" action="/stores/search">
      <input type="text" name="store" id="storeTextBox" value="@if(isset($search)) {{$search}} @endif" placeholder="Enter store name" />
      <button type="submit" id="storeButton"><i class="fa fa-search"></i>&nbsp;&nbsp;&nbsp;Search</button>
    </form>
    	   @forelse(array_chunk($stores->all(), 3) as $stores_row)
      <div class="stores row">
      @foreach($stores_row as $store)
      <div class="product-area">

        <div class="product">
          <div class="product_image"> 
            <img src="../../../../uploads/store/brand_marks/logo/{{ $store->brand_logo }}" alt="{{$store->store_name}}" class="img product_image_content" width="150" />
          </div>
          <div class="product_name">
            <p class="product_name_content marquee"><a href="/mystore/{{$store->store_username}}"><strong>@if(strlen($store->store_name) > 40) {{ substr("$store->store_name", 0, 50) }}... @else {{$store->store_name}} @endif</strong></a></p>
            @if($store->category_of_store != "")
              Category: <strong>{{ $store->category_of_store }}</strong>
            @endif
            @if($store->status == 1)
              <p class="price">Rs. {{ number_format($store->min_wage) }} - Rs. {{ number_format($store->max_wage) }}</p>
            @endif
          </div>
          <div class="actions">
            
            <a href="/mystore/{{$store->store_username}}" class="btn btn-sm btn-primary"><strong>Visit</strong></a>
            @if($store->status == 1)
            <a href="/employ/store/{{$store->store_id}}/{{$store->slug}}" class="btn btn-sm btn-primary">Apply</a>
            @endif
          </div>
        </div>
      </div>
      @endforeach
      @empty
      No stores in this '<strong>{{ $category }}</strong>' category.
      @endforelse
      <div>
    </div>
    @if(!isset($search))
    <div class="pages">
      
      {{ $stores->links() }}
    </div>
    @endif
    </div>
  </div>

</div>
</div>
</div>
<style>
.product_image img
{
    margin-left: 5px;
}
#storeTextBox
{
  width: 80%;
  padding-top: 8px;
  padding-bottom: 8px;
  padding-left: 9px; 
  padding-right: 6px;
  border: 1px solid #0050A0;
  background-color: transparent;
  color: #0050A0;
}
#storeButton
{
  padding-top: 8px;
  padding-bottom: 8px;
  padding-left: 6px; 
  padding-right: 10px;
  background-color: #0050A0;
  color: white;
  border: 0;
}

.pages
{
  margin-left: 400px;
}
.actions
{
  margin-left: 50px;
}
.actions .btn-primary
{
  border-radius: 0 !important;
}
.stores
{
  flex: wrap;
  list-style: none;
margin-top: 10px;
margin-left: 0px !important;
}
.stores li
{
    margin-right: 10px !important;
  margin-bottom: 10px !important;
}
.product-area
{
  /*display: inline-flex;*/
  display: inline-flex;
  margin-right: 15px;
  margin-bottom: 20px; 
  width: 216px !important;
  min-width: 216px !important;
  height: 340px !important;
  min-height: 340px !important;
}
  .list-group-item
  {
    border-radius: 0 !important;
    margin-bottom: 3px !important;
    border: 0 !important;
    border-bottom: 2px solid #0050A0 !important;
  }
  .active
  {
    background-color: #0050A0 !important;
  }
  #stores_container
  {
    padding-bottom: 220px;
  }
</style>
@endsection
