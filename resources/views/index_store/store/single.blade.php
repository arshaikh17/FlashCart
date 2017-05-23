@extends('index_store.layouts.layout-'.$layout->layout_id, ['store'=>$store])


@section('header')
	@include('index_store.header.header-'.$layout->header_id, ['store'=>$store, 'social'=>$social, 'categories'=>$categories, 'sales'=>$sales]) 
@endsection

@section('categories')
	@include('index_store.category_panel.category-panel-'.$layout->category_panel_id, ['store' => $store, 'categories'=>$categories, 'sales'=>$sales])
@endsection

@section('sales')
	@include('index_store.sale_area.sale-area-'.$layout->sale_area_id, ['sales'=>$sales])
@endsection

@section('body')
	@include('index_store.single_product.single-product-'.$layout->product_area_id, ['product'=>$product])
@endsection

