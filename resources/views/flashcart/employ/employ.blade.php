@extends('layouts.flashcart')

@section('title')
	Employment @ FlashCart
@endsection

@section('content')
<div class="container fc-col-container padded_container">
	<h2>
		@if($search)
			'{{ $search }}' 
		@elseif(isset($category))
    Stores under '{{ $category }}' Category
    @else
			All Stores
		@endif
	- {{ $employment_stores->count() }} Total result
	</h2>
  <div class="row">

  	@foreach($employment_stores as $store)
	  <a href="/employ/store/{{ $store->slug }}"><div class="fc-col">
      <div class="panel panel-primary">
        <div class="panel-heading fc-col-head"><div class="marquee">{{ $store->store_name }}</div></div> 
        <div class="panel-body fc-col-body">
        	<img src="../../../uploads/store/logo/{{ $store->brand_logo }}" class="img-responsive" style="width:100%; height: 100%;" alt="{{ $store->store_name }}" />
        </div>
        <div class="panel-footer fc-col-footer">
        	<span class="min-wage">Rs. {{ number_format($store->min_wage) }}/-  
            </span>
            <br />
            <span class="max-wage">Rs. {{ number_format($store->max_wage) }}/-  
            </span>

        </div>
      </div>
    </div></a>
  	@endforeach
  </div>
  <div class="fc-pagination">
  		{{ $employment_stores->appends(request()->input())->links() }}
  	</div>
</div>
@endsection

@section('jquery')
@endsection