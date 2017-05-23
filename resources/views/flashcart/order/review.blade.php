@extends('layouts.flashcart')

@section('search')
  @include('flashcart.static.product-search', ['search'=>""])
@endsection

@section('title')
  Review your Orders
@endsection

@section('side-menu-section')
	@include('flashcart.static.categories')
@endsection

@section('content')
<div class="container" id="main_review_containter">
  <div class="alert alert-info alert-dismissable fade in">
    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
    <strong>Note!</strong> If your items are from different stores then order slip will be created for each store.
  </div>
<?php
	$total = 0;
	$stores = session('stores');
	for($i=0; $i<count($stores); $i++)
	{
		$products = searchProductArrayByUsername(session('products'), $stores[$i]);
		$store_info = getStoreNameByUsername($stores[$i]);
?>

	<div class="panel panel-default col-lg-8 col-lg-offset-2">
		<div class="panel-heading" data-toggle="collapse" data-target="#{{$stores[$i]}}">
			Order <?php echo $i+1 ?> at {{ $store_info->store_name }}
		</div>

		<form action="/order/place" method="POST">
		<div class="collapse in" id="{{$stores[$i]}}">
			<div class="panel-body">
				{{ csrf_field() }}
				<input type="text" name="s_value" class="hidden" value="{{ $store_info->store_id }}" />
				<input type="text" name="s_value_u" class="hidden" value="{{ $stores[$i] }}" />
				<table class="table table-responsive table-condensed table-hover">
					<thead>
						<tr>
							<td class="td_name"><strong>Name</strong></td>
							<td class="td_qty"><strong>Quantity</strong></td>
							<td class="td_price"><strong>Price</strong></td>
						</tr>
					</thead>
					<tbody>
						@foreach($products as $product)
						<?php 
							
							$details = getProductById($product['product']);
						?>
							<tr>
								<td class="td_name">
									<div class="row">
										<div class="col-lg-1">
											<a href="/mystore/{{$stores[$i]}}/product/{{$details->slug}}"><i aria-hidden="true" class="fa fa-eye"></i></a>
										</div>
										<div class="col-lg-11">
											{{ $details->product_name }}
										</div>
									</div>
								</td>
								<td class="td_qty">
									<div class="">
										<input type="number" name="qty[]" value="1" class="form-control"/>
									</div>
								</td>
								<td class="td_price">
									Rs. {{price_check($details->product_discount, $details->product_price, $details->sale_id, $details->discount, $details->sale_status)}} /-
								</td>
							</tr>
							<?php $total = $total + clearNumber(price_check($details->product_discount, $details->product_price, $details->sale_id, $details->discount, $details->sale_status)) ?>
						@endforeach
					</tbody>
				</table>
			</div>
			<hr />
			<div class="panel-body">
				<p><strong>Address Information</strong></p>
				@if(Auth::user())
				<?php $address = getUserAddressById(Auth::user()->id); ?>
					<div class="row">
						<div class="col-lg-6">
							<input type="radio" name="add_type" class="address_type" id="{{$stores[$i]}}" value="1" checked />&nbsp;Use This Address
							<input type="text" name="address_primary" value="House No. {{$address->house_no}}, Street {{ $address->street }}<br />{{$address->area}}, <br />{{$address->city}},{{$address->state}} - {{$address->postal}}<br />{{$address->phone}}, {{$address->mobile}}" readonly class="hidden" />
							<div id="add_1_{{$stores[$i]}}">
								<br />
								House No. {{$address->house_no}}, Street {{ $address->street }}
								<br />
								{{$address->area}}, 
								<br />
								{{$address->city}}, {{$address->state}} - {{$address->postal}}
								<br />
								{{$address->phone}}, {{$address->mobile}}
							</div>
						</div>
						<div class="col-lg-6">
							<input type="radio" name="add_type" class="address_type" id="{{$stores[$i]}}" value="0" />&nbsp;Use This Address
							<div id="add_0_{{$stores[$i]}}">
								<div class="form-group">	
									<label class="col-lg-4">Buyer Name</label>  
									<div class="col-lg-8">
										<input type="text" name="order_name" class="secondary form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4">House no.</label>  
									<div class="col-lg-8">
										<input type="text" name="address_secondary_hno" class="secondary form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4">Street</label>  
									<div class="col-lg-8">
										<input type="text" name="address_secondary_street" class="secondary form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4">Area</label>  
									<div class="col-lg-8">
										<input type="text" name="address_secondary_area" class="secondary form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4">City</label>  
									<div class="col-lg-8">
										<input type="text" name="address_secondary_city" class="secondary form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4">State</label>  
									<div class="col-lg-8">
										<input type="text" name="address_secondary_state" class="secondary form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4">Postal Code</label>  
									<div class="col-lg-8">
										<input type="text" name="address_secondary_postal" class="secondary form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4">Phone</label>  
									<div class="col-lg-8">
										<input type="text" name="address_secondary_phone" class="secondary form-control" />
									</div>
								</div>
								<div class="form-group">
									<label class="col-lg-4">Mobile</label>  
									<div class="col-lg-8">
										<input type="text" name="address_secondary_mobile" class="secondary form-control" />
									</div>
								</div>
							</div>
						</div>
					</div>
				@else
					<div class="">
						<div id="add_0_{{$stores[$i]}}">order_name
							<div class="form-group">
								<label class="col-lg-3">Buyer Name</label>  
								<div class="col-lg-9">
									<input type="text" name="order_name" class="secondary form-control" required />
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3">House no.</label>  
								<div class="col-lg-9">
									<input type="text" name="address_guest_hno" class="secondary form-control" required />
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3">Street</label>  
								<div class="col-lg-9">
									<input type="text" name="address_guest_street" class="secondary form-control" required/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3">Area</label>  
								<div class="col-lg-9">
									<input type="text" name="address_guest_area" class="secondary form-control" required/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3">City</label>  
								<div class="col-lg-9">
									<input type="text" name="address_guest_city" class="secondary form-control" required/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3">State</label>  
								<div class="col-lg-9">
									<input type="text" name="address_guest_state" class="secondary form-control" required/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3">Postal Code</label>  
								<div class="col-lg-9">
									<input type="text" name="address_guest_postal" class="secondary form-control" required/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3">Phone</label>  
								<div class="col-lg-9">
									<input type="text" name="address_guest_phone" class="secondary form-control" />
								</div>
							</div>
							<div class="form-group">
								<label class="col-lg-3">Mobile</label>  
								<div class="col-lg-9">
									<input type="text" name="address_guest_mobile" class="secondary form-control" required/>
								</div>
							</div>
						</div>
					</div>
				@endif
			</div>
			<?php 
				$payments = getPaymentMethodsByUsername($stores[$i]);
			?>
			<div class="panel-body">
				<p><strong>Payment Method</strong></p>
				<select class="form-control" name="payment_method" required>
					<option disabled selected>Please pick payment method</option>
					@forelse($payments as $payment)
					<option value="{{ $payment->spo_id }}">{{ $payment->payment_name }} - {{ $payment->account_name }}</option>
					@empty
						<p>Store might be in maintainence. No payment methods are available right now.</p>
					@endforelse
				</select>
			</div>
			<div class="panel-footer">
				<div>
					TOTAL: <strong>Rs. {{ number_format($total,'2') }} /-</strong>
				</div>
				<input type="submit" class="btn btn-primary" value="Place Order" />
			</div>
		</div>
		</form>
		
	</div>
	<?php $total = 0; ?>
<?php }?>
</div>
<style>
	#main_review_containter
	{
		padding-bottom: 200px;
	}
</style>
@endsection

@section('jquery')
<script>
$(document).ready(function() {
  $('.address_type').change(function() {
if (this.value == '0') {
  var id = $(this).attr('id');
  $("#add_0_" + id).find("input.secondary").prop("disabled", false);
} else {
  $("#add_0_" + id).find("input.secondary").prop("disabled", true);
}

}); });
</script>
@endsection