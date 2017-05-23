@extends('layouts.auth')

@section('auth-title')
    Sign In
@endsection

@section('auth-content')
<div class="container" id="main-container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign In</h1>
            <div class="account-wall">
                <img class="profile-img" src="../../../../uploads/service/user-auth-login.png"
                alt="">
                <form class="form-signin" role="form" method="POST" action="{{ url('/user/login') }}">
                    {{ csrf_field() }}
                    <input id="login_email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required autofocus>
                    @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                    <input id="login_password" type="password" placeholder="Password" class="form-control" name="password" required>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                    <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Sign in</button>
                    <div class="form-group">
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                        
                    </div>
                    <a href="{{ url('/password/reset') }}" class="pull-right need-help">Need help? </a><span class="clearfix"></span>
                </form>
            </div>
            <a href="/user/register" class="text-center new-account">Create an account </a>
        </div>
    </div>
</div>
@endsection
