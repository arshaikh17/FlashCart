@extends('layouts.store', ['store'=>$store])

@section('store-view')
Settings
@endsection
@section('store-subview')
Policy
@endsection

@section('store-breadcrumb')
<li><a href="/store/settings">Settings</a></li>
<li><a href="/store/settings/policies">Policies Settings</a></li>
<li>Policy</li>
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
<section class="col-lg-8">
<div class="box box-default">
    <div class="box-header"><div class="box-title">Policy Management - Editing</div></div>

    <div class="box-body">
        <form class="form-horizontal" role="form" method="POST" action="/store/settings/edit_policy" id="storePolicyEdit">
        {{ csrf_field() }}
        @if($errors->any())
            <span>{{ $errors->first() }}</span>
        @endif
        <input type="text" class="hidden" name="policy" value="{{ $policy->policy_id }}">
            <div class="form-group">
                <label for="title" class="col-md-4 control-label">Title</label>
                <div class="col-md-6">
                    <input id="title" type="text" value="{{ $policy->policy_title }}" class="form-control" name="title" autofocus>
                    <span class="error" id="title_error"></span>
                </div>
            </div>

            <div class="form-group">
                <label for="policy_content" class="col-md-4 control-label">Description</label>
                <div class="col-md-6">
                    <textarea id="policy_content" class="form-control format_able" name="policy_content" autofocus>{{ $policy->policy_content }}</textarea>
                    <span class="error" id="policy_content_error"></span>
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-6 col-md-offset-4">
                    <input value="Save" type="submit" class="btn btn-primary" id="saveDetails" />
                </div>
            </div>
        </form>
    </div>
</div>
</section>
<section class="col-lg-4">
    <div class="box box-default">
        <div class="box-header"><div class="box-title">Current Policies - {{ $policies->count() }} Total</div></div>
        <div class="box-body">
            <ul class="list-group">
            	@forelse($policies as $policy)
                <a class="non_link_type" href="/store/settings/policies/{{ $policy->policy_id }}"><li class=" list-group-item">{{ $policy->policy_title }}</li></a>
                @empty
                <li>Looks like you haven't set up any policy. Go to <a href="/store/settings/policies">Policy Management</a> to set up your store's policies.</li>
                @endforelse
            </ul>
        </div>
    </div>
</section>
@endsection