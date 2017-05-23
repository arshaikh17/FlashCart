<div class="panel panel-default">
	<div class="panel-heading" data-toggle="collapse" data-target="#categories">
		Categories
	</div>
	<div class="panel-collapse collapse in" id="categories">
		<div class="panel-body">
			<ul class="list-group">
				<a class="fc-list-a" href="/mystore/{{$store->store_username}}/products/category/all" title="All Products"><li class="list-group-item">All Products</li></a>
				@foreach($categories as $category)
				<a class="fc-list-a" href="/mystore/{{$store->store_username}}/products/category/{{$category->category}}" title="{{$category->category}}"><li class="list-group-item">{{$category->category}}</li></a>
				@endforeach
			</ul>
		</div>
	</div>
</div>