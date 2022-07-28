@extends('layouts.auth')
@section('content')
@section('styles')
    <style>
        .card-header{
            border-bottom: 1px solid #07b9c0;
        }

    </style>

@endsection



<div class="row justify-content-center">
    <div class="col-md-6">
        <div class="card mx-4">
            <div class="card-body p-4 text-right">

                <div class="card-header text-center bg-white">
                    <img style="height: 100px" class="logo" src="{{asset('image/logo-f-c-removebg.png')}}" alt="">
                </div> <h1 class="text-center pt-2">{{ trans('panel.site_title') }}</h1>

                <p class="text-muted">{{ trans('global.login') }}</p>

                @if(session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">
                                <i class="fa fa-user"></i>
                            </span>
                        </div>

                        <input id="email" name="email" type="text" class=" text-right form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" required autocomplete="email" autofocus placeholder="{{ trans('global.login_email') }}" value="{{ old('email', null) }}">

                        @if($errors->has('email'))
                            <div class="invalid-feedback">
                                {{ $errors->first('email') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fa fa-lock"></i></span>
                        </div>

                        <input id="password" name="password" type="password" class=" text-right form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" required placeholder="{{ trans('global.login_password') }}">

                        @if($errors->has('password'))
                            <div class="invalid-feedback">
                                {{ $errors->first('password') }}
                            </div>
                        @endif
                    </div>

                    <div class="input-group mb-4">
                        <div class="form-check checkbox">
                            <input class="form-check-input" name="remember" type="checkbox" id="remember" style="vertical-align: middle;" />
                            <label class="form-check-label" for="remember" style="vertical-align: middle;">
                                {{ trans('global.remember_me') }}
                            </label>
                        </div>
                    </div>

                    <div class="row text-left">
                        <div class="col-6 text-right ">
                            <button  type="submit" class="btn btn-primary px-4 ">
                                {{ trans('global.login') }}
                            </button>
                        </div>
                        <div class="col-6">
                            <button  class="btn btn-success px-4 text-left">
                                <a class="text-white n" href="{{route('register')}}">
                                    ثبت نام
                                </a>
                            </button>
                        </div>
                    </div>
                    <div class="col-12 text-right">
                        @if(Route::has('password.request'))
                            <a class="btn btn-link px-0" href="{{ route('password.request') }}">
                                {{ trans('global.forgot_password') }}
                            </a><br>
                        @endif

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
