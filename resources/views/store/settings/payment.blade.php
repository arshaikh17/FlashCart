@extends('layouts.store', ['store'=>$store])

@section('store-view')
Settings
@endsection
@section('store-subview')
Payment Options
@endsection

@section('store-breadcrumb')
<li><a href="/store/settings">Settings</a></li>
<li>Payment Options</li>
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
    <div class="box-header" data-toggle="collapse" data-target="#new_payment"><div class="box-title">Payment Method Panel</div></div>
    <div class="collapse" id="new_payment">
    <form method="POST" action="/store/settings/payment/save_payment">
    {{csrf_field()}}

    <div class="box-body">
        <h2>New Payment Option</h2>
        <hr />
        Payment Type
        <select name="payment_type" class="form-control" id="payment_type" required> 
            <option selected disabled>Select methods from options.</option>
            @forelse($left_payment_options as $left)
            <option value="{{$left->pay_id}}">{{$left->payment_name}}</option>
            @empty
            <p>No more options left.</p>
            @endforelse
        </select>
    </div>
    <div class="box-body account-details" id="body_1">
        <h3>Set up Easy Paisa account</h3>
        <hr />
        <div class="form-group">
        Account Name
        <input type="text" name="ep_account_name" class="form-control" />
        </div>
        <div class="form-group">
        Account Number
        <input type="number" name="ep_account_number" class="form-control" />
        </div>
        <div class="form-group pull-right">
        <input type="submit" class="btn btn-primary" name="Submit" value="Save" />
    </div>
    </div>

    <div class="box-body account-details" id="body_2">
        <h3>Set up Bank Account</h3>
        <hr />
        <div class="form-group">
        Account Name
        <input type="text" name="ba_account_name" class="form-control" />
        </div>
        <div class="form-group">
        Account Number
        <input type="number" name="ba_account_number" class="form-control" />
        </div>
        <div class="form-group">
        Bank Name
        <input type="text" name="ba_bank_name" class="form-control" />
        </div>
        <div class="form-group">
        Branch of Bank
        <input type="text" name="ba_bank_branch" class="form-control" />
        </div>
        <div class="form-group pull-right">
        <input type="submit" class="btn btn-primary" name="Submit" value="Save" />
    </div>
    </div>

    <div class="box-body account-details" id="body_3">
        <h3>Set up UBL Omni account</h3>
        <hr />
        <div class="form-group">
        Account Name
        <input type="text" name="ublo_account_name" class="form-control" />
        </div>
        <div class="form-group">
        Account Number
        <input type="number" name="ublo_account_number" class="form-control" />
        </div>
        <div class="form-group pull-right">
        <input type="submit" class="btn btn-primary" name="Submit" value="Save" />
    </div>
    </div>

    <div class="box-body account-details" id="body_4">
        <h3>Enable Cash On Deliver method</h3>
        
        <div class="form-group pull-right">
        <input type="submit" class="btn btn-primary" name="Submit" value="Save" />
        </div>
    </div>
    
    </form>
    </div>
</div>
</section>

<section class="col-lg-12">
<h1>Current Methods</h1>
<hr />
<br />
@forelse(array_chunk($store_payment_options->all(), 3) as $options)
    <div class="row">
        @foreach($options as $option)
        <div class="col-md-4">
            <div class="box box-default">
                <div class="box-header" data-toggle="collapse" data-target="#pay_{{$option->spo_id}}"><div class="box-title">{{$option->payment_name}}</div></div>
                <div class="collapse in" id="pay_{{$option->spo_id}}">
                    <div class="box-body">
                        @if($option->pay_id == 1 || $option->pay_id == 3)
                        <h4>Info</h4>
                        <form method="POST" action="/store/settings/payment/{{$option->spo_id}}/{{$option->pay_id}}/edit">
                        {{csrf_field()}}
                            <div class="form-group">
                                Account Name:
                                <input type="text" class="form-control" name="edit_account_name" value="{{ $option->account_name }}" />
                            </div>
                            <div class="form-group">
                                Account number:
                                <input type="text" class="form-control" name="edit_account_number" value="{{ $option->account_number }}" />
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="Save" class="btn btn-primary btn-sm pull-right" />
                            </div>
                        </form>
                        <br />
                        <br />
                        <hr />
                        <h4>Statistics</h4>
                        Coming Soon.
                        @elseif($option->pay_id == 2)
                        <form method="POST" action="/store/settings/payment/{{$option->spo_id}}/{{$option->pay_id}}/edit">
                        {{csrf_field()}}
                            <div class="form-group">
                                Account Name:
                                <input type="text" class="form-control" name="edit_account_name" value="{{ $option->account_name }}" />
                            </div>
                            <div class="form-group">
                                Account number:
                                <input type="text" class="form-control" name="edit_account_number" value="{{ $option->account_number }}" />
                            </div>
                            <div class="form-group">
                                Bank Name:
                                <input type="text" class="form-control" name="edit_bank_name" value="{{ $option->bank_name }}" />
                            </div>
                            <div class="form-group">
                                Bank Branch:
                                <input type="text" class="form-control" name="edit_bank_branch" value="{{ $option->bank_branch }}" />
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" value="Save" class="btn btn-primary btn-sm pull-right" />
                            </div>
                        </form>
                        <br />
                        <br />
                        <hr />
                        
                        <h4>Statistics</h4>
                        Coming Soon.
                        @elseif($option->pay_id == 4)
                        <br />
                        <br />
                        <hr />
                        
                        <h4>Statistics</h4>
                        Coming Soon.
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@empty
<p>No current payment methods.</p>
@endforelse
 </section>   

@endsection


@section('jquery')
<script>
    $(document).ready(function()
    {  
        $("#payment_type").change(function()
        {
            $('.account-details').slideUp(200);
            var type = $(this).val();
            $("#body_"+type).slideDown(200);
        });
    });
</script>
@endsection

@section('css')
<style>
    .account-details
    {
        display: none;
    }
</style>
@endsection