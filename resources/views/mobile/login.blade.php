
@extends('layouts.app')

@section('title', __('Login'))
<link href="{{ asset('css/mobile.css') }}" rel="stylesheet">
@section('content')
<div class="container" style=" height: 100vh; background-image: url({{ asset('images/login-bg.jpg') }}); ">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" id="main-container">
            <div class=" ">
                <img src="{{ asset('images/logo.jpg') }}" alt="" style=" width: 130px; height: 130px; display: grid; margin: 0 auto; margin-top: 80px; margin-bottom: 20px; border-radius: 10px; ">
                <div class="page-panel-title" style="text-align: center;font-size: 25px;font-weight: bold;color: #fff;">Student Account App.</div>
                
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="panel-body">
                    <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">@lang('ID No.')</label>

                            <div class="col-md-6">
                                <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label for="password" class="col-md-4 control-label">@lang('Password')</label>

                            <div class="col-md-6">
                                <input id="password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        {{--
                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('Remember Me')
                                    </label>
                                </div>
                            </div>
                        </div>
                        --}}
                        <div class="form-group">
                            <div class="col-md-8 col-md-offset-4">
                                <button type="submit" class="btn btn-primary" style="    display: grid; margin: 0 auto;">
                                    @lang('Login')
                                </button>
                                {{--
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    @lang('Forgot Your Password?')
                                </a>
                                --}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
<script> 
    window.localStorage.setItem('sendTokenToServer', '0');
</script> 

<style>
    label{
        color: #fff;
    }
</style>