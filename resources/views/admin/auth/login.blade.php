@extends('layouts.admin_app')

@section('app_content')

@if(session()->has('message'))

<div class='alert alert-success'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
    {{session()->get('message')}}
</div>
@endif

    <div class="login-page">
        <div class="login-box">
            <div class="login-logo">
                <a href="."><b>Vendor</b>LTE</a>
            </div>
            <!-- /.login-logo -->
            <div class="card">
                <div class="card-body login-card-body">
                    <p class="login-box-msg">Sign in to start your session</p>
                    @error('email')
                        {{ $message }}
                    @enderror
                    @error('password')
                        {{ $message }}
                    @enderror
                    <form action="{{ route('admin.auth') }}" method="post">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email" name="email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control" placeholder="Password" name="password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-8">
                                <div class="icheck-primary">
                                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        <label for="remember">
            Remember Me
        </label>
                                </div>
                            </div>

                            
                            <!-- /.col -->
                            <div class="col-4">
                                <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                            </div>
                            <!-- /.col -->
                        </div>
                    </form>

                    
                    <!-- /.social-auth-links -->

                    
                    <p class="mb-0">
                        <a href="{{route('admin.register')}}" class="text-center">Register a new membership</a>
                    </p>

                    <p class="mb-0">
                        <a href="{{route('redo.password')}}" class="text-center">Forgot Password</a>
                    </p>

                    <p class="mb-0">
                        <a href="{{route('login')}}" class="text-center">Are you a user? Login Here!</a>
                    </p>

                    <p class="mb-0">
                        <a href="{{url('/superadmin/login')}}" class="text-center">Are you an admin? Login Here!</a>
                    </p>
                </div>
                <!-- /.login-card-body -->
            </div>
        </div>
    </div>
@stop