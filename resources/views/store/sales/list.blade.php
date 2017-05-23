@extends('layouts.store', ['store'=>$store])

@section('store-view')
Sales
@endsection
@section('store-subview')
All Sales
@endsection

@section('store-breadcrumb')
<li><a href="/store/sales">Sales</a></li>
<li>All Sales</li>
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
<section class="col-lg-12">
    <div class="box box-default">
        <div class="box-header"><div class="box-title">All Sales - {{ $sales->total() }}</div></div>
        <div class="box-body">
        	<table class="table table-responsive table-hover" >
                <thead>
                    <tr>
                        <td>Details</td>
                        <td>Actions</td>
                    </tr>
                </thead>
        		<tbody>
        		@forelse($sales as $sale)
        			<tr class="table_content" id="{{ $sale->sale_id }}">
        				<td class="content_td">
                            Name: <strong>{{ $sale->sale_name }}</strong>
        					<br />
                            Created on: {{ $sale->start_date }}
                            <br />
                            Ending on: {{ \Carbon\Carbon::parse($sale->end_date) }}
        				</td>
        				<td class="action_td">
                            @if($sale->status == "0")
                            Currently: {{ $sale->status }}
                            <br />
                            <a href="/store/sales/sale/{{ $sale->sale_id }}/status/active">make Active</a>
                            @elseif($sale->status == "1")
                            Currently: {{ $sale->status }}
                            <br />
                            <a href="/store/sales/sale/{{ $sale->sale_id }}/status/inactive">make Inactive</a>
                            @endif
                            <br />
                            <a href="/store/sales/sale/{{ $sale->sale_id }}/products" class="edit">edit</a>
                        </td>
        			</tr>
        		@empty
        			<tr>
        				<tr><td>No Sales</td></tr>
        			</tr>
        		@endforelse
        		</tbody>
        	</table>
            {{ $sales->links() }}
        </div>
    </div>
</section>
@endsection
