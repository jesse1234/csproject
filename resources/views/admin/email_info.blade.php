<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Vendor | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  @include('admin.css')

 <style>
     .email-label{
    display:inline-block;
    width:200px;
    font-size:15px;
    font-weight:bold;
}
 </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('dist/img/AdminLTELogo.png')}}" alt="AdminLTELogo" height="60" width="60">
  </div>

  <!-- Navbar -->
  @include('admin.navbar')
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  @include('admin.sidebar')

  <!-- Content Wrapper. Contains page content -->

  <div class="content-wrapper">
    <h1 style='text-align:center; font-size:25px;'>Send Email to {{$order->email}}</h1>
    
    <form action="{{ url('send_user_email', $order->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div style="padding-left: 35%; padding-top: 30px">
        <label for="greeting" class="email-label" style="color: black;">Email Greeting</label>
        <input type="text" name="greeting">
    </div>

    <div style="padding-left: 35%; padding-top: 30px">
        <label for="firstline" class="email-label" style="color: black;">Email First Line</label>
        <input type="text" name="firstline">
    </div>

    <div style="padding-left: 35%; padding-top: 30px">
        <label for="body" class="email-label" style="color: black;">Email Body</label>
        <input type="text" name="body">
    </div>

    <div style="padding-left: 35%; padding-top: 30px">
        <label for="file" class="email-label" style="color: black;">Email File</label>
        <br>
        <input type="file" name="attachment">
    </div>

    <div style="padding-left: 35%; padding-top: 30px">
        <label for="url" class="email-label" style="color: black;">Email URL</label>
        <input type="text" name="url">
    </div>

    <div style="padding-left: 35%; padding-top: 30px">
        <label for="lastline" class="email-label" style="color: black;">Email Last Line</label>
        <br>
        <input type="text" name="lastline">
    </div>

    <div style="padding-left: 35%; padding-top: 30px">
        <input type="submit" value="Send Email" class="btn btn-primary">
    </div>
</form>


  </div>

  <!-- /.content-wrapper -->
  @include('admin.footer')

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
@include('admin.script')
</body>
</html>

