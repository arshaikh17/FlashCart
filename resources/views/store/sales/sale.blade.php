@extends('layouts.store', ['store'=>$store])

@section('store-view')
Sales
@endsection
@section('store-subview')
Add Products to sale
@endsection

@section('store-breadcrumb')
<li><a href="/store/sales">Sales</a></li>
<li><a href="/store/sales/add">Add Sales</a></li>
<li>Add Products</li>
@endsection

@section('store-title')
{{ $store->store_name }} - Sales List
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
<section class="col-lg-9">
    <div class="box box-default">
        <div class="box-header"><div class="box-title"><a href="/store/sale/{{$sale->sale_id}}">{{ $sale->sale_name }}</a> - Products - {{ $nosaleproducts->count() }} Total Products</div></div>
        <div class="box-body">
        	<table class="table table-responsive table-hover">
        		<tbody>
        		@forelse($nosaleproducts as $products)
        			<tr class="table_content" id="{{ $products->id }}">
        				<td class="content_td">
        					Name: {{ $products->product_name }}
        				</td>
        				<td class="action_td"><span class="span_edit"><a href="/store/sales/sale/{{ $sale_id }}/products/{{ $products->id }}/add" class="add">add</a></span></td>
        			</tr>

        		@empty
        			<tr>
        				<tr><td>No products</td></tr>
        			</tr>
        		@endforelse

        		</tbody>
        	</table>
        </div>
    </div>
</section>

<section class="col-lg-3">
<div class="box box-default">
    <div class="box-header" data-toggle="collapse" data-target="#status"><div class="box-title">Status</div></div>
    <div class="collapse in" id="status">
        
    <div class="box-body">
        <span>
            Current: @if($sale->status==1)Active @elseif($sale->status == 0)Inactive @endif
        </span>
        <br />
        @if($sale->status == "0")
        <a href="/store/sales/sale/{{ $sale_id }}/status/active">Go Active</a>
        @elseif($sale->status == "1")
        <a href="/store/sales/sale/{{ $sale_id }}/status/inactive">Inactive sale</a>
        @endif
    </div>
    </div>
</div>

<div class="box box-default">
    <div class="box-header" data-toggle="collapse" data-target="#product"><div class="box-title">This Sale - {{ $sale_products->count() }} Total Products</div></div>
    <div class="collapse in" id="product">
    <div class="box-body">
        <table class="table table-responsive table-hover" >
            <tbody>
            @forelse($sale_products as $products)
                <tr class="table_content" id="{{ $products->id }}">
                    <td class="content_td">
                        {{ $products->product_name }}
                    </td>
                    <td class="action_td"><span class="span_edit"><a href="/store/sales/sale/{{ $sale_id }}/products/{{ $products->id }}/remove" class="remove">remove</a></span></td>
                </tr>

            @empty
                <tr>
                    <tr><td>No products</td></tr>
                </tr>
            @endforelse

            </tbody>
        </table>
    </div>
    </div>
</div>
</section>
@endsection