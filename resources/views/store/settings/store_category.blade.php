@extends('layouts.store', ['store'=>$store])

@section('store-view')
Settings
@endsection
@section('store-subview')
Store Category
@endsection

@section('store-breadcrumb')
<li><a href="/store/settings">Settings</a></li>
<li>Store Category</li>
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
        <div class="box-header"><div class="box-title">Category of Store</div></div>
        <div class="box-body">
            @if(isset($category))
            Current Category your store is listed as.
            <h3>{{ $category->category_of_store }}</h3>
            @else
            <p>Please set up store's category.</p>
            @endif
        </div>
        <hr />
        <div class="box-body">
            <form class="form-horizontal" role="form" method="POST" action="/store/settings/save_category" id="storeCategory">
                {{ csrf_field() }}
                <p>Select Category</p>
                <div class="col-md-6 form-group">
                    <select name="store_category" class="form-control" id="store_category">
                        <option disabled selected>Select Category from here.</option>
                        @forelse($all_category as $cats)
                        <option value="{{ $cats->cat_id }}">{{ $cats->category_of_store }}</option>
                        @empty
                        <option disabled selected>There are no categories</option>
                        @endforelse
                    </select>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <input value="Save" type="submit" class="btn btn-primary" id="saveStoreCat" />
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
