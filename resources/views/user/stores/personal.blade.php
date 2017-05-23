@extends('layouts.user')


@section('user-header')
    <h5><b><i class="fa fa-home"></i> Personal Stores</b></h5>
@endsection


@section('user-alert')
@if($errors->any())
    <div class="container">
        <div class="alert alert-warning alert-dismissable">
      <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <strong>NOTE!</strong> {!! $errors->first('check') !!}
        </div>
    </div>
    @endif
@endsection

@section('user-success')
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

@section('user-content')
<section class="col-lg-12">
  <div class="w3-row-padding w3-margin-bottom">


  @forelse($stores as $store)
  <?php
    $notifications = count(getStoreNotifications($store->store_id)['unseen']);
  ?>
    <div class="w3-third">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-home w3-xxxlarge"></i></div>
        <div class="w3-right">
          <span class=""><h3>{{$notifications}}</h3>Notifications</span>
        </div>
        <div class="w3-clear"></div>
        <h4>{{$store->store_name}}</h4>
      </div>
      <br />
      <a class="btn btn-primary" href="/redirect/store/{{$store->store_id}}/{{ Auth::user()->id }}" style="width:100%;">Enter Store</a>
      <br />
      <br />
    <div class="panel panel-primary">
      <div class="panel-heading">
      {{$store->store_name}} Statistics
      </div>
      <div class="panel-body">
      <table class="table table-responsive table-hover">
        <tbody>    
          <tr>
            <td>Employees Working:</td>
            <td class="employee_td">{{$statistics[$store->store_id]['employees']}}</td>
          </tr>
          <tr>
            <td>Products:</td>
            <td class="product_td">{{$statistics[$store->store_id]['products']}}</td>
          </tr>
          <tr>
            <td>Sales:</td>
            <td class="sale_td">{{$statistics[$store->store_id]['sales']}}</td>
          </tr>
          <tr>
            <td>Orders:</td>
            <td class="order_td">{{$statistics[$store->store_id]['orders']}}</td>
          </tr>
          <tr>
            <td>Products Sold:</td>
            <td class="product_sold_td">{{$statistics[$store->store_id]['products_sold']}}</td>
          </tr>
          <tr>
            <td>Categories:</td>
            <td class="category_td">{{$statistics[$store->store_id]['categories']}}</td>
          </tr>
          <tr>
            <td>Sub Categories:</td>
            <td class="sub_category_td">{{$statistics[$store->store_id]['sub_categories']}}</td>
          </tr>
          <tr>
            <td>Payment Options:</td>
            <td class="payment_option_td">{{$statistics[$store->store_id]['payment_options']}}</td>
          </tr>
        </tbody>
      </table>
    </div>
    </div>
</div>

    @empty
      <p>You haven't opened any store, yet.</p>
    @endforelse
  </div>
</section>
<script>
$(document).ready(function() {
    highlightGreatest('.employee_td');
    highlightGreatest('.product_td');
    highlightGreatest('.sale_td');
    highlightGreatest('.order_td');
    highlightGreatest('.product_sold_td');
    highlightGreatest('.category_td');
    highlightGreatest('.sub_category_td');
    highlightGreatest('.payment_option_td');
});

</script>
<style>
  .tick
  {
    background: yellow;
  }
</style>
@endsection