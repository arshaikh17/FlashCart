

@foreach($store_categories as $cats)
	<a href="/employ/search?category={{ $cats->category_of_store }}"><i class="{{ $cats->label }}" aria-hidden="true"></i>
 {{ $cats->category_of_store }}</a>
@endforeach
