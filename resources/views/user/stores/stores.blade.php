@extends('layouts.user')


@section('user-header')
    <h5><b><i class="fa fa-home"></i> Stores</b></h5>
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
    <p>This section includes all of your stores' information. From here you can redirect to your Personal Store Room, those which you own, and Employeed Store Room, those which you are employeed at.</p>

    <p>You can own up to 3 stores of your own and can be employeed at 3 stores other than yours.</p>
    <p>Please make sure you regularly check your Stores for newer notifications and orders and other related information. We advise you check your store after every 30 minutes if you have large envolvement of customers. This will keep the store's engagement high and as well as better positioned.</p>
  </div>
    <a href="/user/stores/personal"><div class="w3-third shadow" style="margin-left: 100px;">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-home w3-xxxlarge"></i></div>
        <div class="w3-right">
          <p>Stores Owned: {{ $personal_stores }}</p>
        </div>
        <div class="w3-clear"></div>
        <h4>Personal Stores Lobby</h4>
      </div>
    </div></a>

    <a href="/user/stores/employeed"><div class="w3-third shadow" style="margin-left: 100px;">
      <div class="w3-container w3-red w3-padding-16">
        <div class="w3-left"><i class="fa fa-home w3-xxxlarge"></i></div>
        <div class="w3-right">
          <p>Employeed Stores: {{ $employeed_stores }}</p>
        </div>
        <div class="w3-clear"></div>
        <h4>Employeed Stores Lobby</h4>
      </div>
    </div></a>
</section>

<section class="col-lg-4">
<br />
<br />
  <div class="panel panel-default">
    <div class="panel-heading">Applicants</div>
    <div class="panel-body">
    @if($personal_stores != 3)
      <p>Since, you have less than 3 stores you open another one.</p>
      <a href="/store/open">Open a new Store</a>
      @else
      <p>You have reached the maximum limit of personal stores.</p>  
    @endif
    </div>
    <hr />
    <div class="panel-body">
    @if($employeed_stores != 3)
      <p>Since, you are employeed in less than 3 stores you can still apply in another one.</p>
      <a href="/store/employment">Apply Now</a>
      @else
      <p>You have reached the maximum limit of employment.</p>  
    @endif
    </div>
  </div>
</section>
@endsection