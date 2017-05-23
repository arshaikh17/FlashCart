@extends('layouts.flashcart')

@section('title')
	Our Partners - FlashCart
@endsection

@section('content')
<div class="main-container container">
	<div class="search_container">
		<h1>Our Partners</h1>
		Find our partners. Organizations working FlashCart.com.pk
		<br />
		<br />
		<div class="">
			

<div class="container">
    <ul class="timeline">
    @foreach($partners as $partner)

<li @if($partner->partner_id % 2 == 0) class="timeline-inverted" @endif>
	
	
	
	<div class="timeline-badge"><a rel="nofollow" target="_blank" @if($partner->partner_website != "") href="http://{{ $partner->partner_website }} @else href="#" @endif"><i class="fa fa-link"></i></a></div>
	<div class="timeline-panel">
		<div class="row">
			
			<div class="col-lg-3">
				<img src="../../../../uploads/flashcart/partners/{{ $partner->partner_brandmark }}" class="img-responsive img-circle" />
			</div>
			<div class="col-lg-9">
				<div class="timeline-heading">
					<h4 class="timeline-title">{{ $partner->partner_name }}</h4>
				</div>
				<div class="timeline-body">
					<p>{!! $partner->partner_description !!}</p>
				</div>
			</div>
		</div>
	</div>
</li>

    @endforeach

    </ul>
</div>
  </div>
</div>
</div>
<style>
.search_container
{
    min-width: 692px;
}
.timeline-badge a
{
	color: white;
}
.timeline-badge a:hover
{
	color: white;
}
hr
{
	padding-bottom: 5px;
	border-bottom: 2px solid #0050A0;
}
.main-container
{
	padding-bottom: 50px;
	color: #0050A0;
}.timeline {
  list-style: none;
  padding: 20px 0 20px;
  position: relative;
}
.timeline:before {
  top: 0;
  bottom: 0;
  position: absolute;
  content: " ";
  width: 3px;
  background-color: #eeeeee;
  left: 50%;
  margin-left: -1.5px;
}
.timeline > li {
  margin-bottom: 20px;
  position: relative;
}
.timeline > li:before,
.timeline > li:after {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li:before,
.timeline > li:after {
  content: " ";
  display: table;
}
.timeline > li:after {
  clear: both;
}
.timeline > li > .timeline-panel {
  width: 50%;
  float: left;
  border: 1px solid #d4d4d4;
  border-radius: 2px;
  padding: 20px;
  position: relative;
  -webkit-box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
  box-shadow: 0 1px 6px rgba(0, 0, 0, 0.175);
}
.timeline > li.timeline-inverted + li:not(.timeline-inverted),
.timeline > li:not(.timeline-inverted) + li.timeline-inverted {
margin-top: -60px;
}

.timeline > li:not(.timeline-inverted) {
padding-right:90px;
}

.timeline > li.timeline-inverted {
padding-left:90px;
}
.timeline > li > .timeline-panel:before {
  position: absolute;
  top: 26px;
  right: -15px;
  display: inline-block;
  border-top: 15px solid transparent;
  border-left: 15px solid #ccc;
  border-right: 0 solid #ccc;
  border-bottom: 15px solid transparent;
  content: " ";
}
.timeline > li > .timeline-panel:after {
  position: absolute;
  top: 27px;
  right: -14px;
  display: inline-block;
  border-top: 14px solid transparent;
  border-left: 14px solid #fff;
  border-right: 0 solid #fff;
  border-bottom: 14px solid transparent;
  content: " ";
}
.timeline > li > .timeline-badge {
  color: #fff;
  width: 50px;
  height: 50px;
  line-height: 50px;
  font-size: 1.4em;
  text-align: center;
  position: absolute;
  top: 16px;
  left: 50%;
  margin-left: -25px;
  background-color: #0050A0;
  z-index: 100;
  border-top-right-radius: 50%;
  border-top-left-radius: 50%;
  border-bottom-right-radius: 50%;
  border-bottom-left-radius: 50%;
}
.timeline > li.timeline-inverted > .timeline-panel {
  float: right;
}
.timeline > li.timeline-inverted > .timeline-panel:before {
  border-left-width: 0;
  border-right-width: 15px;
  left: -15px;
  right: auto;
}
.timeline > li.timeline-inverted > .timeline-panel:after {
  border-left-width: 0;
  border-right-width: 14px;
  left: -14px;
  right: auto;
}
.timeline-badge.primary {
  background-color: #2e6da4 !important;
}
.timeline-badge.success {
  background-color: #3f903f !important;
}
.timeline-badge.warning {
  background-color: #f0ad4e !important;
}
.timeline-badge.danger {
  background-color: #d9534f !important;
}
.timeline-badge.info {
  background-color: #5bc0de !important;
}
.timeline-title {
  margin-top: 0;
  color: inherit;
}
.timeline-body > p,
.timeline-body > ul {
  margin-bottom: 0;
}
.timeline-body > p + p {
  margin-top: 5px;
}

</style>
@endsection