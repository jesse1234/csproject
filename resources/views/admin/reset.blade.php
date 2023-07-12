<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reset Password Form</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('plugins/fontawesome-free/css/all.min.css')}}"> 
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href=""><b>Admin</b>LTE</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      @if(Session::has('error'))
      <div class="alert alert-success" >
    <strong>{{Session::get('error')}}</strong> 
    </div>
    @endif

    @if(Session::has('success'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>{{Session::get('success')}}</strong> 
    </div>
    @endif

      <form action="{{route('reset.password')}}" method="post">
        @csrf
        <input type="hidden" name = 'token' value = '{{$token}}'>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Reset Password" name = 'email' value="{{$email ?? old('email')}}">
          <div class="input-group-append">
                <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name = 'password'>
          <div class="input-group-append">
                <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <x-input-error :messages="$errors->get('password')" class="mt-2" />

        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Confirm Password" name = 'password_confirmation'>
          <div class="input-group-append">
                <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />

        <div class="row">
          
          <!-- /.col -->
          <div class="col-4">
            <button type="submit" class="btn btn-primary btn-block">Reset</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="{{ route('login_form') }}">Login</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>
</html>
