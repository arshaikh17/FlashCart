@extends('layouts.flashcart')

@section('title')
	{{ $store->store_name }} - Apply
@endsection

@if($errors->any())
@section('content-alert')
<div class="container padded_container">
	<div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
  		<strong>NOTE !</strong>  {{ $errors->first('salary_error') }}
	</div>
</div>
@endsection
@endif



@if(session()->has('proposal_successful'))
	@section('main-section')
		<div class="container warning_container">
			{{ $user->name }}, {{ session()->get('proposal_successful') }}<br/>
			Good Luck :)
		</div>
	@endsection
@endif


@section('content')
<div class="search_container">
@if(isset($store_check_ownership))
<div class="container warning_container">
	<div class="col-md-7 col-md-offset-3">
		{{ $user->name }}, you cannot apply to your own store.
	</div>
</div>
@elseif(isset($proposal_check))

<div class="container warning_container">
	<div class="col-md-7 col-md-offset-3">
		{{ $user->name }}, you have already applied to {{ $store->store_name }}. Please wait for their decision.
	</div>
</div>
@elseif(isset($employment_check))
<div class="container warning_container">
	<div class="col-md-7 col-md-offset-3">
		{{ $user->name }}, you are already employeed in {{ $store->store_name }}.
	</div>
</div>
@else
<div id="apply-form" class="container">
	<h1>Apply Form</h1>
	<div class="row">
		<div class="col-md-8">
			<div class="panel panel-primary">
				<div class="panel-body">

					<div class="panel-body">
						<form action="/employ/apply_form" id="applyForm" method="POST">
							{{ csrf_field() }}

							Please sign your proposal, {{ $user->name }}
							<br />
							<div class="form-group">
								<div class="">
									Salary:
								</div>
								<div class="">
									<input type="number" pattern="[0-9]+" name="salary" id="salary" class="form-control" required />
								</div>
							</div>
							<div class="form-group">
								<div class="">
									Proposal:
								</div>
								<div class="">
									<textarea class="form-control" name="proposal" id="proposal" required></textarea>
								</div>
							</div>
							<div class="form-group">
								<input type="submit" name="submit" value="Submit" class="btn btn-primary" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="panel panel-primary">
				<div class="panel-body">
					<div class="panel-heading">
						Note!
					</div>
					<div class="panel-body">
						<p>Make sure your proposal lies in between store's given salary range that is <strong>{{ number_format($store->min_wage)}} Rs.</strong> - <strong>{{ number_format($store->max_wage) }} Rs.</strong> </p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
@endif
<style>
.warning_container
{
    padding-top:20px;

    padding-bottom: 20px;
    text-align:center;
    border-bottom: 2px solid #0050A0;
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
