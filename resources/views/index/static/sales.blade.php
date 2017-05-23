<div class="panel panel-default">
	<div class="panel-heading" data-toggle="collapse" data-target="#sales">
		Sales
	</div>
	<div class="panel-collapse collapse in" id="sales">
		<div class="panel-body">
				<a class="fc-list-a" href="/mystore/{{$store->store_username}}/sales/"><li class="list-group-item">All Sales</li></a>
			<ul class="list-group">
				@foreach($sales as $sale)
				<a class="fc-list-a" href="/mystore/{{$store->store_username}}/sale/{{$sale->sale_slug}}"><li class="list-group-item">{{$sale->sale_name}} <span class="badge">{{ sale_product_count($sale->sale_id) }}</span></li></a>
				@endforeach
			</ul>
		</div>
	</div>
</div>