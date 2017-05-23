<link  rel="stylesheet" type="text/css"  media="all" href="../../../../../../css/store/single_product/single-product-1.css" />
<div class="">
	<div class="row">
		<div class="col-lg-3 col-md-3 col-xs-3 product_image">
			<img src="../../../../../../uploads/store/products/{{ $product->product_image1 }}" class="image" />
		</div>
		<div class="col-lg-7 col-md-7 col-xs-7 product_head">
			<h3>{{ $product->product_name }}</h3>
			<br />
			<h4>Price: <strong>{{price_check($product->product_discount,$product->product_price,$product->sale_id, $product->discount,$product->status)}}/-</strong></h4>
			<br />
			Category: <strong>{{ $product->category }}</strong>
			<br />
			@if($star_count > 0)
			<?php
				for($i=1; $i<= (int)$star_count; $i++)
				{
			?>
			<i class="fa fa-star"></i>
			<?php
				}
			?>
			@endif
		</div>
	</div>
	<hr />
	<div class="row">
		<div class="col-lg-12">
			<ul class="nav nav-tabs">
				<li><a data-toggle="tab" href="#description">Description</a></li>
				<li class="active"><a data-toggle="tab" href="#details">Details</a></li>
				<li><a data-toggle="tab" href="#review">Reviews & Rantings</a></li>
				<li><a data-toggle="tab" href="#submit">Submit a Review</a></li>
			</ul>
			<div class="tab-content">
				<div id="description" class="tab-pane fade  ">
					<h3>Description</h3>
					<hr>
					<p>{{$product->product_desc}}</p>
				</div>
				<div id="details" class="tab-pane fade in active">
					<h3>Product Brief Details</h3>
					<hr>
					<table class="table table-responsive table-hover table-condensed table-striped">
						<thead>
							<tr>
								<td><strong>Type</strong></td>
								<td><strong>Details</strong></td>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Product Category</td>
								<td>{{ $product->category }}</td>
							</tr>
							<tr>
								<td>Product Code</td>
								<td>{{ $product->product_code }}</td>
							</tr>
							<tr>
								<td>Product Price</td>
								<td>Rs. {{ number_format($product->product_price, 2) }} /-</td>
							</tr>
							<tr>
								<td>Product Discount</td>
								<td>{{ $product->product_discount }}% @if($product->sale_id != "") (no applied due to sale)@endif</td>
							</tr>
							<tr>
								<td>Product Sale</td>
								<td>@if($product->saleid != "") {{$product->sale_name}} @else No related sale. @endif</td>
							</tr>
							<tr>
								<td>Sale Discount</td>
								<td>@if($product->discount !=""){{ $product->discount }}% @else No related sale. @endif</td>
							</tr>
						</tbody>
					</table>
				</div>
				<div id="review" class="tab-pane fade">
					<h3>Reviews and Ratings</h3>
					<hr />
					@forelse($rating as $rate)
					<div class="media">
						<div class="media-left">
							<img src="../../../../uploads/service/img_avatar1.png" class="media-object" style="width:60px">
						</div>
						<div class="media-body">
							<h4 class="media-heading">{{$rate->review_title}}</h4>
							<p>{{$rate->review}}</p>
							<i>{{ $rate->review_name }} - {{ $rate->created_at->diffForHumans() }}</i>
						</div>
					</div>
					<hr>
					@empty
					<p>No reviews, yet.</p>
					@endforelse
					
				</div>
				<div id="submit" class="tab-pane fade  ">
					<h3>Submit a Review</h3>
					<hr>
					<form method="POST" action="/review/product/{{ $product->product_id }}">
						{{ csrf_field() }}
						<fieldset class="rating">
							
							<input type="radio" id="star5" name="rating" value="5" /><label class = "full" for="star5" title="Awesome - 5 stars"></label>
							<input type="radio" id="star4" name="rating" value="4" /><label class = "full" for="star4" title="Pretty good - 4 stars"></label>
							
							<input type="radio" id="star3" name="rating" value="3" /><label class = "full" for="star3" title="Meh - 3 stars"></label>
							
							<input type="radio" id="star2" name="rating" value="2" /><label class = "full" for="star2" title="Kinda bad - 2 stars"></label>
							
							<input type="radio" id="star1" name="rating" value="1" /><label class = "full" for="star1" title="Sucks big time - 1 star"></label>

						</fieldset>
						<input type="text" name="review_name" class="review_text textbox" placeholder="Your Name" />
						<input type="text" name="review_title" class="review_text textbox" placeholder="Title of review" />
						<textarea name="review_review" class="review_text" placeholder="Your review"></textarea>
						<input type="submit" class="custom-buttom pull-right" value="Submit" />
					</form>
				</div>
			</div>
		</div>
	</div>
</div>