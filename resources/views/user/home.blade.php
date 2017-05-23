@extends('layouts.user')

@section('user-header')
    <h5><b><i class="fa fa-dashboard"></i> My Dashboard</b></h5>
@endsection



@section('user-content')

<div class="w3-row-padding w3-margin-bottom">
    <div class="w3-quarter">
    <a href="/user/conversations">

      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>{{count($convo_messages)}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>New Convo Messages</h4>
      </div>
    </a>
    </div>
    <div class="w3-quarter">
    <a href="/user/messages">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-comment w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>{{ count($direct_messages)}}</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>New Messages</h4>
      </div>
    </a>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>23</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Shares</h4>
      </div>
    </div>
    <div class="w3-quarter">
      <div class="w3-container w3-orange w3-text-white w3-padding-16">
        <div class="w3-left"><i class="fa fa-users w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>50</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Users</h4>
      </div>
    </div>
  </div>
<style>
  a:hover
  {
    text-decoration: none !important;
  }
</style>
@endsection
