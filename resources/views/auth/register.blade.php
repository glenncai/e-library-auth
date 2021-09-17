<!-- @author Glenn Cai -->

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-center mt-2">
                    <h4 class="font-weight-bold">Register</h4>
                    <!-- 'status' is the default session which is defined by laravel -->
                    @if(session('status'))
                    <div class="alert alert-success">
                        {{session('status')}}
                    </div>
                    @endif
                </div>
                <div class="card-body">
                    <!-- Because I use Fortify. There are some built-in functions for users. You can run the command 'php artisan r:l' to check the URL for actions -->
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" placeholder="Enter your Name" >
                            @error('name')
                            <span class="invalid-feedback" role="alert">
								<strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter your Email">
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
                        <div class="form-group">
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" placeholder="Confirm your Password">
                            @error('password_confirmation')
                            @enderror
                        </div>
                        <button type="submit" class="btn oneHundredWidth submit-btn">Sign Up</button>
                    </form>
                    <span class="dash"></span>
                    <div class="jumpPage">
                        <span>Have an account?</span>
                        <a href="{{ route('login') }}">login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
