<!DOCTYPE html>
<html>
<head>
	<title>{{ $store->store_name }}</title>
	<meta charset="utf-8">
  	<meta name="viewport" content="width=device-width, initial-scale=1">
  	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  	<script src="../../../../../../../../../js/jquery.min-1.12.0.js"></script>
  	        <script src="../../../../../../../../../js/jquery-ui.js"></script>
  	        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="../../../../../../../../css/jquery-ui.css">
        <link rel="stylesheet" type="text/css" href="../../../../../../../../css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../../../../../../../../css/store/layout/layout-1.css">
  	<style>
		body
		{
			font-family: Open Sans !important;
		}
	</style>
</head>

<body>
	<div class="container">
		@yield('header')
		<div class="container">
			<div class="row">
				<div class="col-lg-3 col-md-3 col-xs-3">
					@yield('categories')
					@yield('sales')
				</div>
				<div class="col-lg-9 col-md-9 col-xs-9">
					<div class="products">
						@yield('body')
					</div>
				</div>
			</div>
		</div>
	</div>


	<!--<div class="container">
		<div class="row">
			<div class="col-md-3">
				@yield('categories')
			</div>
			<div class="col-md-9">
				@yield('body')
			</div>
		</div>
	</div>
	-->
	
</body>
</html>