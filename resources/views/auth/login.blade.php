<!-- @author Glenn Cai -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-center mt-2">
                    <h4 class="font-weight-bold">Login</h4>
                    <!-- 'status' is the default session which is defined by laravel -->
                    @if(session('status'))
                    <div class="alert alert-success">
                        {{session('status')}}
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Cuz I use Fortify. There are some built-in functions for users. You can run the command 'php artisan r:l to check the URL for actions' -->
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your Email or Name">
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter your Password">
                            @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group form-check">
                            <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                            <label class="form-check-label" for="remember">Remember me l </label>
                            <span><a class="forgotPassword-text" href="{{ route('password.request') }}">Forgot Password ?</a></span>
                        </div>
                        <button type="submit" class="btn oneHundredWidth submit-btn">Login In</button>
                    </form>
                    <span class="dash"></span>
                    <div class="jumpPage">
                        <span>Login as guest?</span>
                        <a href="{{ route('register') }}">Click here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection