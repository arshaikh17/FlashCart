@extends('layouts.store', ['store'=>$store])

@section('store-title')
{{ $store->store_name }} - All Orders
@endsection

@section('store-view')
Orders
@endsection
@section('store-subview')
All Orders
@endsection

@section('store-breadcrumb')
<li><a href="/store/orders">Orders</a></li>
<li>All Orders</li>
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
    <div class="row">
        <div class="col-lg-2">
            Find Order
        </div>
        <div class="col-lg-10">
            <form method="POST" action="/store/orders/order/find">
                    {{ csrf_field()}}                
                <input type="text" name="order_q" class="form-control" placeholder="Enter Invoice ID" />
            </form>
        </div>
    </div>
    <br />
    <div class="box box-primary">
        <div class="box-header">
            <div class="box-title">All Orders</div>
        </div>
        <div class="box-body">
        @forelse($orders as $order)
            <?php 
                $order_products = array();
                $order_products = getOrderProducts($order->so_id);
                $order_price = 0;

                foreach($order_products as $op)
                {
                    $price = $op->price * $op->quantity;
                    $order_price = $order_price + $price;
                }
            ?>
            <a href="/store/orders/order/{{ $order->invoice_id }}"><div class="order-box shadow ">
                <div class="box-header">
                    <div class="box-title">{{ $order->order_name }}</div><div class="pull-right">{{ $order->created_at->diffForHumans() }}</div>
                </div>
                <div class="order-details">
                    <div class="order_info">
                        <table class="table  table-responsive">
                            <tr>
                                <td>Invoice ID: {{ $order->invoice_id }}</td>
                            </tr>
                            <tr>
                                <td>Products: {{ count($order_products) }}</td>
                            </tr>
                            <tr>
                                <td>Price: Rs {{ number_format($order_price) }}/-</td>
                            </tr>
                        </table>
                    </div>
                    <div class="order_actions">
                    </div>
                </div>
            </div></a>
        @empty
            <p><strong>No orders yet.</strong></p>
        @endforelse
        </div>
    </div>
</section>
@endsection

@section('jquery')
<script>

</script>
@endsection

@section('css')
<style>
.order-box
{
    width: 270px;
    height: 164px;
    display: inline-block;
    border-radius: 5px;
    background-color: #eaeaef;
    margin-top: 10px;
    margin-right: 10px;
    -webkit-box-shadow: 0px 1px 4px 1px rgba(0,0,0,0.35);
    -moz-box-shadow: 0px 1px 4px 1px rgba(0,0,0,0.35);
    box-shadow: 0px 1px 4px 1px rgba(0,0,0,0.35);
}
@media{
.order-box
{ 
    -moz-transition: all .2s ease-in;
    -o-transition: all .2s ease-in;
    -webkit-transition: all .2s ease-in;
    transition: all .2s ease-in;
}}
.order-box:hover
{
    background-color: #0050A0;
    color: white !important;
}
</style>
@endsection