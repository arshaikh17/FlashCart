@extends('layouts.auth')

@section('auth-title')
    Sign Up
@endsection

@section('auth-content')
<div class="container" id="main-container">
    <div class="row">
        <div class="col-sm-6 col-md-4 col-md-offset-4">
            <h1 class="text-center login-title">Sign Up</h1>
            <div class="account-wall">
                <img class="profile-img" src="../../../../uploads/service/user-auth-register.png"
                alt="">
                <form class="form-signin" role="form" method="POST" action="" id="userRegister">
                    {{ csrf_field() }}
                    <input id="username" type="text" placeholder="Username" class="form-control" name="username" value="{{ old('username') }}" required autofocus>
                                <span class="error" id="username_error"></span>
                                @if ($errors->has('username'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('username') }}</strong>
                                    </span>
                                @endif
                    <input id="name" type="text" class="form-control" placeholder="Full Name" name="name" value="{{ old('name') }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                                <input id="email" type="email" class="form-control" placeholder="Email" name="email" value="{{ old('email') }}" required>
                                <span class="error" id="email_error"></span>
                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <input id="password" type="password" placeholder="Password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <input id="password-confirm" type="password" placeholder="Confirm Password" class="form-control" name="password_confirmation" required>
                    <button class="btn btn-lg btn-primary btn-block" type="submit">
                    Sign up</button>
                    <div class="form-group">
                        
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                            </label>
                        </div>
                        
                    </div>
                </form>
            </div>
            <a href="/user/login" class="text-center new-account">Sign in </a>
        </div>
    </div>
</div>
@endsection
