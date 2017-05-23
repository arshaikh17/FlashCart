@extends('layouts.store', ['store'=>$store])

@section('store-view')
Settings
@endsection
@section('store-subview')
Social Media
@endsection

@section('store-breadcrumb')
<li><a href="/store/settings">Settings</a></li>
<li>Social Media</li>
@endsection


@section('store-alertcontent')
@if($errors->any())
  <div class="container">
    <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>NOTE!</strong>  
        {!! $errors->first('check') !!}
    </div>
  </div>
  @section('css')
  <style>
    .check{
  color:red;
  background:red;
  border-radius:50%;
  animation:op 3s ease infinite;
}
@keyframes op{
0%{
  opacity:0;
}
50%{
  opacity:1;
}
100%{
  opacity:0;
}
}
  </style>
  @endsection
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
  @section('css')
  <style>
    .success{
  color:green;
  background:green;
  border-radius:50%;
  animation:op 3s ease infinite;
}
@keyframes op{
0%{
  opacity:0;
}
50%{
  opacity:1;
}
100%{
  opacity:0;
}
}
  </style>
  @endsection
  @endif
@endsection

@section('store-content')
<section class="col-lg-6">
	<div class="box box-primary">
		<div class="box-header">
			<div class="box-title">Social Media Settings</div>
		</div>
		<div class="box-body">
			<div>
				<form method="POST" action="/store/settings/social_media/save">
				{{ csrf_field() }}
					<div class="form-group">
						<div class="row">
							<label class="col-lg-2">
								<i class="fa fa-facebook fa-5x"></i>
							</label>
							<div class="col-lg-10">
								<input type="text" name="social_facebook" value="{{ $social->facebook }}" class="form-control" placeholder="Enter 'facebook' username" />
							</div>
						</div>
					</div>
					<hr />
					<div class="form-group">
						<div class="row">
							<label class="col-lg-2">
								<i class="fa fa-google-plus fa-5x"></i>
							</label>
							<div class="col-lg-10">
								<input type="text" name="social_google" value="{{ $social->google_plus }}" class="form-control" placeholder="Enter 'google plus' username" />
							</div>
						</div>
					</div>
					<hr />
					<div class="form-group">
						<div class="row">
							<label class="col-lg-2">
								<i class="fa fa-twitter fa-5x"></i>
							</label>
							<div class="col-lg-10">
								<input type="text" name="social_twitter" value="{{ $social->twitter }}" class="form-control" placeholder="Enter 'twitter' username" />
							</div>
						</div>
					</div>
					<hr />
					<div class="form-group">
						<input type="submit" class="btn btn-primary pull-right" value="Save" />
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
@endsection