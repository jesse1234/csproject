<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  @include('superadmin.css')
  <style>
    .h2_font{
        font-size:40px;
        padding-bottom:40px;
    }

    .img-size{
        width:250px;
        height:250px;
    }
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  @if(Session::has('error'))
      <div class="alert alert-warning alert-dismissible fade show" role="alert">
    <strong>{{Session::get('error')}}</strong> 
    </div>
    @endif
<div class="wrapper">


  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  @include('superadmin.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('superadmin.sidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    @if(session()->has('success'))

    <div class='alert alert-success'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>x</button>
        {{session()->get('success')}}
    </div>
    @endif
  
    <h2 class='h2_font'>View User Details</h2>

  <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Email Verified At</th>
                      <th>Password</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($user as $user)
                        <tr>
                        <td>{{$user->id}}</td> 
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->email_verified_at}}</td>
                        <td>{{$user->password}}</td>
                        </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
  <!-- /.content-wrapper -->
  @include('superadmin.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@include('superadmin.script')
</body>
</html>
