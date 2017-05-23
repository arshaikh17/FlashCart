<link rel="stylesheet" type="text/css" href="../../../../../../css/store/category_panel/category-panel-1.css">
<div class="left-menu-area mb-50">
	<div class="menu-title">
		<span><h3><a id="left-menu-opener" data-toggle="collapse" data-target="#left-menu">Categories</a></h3></span>

	</div>
	<div class="left-menu collapse in" id="left-menu">
		<nav>
			<ul class="left-menu-ul">
				@forelse($categories as $category)
				<?php $sub_categories = getSubCategories($category->id);?>
					
					<li>
						<a href="/mystore/{{$store->store_username}}/category/{{$category->category}}">{{$category->category}} @if(count($sub_categories)>0)<i aria-hidden="true" class="fa fa-angle-right pull-right"></i>@endif</a>
						@if(count($sub_categories) > 0)
						<div class="left-mega-menu">
							<span>
								@foreach($sub_categories as $sub)
									<a href="/mystore/{{$store->store_username}}/category/{{$category->category}}/sub_cat/{{ $sub->sub_category }}">{{ $sub->sub_category }}</a>
								@endforeach
							</span>
						</div>
						@endif
					</li>
				@empty
				<li>No categories yet.</li>
				@endforelse
				
			</ul>
		</nav>
	</div>
</div>