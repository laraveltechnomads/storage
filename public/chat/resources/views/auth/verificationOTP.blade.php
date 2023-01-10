@extends('layouts.app')

@section('title', 'Verfication Email')


@section('content')
<div class="card-body login-card-body">
    @if(Session::has('message'))
        <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
    @endif
    <p class="login-box-msg">Veriftication OTP</p>
    <form action="{{ route('email.verification.check', ['email' => $email]) }}" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email , old('email') }}" required autocomplete="email" autofocus placeholder="Email" readonly="" />
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
        <div class="input-group mb-3">
            <input id="otp" type="text" class="form-control @error('password') is-invalid @enderror" name="otp" required autocomplete="otp" onkeypress="return [48, 49, 50, 51, 52, 53, 54, 55, 56, 57].includes(event.charCode);" maxlength="6" placeholder="Enter 6 digit otp" />
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('otp')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Verify</button>
                <a href="{{ route('email.resend.otp' , ['email' => $email, '_token' => csrf_token() ]) }}">Resend OTP</a>
                <p class="mt-3 mb-1">
                    <a href="{{ route('login') }}">Login</a>
                </p>
            </div>
            
            <!-- /.col -->
        </div>
    </form>
</div>
@endsection
