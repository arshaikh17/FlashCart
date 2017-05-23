@extends('layouts.user')


@section('user-header')
    <h5><b><i class="fa fa-dashboard"></i> My Address</b></h5>
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

<section class="col-lg-10">
	<div class="panel panel-default">
		<div class="panel-heading">
			Address Information
		</div>
		<div class="panel-body">
			<form action="/user/settings/address/edit" method="POST">
				{{ csrf_field() }}
				<div class="form-group row">
					<div class="col-md-6">
						House No.
						<input type="text" value="{{ $address->house_no }}" name="hno" class="form-control" required />
					</div>
					<div class="col-md-6">
						Street
						<input type="text" name="street" value="{{ $address->street }}" class="form-control" required />
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-6">
						Area
						<input type="text" name="area" value="{{ $address->area }}" class="form-control" required />
					</div>
					<div class="col-md-6">
						City
						<input type="text" name="city" value="{{ $address->city }}" class="form-control" required />
					</div>
				</div>

				<div class="form-group row">
					<div class="col-md-6">
						State
						<input type="text" name="state" value="{{ $address->state }}" class="form-control" required />
					</div>
					<div class="col-md-6">
						Postal Code
						<input type="number" name="postal_code" value="{{ $address->postal }}" class="form-control" required />
					</div>
				</div>

				<div class="form-group">
					Phone Number (0xx-xxxxxxxx)
					<input type="text" name="phone" value="{{ $address->phone }}" class="form-control"/>
				</div>

				<div class="form-group">
					Mobile Number (0xxx-xxxxxxx)
					<input type="text" name="mobile" value="{{ $address->mobile }}" class="form-control" required/>
				</div>

				<div class="form-group">
					Mobile Number (if other) (0xxx-xxxxxxx)
					<input type="text" name="mobile_2" value="{{ $address->mobile_2 }}" class="form-control"/>
				</div>

				<div class="form-group">
					<input type="submit" value="Save" class="btn btn-primary pull-right" />
				</div>
			</form>
		</div>
	</div>
	</section>
@endsection