@extends('layouts.store', ['store'=>$store])

@section('store-title')
{{ $store->store_name }} - Employees
@endsection

@section('store-view')
Employment Area
@endsection
@section('store-subview')
All Employees
@endsection

@section('store-breadcrumb')
<li><a href="/store/employment">Employment Area</a></li>
<li>All Employees</li>
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
<div class="box box-default">
    <div class="box-header">
        <div class="box-title">Employees List</div>
    </div>
	<div class="box-body">
		<table class="table table-responsive table-condensed table-hover">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Position</td>
                    <td>Joined</td>
                    <td>Action</td>
                </tr>
            </thead>
            <tbody>
                @forelse($employees as $employee)
                <tr>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->emp_position }}</td>
                    <td>{{ $employee->created_at->diffForHumans() }}</td>
                    <td>
                        <a class="collapse_achor action_anchor" data-toggle="collapse" data-target="#actions{{$employee->emp_id}}">actions</a>
                        <div class="collapse" id="actions{{$employee->emp_id}}">
                            <a href="/store/employment/employees/edit/{{ $employee->emp_id }}">edit</a><br />
                        </div>
                    </td>
                </tr>
                @empty
                    No Employees yet.
                @endforelse
            </tbody>
        </table>
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
.action_anchor
{
    cursor: pointer;
}
</style>
@endsection