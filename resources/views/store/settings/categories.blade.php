@extends('layouts.store', ['store'=>$store])

@section('store-view')
Settings
@endsection
@section('store-subview')
Product Categories
@endsection

@section('store-breadcrumb')
<li><a href="/store/settings">Settings</a></li>
<li>Product Categories</li>
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
<section class="col-lg-6">
<div class="box box-default">
    <div class="box-header"><div class="box-title">Categories</div></div>
    <div class="box-body">
        <p>Current</p>
        @forelse($categories as $cat)
        <?php  $sub_categories = getSubCategories($cat->spc_id); ?>
        <ul class="current-categories">
            <li class="main_cat" data-toggle="collapse" data-target="#sub_list_{{$cat->id}}"><strong>{{ $cat->category }} @if(count($sub_categories)>0)<span><i aria-hidden="true" class="fa fa-chevron-down"></i></span>@endif</strong>
                
                <p>Sub categories: {{ count($sub_categories) }}</p>
                <ul class="todo-list collapse" id="sub_list_{{$cat->id}}">
                    @forelse($sub_categories as $subs) 
                    <li class="list-group-item">{{ $subs->sub_category }}</li>
                    @empty
                    @endforelse
                </ul>
            </li>
            <hr />
        </ul>
        @empty
        <ul>
            <li>No categories yet.</li>
        </ul>
        @endforelse
    </div>
    <hr />
   
</div>
</section>
<section class="col-lg-6">

<div class="box box-default">
    <div class="box-header">
        <div class="box-title">New Categories</div>
    </div>
     <div class="box-body">
        <form class="form-horizontal" role="form" method="POST" action="/store/settings/add_category" id="new-cats">
            {{ csrf_field() }}
            
            <div class="col-lg-8 form-group">
                <select name="new_category" class="form-control" id="new-category">
                    @forelse($exclusive_categories as $n_cats)
                    <option value="{{ $n_cats->id }}">{{ $n_cats->category }}</option>
                    @empty
                    <option disabled selected>No Categories left</option>
                    @endforelse
                </select>
            </div>
            <div class="form-group">
                <div class="col-md-offset-8">
                    <input value="Add" type="submit" class="btn btn-primary" id="saveCat" />
                </div>
            </div>
        </form>
    </div>
</div>
<div class="box box-default">
    <div class="box-header">
        <div class="box-title">Create Sub Categories</div>
    </div>
    <div class="box-body">
        <form method="POST" action="/store/settings/categories/sub-categories/add">
            {{ csrf_field() }}
            <label class="col-md-4">Select Category</label>
            <div class="col-md-6 form-group">
                <select name="sub_category_for" class="form-control" id="sub_category">
                    @forelse($categories as $cat)
                    <option value="{{ $cat->spc_id }}">{{ $cat->category }}</option>
                    @empty
                    <option disabled selected>No Categories left</option>
                    @endforelse
                </select>
            </div>
            <label class="col-md-4">Sub Category</label>
            <div class="col-md-6 form-group">
                <input type="text" name="sub_category" class="form-control" />
            </div>
            <div class="col-md-12 form-group">
                <div class="col-md-offset-9">
                    <input value="Add" type="submit" class="btn btn-primary" id="saveCat" />
                </div>
            </div>
        </form>
    </div>
</div>
</section>
@endsection

@section('css')
<style>
.main_cat
{
    cursor: pointer;
}
</style>
@endsection