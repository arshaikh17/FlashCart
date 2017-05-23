@extends('layouts.store', ['store'=>$store])

@section('store-view')
Employment Area
@endsection
@section('store-subview')
Proposal
@endsection

@section('store-breadcrumb')
<li><a href="/store/employment">Employment Area</a></li>
<li><a href="/store/employment">All Requests</a></li>
<li>Proposal</li>
@endsection

@section('store-alertcontent')
@if($errors->any())
  <div class="container">
    <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>NOTE!</strong>  
        {!! $errors->first('category_check') !!}
        {!! $errors->first('privilege_check') !!}
    </div>
  </div>
  @endif
@endsection
@section('store-successcontent')
@if(session()->has('message'))
  <div class="container">
    <div class="alert alert-success alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>SUCCESS!</strong>  
        {!! session()->get('message') !!}
    </div>
  </div>
  @endif
@endsection

@section('store-content')
<section class="col-lg-12">
<div class="box box-default" id="user_profile_view">
	<div class="box-body">
		<div class="row">
    		<div class="col-sm-2 col-md-2"><img title="{{ $user->name }}" class="img-responsive img-thumbnail" src="/uploads/user/pictures/{{ $user->picture }}"></div>
  			<div class="col-sm-4 col-md-4"><h1>{{ $user->name }}</h1></div>
    	</div>
    	<hr />
    	<div class="row">
    		<div class="col-md-5">
	    		<div class="box box-default">
	    			<div class="box-header">
	    				<div class="box-title">About <i class="fa fa-address-card" aria-hidden="true"></i></div>
	    			</div>
	    			<div class="box-body">
	    				<span><strong>Email:</strong> <a class="pull-right">{{ $user->email }}</a></span>
	    				<br />
	    				<strong>Date of Birth:</strong> <span class="pull-right">{{ date('F d, Y', strtotime($user->dob)) }}</span>
	    				<hr />
	    				
	    				<strong>Joined: </strong><span class="pull-right">{{ date('F d, Y', strtotime($user->created_at)) }}</span>
	    			</div>
	    		</div>
	    		<div class="box box-default">
    				<div class="box-header">
    					<div class="box-title">Stores <i class="fa fa-shopping-cart" aria-hidden="true"></i></div>
    				</div>
    				<div class="box-body">
    					<strong>Personal Stores:</strong>
    					<hr />
    					@forelse($user_stores_owner as $owner)
    						<a href="/{{ $owner->store_username }}">{{ $owner->store_name }}</a>
    						<br />
    					@empty
    						None yet.
    					@endforelse
    					<hr />
    					<strong>Employeed At:</strong>
    					<hr />
    					@forelse($user_stores_employee as $employee)
    						<a href="/{{$employee->store_username}}">{{ $employee->store_name }}</a>
    						<br />
    					@empty
    						None yet.
    					@endforelse
    				</div>
    			</div>
    			<div class="box box-default">
    				<div class="box-header">
    					<div class="box-title">Social <i class="fa fa-users" aria-hidden="true"></i></div>
    				</div>
    				<div class="box-body">
    					@if(isset($user->website))
    						<a href="http://{{ $user->website }}">{{ $user->website }}</a>
    					@else
    						No personal website.
    					@endif
    					<hr />
    					@if(isset($user->facebook))
    						<a href="http://www.facebook.com/{{ $user->facebook }}"><i class="fa fa-facebook-official fa-3x" aria-hidden="true"></i></a>&nbsp;
    					@endif
    					@if(isset($user->google))
    						<a href="http://www.plus.google.com/{{ $user->google }}"><i class="fa fa-google-plus-official fa-3x" aria-hidden="true"></i></a>&nbsp;
    					@endif
    					@if(isset($user->twitter))
    						<a href="http://www.twitter.com/{{ $user->twitter }}"><i class="fa fa-twitter fa-3x" aria-hidden="true"></i></a>&nbsp;
    					@endif
    					@if(isset($user->instagram))
    						<a href="http://www.instagram.com/{{ $user->instagram }}"><i class="fa fa-instagram fa-3x" aria-hidden="true"></i></a>&nbsp;
    					@endif
    				</div>
    			</div>


    		</div>
    		
    		<div class="col-md-6">
    			<div class="box box-default">
    				<div class="box-header">
    					<div class="box-title">Statistics</div>
    				</div>
    				<div class="box-body">
    					Coming soon.
    				</div>
    			</div>
    			<div class="box box-default">
    				<div class="box-header">
    					<div class="box-title">Hire?</div>
    				</div>
    				<div class="box-body">
    					<a href="/store/employment/proposal/{{$user->user_id}}/{{$user->proposal_id}}/{{$user->store_id}}/action/decline" class="btn btn-danger" id="reject_emp">Reject</a>
    					<input type="button" class="btn btn-primary" value="Hire" id="hire_emp" />
    				</div>
    			</div>

    			<div class="box box-default" id="emp_form">
    				<div class="box-header">
    					<div class="box-title">Employ {{ $user->name }}</div>
    				</div>
    				<div class="box-body">
    					<div>
    						<form method="POST" action="/store/employment/proposal/proposal_action_full">
    							{{ csrf_field() }}
    							<div class="form-group">
    								<input type="text" name="proposal_id" class="hidden" value="{{ $user->proposal_id }}" />
    								<input type="text" name="user_id" class="hidden" value="{{ $user->user_id }}" />
    								<input type="text" name="store_id" class="hidden" value="{{ $user->store_id }}" />
    								Salary: <input class="form-control" type="number" name="emp_salary" pattern="[0-9]+" required/>
    								Position: <input type="text" class="form-control" name="emp_position" required />
    							</div>
    								<div class="form-group">
    									<input type="submit" name="submit" class="btn btn-primary" value="Hire!" />
    								</div>
    						</form>
    					</div>
    				</div>
    			</div>
    		</div>
    	</div>
	</div>
</div>
</section>
@endsection


@section('jquery')

<script>
$(document).ready(function()
{
	$('#hire_emp').click(function()
	{
		$("#emp_form").slideDown(500);
	});
});
</script>
@endsection

@section('css')
<style>
#emp_form
{
    display: none;
}
</style>
@endsection