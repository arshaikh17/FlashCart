@extends('layouts.user')

@section('user-header')
    <h5><b><i class="fa fa-shopping-basket"></i> Open Store</b></h5>
@endsection

@section('user-content')
<div class="container" id="main-container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Open Store</h1>
            <div class="account-wall">
                <img class="profile-img" src="../../../../../../uploads/service/auth-open-store.png"
                alt="">
                <form class="form-signin" role="form" method="POST" action="{{ url('/user/login') }}">
                    {{ csrf_field() }}
                    <input id="store_username" placeholder="Store's username" type="text" class="form-control" name="store_username" value="{{ old('store_username') }}" required autofocus>
                    <span class="error" id="username_error"></span>
                    @if ($errors->has('store_username'))
                    <span class="help-block">
                        <strong>{{ $errors->first('store_username') }}</strong>
                    </span>
                    @endif
                    <input id="store_name" type="text" class="form-control" placeholder="Store's name" name="store_name" value="{{ old('store_name') }}" required autofocus>
                    @if ($errors->has('store_name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('store_name') }}</strong>
                    </span>
                    @endif
                    <input id="store_email" type="email" class="form-control" placeholder="Store's email" name="store_email" value="{{ old('store_email') }}" required>
                    <span class="error" id="email_error"></span>
                    @if ($errors->has('store_email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('store_email') }}</strong>
                    </span>
                    @endif
                    <input id="password" type="password" placeholder="Enter Store's password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                    <input id="password" type="password" placeholder="Confirm password" class="form-control" name="confirm_password" required>
                    <input id="secret_code" type="text" placeholder="Secret code" class="form-control" name="secret_code" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Open Now!</button>
                    <a href="{{ url('/password/reset') }}" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
