@extends('layouts.store', ['store'=>$store])

@section('store-title')
{{ $store->store_name }} - Add Sale
@endsection

@section('store-view')
Sales
@endsection
@section('store-subview')
Add Sales
@endsection

@section('store-breadcrumb')
<li><a href="/store/sales">Sales</a></li>
<li>Add Sales</li>
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
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
  $(document).ready(function () {
  $.datepicker.setDefaults();
    $(".datepicker").datepicker({
      format: 'dd-mm-yyyy'
    });
  });
</script>

<section class="col-lg-12">
            <div class="box box-default">
                <div class="box-header"><div class="box-title">Add Sale</div></div>

                <div class="box-body">
                    <form class="form-horizontal" role="form" method="POST" action="/store/sales/save_sale" id="add_sale" enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label for="sale_name" class="col-md-4 control-label">Sale Name</label>

                            <div class="col-md-6">
                                <input id="sale_name" class="form-control" name="sale_name" value="{{ old('sale_name') }}" required autofocus />
                                
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sale_tagline" class="col-md-4 control-label">Sale Tagline</label>

                            <div class="col-md-6">
                                <input id="sale_tagline" class="form-control" name="sale_tagline" value="{{ old('sale_tagline') }}" required autofocus />
                                
                                
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="sale_discount" class="col-md-4 control-label">Discount (1-99%)</label>

                            <div class="col-md-6">
                                <input id="sale_discount" type="number" class="form-control" name="sale_discount" value="{{ old('sale_discount') }}" required autofocus />
                        
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="sale_start_date" class="col-md-4 control-label">Starting From</label>

                            <div class="col-md-6">
                                <input id="sale_start_date" type="text" class="datepicker form-control date" name="sale_start_date"  value="{{ old('sale_start_date') }}" required autofocus />
                            </div>  
                        </div>

                        <div class="form-group">
                            <label for="sale_end_date" class="col-md-4 control-label">Ending On</label>
                            <div class="col-md-6">
                                <input id="sale_end_date" type="text" class="datepicker form-control date" name="sale_end_date" value="{{ old('sale_end_date') }}" required autofocus /> 
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">

                                <input value="Next" type="submit" class="right-button btn btn-primary" id="next_sale" />
                            </div>
                        </div>
                    </form> 
                </div>
</div>
</section>
@endsection
