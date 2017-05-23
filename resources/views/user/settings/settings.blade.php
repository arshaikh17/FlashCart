@extends('layouts.user')


@section('user-header')
    <h5><b><i class="fa fa-dashboard"></i> My Settings</b></h5>
@endsection


@section('user-alert')
@if($errors->any())
    <div class="container">
        <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>NOTE!</strong> {!! $errors->first('check') !!}
        </div>
    </div>
    @endif
@endsection

@section('user-success')
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

@section('user-content')

<section class="col-lg-7">
	<div class="panel panel-default">
		<div class="panel-heading">
			Your Primary
		</div>
		<div class="panel-body">
			<form action="/user/settings/primary/save" method="POST">
				{{ csrf_field() }}
				<div class="form-group row">
					<div class="col-md-6">
						Full Name:
						<input type="text" value="{{ Auth::user()->name }}" name="primary_full_name" class="form-control" required />
					</div>
				</div>

				<div class="form-group">
					<input type="submit" value="Save" class="btn btn-primary pull-right" />
				</div>
			</form>
		</div>
	</div>
</section>

<section class="col-lg-5">
	<div class="panel panel-default">
		<div class="panel-heading">
			Profile Picture
		</div>
		<div class="panel-body col-lg-9 col-lg-offset-3">
			<img src="../../../../../uploads/user/pictures/{{ Auth::user()->picture }}" width="200" height="200" class="img-responsive img-thumbnail">
		</div>
		 <hr/>
		<div class="panel-body">
		<p>Upload new</p>
			<form action="/user/settings/picture/save" enctype="multipart/form-data" method="POST">
				{{ csrf_field() }}
				<div class="form-group">
					<div class="" style="overflow: hidden;">
						<input type="file" name="user_picture_new"/>
					</div>
				</div>

				<div class="form-group">
					<input type="submit" value="Save" class="btn btn-primary pull-right" />
				</div>
			</form>
		</div>
	</div>
</section>

@endsection