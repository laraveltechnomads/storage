@extends('layouts.app')

@section('title', 'Log In')


@section('content')
<div class="card-body login-card-body">

    <form action="{{ route('login') }}" method="post">
        @csrf
        <div class="input-group mb-3">
            <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email" />
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
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password" />
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
            @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
            @enderror
        </div>
        <div class="row">
            <!-- /.col -->
            <div class="col-12">
                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                <p class="mb-1">
                    <a href="{{ route('password.request') }}">Forgot password?</a>
                </p>
            </div>

            <!-- /.col -->
        </div>
    </form>
</div>
<script type="text/javascript">
    (function() {
            var some_id = document.getElementById('password');
            // some_id.type = 'text';
            some_id.removeAttribute('autocomplete');
        })();
</script>
@endsection
