@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
    <div class="card-body login-card-body">
        @if(Session::has('message'))
            <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
        @endif
        <p class="login-box-msg">You forgot your password? Here you can easily retrieve a new password.</p>

        <form action="{{ route('password.email') }}" method="post">
            @csrf
            <div class="input-group mb-3">
                <input id="email"  type="email" class="form-control @error('email') is-invalid @enderror"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" />
                <div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="row">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-block">Send Email Verification OTP</button>
                </div>
                <!-- /.col -->
            </div>
        </form>

        <p class="mt-3 mb-1">
            <a href="{{ route('login') }}">Login</a>
        </p>
    </div>
@endsection