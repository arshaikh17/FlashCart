@extends('layouts.flashcart')

@section('title')
	Request Feature - FlashCart
@endsection

@section('content')
<div class="main-container container">
	<div class="search_container">
		<h1>Request Feature</h1>
		Here you can submit any new feature that you didn't experience in FlashCart.com.pk. We will be highly obliged if you provide a response to our organization. Make sure you describe the functionality wise and clear so our team can start working on it whenever feasible.
		<br />
		<br />
		<div class="container" id="formContainer">
			<form method="POST" action="/request-feature/save" enctype="multipart/form-data">
				{{ csrf_field() }}
				<h3>About You</h3>
				<hr />
				<div class="row">
					Your Name
					<input type="text" class="custom_text" name="name" placeholder="Enter your name" required />
				</div>
				<div class="row">
					Email Address
					<input type="email" class="custom_text" name="email" placeholder="Enter your email address" required />
				</div>
				<br />
				<h3>Feature</h3>
				<hr />
				<div class="row">
					Title
					<input type="text" class="custom_text" name="title" placeholder="Enter name of feature you think best" required />
				</div>
				<div class="row">
					Description
					<textarea class="custom_text" name="description" placeholder="Enter description of your report" required></textarea>
				</div>
				<div class="row">
					Level of Priority
					<select name="priority" class="custom_text" required>
						<option selected disabled>Select the priority with respect to organization</option>
						<option value="highest">Highest</option>
						<option value="high">High</option>
						<option value="medium">Medium</option>
						<option value="low">Low</option>
						<option value="lowest">Lowest</option>
					</select>
				</div>
				<br />
				<h3>Support</h3>
				<hr />
				<div class="row">
					Link
					<input type="text" name="link" class="custom_text" placeholder="Link if any page of website has it" />
				</div>
				<div class="row">
					Upload any image
					<input type="file" name="support" />
				</div>
				<div class="row">
					<input type="submit" value="Request" class="custom_button pull-right" />
				</div>
			</form>
		</div>
	</div>
</div>
<style>
hr
{
	padding-bottom: 5px;
	border-bottom: 2px solid #0050A0;
}
.main-container
{
	padding-bottom: 50px;
	color: #0050A0;
}
.custom_text
{
	padding-top: 8px;
	padding-bottom: 8px;
	padding-left: 8px;
	padding-right: 8px;
	width: 100%;
	border: 2px solid #0050A0;
}
#formContainer .row
{
	margin-bottom: 10px !important;
}
textarea
{
	resize: none;
}
.custom_button
{
	padding-top: 10px;
	padding-bottom: 10px;
	padding-left: 10px;
	padding-right: 10px;
	border: none;
	background-color: #0050A0;
	color: white;
}
</style>
@endsection