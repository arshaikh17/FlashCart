@if(count($sales) > 0)
<link rel="stylesheet" type="text/css" href="../../../../../../css/store/sale_area/sale-area-1.css">
<div class="left-menu-area mb-50">
	<div class="menu-title">
		<span><h3><a id="left-menu-opener" data-toggle="collapse" data-target="#left-menu">Sales</a></h3></span>

	</div>
	<div class="left-menu collapse in" id="left-menu">
		<nav>
			<ul class="left-menu-ul">
				@forelse($sales as $sale)
					<li><a href="/mystore/{{ $store->store_username }}/sale/{{$sale->sale_id}}/{{$sale->sale_slug}}">{{$sale->sale_name}}</a></li>
				@empty
					<li>No sales yet.</li>
				@endforelse
			</ul>
		</nav>
	</div>
</div>
@endif