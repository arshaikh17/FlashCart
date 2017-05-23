@extends('layouts.store', ['store'=>$store])

@section('store-view')
Settings
@endsection
@section('store-subview')
Main Settings
@endsection

@section('store-breadcrumb')
<li><a href="/store/settings">Settings</a></li>
<li>Main Settings</li>
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
        <div class="box-header"><div class="box-title">Store's Setting</div></div>
        <div class="box-body">
            <form class="form-horizontal" role="form" method="POST" action="/store/settings/update_store" id="storeUpdate">
                {{ csrf_field() }}
                <div class="form-group{{ $errors->has('store_username') ? ' has-error' : '' }}">
                    <label for="store_username" class="col-md-4 control-label">Username</label>
                    <div class="col-md-6">
                        <input id="store_username" type="text" class="form-control" value="{{ $store->store_username }}" name="store_username" value="{{ old('store_username') }}" required autofocus>
                        <span class="error" id="username_error"></span>
                        @if ($errors->has('store_username'))
                        <span class="help-block">
                            <strong>{{ $errors->first('store_username') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group{{ $errors->has('store_name') ? ' has-error' : '' }}">
                    <label for="store_name" class="col-md-4 control-label">Store Name</label>
                    <div class="col-md-6">
                        <input id="store_name" type="text" class="form-control" value="{{ $store->store_name }}" name="store_name" value="{{ old('store_name') }}" required autofocus>
                        <span class="error" id="name_error"></span>
                        @if ($errors->has('store_name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('store_name') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <input type="text" class="hidden" id="slug" name="slug" value="{{ $store->slug }}" />
                <div class="form-group{{ $errors->has('store_email') ? ' has-error' : '' }}">
                    <label for="store_email" class="col-md-4 control-label">Store Email</label>
                    <div class="col-md-6">
                        <input id="store_email" type="text" class="form-control" value="{{ $store->store_email }}" name="store_email" value="{{ old('store_email') }}" required autofocus>
                        <span class="error" id="email_error"></span>
                        @if ($errors->has('store_email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('store_email') }}</strong>
                        </span>
                        @endif
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <input value="Save" type="submit" class="btn btn-primary" id="save" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
