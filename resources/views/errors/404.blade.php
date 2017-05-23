@extends('layouts.flashcart')

@section('title')
404 - Page Not Found
@endsection

@section('content')
<div class="main-container">
	
	<div class="error search_container">
		<h1>404</h1>
		<p>The page you are searching for doesn't exist.</p>
	</div>
	<div class="container"> 
		
	<ul>
		<h4>Possibility of this: </h4>
		<li>Wrong url</li>
		<li>Page mistakenly deleted</li>
		<li>Page is currently disabled</li>
		<li><strong><a href="/report">report the issue?</a></strong></li>
	</ul>
	</div>
</div>
<style>
.main-container
{
	padding-bottom: 50px;
	color: #0050A0;
}
.error
{
	
	text-align: center;
}
.error h1
{
	font-size: 180px;
}
.error p
{
	font-size: 20px;
}
ul
{
	list-style: none;
}
</style>
@endsection