@extends('layouts.app')

@section('title', __('Login'))

@section('content')
<div class="container" style=" height: 100%; display: grid; ">
    <div class="row">
        <div class="col-md-8 col-md-offset-2" id="main-container">
            <div class="panel panel-default" style=" width: 350px; display: grid; margin: 0 auto; text-align: center; "> 
                <img src="{{asset('people.png')}}" alt="" style=" display: grid; margin: 0 auto; ">
                <div class="page-panel-title">@lang('Login')</div>
                
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
                            {{-- <label for="email" class="col-md-4 control-label">@lang('E-Mail')</label> --}}
                            {{-- <label for="email" class="col-md-4 control-label"> </label> --}}

                            <div class="col-md-12" style=" position: relative; ">
                                <i class="material-icons" style=" position: absolute; top: 30%; left: 25px; color: #97AEC6; ">people</i>  
                                <input id="email"
                                style=" padding-left: 37px; " placeholder="Email" type="text" class="form-control" name="email" value="{{ old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            {{-- <label for="password" class="col-md-4 control-label">@lang('Password')</label> --}}
                            {{-- <label for="password" class="col-md-4 control-label"></label> --}}

                            <div class="col-md-12"  style=" position: relative; ">
                                <i class="material-icons" style=" position: absolute; top: 30%; left: 25px; color: #97AEC6; ">key</i>  
                                <input id="password"
                                style=" padding-left: 37px; " placeholder="Password" type="password" class="form-control" name="password" required>

                                @if ($errors->has('password'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        {{--
                        <div class="form-group">
                            <div class="col-md-6 ">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> @lang('Remember Me')
                                    </label>
                                </div>
                            </div>
                        </div>
                        --}}
                        <div class="form-group">
                            <div class="col-md-12 ">
                                <button type="submit" class="btn btn-primary" style=" width: 100%; ">
                                    @lang('Login')
                                </button>
                                {{--
                                <a class="btn btn-link" href="{{ route('password.request') }}">
                                    @lang('Forgot Your Password?')
                                </a>
                                --}}
                            </div>
                            <div class="col-md-12 ">
                                <a href="{{asset('sltfci-v2.apk')}}" >
                                    <img src="{{asset('dl-apk.png')}}"  alt="" 
                                    style=" margin-top: 8px; height: 50px; cursor: pointer; ">
                                </a>
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
    .navbar-default{
        display: none !important;
    }
</style>