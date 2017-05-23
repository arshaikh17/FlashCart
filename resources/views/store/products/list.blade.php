@extends('layouts.store', ['store'=>$store])

@section('store-title')
{{ $store->store_name }} - Products List
@endsection

@section('store-view')
    Products
@endsection
@section('store-subview')
    All
@endsection

@section('store-breadcrumb')
    <li><a href="/store/products">Products</a></li>
    <li>All Products</li>
@endsection

@section('store-content')
@section('store-alertcontent')
@if($errors->any())
    <div class="container">
        <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>NOTE!</strong>  
        {!! $errors->first('category_check') !!}
        {!! $errors->first('privilege_check') !!}
        {!! $errors->first('check') !!}
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
<section class="col-lg-8">
    <div class="box box-default">
        <div class="box-header">

            <?php if($key == 0){ ?>
            <div class="box-title">All Products - {{ $list->total() }}</div>

            <?php } else if($key == 1){ ?>
            <div class="box-title">Products under <strong>{{$key_category->category}}</strong> - {{ $list->total() }}</div>

            <?php } else if($key == 2){ ?>
            <div class="box-title">Products in <strong>{{ $key_sub_category->sub_category }}</strong> under <strong>{{ $key_category->category }}</strong> - {{ $list->total() }}</div> 
            <?php } ?>
        </div>
        <div class="box-body">
            <table class="table table-responsive table-hover" >
                <tbody>
                    @forelse($list as $products)
                    <tr class="table_content" id="{{ $products->id }}">
                        <td class="content_td">
                            Code: {{ $products->product_code }} <br />
                            Name: <a href="/mystore/{{ $store->store_username }}/product/{{ $products->slug }}">{{ $products->product_name }}</a>
                        </td>
                        <td class="action_td"><span class="span_edit"><a href="/store/products/edit/{{ $products->id }}" class="edit">edit</a></span></td>
                    </tr>
                    @empty
                    <tr>
                        <tr><td>No products</td></tr>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $list->links() }}
        </div>
    </div>
</section>

<section class="col-lg-4">
    <div class="box box-default">
        <div class="box-header">
            <div class="box-title">Categories</div>
        </div>
        <div class="box-body">
            <ul class="todo-list">
                <li><a href="/store/products">All Products</a></li>
                @forelse($categories as $cats)

                <?php 
                    $sub_categories = getSubCategories($cats->id);
                ?>

                    @if(count($sub_categories) > 0)
                    <li data-toggle="collapse" data-target="#cat_{{$cats->id}}"><a href="/store/products/category/{{ $cats->id }}">{{ $cats->category }}</a> (has sub categories)<i aria-hidden="true" class="fa fa-angle-down pull-right"></i>
                        <ul class="todo-list collapse" id="cat_{{$cats->id}}">
                            @foreach($sub_categories as $sub)
                                <li><a href="/store/products/category/{{ $cats->id }}/sub_category/{{ $sub->spsc_id }}">{{ $sub->sub_category }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    @else
                        <li><a href="/store/products/category/{{ $cats->id }}">{{ $cats->category }}</a></li>
                    @endif
                @empty
                <li>Looks like you haven't set up your store's categories. Go to <a href="/store/settings">Settings </a>to set them up.</li>
                @endforelse
            </ul>
        </div>
    </div>
</section>
@endsection