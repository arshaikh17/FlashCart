@extends('layouts.store', ['store'=>$store])

@section('store-title')
{{ $store->store_name }} - View Order
@endsection

@section('store-view')
Orders
@endsection
@section('store-subview')
View Order
@endsection

@section('store-breadcrumb')
<li><a href="/store/orders">Orders</a></li>
<li><a href="/store/orders">All Orders</a></li>
<li>View Order</li>
@endsection

@section('store-alertcontent')
@if($errors->any())
  <div class="container">
    <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
      <strong>NOTE!</strong>  
        {!! $errors->first('check') !!}
    </div>
  </div>
  @section('css')
  <style>
    .check{
  color:red;
  background:red;
  border-radius:50%;
  animation:op 3s ease infinite;
}
@keyframes op{
0%{
  opacity:0;
}
50%{
  opacity:1;
}
100%{
  opacity:0;
}
}
  </style>
  @endsection
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
  @section('css')
  <style>
    .success{
  color:green;
  background:green;
  border-radius:50%;
  animation:op 3s ease infinite;
}
@keyframes op{
0%{
  opacity:0;
}
50%{
  opacity:1;
}
100%{
  opacity:0;
}
}
  </style>
  @endsection
  @endif
@endsection

@section('store-content')

<div class="col-lg-12">
@if($order != "")
<?php
  $order_products = array();
  $order_products = getOrderProducts($order->so_id);


?>
  <div class="row">
    <div class="col-lg-7">
      <div class="box box-primary">
        <div class="box-header">
          <div class="box-title">Order Title</div>
        </div>
        <div class="box-body">
          <h2>{{ $order->order_name }}</h2>
        </div>
      </div>
      <div class="box box-primary">
        <div class="box-header">
          <div class="box-title">Order Products - {{ count($order_products) }}</div>
        </div>
        <div class="box-body">
          <table class="table table-hover table-condensed table-bordered info">
            <thead>
              <td><strong>Name</strong></td>
              <td><strong>Quantity</strong></td>
              <td><strong>Price</strong></td>
            </thead>
            <tbody>
              @foreach($order_products as $product)
                <tr>
                  <td>{{ $product->product_name }}</td>
                  <td class="info">{{ $product->quantity }}</td>
                  <td>Rs. {{ number_format($product->price * $product->quantity) }}/-</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>

    </div>
    <div class="col-lg-5">
      <div class="box box-primary">
        <div class="box-header">
          <div class="box-title">Order Statistics</div>
        </div>
        <div class="box-body">
          <table class="table table-condensed order-statistics">
            <tr>
              <div class="order-statistics-row">
                <div class="row">
                  <div class="col-lg-4">
                    <strong>Order ID:</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $order->so_id }}
                  </div>
                </div>
              </div>
            </tr>
            <tr>
              <div class="order-statistics-row">
                <div class="row">
                  <div class="col-lg-4">
                    <strong>Invoice ID:</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $order->invoice_id }}
                  </div>
                </div>
              </div>
            </tr>
            <tr>
              <div class="order-statistics-row">
                <div class="row">
                  <div class="col-lg-4">
                    <strong>Address:</strong>
                  </div>
                  <div class="col-lg-8">
                    {!! $order->address_info !!}
                  </div>
                </div>
              </div>
            </tr>
            <tr>
              <div class="order-statistics-row">
                <div class="row">
                  <div class="col-lg-4">
                    <strong>Payment Method:</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ $payment->payment_name }}
                  </div>
                </div>
              </div>
            </tr>
            <tr>
              <div class="order-statistics-row">
                <div class="row">
                  <div class="col-lg-4">
                    <strong>Ordered At:</strong>
                  </div>
                  <div class="col-lg-8">
                    {{ date_format($order->created_at, 'l, F dS - Y') }} at {{ date_format($order->created_at, 'g:ia')  }}
                    <br />
                    {{$order->created_at->diffForHumans()}}
                  </div>
                </div>
              </div>
            </tr>
            <tr>
              <div class="order-statistics-row">
                <div class="row">
                  <div class="col-lg-4">
                   <strong> Current Status:</strong>
                  </div>
                  <div class="col-lg-8">
                    @if($order->order_status == 1)Accepted @elseif($order->order_status == 0) Rejected @elseif($order->order_status == 2)Pending @endif
                  </div>
                </div>
              </div>
            </tr>
            <tr>
              <div class="order-statistics-row">
                <div class="row">
                  <div class="col-lg-4">
                    <strong>Last Action:</strong>
                  </div>
                  <div class="col-lg-8">
                    @if($order->updated_at != "")
                    {{ date_format($order->updated_at, 'l, F dS - Y') }} at {{ date_format($order->updated_at, 'g:ia')  }}
                    <br />
                    {{$order->updated_at->diffForHumans()}}
                    @else
                    {{ date_format($order->created_at, 'l, F dS - Y') }} at {{ date_format($order->created_at, 'g:ia')  }}
                    <br />
                    {{$order->created_at->diffForHumans()}}
                    @endif
                  </div>
                </div>
              </div>
            </tr>
          </table>
        </div>
      </div>
      <div class="box box-primary">
        <div class="box-header">
          <div class="box-title">Order Actions</div>
        </div>
        <div class="box-body">
          <a href="/store/orders/order/{{$order->so_id}}/action/1">accept</a>
          <br />
          <a href="/store/orders/order/{{$order->so_id}}/action/0">reject</a>
        </div>
      </div>
    </div>
  </div>
  @else
  No Order with this Invoice ID was found.
  @endif
</div>
@endsection

@section('css')
<style>
  .order-statistics-row
  {
    border-bottom: 1pt solid black;
  }
</style>
@endsection