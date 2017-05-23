@extends('layouts.store', ['store'=>$store])

@section('store-title')
{{ $store->store_name }} - Employees
@endsection

@section('store-view')
Employment Area
@endsection
@section('store-subview')
Edit Employee
@endsection

@section('store-breadcrumb')
<li><a href="/store/employment">Employment Area</a></li>
<li><a href="/store/employment">All Employees</a></li>
<li>Edit Employee</li>
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
<section class="col-lg-8 col-lg-offset-2">
<div class="box box-default">
    <div class="box-header">
        <div class="box-title">Edit Service</div>
    </div>
	<div class="box-body">
        <span><h2>{{ $employee->name }} - joined {{ $employee->created_at->diffForHumans() }}</h2></span>
        <hr />
		<form method="POST" action="/store/employment/employees/edit/save">
            {{ csrf_field() }}
            <input type="text" class="hidden" name="emp_id" value="{{ $employee->emp_id }}" />
            <div class="form-group">
                Salary: <input type="text" class="form-control" name="emp_salary" value="{{ $employee->emp_salary }}" />
            </div>

            <div class="form-group">
                Position: <input type="text" class="form-control" name="emp_position" value="{{ $employee->emp_position }}" />
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" name="submit" value="Save" />
            </div>
        </form>
	</div>
</div>
</section>
@endsection

@section('jquery')
<script>
</script>
@endsection

@section('css')
<style>
</style>
@endsection