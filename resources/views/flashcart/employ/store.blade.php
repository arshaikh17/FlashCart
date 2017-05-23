@extends('layouts.flashcart')

@section('title')
	{{ $store->store_name }}
@endsection

@section('content')
<div id="descriptionDiv" class="container padded_container">
<h1>{{ $store->store_name }}</h1>
	<div class="row">
		<div class="col-md-8" id="description">
			<div class="panel panel-primary">
				<div class="panel-body">
					<div class="panel-heading less-height">
						<p>Description</p>
					</div>
					<div class="panel-body">						
						<p id="description-content" class="justify">{{ $store->description }}</p>
					</div>
					<div class="panel-heading less-height">
						<p>Employment Policy</p>
					</div>
					<div class="panel-body">
						<p class="justify">{{ $store->emp_policy }}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4" id="statistic">
			<div class="panel panel-body">
				<div class="panel-heading less-height">
					<p>Statistics</p>
				</div>
				<div class="panel-body">
					Number of Employees: {{ count($employees)}}
					<br/>
					Orders Served: {{count($orders)}}
				</div>
			</div>
			<div class="panel panel-body">
				<div class="panel-heading less-height">
					<p>Apply!</p>
				</div>
				<div class="panel-body">
					<span>Salary:</span>
					<hr />
					<span>From: </span><span>{{ number_format($store->min_wage) }} Rs.</span>
					<br />
					<span>To: </span><span>{{ number_format($store->max_wage) }} Rs.</span>
				</div>
				<div class="panel-footer">
					<div id="input-apply">
						<a href="/employ/store/{{ $store->store_id}}/{{ $store->slug}}/apply">Apply Now!</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<style>
#descriptionDiv
{
	padding-bottom: 220px !important;
}
.panel-heading
{
	border-left: 4px solid #0050A0 !important;
}

.panel
{
	-webkit-box-shadow: 3px 3px 5px 0.5px #dbdbdb;
	box-shadow: 3px 3px 5px 0.5px #dbdbdb;
}
#description
{
}
#statistic
{
}
#description-content
{
	color: black;
}
#tagline-content
{
	color: black;
	font-style: italic;
}
#title-content
{
	color: black;
}
.jumbotron
{
	background-color: white !important;
}
#brandmark-logo
{
	margin-top: 20px;
	display: block;
	height: 215px;
	min-height: 50px; 
}
#brand-name
{
	margin-top: 20px;
	display: block;	
}
</style>
@endsection

