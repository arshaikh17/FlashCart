@extends('layouts.store')

@section('storetitle')
{{ $store->store_name }} - Employment Management
@endsection

@section('storecontent-alert')
@if($errors->any())
    <div class="container">
        <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>NOTE!</strong> {!! $errors->first('check') !!}
        </div>
    </div>
    @endif
@endsection

@section('storecontent-success')
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

@section('storecontent')
<div class="panel panel-default">
    <div class="panel-heading">Policy Management</div>

    <div class="panel-body">
        <form class="form-horizontal" role="form" method="POST" action="/store/settings/update_employment" id="storeEmployment">
        {{ csrf_field() }}
        
        	<div class="form-group">
                <label for="title" class="col-md-6 control-label">Status of Employment: </label>
                <div class="col-md-4">

                	@if($employment->status == 1)
        			<input type="checkbox" onchange="this.form.submit();" name="employ"  checked  />
        			<input type="text" class="hidden" name="emp_val" value="1">
        			@elseif($employment->status == 0)
        			<input type="checkbox" onchange="this.form.submit();" name="employ" />
        			<input type="text" class="hidden" name="emp_val" value="0">
        			@endif
        			(Current: <strong>@if($employment->status==1)ON @elseif($employment->status==0) OFF @endif</strong> )
				</div>
				@if($errors->any())
            		<span>{{ $errors->first() }}</span>
        		@endif
            </div>
       </form>
       <hr />
       @if($employment->status == 1)
       <form  class="form-horizontal" role="form" method="POST" action="/store/settings/setting_employment_wages" id="storeEmploymentWages">
       {{ csrf_field() }}
            <div class="form-group">

                <label for="title" class="col-md-4 control-label">Minimum Wage</label>
                <div class="col-md-6">
                    <input id="title" type="text" value="{{ $employment->min_wage }}" class="form-control" name="min_wage" autofocus>
                    <span class="error" id="title_error"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="title" class="col-md-4 control-label">Maximum Wage</label>
                <div class="col-md-6">
                    <input id="title" type="text" value="{{ $employment->max_wage }}" class="form-control" name="max_wage" autofocus>
                    <span class="error" id="title_error"></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <input value="Save" type="submit" class="btn btn-primary" id="saveDetails" />
                </div>
            </div>
        </form>
        @else
        <p>Please turn ON your employment to set up wages.</p>
        @endif
    </div>
</div>
@endsection


@section('storecontent-right')
@include('store.static.settingmenu')
@endsection