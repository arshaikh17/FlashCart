<!DOCTYPE html>
<html>
<head>
	<title>Invoice</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open Sans" rel="stylesheet" type="text/css">
  	<script src="../../../js/jquery.min-3.1.1.js"></script>
	<link rel="stylesheet" type="text/css" href="../../../css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="../../../css/invoice.css" />
	<link rel="stylesheet" type="text/css" href="../../../css/main.css" />
</head>
<body>
	<div class="container invoice-container">
		<div class="col-lg-7 abc col-md-offset-2 invoice">
		<div class="invoice-header">
				<div class="row">
					<div class="col-lg-4">
						<img src="../../../uploads/store/brand_marks/logo/{{ $store->brand_logo }}" height="100" width="100" class="img img-responsive" />
						<div class="store-name">
							<h4 class="align-left">{{ $store->store_name }}</h4>
							<p>Invoice ID: <strong>{{ $invoice_id }}</strong></p>
						</div>
					</div>
					<div class="col-lg-8">
						<p class="align-right address">{!! $order['address'] !!}</p>

					</div>
				</div>
			</div>
			
			<div class="line-separator"></div>

			<div class="invoice-body">
				<div>
					<table class="table table-responsive table-hover">
						<thead>
							<tr>
								<td><strong>Name</strong></td>
								<td><strong>Quantity</strong></td>
								<td><strong>Price</strong></td>
							</tr>
						</thead>
						<tbody>
						<?php 
							$product = array();
							$product = $order['products'];
							$total = 0;					

						?>
						<?php 
							for($i=0;$i<count($product);$i++)
							{
								//dd($product[$i]);
								$details = getProductById($product[$i]);
						?>

							<tr>
								<td>{{ $details->product_name }}</td>
								<td>{{ $order['quantities'][$i] }}</td>
								<td>Rs. <?php $sum = $order['prices'][$i] * $order['quantities'][$i]; echo number_format($sum, 2); $total = $total + $sum; ?>/-</td>
							</tr>
						<?php }?>
						</tbody>

					</table>
					<hr />
					<br />
					<p class="align-right total"><strong>Total: Rs. {{ number_format($total, 2) }}</strong></p>

					<div class="line-separator"></div>
					<br />

					<?php
						$payment = getPaymentMethodsBySpoId($order['payment_id']);
					?>
					<p>Payment Method: {{ $payment->payment_name }}@if($payment->account_name!="") - {{ $payment->account_name }}@endif</p>
				</div>

				<div class="">
					<a href="/order/sign/{{$store->store_username}}" class="btn btn-primary">Sign</a>
				</div>
			</div>
			<br />
			<div class="line-separator"></div>

			<div class="invoice-footer">
				<div class="sign">
					<p class="italic">{{ $store->store_name }} @ FlashCart.com.pk</p>
				</div>
			</div>



		</div>
	</div>
</body>
</html>