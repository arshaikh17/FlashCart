@extends('layouts.store', ['store'=>$store])

@section('store-view')
Settings
@endsection
@section('store-subview')
Details
@endsection

@section('store-breadcrumb')
<li><a href="/store/settings">Settings</a></li>
<li>Details</li>
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
<section class="col-lg-8">
    <div class="box box-default">
        <div class="box-header"><div class="box-title">Details</div></div>
        <div class="box-body">
            <form class="form-horizontal" role="form" method="POST" action="/store/settings/save_details" id="storeDetail">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="tagline" class="col-md-4 control-label">Tagline</label>
                    <div class="col-md-6">
                        <input id="tagline" type="text" class="form-control" value="{{ $details->tagline }}" name="tagline" value="{{ old('tagline') }}"  autofocus>
                        <span class="error" id="tagline_error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-md-4 control-label">Description</label>
                    <div class="col-md-6">
                        <textarea id="description" class="form-control format_able" name="description"  autofocus>{{ $details->description }}</textarea>
                        <span class="error" id="description_error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label for="welcome_note" class="col-md-4 control-label">Welcome Note</label>
                    <div class="col-md-6">
                        <textarea id="welcome_note" class="form-control format_able" name="welcome_note"  autofocus>{{ $details->welcome_note }}</textarea>
                        <span class="error" id="welcome_note_error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <input value="Save" type="submit" class="btn btn-primary" id="saveDetails" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection


@section('storecontent-right')
@include('store.static.settingmenu')
@endsection