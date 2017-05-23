@extends('layouts.store', ['store'=>$store])

@section('store-view')
Settings
@endsection
@section('store-subview')
Brand Marks
@endsection

@section('store-breadcrumb')
<li><a href="/store/settings">Settings</a></li>
<li>Brand Marks</li>
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
    <div class="box-header"><div class="box-title">Brand Marks</div></div>
    <div class="box-body">
        <form class="form-horizontal" role="form" method="POST" action="/store/settings/save_brand_mark" id="brandUpdate" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="form-group">
                <label for="brand_mark_logo" class="col-md-4 control-label">Brand Mark (Logo)</label>
                <div class="col-md-6">
                    <input id="brand_mark_logo" type="file" class="form-control" name="brand_mark_logo"  autofocus>
                    <span class="error" id="brand_mark_logo_error"></span>
                </div>
            </div>
            <div class="form-group">
                <label for="brand_mark_icon" class="col-md-4 control-label">Brand Mark Icon (Icon)</label>
                <div class="col-md-6">
                    <input id="brand_mark_icon" type="file" class="form-control" name="brand_mark_icon"  autofocus>
                    <span class="error" id="brand_mark_icon_error"></span>
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <input value="Save" type="submit" class="btn btn-primary" id="saveBrandMark" />
                </div>
            </div>
        </form>
    </div>
</div>
</section>
<section class="col-lg-4">
<div class="box box-primary">
    <div class="box-header">
        <div class="box-title">
            Brand Logo
        </div>
        <div class="box-body">
            @if($brand->brand_logo != "")
            <div class="col-lg-offset-2">
                <img class="img-responsive img-thumbnail" src="../../../../../../uploads/store/brand_marks/logo/{{$brand->brand_logo}}" width="200" height="200">
                
            </div>
            @else
            Nothing uploaded yet.
            @endif
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-header">
        <div class="box-title">
            Brand Icon
        </div>
        <div class="box-body">
        </div>
    </div>
</div>
</section>

@endsection
